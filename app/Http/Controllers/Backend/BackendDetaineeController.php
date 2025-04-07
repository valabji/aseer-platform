<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Detainee;
use App\Models\DetaineePhoto;
use App\Notifications\DetaineeStatusChanged;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BackendDetaineeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:detainees-read', ['only' => ['index']]);
        $this->middleware('can:detainees-update', ['only' => ['approve', 'edit', 'update']]);
        $this->middleware('can:detainees-delete', ['only' => ['destroy']]);
    }

    public function updateStatus(Request $request, Detainee $detainee)
    {
        // Notify followers about the status change
        $oldStatus = $detainee->getOriginal('status');
        $request->validate([
            'status' => 'required|in:detained,missing,released,martyr',
        ]);

        $detainee->update(['status' => $request->status]);

        toastr()->success('تم تحديث حالة الأسير بنجاح');
        return back();
    }

    public function edit(Detainee $detainee)
    {
        return view('admin.detainees.edit', compact('detainee'));
    }

    public function update(Request $request, Detainee $detainee)
    {
        // ✅ Validate all allowed fields for update
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'detention_date' => 'nullable|date',
            'status' => 'nullable|in:detained,missing,released,martyr',
            'detaining_authority' => 'nullable|string|max:255',
            'prison_name' => 'nullable|string|max:255',
            'is_forced_disappearance' => 'nullable|boolean',
            'family_contact_name' => 'nullable|string|max:255',
            'family_contact_phone' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'source' => 'nullable|string|max:255',
            'is_approved' => 'nullable|boolean',
            'martyr_date' => 'nullable|date',
            'martyr_place' => 'nullable|string|max:255',
            'martyr_reason' => 'nullable|string|max:255',
            'martyr_notes' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:8048',
            'featured_photo' => 'nullable|exists:detainee_photos,id'
        ]);

        // ✅ Track only changed fields
        $updatedFields = [];

        foreach ($validated as $key => $newValue) {
            if ($key === 'photos' || $key === 'featured_photo') {
                continue; // Photos are handled separately
            }

            $oldValue = $detainee->$key;

            // Compare dates as strings
            if (in_array($key, ['detention_date', 'birth_date', 'martyr_date']) && $oldValue && $newValue) {
                $oldValue = Carbon::parse($oldValue)->toDateString();
                $newValue = Carbon::parse($newValue)->toDateString();
            }

            if ($newValue !== null && $newValue != $oldValue) {
                $updatedFields[$key] = $newValue;
            }
        }

        // ✅ Handle new photo uploads
        if ($request->hasFile('photos')) {
            // Upload and store new photos
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('detainees', 'public');
                DetaineePhoto::create([
                    'detainee_id' => $detainee->id,
                    'path' => $path,
                ]);
            }
        }

        // Handle featured photo
        if ($request->filled('featured_photo')) {
            $detainee->photos()->update(['is_featured' => false]);
            DetaineePhoto::where('id', $request->featured_photo)->update(['is_featured' => true]);
        }
        else if ($detainee->photos()->count() > 0){
            $detainee->photos()->first()->update(['is_featured' => true]);
        }


        // ✅ Apply updates if any fields changed
        if (!empty($updatedFields)) {
            $detainee->update($updatedFields);
            toastr()->success('Only changed fields have been updated.', 'Updated');
        } else {
            toastr()->info('No changes detected in the data.', 'Not Updated');
        }
        $detainee->update($request->all());



        return redirect()->route('admin.detainees.index')->with('success', 'تم تحديث الأسير بنجاح');
    }

    public function setfeatured(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:detainee_photos,id',
        ]);
       // get the featured photo
        $featuredPhoto = DetaineePhoto::where('is_featured', true)->first();
        $featuredPhoto->update(['is_featured' => false]);
        // set the selected photo to featured to the photo on the request
        $photo = DetaineePhoto::findOrFail($request->id);
        $photo->update(['is_featured' => true]);
        // return with success message
        toastr()->success('تم تعيين الصورة بنجاح');
    }


    public function index(Request $request)
    {
        $locations = Detainee::whereNotNull('location')
            ->distinct()
            ->pluck('location')
            ->filter()
            ->values();

        $detainees = Detainee::query()
            ->when($request->q, fn($q) => $q->where('name', 'like', '%' . $request->q . '%'))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->is_approved !== null, fn($q) => $q->where('is_approved', $request->is_approved))
            ->when($request->location, fn($q) => $q->where('location', 'like', '%' . $request->location . '%'))
            ->when($request->date_from, fn($q) => $q->whereDate('detention_date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('detention_date', '<=', $request->date_to))
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.detainees.index', compact('detainees', 'locations'));
    }

    public function approve(Detainee $detainee)
    {
        $detainee->update(['is_approved' => true]);
        toastr()->success('تمت الموافقة على الأسير بنجاح');
        return back();
    }
    public function deletePhoto(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:detainee_photos,id',
        ]);
        $photo = DetaineePhoto::findOrFail($request->id);
        // Delete the file from storage
        if (Storage::disk('public')->exists(str_replace('/storage/', '', $photo->url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $photo->url));
        }

        // Delete the database record
        $photo->delete();

        return response()->json(['success' => true]);
    }

    public function uploadPhotos(Request $request, Detainee $detainee)
    {
        $request->validate([
            'photos' => 'required|image|max:2048',
        ]);

        $path = $request->file('photos')->store('detainees', 'public');

        DetaineePhoto::create([
            'detainee_id' => $detainee->id,
            'path' => $path,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy(Detainee $detainee)
    {
        $detainee->delete();
        toastr()->success('تم حذف الأسير بنجاح');
        return back();
    }
}

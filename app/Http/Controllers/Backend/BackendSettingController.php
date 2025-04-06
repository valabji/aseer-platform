<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
class BackendSettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:settings-update',   ['only' => ['index','update']]);
    }

    public function index()
    {
        if(!auth()->user()->can('settings-update'))abort(403);
        cache()->forget('settings');
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {

        // Check if the user has permission to update settings
        if (!auth()->user()->can('settings-update')) abort(403);

        cache()->forget('settings');

        $settings = $request->get('settings', []);

        foreach ($settings as $key => $value) {
            if (!in_array($key, ['website_logo','website_wide_logo','website_icon','website_cover'])) {
                if ($value === null || $value === '') continue;

                if (is_array($value)) $value = implode(',', $value);
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }



        $uploadables = ['website_logo', 'website_wide_logo', 'website_icon', 'website_cover'];
        foreach ($uploadables as $upload_key) {
            if ($request->hasFile("settings.$upload_key")) {
                $setting = Setting::firstOrCreate(['key' => $upload_key]);
                $image = $setting->addMedia($request->file("settings.$upload_key"))->toMediaCollection($upload_key);
                $setting->update(['value' => $image->id.'/'.$image->file_name]);
            }
        }


        toastr()->success('تم تحديث الإعدادات بنجاح','عملية ناجحة');
        return redirect()->back();
    }


}

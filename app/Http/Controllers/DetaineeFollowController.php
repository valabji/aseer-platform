<?php

namespace App\Http\Controllers;

use App\Models\Detainee;
use Illuminate\Http\Request;

class DetaineeFollowController extends Controller
{
    public function follow(Detainee $detainee)
    {
        auth()->user()->followedDetainees()->syncWithoutDetaching([$detainee->id]);
        return back()->with('success', 'تمت المتابعة بنجاح');
    }

    public function unfollow(Detainee $detainee)
    {
        auth()->user()->followedDetainees()->detach($detainee->id);
        return back()->with('success', 'تم إلغاء المتابعة');
    }
}

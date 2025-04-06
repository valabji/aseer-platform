<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Detainee;
use Illuminate\Support\Facades\Auth;

class DetaineeFollowButton extends Component
{
    public Detainee $detainee;
    public bool $isFollowing = false;
    public int $followersCount = 0;

    public function mount(Detainee $detainee)
    {
        $this->detainee = $detainee;
        $this->isFollowing = Auth::check() && Auth::user()->followedDetainees->contains($detainee->id);
        $this->followersCount = $detainee->followers()->count();
    }

    public function toggleFollow()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->followedDetainees->contains($this->detainee->id)) {
            $user->followedDetainees()->detach($this->detainee->id);
            $this->isFollowing = false;
        } else {
            $user->followedDetainees()->attach($this->detainee->id);
            $this->isFollowing = true;
        }

        $this->followersCount = $this->detainee->followers()->count();
    }

    public function render()
    {
        return view('livewire.detainee-follow-button');
    }
}

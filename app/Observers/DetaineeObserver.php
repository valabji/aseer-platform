<?php

namespace App\Observers;

use App\Models\Detainee;
use App\Notifications\DetaineeStatusChanged;

class DetaineeObserver
{
    /**
     * Handle the Detainee "created" event.
     */
    public function created(Detainee $detainee): void
    {
        //
    }

    /**
     * Handle the Detainee "updated" event.
     */
    public function updated(Detainee $detainee)
    {
        if ($detainee->isDirty('status')) {
            foreach ($detainee->followers as $user) {
                $user->notify(new DetaineeStatusChanged($detainee));
            }
        }
    }

    /**
     * Handle the Detainee "deleted" event.
     */
    public function deleted(Detainee $detainee): void
    {
        //
    }

    /**
     * Handle the Detainee "restored" event.
     */
    public function restored(Detainee $detainee): void
    {
        //
    }

    /**
     * Handle the Detainee "force deleted" event.
     */
    public function forceDeleted(Detainee $detainee): void
    {
        //
    }
}

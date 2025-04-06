<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Traits\SetDataForNotifications;

class DetaineeStatusChanged extends Notification
{
    use Queueable, SetDataForNotifications;

    public $tries = 2;
    public $timeout = 10;

    protected $detainee;

    public function __construct($detainee)
    {
        $this->detainee = $detainee;

        $this->subject = 'تحديث حالة الأسير';
        $this->greeting = 'مرحباً';
        $this->content = 'تم تغيير حالة الأسير <strong>' . $detainee->name . '</strong> إلى <span class="badge bg-' .
            ($detainee->status === 'martyr' ? 'danger' : ($detainee->status === 'released' ? 'success' : 'danger')) . '">' .
            __('status.' . $detainee->status) . '</span>';

        $this->actionText = 'عرض تفاصيل الأسير';
        $this->actionUrl = route('front.detainees.show', $detainee->id);
        $this->image = $detainee->photos()->featured()->first()->url ?? env("DEFAULT_IMAGE_AVATAR");
        $this->methods = ['database']; // add 'mail' if you want to send via email
    }

    public function via($notifiable)
    {
        return $this->methods;
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => '<a href="' . $this->actionUrl . '">' . $this->content . '</a>',
            'image' => $this->image,
        ];
    }

    public function toMail($notifiable)
    {
        return [
            'message'=> '<a href="' . $this->actionUrl . '">' . $this->content . '</a>',
            'image'=>$this->image,
        ];
    }
}

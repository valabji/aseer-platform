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
    protected $type;

    protected $detainee;

    public function __construct($detainee, $type = 'status_changed')
    {
        $this->type = $type;
        $this->detainee = $detainee;
        $this->subject = 'تحديث الحالة';
        $this->greeting = 'مرحباً';

        if ($type === 'unapproved') {
            $this->content = 'تم إلغاء نشر الأسير <strong>' . $detainee->name . '</strong>';
        } else {
            $statusBadge = '<span class="badge bg-' . $this->getBadgeClass($detainee->status) . '">'
                . __('status.' . $detainee->status) . '</span>';

            $this->content = 'تم تغيير الحالة <strong>' . $detainee->name . '</strong> إلى ' . $statusBadge;
        }

        $this->actionText = 'عرض تفاصيل الحالة';
        $this->actionUrl = route('front.detainees.show', $detainee->id);
        $this->image = $detainee->photos()->featured()->first()->url ?? asset('images/default-avatar.png');
        $this->methods = ['database'];
    }

    protected function getBadgeClass($status)
    {
        return match ($status) {
            'martyr' => 'danger',
            'released' => 'success',
            default => 'secondary',
        };
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
            'type' => $this->type ?? 'status_changed',
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

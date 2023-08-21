<?php

namespace App\Notifications;

use App\Http\Resources\SensorCctvResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class AlertDeviceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $title, $message , $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title , $message , $data)
    {
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->message)
            ->withPriority('high')
            ->withAdditionalData([
                'detect' => $this->data,
            ])
            ->asNotification([$notifiable->fcm_token]);
    }
}

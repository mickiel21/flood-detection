<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use App\Channels\SmsChannel;

class SemaphoreSMSNotification extends Notification
{
    use Queueable;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
   public function via($notifiable)
    {
        return [SmsChannel::class];
    }


    /**
     * Get the mail representation of the notification.
     */
     public function toSms($notifiable)
    {
        return Http::asForm()->post('https://semaphore.co/api/v4/messages', [
            'apikey' => env('SEMAPHORE_API_KEY'),
           'number' => $notifiable->routeNotificationForSms(),
            'message' => $this->message,
            'sendername' => 'SEMAPHORE' // Change this as needed
        ]);
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;
use App\Models\Message;

class SMSNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $severity;

    public function __construct($severity)
    {
        $this->severity = $severity;
    }


    public function via($notifiable)
    {
        return ['vonage'];
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toVonage($notifiable)
    {
        $messageData = Message::where('sensor_id', 1) // Use dynamic sensor_id
                      ->where('severity', $this->severity)
                      ->first();

        $message = "Flood Alert: {$this->severity} Warning\n";

        // Ensure $messageData is not null before accessing properties
        if ($messageData) {
            $message .= $messageData->message;
        } else {
            $message .= "No predefined alert message found for this severity level.";
        }

        return (new VonageMessage)->content($message);

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

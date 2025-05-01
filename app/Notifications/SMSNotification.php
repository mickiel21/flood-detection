<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class SMSNotification extends Notification
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
        $message = "Flood Alert: {$this->severity} Warning\n";
    
        if ($this->severity === 'Medium') {
            $message .= "Moderate flooding detected. Stay alert and follow safety measures.";
        } elseif ($this->severity === 'Critical') {
            $message .= "Severe flooding detected! Evacuate immediately and seek higher ground.";
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

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FloodAlertNotification extends Notification implements ShouldQueue

{
    use Queueable;
    protected $severity;

    /**
     * Create a new notification instance.
     */
    public function __construct($severity)
    {
        $this->severity = $severity;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $message = new MailMessage();
        $message->subject("Flood Alert: {$this->severity} Warning")
                ->greeting("Attention!");


        if ($this->severity === 'Medium') {
            $message->line("Moderate flooding detected. Please stay alert and follow safety measures.")
                    ->action('Check Updates', url('/'));
        } elseif ($this->severity === 'Critical') {
            $message->line("Severe flooding detected! Evacuate immediately and seek higher ground.")
                    ->action('Emergency Info', url('/evacuation-plan'));
        }

            return $message;
        

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

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
        $message->subject("🚨 Flood Alert: {$this->severity} Warning")
                ->greeting("Attention!");

        switch ($this->severity) {
            case 'Low':
                $message->line("Water level is stable. No immediate action needed. Stay informed.")
                        ->action('View Status', url('/'));
                break;
            case 'Medium':
                $message->line("Moderate flooding detected. Please stay alert and follow safety measures.")
                        ->action('Check Updates', url('/main'));
                break;
            case 'High':
                $message->line("High water level detected! Prepare for possible flooding.")
                        ->action('Safety Tips', url('/main'));
                break;
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

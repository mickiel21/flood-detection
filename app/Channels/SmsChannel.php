<?php
namespace App\Channels;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $response = $notification->toSms();
        return $response->json();
    }
}
<?php

namespace App\Notifications\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    use Queueable;
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }


    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                ->subject('New Customer Registration')
                ->view('admin.emails.user.NewUser', [
                    'user' => $this->user,
                    'admin' => $notifiable->name,
                ]);
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

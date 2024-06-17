<?php

namespace App\Notifications\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderAdminNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order on '.(config('app.name')))
            ->view('admin.emails.order.NewOrder', [
                'order' => $this->order,
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

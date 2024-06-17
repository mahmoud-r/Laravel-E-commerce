<?php

namespace App\Notifications\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReviewAdminNotification extends Notification
{
    use Queueable;
    public $review;

    public function __construct($review)
    {
        $this->review = $review;
    }


    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Product Review Submitted.')
            ->view('admin.emails.Review.NewReview',[
                'review'=>$this->review,
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

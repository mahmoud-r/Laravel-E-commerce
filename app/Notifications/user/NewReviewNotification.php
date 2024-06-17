<?php

namespace App\Notifications\user;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReviewNotification extends Notification
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
            ->view('front.emails.Review.NewReview',['review'=>$this->review]);
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

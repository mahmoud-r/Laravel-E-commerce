<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\ProductRating;
use App\Notifications\admin\NewReviewAdminNotification;
use App\Notifications\user\NewReviewNotification;
use App\Notifications\user\ReviewPublishedNotification;
use Illuminate\Support\Facades\Notification;

class ReviewObserver
{
    public function created(ProductRating $review){

        // Check user notification setting
        if (config('settings.email_user_new_review')) {
            Notification::send($review->user, new NewReviewNotification($review));
        }

        if (get_setting('email_user_new_review_admin')){
            $admins = Admin::where('notification','1')->get();

            Notification::send($admins, new NewReviewAdminNotification($review));

        }
    }

    public function updated(ProductRating $review){

        if ($review->status == true){
            // Check user notification setting
            if (config('settings.email_user_confirm_review')) {
                Notification::send($review->user, new ReviewPublishedNotification($review));
            }
        }

    }
}

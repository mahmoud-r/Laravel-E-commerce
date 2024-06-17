<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\Models\Admin;
use App\Notifications\admin\NewOrderAdminNotification;
use App\Notifications\user\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NewOrderSend
{

    public function __construct()
    {
        //
    }


    public function handle(NewOrder $event): void
    {
        $order = $event->order;
        $order->load('address', 'items', 'user');

        // Check user notification setting
        if (config('settings.email_user_new_order')) {
            Notification::send($order->user, new NewOrderNotification($order));
        }


        // Check admin notification setting
        if (config('settings.email_user_register_admin')) {
            $admins = Admin::where('notification', '1')->get();
            Notification::send($admins, new NewOrderAdminNotification($order));
        }
    }
}

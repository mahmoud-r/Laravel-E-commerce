<?php

namespace App\Providers;

use App\Events\NewOrder;
use App\Listeners\NewOrderSend;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\OrderPayment;
use App\Models\OrderStatue;
use App\Models\ProductRating;
use App\Models\Shipment;
use App\Models\ShipmentInfo;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use App\Observers\OrderStatusObserver;
use App\Observers\PaymentObserver;
use App\Observers\ReviewObserver;
use App\Observers\ShipmentInfoObserver;
use App\Observers\ShipmentObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewOrder::class => [
            NewOrderSend::class,
        ],
    ];

    public function boot(): void
    {
        Shipment::observe(ShipmentObserver::class);
        OrderPayment::observe(PaymentObserver::class);
        Order::observe(OrderObserver::class);
        OrderStatue::observe(OrderStatusObserver::class);
        ShipmentInfo::observe(ShipmentInfoObserver::class);
        Order_item::observe(OrderItemObserver::class);
        ProductRating::observe(ReviewObserver::class);

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

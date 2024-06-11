<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Order_item;
use App\Models\OrderPayment;
use App\Models\OrderStatue;
use App\Models\Shipment;
use App\Models\ShipmentInfo;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use App\Observers\OrderStatusObserver;
use App\Observers\PaymentObserver;
use App\Observers\ShipmentInfoObserver;
use App\Observers\ShipmentObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Shipment::observe(ShipmentObserver::class);
        OrderPayment::observe(PaymentObserver::class);
        Order::observe(OrderObserver::class);
        OrderStatue::observe(OrderStatusObserver::class);
        ShipmentInfo::observe(ShipmentInfoObserver::class);
        Order_item::observe(OrderItemObserver::class);

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

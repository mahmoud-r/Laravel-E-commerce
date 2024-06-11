<?php

namespace App\Observers;

use App\Models\Order_item;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class OrderItemObserver
{
    /**
     * Handle the OrderItem "created" event.
     */
    public function created(Order_item $orderItem)
    {
        $product = Product::find($orderItem->product_id);

        if ($product) {
            try {
                $product->qty -= $orderItem->qty;
                $product->save();
            } catch (\Exception $e) {
                Log::error('Failed to update product quantity: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle the OrderItem "updated" event.
     */
    public function updated(Order_item $orderItem): void
    {

    }

    /**
     * Handle the OrderItem "deleted" event.
     */
    public function deleted(Order_item $orderItem): void
    {

    }

    /**
     * Handle the OrderItem "restored" event.
     */
    public function restored(Order_item $orderItem): void
    {
        //
    }

    /**
     * Handle the OrderItem "force deleted" event.
     */
    public function forceDeleted(Order_item $orderItem): void
    {
        //
    }
}
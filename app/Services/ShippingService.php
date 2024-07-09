<?php

namespace App\Services;
use App\Models\Product;
use App\Models\ShippingZone;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShippingService
{

    public function calculateShippingCost($governorateId, $weight) {

        $zone = $this->getShippingZone($governorateId, $weight);

        if (!$zone) {
            $zone = ShippingZone::where('name', 'Default')->first();
            if (!$zone) {
                throw new \Exception('No suitable shipping zone found and no default zone available.');
            }
        }

        return $this->computeCost($zone, $weight);
    }

    public function calculateWeight()
    {
        $weight = 0;
        foreach (Cart::instance('default')->content() as $item) {
            $product = Product::select('weight')->where('id', $item->id)->first();
            $weight += $product->weight * $item->qty;
        }
        return $weight;
    }

    private function getShippingZone($governorateId, $weight) {
        return ShippingZone::whereHas('governorates', function($query) use ($governorateId) {
            $query->where('governorate_id', $governorateId);
        })->first();
    }

    private function computeCost($zone, $weight) {
        $cost = $zone->price;

        if ($weight > $zone->weight_to) {
            $extraWeight = $weight - $zone->weight_to;
            $extraCost = ceil($extraWeight) * $zone->additional_weight_price;
            $cost += $extraCost;
        }

        return $cost;
    }
}

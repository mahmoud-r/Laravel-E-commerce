<?php

namespace App\Http\Traits;

use App\Models\ShippingZone;

trait ShippingTrait
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


<?php

namespace App\Traits;

use App\Models\Governorate;
use App\Models\ShippingZone;
use Illuminate\Support\Facades\Log;

trait ShippingCalculator
{

    public function calculateShippingCost(float $weight, int $governorateId): float
    {
        $governorate = Governorate::find($governorateId);

        if (!$governorate) {
            Log::error("Governorate with ID {$governorateId} not found.");
            throw new \Exception('Governorate not found.');
        }

        $shippingZone = $governorate->shippingZone;

        if (!$shippingZone) {
            Log::warning("No shipping zone found for governorate ID {$governorateId}. Using default shipping cost.");
            $defaultShippingCost = 50.0;
            return $defaultShippingCost;
        }

        if ($weight < $shippingZone->weight_from || $weight > $shippingZone->weight_to) {
            Log::error("Weight {$weight} is out of the range for shipping zone ID {$shippingZone->id}.");
            throw new \Exception('Weight is out of the shipping zone range.');
        }

        return $shippingZone->price;
    }
}

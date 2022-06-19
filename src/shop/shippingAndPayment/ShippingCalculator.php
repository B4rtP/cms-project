<?php

namespace Cms\shop\shippingAndPayment;

class ShippingCalculator {

    public function calculateTotalShipping($pricePerKilo, $weight) {
        return $pricePerKilo * $weight;
        
    }

    public static function calculateTotalWeight(array $productWeightAndCount) {
        $totalWeight = 0;
        foreach ($productWeightAndCount as $weight => $count) {
            if(!is_float($weight)) {
                $weight = floatval($weight);
            }
            $totalWeight += $weight*$count;
        }
        return $totalWeight;
    }
}
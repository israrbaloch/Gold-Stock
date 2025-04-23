<?php

namespace App\Helper;

class ProductsHelper {
    static function getOzNumberWeight($weight) {
        $clean_weight = strtolower(str_replace('-', '', $weight));
        $clean_weight = str_replace(' ', '', $clean_weight);
        $clean_weight = str_replace('/oz', 'oz', $clean_weight);
        $clean_weight = str_replace('-oz', 'oz', $clean_weight);
        $oz_number_weight = 0;
        if (strlen($clean_weight) > 0) {
            $number_weight = 0;
            $no_letters_weight = preg_replace("/[a-zA-Z]/", "", $clean_weight);

            if (strpos($no_letters_weight, '/') !== false) {
                $numArray = explode("/", $no_letters_weight);
                $number_weight = $numArray[0] / $numArray[1];
            } else {
                $number_weight = $no_letters_weight;
            }

            if (strpos($clean_weight, 'oz') !== false) {
                $oz_number_weight = $number_weight;
            } elseif (strpos($clean_weight, 'gram') !== false) {
                $oz_number_weight = $number_weight / 31.105;
            }
        }
        return $oz_number_weight;
    }
}

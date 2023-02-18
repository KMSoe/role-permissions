<?php

namespace App\Helpers;

class CoreHelper
{
    static function generateRandomString($prefix, $length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $prefix . "-" . $randomString;
    }
}
<?php

namespace App\Sanitizers;

class PhoneSanitizer
{
    public static function sanitize(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $res = preg_replace('/\D+/', '', $value);
        $res[0] = 7;
        return $res;
    }
}

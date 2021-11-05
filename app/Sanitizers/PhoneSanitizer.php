<?php

namespace App\Sanitizers;

class PhoneSanitizer
{
    public static function sanitize(string $value) : string {
        $res = preg_replace('/\D+/', '', $value);
        if ($res[0] === '8') {
            $res[0] = 7;
        }
        else {
            $res = "7" . $res;
        }
        print $res;
        return $res;
    }
}

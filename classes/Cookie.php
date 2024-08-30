<?php

namespace Route\Classes;

class Cookie {

    public static function set($key,$value,$days=14){
        $expiryTime = time() + 60 * 60 * 24 * $days;
        setcookie($key, $value, $expiryTime);
    }

    public function get($key){
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null ;
    }
}
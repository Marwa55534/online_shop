<?php

namespace Route\Classes;
require_once 'Validation.php';
use Route\Classes\Validation;

class Strlen implements Validation{

    public function check($key , $value){

        if(strlen($value)<5){
            return "$key must be more than 4 char"; // errors
        }else{
            return false;
        }
    }
}
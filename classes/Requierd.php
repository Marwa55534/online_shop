<?php

namespace Route\Classes;
require_once 'Validation.php';
use Route\Classes\Validation;
 
class Requierd implements Validation{

    public function check($key , $value){

        if(empty($value)){
            return "$key is Requierd"; // errors
        }else{
            return false;
        }
    }
}
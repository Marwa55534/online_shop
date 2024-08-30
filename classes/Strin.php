<?php

namespace Route\Classes;
require_once 'Validation.php';
use Route\Classes\Validation;
 
class Strin implements Validation{

    public function check($key , $value){

        if(is_numeric($value) ){
            return "$key must be string"; // errors
        }else{
            return false;
            
        }
    }
}
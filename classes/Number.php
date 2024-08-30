<?php

namespace Route\Classes;
require_once 'Validation.php';
use Route\Classes\Validation;
 
class Number implements Validation{

    public function check($key , $value){

        if(! is_numeric($value)){
            return "$key must be a numeric";
        }else{
            return false;
        }
    }
}
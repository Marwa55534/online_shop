<?php

namespace Route\Classes;
require_once 'Validation.php';
use Route\Classes\Validation;

// class Filter implements Validation{

//     public function check($key , $value){

//         if(! filter_var($value,FILTER_VALIDATE_EMAIL)){
//             return "$key email not valid"; // errors
//         }else{
//             return false;
//         }
//     }
// }

class Filter implements Validation {
    public function check($key, $value) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return "$key is not valid"; // error
        }
        return false;
    }
}
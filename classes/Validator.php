<?php

namespace Route\Classes;


require_once 'Requierd.php';
require_once 'Strin.php';
require_once 'Number.php';
require_once 'Strlen.php';
require_once 'emailFilter.php';


class Validator{

    private $errors = [];

    public function endValidation($key,$value,$rules){ // دا المبدا الاخير 
        foreach ($rules as $rule) {
            $rule = "Route\Classes\\" . $rule;  // use
            $obj = new $rule; // "Requierd","Str"
            $result = $obj->check($key,$value); //  abstract method
            if($result != false){
                $this->errors[] = $result;
               // return $this->errors;
            }
        }
    }

    public function getErrors(){
        return $this->errors;
    }
} 
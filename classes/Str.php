<?php


class Str{
    public static function limit($str){
        if(strlen($str)>100){
            return substr($str , 0, 100) . "...";
        }
        return $str;
    }
}
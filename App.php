<?php

require_once "classes/Request.php";
require_once "classes/Session.php";
require_once "classes/Str.php";
require_once "classes/Validator.php";
require_once "classes/img.php";
require_once "classes/Cookie.php";



use Route\Classes\Request;
use Route\Classes\Session;
use Route\Classes\Validator;
use Route\Classes\Img;
use Route\Classes\Cookie;




$request = new Request();
$session = new Session();
$validator = new Validator();
$cookie = new Cookie();

//$img = new Img("img");



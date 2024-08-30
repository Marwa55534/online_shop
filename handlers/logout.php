<?php
require_once '../App.php';

// if(! $session->get("email")){ 
//     $request->redirect("../login.php");
// }

$session->remove("id");

$request->redirect("../login.php");










// نفضي السيشن



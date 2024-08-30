<?php
require_once '../inc/connection.php';
require_once '../App.php';

if(! $session->get("id")){
    $request->redirect("../login.php");

}
// check , catch , vaildation , empty errors check(email , passw) , login

// check
if ($request->check($request->post("login"))) {

    // catch
    $email = filter_var($request->filter($request->post("email"))); 
    $password = $request->filter($request->post("password"));
    
    // validation
    $validator->endValidation("email", $email, ["Requierd","Filter"]); 
    $validator->endValidation("password", $password, ["Requierd","Strlen"]); 

    $errors = $validator->getErrors();
    if (!empty($errors)) {
        $session->set("errors", $errors);
        $request->redirect("../login.php");
        die();
    }
    
    // check(email , passw)
    $runQuery = $conn->prepare("select * from users where email = :email");
    $runQuery->bindParam(":email", $email);
    $runQuery->execute();
    
    if ($runQuery->rowCount() === 1) {
        $user = $runQuery->fetch(PDO::FETCH_ASSOC); 
        $passwordHash = $user['password'];
       
        $name = $user['name']; //
        $id = $user['id']; // id

        if(password_verify($password, $passwordHash)) {
            
            $session->set("id", $id);//

            $role = $user['role']; 
    
        if ($role === "admin") {
            $session->set("success", "welcom $name");
            $request->redirect("../index.php");
        } else {
         //   $userLoggedIn = true;
           // setcookie("userLoggedIn", $userLoggedIn, time() + 60 * 60 * 24 * 14);
            $cookie->set("userLoggedIn",true);
            $session->set("success", "welcom ");
            $request->redirect("../index.php");
            die();
        }
        } else {
            $session->set("errors", ["invalid password"]);
            $request->redirect("../login.php");
        }
    } else {
        $session->set("errors", ["invalid email"]);
        $request->redirect("../login.php");
    }
}

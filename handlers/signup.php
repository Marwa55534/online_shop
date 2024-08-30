<?php
require_once '../inc/connection.php';
require_once '../App.php';

// check
if ($request->check($request->post("singup"))) {
    // catch
    $name = $request->filter($request->post("name"));  // done
    $email = filter_var($request->filter($request->post("email")));  // filter_var for email
    $password = $request->filter($request->post("password"));  // done
    $phone = $request->filter($request->post("phone"));  // done
    $address = $request->filter($request->post("address"));

    // Validation
    $validator->endValidation("name", $name, ["Requierd", "Strin","Strlen"]); //
    $validator->endValidation("email", $email, ["Requierd","Filter"]); 
    $validator->endValidation("password", $password, ["Requierd","Strlen"]); //
    $validator->endValidation("phone", $phone, ["Requierd", "Number"]); //
    $validator->endValidation("address", $address, ["Requierd"]); //

    $errors = $validator->getErrors();

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // insert
        $runQuery = $conn->prepare("insert into users(`name`, `email`, `password`, `phone`, `address`) values(:name, :email, :password, :phone, :address)");
        $runQuery->bindParam(":name", $name);
        $runQuery->bindParam(":email", $email);
        $runQuery->bindParam(":password", $hashedPassword);  // Use hashed password
        $runQuery->bindParam(":phone", $phone);
        $runQuery->bindParam(":address", $address);

        if ($runQuery->execute()) {
            $session->set("success", "insert successful");
            $request->redirect("../login.php");
        } else {
            $session->set("errors", ["error while inserting"]);
            $request->redirect("../singup.php");

        }
     }else {
         $session->set("errors", $errors);
         $request->redirect("../singup.php");

    }
} else {
    $request->redirect("../login.php");
}
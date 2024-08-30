<?php
require_once '../inc/connection.php';
require_once "../App.php";
require_once '../classes/Img.php';

if(! $session->get("id")){ //if(! $session->get("id"))
    $request->redirect("../login.php");

}else{

// check ان احنا جايين من الفورم
// catch input
// validation لو تمام class  
// insert
// لو ال insert مش تمام هعمل 
// errors



// Check 
if ($request->check($request->post("submit"))) {

    // Catch input
    $name = $request->filter($request->post("name"));  
    $price = $request->filter($request->post("price"));  
    $body = $request->filter($request->post("body"));  
    $img = $request->file("img");  //

    // Validate the input data
    $validator->endValidation("name", $name, ["Requierd", "Strin"]);
    $validator->endValidation("body", $body, ["Requierd", "Strin"]);
    $validator->endValidation("price", $price, ["Requierd", "Number"]);
    $validator->endValidation("img", $img, ["Requierd"]); //

    $img = new Img($img); //

    // $imgErrors = $img->getErrorsImg();
    // $errors = array_merge($validator->getErrors(), $imgErrors);

    $errors = array_merge($validator->getErrors(), $img->getErrorsImg());
    
    if (empty($errors)) {
        // Insert 
        $runQuery = $conn->prepare("insert into products(`name`,`price`,`body`,`img`) values(:name,:price,:body,:img)");
        $runQuery->bindParam(":name", $name, PDO::PARAM_STR);
        $runQuery->bindParam(":price", $price, PDO::PARAM_INT);
        $runQuery->bindParam(":body", $body, PDO::PARAM_STR);
        $runQuery->bindParam(":img", $img->getNewFileName(), PDO::PARAM_STR);

        if ($runQuery->execute()) {
            $session->set("success", "product inserted successfully");
            $request->redirect("../index.php");
        } else {
            $session->set("errors", ["Error while inserting"]);
            $request->redirect("../add.php");
        }
    } else {
        $session->set("errors", $errors);
        $request->redirect("../add.php");
    }

} else {
    $request->redirect("../index.php");
}
}
 

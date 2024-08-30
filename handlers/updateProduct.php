<?php

require_once '../inc/connection.php';
require_once '../App.php';
require_once '../classes/Img.php';

if(! $session->get("id")){
    $request->redirect("../login.php");

}

// check submit , id -- ان احنا جايين من الفورم وكمان معانا ال id
// catch input
// validation لو تمام class 
// empty (errors) select one -> founded -> update
// لو ال update مش تمام هعمل 
// errors 

// Check submit , id
if ($request->check($request->post("submit")) && $request->check($request->get("id"))) {

   // catch input id
    $id = $request->get("id");


    // select one
    $runQuery = $conn->prepare("select * from products where id=:id");
    $runQuery->bindParam(":id", $id, PDO::PARAM_INT);
    $runQuery->execute();

    if ($runQuery->rowCount() == 1) {
        $product = $runQuery->fetch(PDO::FETCH_ASSOC);
        $oldImage = $product['img'];

        // catch input
        $name = $request->filter($request->post("name"));  
        $price = $request->filter($request->post("price"));  
        $body = $request->filter($request->post("body"));
        $img = $request->file("img");

        // Validate input
        $validator->endValidation("name", $name, ["Requierd", "Strin"]);
        $validator->endValidation("body", $body, ["Requierd", "Strin"]);
        $validator->endValidation("price", $price, ["Requierd", "Number"]);

        // img Validate only 
        if (!empty($img['name'])) { //$img['name'])
            $validator->endValidation("img", $img, ["Requierd"]);
            $imageHandler  = new Img($img); 
            $errors = array_merge($validator->getErrors(), $imageHandler ->getErrorsImg());
            $newImageName = $imageHandler ->getNewFileName();
        } else {
            $newImageName = $oldImage; 
        }

        if (empty($errors)) {
            // Update 
            $runQuery = $conn->prepare("update products set `name`= :name, `body`= :body, `price`= :price, `img`= :img where id=:id");
            $runQuery->bindParam(":id", $id, PDO::PARAM_INT);
            $runQuery->bindParam(":name", $name, PDO::PARAM_STR);
            $runQuery->bindParam(":body", $body, PDO::PARAM_STR);
            $runQuery->bindParam(":price", $price, PDO::PARAM_INT);
            $runQuery->bindParam(":img", $newImageName);
            $runQuery->execute();

            if ($runQuery) { // true
                if (!empty($img['name']))  
                {
                    unlink('../uploads/' . $oldImage); 
                }
                $session->set("success", "Product updated successfully");
                $request->redirect("../index.php");
            } else {
                $session->set("errors", ["Error while updateing"]);
                $request->redirect("../edit.php?id=$id");
            }
        } else {
            $session->set("errors", $errors);
            $request->redirect("../edit.php?id=$id");
        }
    } else {
        $session->set("errors", ["Product not found"]);
        $request->redirect("../index.php");
    }
} else {
    $request->redirect("../index.php");
}
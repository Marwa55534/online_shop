<?php
require_once '../inc/connection.php';
require_once '../App.php';
require_once '../classes/Img.php';

if(! $session->get("id")){
    $request->redirect("../login.php");

}else{


// check  معانا ال id
//  select one -> founded -> delete
// لو ال delete مش تمام هعمل 
// errors

if($request->check($request->get("id"))){

    // catch input id
    $id = $request->get("id");
 
     // select one
    $runQuery = $conn->prepare("select * from products where id=:id");
    $runQuery->bindParam(":id", $id, PDO::PARAM_INT);
    $runQuery->execute();
 
    if($runQuery->rowCount() == 1) {

        $product = $runQuery->fetch(PDO::FETCH_ASSOC);
        if(! empty($product)){ // هتشيك ان الصوره موجوده 
            unlink('../uploads/' . $oldImage); 

        }
        // update
        $runQuery = $conn->prepare("delete from products where id=:id");
        $runQuery->bindParam(":id",$id);
        $result = $runQuery->execute();
        if($result){ // true
            $session->set("success","task deleted successfully");   // key,value
            $request->redirect("../index.php");
        }else{
            $session->set("errors",["error while delete"]);   // key,value
            $request->redirect("../index.php");
        }

    }else{
        $session->set("errors", ["Product not found"]);
        $request->redirect("../index.php");
    }

} else {
    $request->redirect("../index.php");
}
}

<?php include 'inc/header.php'; 
require_once "inc/connection.php";
require_once 'App.php';
?>

<?php
$id = $request->get("id");

$runQuery = $conn->prepare("select * from products where id=:id");
$runQuery->bindparam(":id",$id,PDO::PARAM_INT); // ببعتها لناتج بتاع الكويري
$runQuery->execute();
if($runQuery->rowCount()==1){ 
    $product = $runQuery->fetch(PDO::FETCH_ASSOC);
}else{
    $session->set("errors",["product not found"]); // key,value
    $request->redirect("index.php");
}
?>


<div class="container my-5">

          
    <div class="row">


    <div class="col-lg-6">
            <img src="uploads/<?php echo $product['img'] ?>" class="card-img-top">
            </div>
            <div class="col-lg-6">
            <h5 ><?php echo $product['name'] ?></h5>
            <p class="text-muted">Price:<?php echo $product['price'] ?></p>
            <p><?php echo $product['body'] ?></p>
            <a href="index.php" class="btn btn-primary">Back</a>
            <a href="edit.php?id=<?php echo $product["id"] ?>" class="btn btn-info">Edit</a>
            <a href="handlers/deleteProduct.php?id=<?php echo $product["id"] ?>" class="btn btn-danger">Delete</a>
     
        </div>
    </div>
</div>



<?php include 'inc/footer.php'; ?>
<?php include 'inc/header.php'; 
require_once 'inc/connection.php';
require_once 'APP.php';



if(! $session->get("id")){
    $request->redirect("login.php");

}
?>

<?php
if($request->get("id")){
    $id = $request->get("id");
    $runQuery = $conn->prepare("select * from products where id=:id");
    $runQuery->bindParam(":id",$id);
    $runQuery->execute();
    if($runQuery->rowCount()==1){
        $product = $runQuery->fetch(PDO::PARAM_STR);
    }else{
        $session->set("errors",["product not found"]);
        $request->redirect("index.php");
    }
}else{
    $request->redirect("index.php");
}

?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">

        <?php
        require_once "inc/errors.php";
      


    ?>


            <form action="handlers/updateProduct.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name = "name" value="<?php echo $product['name'] ?>">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']?>">
                </div>

                <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name = "body"><?php echo $product['body'] ?></textarea>
                </div>

                <div class="mb-3">
                <label for="formFile" class="form-label">Image:</label>
                <input class="form-control" type="file" id="formFile" name="img">
                </div>

                <div class="col-lg-3">
                        <img src="uploads/<?php echo $product['img'] ?>" class="card-img-top">
                        </div>
                        
                <center><button on type="submit" class="btn btn-primary" name="submit">Add</button></center>
            </form>
        </div>
    </div>
</div>



<?php include 'inc/footer.php'; ?>
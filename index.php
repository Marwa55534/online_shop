<?php include 'inc/header.php'; 
require_once "inc/connection.php";
require_once 'App.php';
?>

<?php
$id = $request->get("id");

$runQuery = $conn->query("select * from products");
if($runQuery->rowCount()>0){  // num_rows
    $products = $runQuery->fetchAll();
}
else{
    $msg = "There are no products";
  }
?>

<div class="container my-5">

    <div class="row">
        

<?php
    if(! empty($products)) :
        foreach ($products as $product) :
?>
 <?php
            require_once "inc/success.php";
            require_once "inc/errors.php";

            
            ?>
    <div class="col-lg-4 mb-3">

            <div class="card">
            <img src="uploads/<?php echo $product['img'] ?>" class="card-img-top">
            <div class="card-body">
            <h5 class="card-title"><?php echo $product['name'] ?></h5>
            <p class="text-muted"><?php echo $product['price'] ?></p>
            <p class="card-text"><?php echo Str::limit($product['body']) ?></p>
           
    
            <a href="show.php?id=<?php echo $product["id"] ?>" class="btn btn-primary">Show</a>
       
            <a href="edit.php?id=<?php echo $product["id"] ?>" class="btn btn-info">Edit</a>
            <a href="handlers/deleteProduct.php?id=<?php echo $product["id"] ?>" class="btn btn-danger">Delete</a>
           
        
        </div>
        </div>
    </div>
    <?php
     endforeach ;
          else : echo $msg ;
          endif ;
   
    ?>
        
    </div>

</div>



<?php include 'inc/footer.php'; ?>
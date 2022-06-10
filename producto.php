<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$user_id = $_SESSION['user_id'];

if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

if (!isset($user_id)) {
   header('location:login.php');
};

if (isset($_POST['add_to_cart'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $filter = array('_id' => new \MongoDB\BSON\ObjectId($user_id), 'name' => $product_name);

   $check_cart_numbers = $carrito->count($filter);

   if ($check_cart_numbers>0) {
      $message[] = 'El producto ya está en el carrito.';
   } else {
      $agregarCarritoTienda = $carrito->insertOne(['user_id' => new \MongoDB\BSON\ObjectId($user_id), 'name' => $product_name, 'price' => (int)$product_price,'quantity' => (int)$product_quantity, 'image'=> $product_image]);
      $message[] = 'El producto fue añadido al carrito.';
      
   }
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tienda</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Producto</h3>
      <p> <a href="home.php">Inicio</a> / Producto</p>
   </div>


   <section class="products">

<h1 class="title">Producto</h1>

<section class="padding-y">
<div class="container">

<div class="row">
<aside class="col-lg-6">
  <article class="gallery-wrap"> 
    <div class="img-big-wrap img-thumbnail">
       <a data-fslightbox="mygalley" data-type="image"> 
       <?php
                    $dato_id = $_GET['dato'];
                    $select_products = $productos->findOne(
                        array('_id' => new MongoDB\BSON\ObjectId($dato_id))
                    );
                    ?>
                    <img class="mx-auto d-block " height="560" data-mdb-zoom-effect="true" src="uploaded_img/<?php echo $select_products['image']; ?>" alt="">
       </a>
    </div> <!-- img-big-wrap.// -->
    
  </article> <!-- gallery-wrap .end// -->
</aside>
<main class="col-lg-6">
  <article class="ps-lg-3">
    <h4 class="title text-dark"><?php echo $select_products['name']; ?></h4>


    <div class="mb-3"> 
      <var class="price h2">$<?php echo $select_products['price']; ?></var> 
      <span class="text-muted">/precio</span> 
    </div> 

    <h2><?php echo $select_products['description']; ?></h2>



    <div class="row mb-4">
      <!-- col.// -->
      <div class="col-md-4 col-6 mb-3">
        <!-- <label class="form-label d-block">Cantidad</label>
        <div class="input-group input-spinner">
        <input  type="number" min="1" name="product_quantity" value="1" class="form-control" style="font-size:25px;">
           -->
          <form action="" method="post">
                        <div class="">
                            <label hidden="true" for="product_quantity">Ingrese la cantidad deseada</label></br>
                            <input hidden="true" type="number" min="1" name="product_quantity" value="1" class="form-control" style="font-size:25px;">
                            <input type="hidden" name="product_name" value="<?php echo $select_products['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $select_products['price']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $select_products['image']; ?>">
                            <input type="submit" value="Añadir al carrito" name="add_to_cart" class="white-btn"></br>
                        </div>
                    </form>
        </div> <!-- input-group.// -->
      </div> <!-- col.// -->
    </div> <!-- row.// -->
  </article> <!-- product-info-aside .// -->
</main> <!-- col.// -->
</div> <!-- row.// -->

</div> <!-- container .//  -->
</section>





   <?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>

</html>
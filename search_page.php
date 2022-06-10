<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = $carrito -> findOne(['name' => $product_name, 'user_id' => $user_id]);

   if(isset($check_cart_numbers)){
      $message[] = 'El producto ya está en el carrito.';
   }else{
      $agregarCarritoTienda = $carrito -> insertOne(['user_id' => $user_id, 'name' => $product_name, 'price' => $product_image, 'quantity' => $product_quantity, 'image' => $product_image]);
      $message[] = 'El producto fue añadido al carrito.';
      var_dump($agregarCarrito);
   }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Página de Búsqueda</h3>
   <p> <a href="home.php">Inicio</a> / Búsqueda </p>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="Buscar productos" class="box">
      <input type="submit" name="submit" value="Buscar" class="btn">
   </form>
</section>

<section class="products" style="padding-top: 0;">

   <div class="box-container">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         //$regex = '/'.$search_item.'/';
         $mongoRegex = new MongoDB\BSON\Regex("$search_item", "i");
         //$productos -> find(array('name' => $regex));
         //$filter = array('name' => $search_item);
         $conteo = $productos -> find(['name' => $mongoRegex]);

         if(isset($conteo)){
            $select_products1 = $productos -> find(
               ['name' => $mongoRegex]
           );
         foreach($select_products1 as $fetch_product){
   ?>
   <form action="" method="post" class="box">
      <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image">
      <div class="name"><?php echo $fetch_product['name']; ?></div>
      <div class="price">$<?php echo $fetch_product['price']; ?></div>
      <input hidden="true" type="number"  class="qty" name="product_quantity" min="1" value="1">
      <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
      <input type="submit" class="white-btn" value="Añadir al carrito" name="add_to_cart">
   </form>
   <?php
            }
         }else{
            echo '<p class="empty">No hay resultados.</p>';
         }
      }else{
         echo '<p class="empty">Haga una búsqueda.</p>';
      }
   ?>
   </div>
  

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
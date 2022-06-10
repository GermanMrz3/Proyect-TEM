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
      <h3>Sonido</h3>
      <p> <a href="home.php">Inicio</a> / Tienda</p>
   </div>

   <section class="products">

      <h1 class="title">Últimos productos</h1>

      <div class="box-container">

        
            <?php
            $select_products = $productos->find(
               //['name'=>'Conceptos Basicos Php']
            );
            foreach ($select_products as $fetch_products) {
            ?>
               <?php if ($fetch_products['product_type'] == 'sonido') { ?>
                  <form action="" method="post" class="box">
                     <a href="producto.php?dato=<?php echo $fetch_products['_id']; ?>">
                     <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt=""></a>
                     <div class="product_blog_cont">
                        <div class="name"><?php echo $fetch_products['name']; ?></div> 
                        <div class="price">$<?php echo $fetch_products['price']; ?></div>
                        <input hidden="true" type="number" min="1" name="product_quantity" value="1" class="qty">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="submit" value="Agregar" name="add_to_cart" class="white-btn">
                     </div>
                  </form>
               <?php } else {
               } ?>
            <?php
               //var_dump($fetch_products1['name']);
            }
            ?>
         </div>

   </section>

   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>
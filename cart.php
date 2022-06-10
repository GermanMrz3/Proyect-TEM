<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   var_dump($cart_quantity);
   $updateResult = $carrito -> updateOne(
      array('_id' => new \MongoDB\BSON\ObjectId($cart_id)), ['$set' == ["quantity" => $cart_quantity]]);
   $message[] = 'Carro actualizado';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = $carrito -> findOne(['_id' => $delete_id]);
   $fetch_delete_image = $carrito -> findOne(['_id' => $delete_image_query]);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   $resultadoBorrado = $carrito -> deleteOne(['_id' => new MongoDB\BSON\ObjectId($delete_id)]);
   header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
   var_dump($user_id);
   $deleteResult = $carrito->deleteMany(
      ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
   );
   $message[] = printf("Deleted %d documents", $deleteResult->getDeletedCount());
   header('location:cart.php');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Carrito de compras</h3>
   <p> <a href="home.php">Inicio</a> / Carrito </p>
</div>

<section class="shopping-cart">

   <h1 class="title">Productos agregados</h1>

   <div class="box-container">
      <?php
         $grand_total = 0;
         $select_cart = $carrito -> find(['user_id' => new MongoDB\BSON\ObjectId($user_id)]);
         if(isset($select_cart)){
            foreach($select_cart as $fetch_cart){
      ?>
      <div class="box">
         <a href="cart.php?delete=<?php echo $fetch_cart['_id']; ?>" class="fas fa-times" onclick="return confirm('¿Eliminar este producto del carrito?');"></a>
         <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['name']; ?></div>
         <div class="price">$<?php echo $fetch_cart['price']; ?></div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['_id']; ?>">
            <input hidden="true" type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
         </form>
         <div class="sub-total"> Subtotal : <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?> </span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }      
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('¿Eliminar todos los productos del carrito?');">Eliminar todo</a>
   </div>

   <div class="cart-total">
      <p>Total final: <span>$<?php echo $grand_total; ?></span></p>
      <div class="flex">
         <a hidden="true" href="shop.php" class="option-btn">Seguir comprando</a>
         <a href="checkout.php" class="white-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Pagar y confirmar</a>
      </div>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
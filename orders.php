<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Sus órdenes</h3>
   <p> <a href="home.php">Inicio</a> / Órdenes </p>
</div>

<section class="placed-orders">

   <h1 class="title">Pedidos realizados</h1>

   <div class="box-container">

      <?php
         //$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         $order_query = $ordenes -> find(["user_id" => $user_id]);
         if(isset($order_query)){
            foreach($order_query as $fetch_orders){
      ?>
      <div class="box">
         <p> Fecha de orden: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Nombre: <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Número: <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> E-mail: <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Dirección: <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Método de pago: <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> Sus órdenes: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Fecha de reserva: <span><?php echo $fetch_orders['reserve_date']; ?></span> </p>
         <p> Precio total: <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> Estado de orden: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">No tiene órdenes por el momento.</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
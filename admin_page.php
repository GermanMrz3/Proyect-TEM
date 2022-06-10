<?php

use MongoDB\Operation\CountDocuments;

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tablero</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="title">Tablero</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $total_pendings = 0;            
            $select_pending = $ordenes -> find(["payment_status" => 'pending']);            
            if(isset($select_pending)){
               foreach($select_pending as $fetch_pending){
                  $total_price = $fetch_pending['total_price'];
                  $total_pendings += $total_price;
               };
            };
         ?>
         <h3>$<?php echo $total_pendings; ?></h3>
         <p>Pendientes totales</p>
      </div>

      <div class="box">
         <?php
            $total_completed = 0;           
            $select_completed = $ordenes -> find(["payment_status" => 'completed']);
            if(isset($select_completed)){
               foreach($select_completed as $fetch_completed){
                  $total_price = $fetch_completed['total_price'];
                  $total_completed += $total_price;
               };
            };
         ?>
         <h3>$<?php echo $total_completed; ?></h3>
         <p>Completados totales</p>
      </div>

      <div class="box">
         <?php
            $select_orders = $ordenes -> countDocuments();
            //$number_of_orders = isset($select_orders);
         ?>
         <h3><?php echo $select_orders; ?></h3>
         <p>Órdenes realizadas</p>
      </div>

      <div class="box">
         <?php 
            $select_products = $productos -> countDocuments();
            //$number_of_products = isset($select_products);
         ?>
         <h3><?php echo $select_products; ?></h3>
         <p>Productos Añadidos</p>
      </div>

      <div class="box">
         <?php 
            $select_users = $usuarios -> countDocuments(["user_type" => 'user']);
            //$number_of_users = isset($select_users);
         ?>
         <h3><?php echo $select_users; ?></h3>
         <p>Usuarios Normales</p>
      </div>

      <div class="box">
         <?php 
            $select_admins = $usuarios -> countDocuments(["user_type" => 'admin']);
            //$number_of_admins = isset($select_users);
         ?>
         <h3><?php echo $select_admins; ?></h3>
         <p>Administradores</p>
      </div>

      <div class="box">
         <h3><?php echo $select_users + $select_admins; ?></h3>
         <p>Cuentas totales</p>
      </div>

      <div class="box">
         <?php 
            $select_messages = $mensaje -> countDocuments();
            //$number_of_messages = isset($select_messages);
         ?>
         <h3><?php echo $select_messages; ?></h3>
         <p>Nuevos Mensajes</p>
      </div>

   </div>

</section>
<!-- admin dashboard section ends -->

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
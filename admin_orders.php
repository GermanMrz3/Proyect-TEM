<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   // $actualizar = $ordenes -> updateOne(['_id' => new MongoDB\BSON\ObjectId($order_update_id)], '$set' == ["payment_status" => $update_payment]);
   $actualizar = $ordenes->updateOne(
      array('_id' => new MongoDB\BSON\ObjectId($order_update_id)),
      ['$set' => ['payment_status' => $update_payment]]
  );

   $message[] = 'El estatus de pago ha sido actualizado.';
   
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $deleteResult = $ordenes -> deleteOne(['_id' => new MongoDB\BSON\ObjectId($delete_id)]);
   header('location:admin_orders.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Órdenes</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Órdenes agregadas actualmente</h1>

   <div class="box-container">
      <?php
      $select_orders = $ordenes -> find();
      if(isset($select_orders)){
         foreach($select_orders as $fetch_orders){
      ?>
      <div class="box">
         <p> ID del usuario: <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> Realizada en: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Nombre: <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Número: <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> E-mail: <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Dirección: <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Total de productos: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Precio total: <span>$<?php echo $fetch_orders['total_price']; ?></span> </p>
         <p> Método de pago: <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['_id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">Pendiente</option>
               <option value="completed">Completada</option>
            </select>
            <input type="submit" value="Actualizar orden" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['_id']; ?>" onclick="return confirm('¿Desea eliminar esta orden?');" class="delete-btn">Eliminar orden</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No hay órdenes agregadas.</p>';
      }
      ?>
   </div>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
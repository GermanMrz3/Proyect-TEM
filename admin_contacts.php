<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $mensaje -> deleteOne(['_id' => new MongoDB\BSON\ObjectId($delete_id)]);
   header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title"> Mensajes recibidos</h1>

   <div class="box-container">
   <?php
      $select_message = $mensaje -> find();
      if(isset($select_message)){
         foreach($select_message as $fetch_message){
      
   ?>
   <div class="box">
      <!-- p> user id : <span><?php echo $fetch_message['user_id']; ?></span> </p-->
      <p> Nombre: <span><?php echo $fetch_message['name']; ?></span> </p>
      <p> Número : <span><?php echo $fetch_message['number']; ?></span> </p>
      <p> E-mail: <span><?php echo $fetch_message['email']; ?></span> </p>
      <p> Mensaje: <span><?php echo $fetch_message['message']; ?></span> </p>
      <a href="admin_contacts.php?delete=<?php echo $fetch_message['_id']; ?>" onclick="return confirm('¿Desea eliminar este mensaje?');" class="delete-btn">Eliminar mensaje</a>
   </div>
   <?php
      };
   }else{
      echo '<p class="empty">No tiene mensajes.</p>';
   }
   ?>
   </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
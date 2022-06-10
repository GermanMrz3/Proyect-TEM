<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();


$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $usuarios -> deleteOne(['_id' => new MongoDB\BSON\ObjectId($delete_id)]);
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title"> Cuentas de usuario </h1>

   <div class="box-container">
      <?php
         $select_users = $usuarios -> find();
         foreach($select_users as $fetch_users){
      ?>
      <div class="box">
         <p> ID del usuario: <span><?php echo $fetch_users['_id']; ?></span> </p>
         <p> Nombre de usuario: <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> E-mail: <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> Tipo de usuario: <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['_id']; ?>" onclick="return confirm('¿Desea eliminar este usuario?');" class="delete-btn">Eliminar usuario</a>
      </div>
      <?php
         };
      ?>
   </div>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
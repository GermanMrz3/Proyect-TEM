<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){


   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $msg = $_POST['message'];

   $select_message = $mensaje -> findOne(['message' => $msg, 'name' => $name, 'email' => $email, 'number' => $number]);

   if(isset($select_message)){
      $message[] = 'message sent already!';
   }else{
      $mensaje -> insertOne(['message' => $msg, 'name' => $name, 'email' => $email, 'number' => $number]);
      $message[] = 'message sent successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Página de Contacto</h3>
   <p> <a href="home.php">Inicio</a> / Contáctenos </p>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>¡Escríbanos!</h3>
      <input type="text" name="name" required placeholder="Nombre" class="box">
      <input type="email" name="email" required placeholder="E-mail" class="box">
      <input type="number" name="number" required placeholder="Número" class="box">
      <textarea name="message" class="box" placeholder="Ingrese su mensaje" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Enviar" name="send" class="white-btn">
   </form>

</section>


<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
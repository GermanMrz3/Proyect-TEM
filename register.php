<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $email = $_POST['email'];
   $pass = $_POST['password'];
   $cpass = $_POST['cpassword'];
   $user_type = 'user';
   $shopDB = $conexion -> $shopDB;

   $comparacion = $usuarios -> findOne(['email' => $email],['password' => $pass]);

   if(!empty($comparacion)){
      $message[] = '¡El usuario ya existe!';
   }else{
      if($pass != $cpass){
         $message[] = 'Las contraseñas no coinciden. Intente de nuevo.';
      }else{
         $usuarios -> insertOne(['email' => $email, 'password' => $pass, 'name' => $name, 'user_type' => $user_type]);
         $message[] = 'Se ha registrado exitosamente. ¡Bienvenido/a!';
         header('location:login.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title></title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Regístrese</h3>
      <input type="text" name="name" placeholder="Nombre" required class="box">
      <input type="email" name="email" placeholder="Correo Electrónico" required class="box">
      <input type="password" name="password" placeholder="Contraseña" required class="box">
      <input type="password" name="cpassword" placeholder="Confirmar Contraseña" required class="box">
      <input type="submit" name="submit" value="Guardar" class="btn">
      <p>¿Ya tiene una cuenta? <a href="login.php">Iniciar sesión</a></p>
   </form>

</div>

</body>
</html>
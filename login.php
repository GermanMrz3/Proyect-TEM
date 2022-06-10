<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $pass = $_POST['password'];

   $comparacion = $usuarios -> findOne(['email' => $email, 'password' => $pass]);

   if(isset($comparacion['email'])){

      if($comparacion['user_type'] == 'admin'){
         $_SESSION['admin_email'] = $comparacion['email'];
         $_SESSION['admin_pass'] = $comparacion['password'];
         $_SESSION['admin_id'] = $comparacion['_id'];
         header('location:admin_page.php');
      }
      elseif($comparacion['user_type'] == 'user'){
         $_SESSION['user_email'] = $comparacion['email'];
         $_SESSION['user_pass'] = $comparacion['password'];
         $_SESSION['user_id'] = $comparacion['_id'];
         header('location:home.php');
      }

   }else{
      $message[] = 'El correo y/o la contraseña son incorrectas, o el usuario/adminisrador no existe. Verifique e intente de nuevo.';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

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
      <h3>Inicio de sesión</h3>
      <input type="email" name="email" placeholder="E-mail" required class="box">
      <input type="password" name="password" placeholder="Contraseña" required class="box">
      <input type="submit" name="submit" value="Ingresar" class="btn">
      <p>¿Aún no tiene una cuenta? <a href="register.php">Registrarse</a></p>
   </form>

</div>

</body>  
</html>
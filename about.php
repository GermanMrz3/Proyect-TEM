<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/es.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Acerca de</h3>
      <p> <a href="home.php">Inicio</a> / Acerca de</p>
   </div>
   <br>
   <br>
   <div class="contenedor sombra">
   <div class="servicio formul">
   <blockquote class=" text-center">
   <h1>ACERCA DE NOSOTROS</h1>
      <h4>Este sitio esta diseñado para que los usuarios puedan vivir una experiencia
         agradable y fácil de utilizar.</h2>
      <br>
      <h4>Hemos creado contenidos y herramientas que ayudan a las parejas en cada
         de los puntos para organizar su boda.
         <br>
         Desde el lugar para la boda, al vestido
         para que lo encuentren fácilmente lo que necesiten.</h2>
      <br>
      <h4>Como creadores del sitio tratamos que puedas organizar y optimizar el
         tiempo de organización de tu boda soñada,
      <br> 
         donde podrás comunicarte con nosotros si tienes alguna duda y te contestaremos contestando en el menor
         tiempo, Bright Beauty,</h2>

   </blockquote>
   </div>
   </div>
   <section class="about">

      <div class="flex">

         <div class="image">
            <img src="images/Boda6.jpeg" alt="">
         </div>

         <div class="content">
            <h3>¿POR QUÉ ELEGIRNOS?</h3>
            <p>Somos una empresa donde buscamos y realizamos todo aquello que usted soñó para su día especial</p>
            <p>Bright Beauty es tu mejor opción para llevar su boda ideal</p>
            <a href="contact.php" class="white-btn">Contáctanos</a>
         </div>

      </div>

   </section>

   <section class="authors">

      <h1 class="title">Grandes autores</h1>

      <div class="box-container">

         <div class="box">
            <img src="images/German.png" alt="">
            <div class="share">
               <a href="https://www.facebook.com/geralber/" class="fab fa-facebook-f" target="_blank"></a>
               <a href="https://twitter.com/geralber12" class="fab fa-twitter" target="_blank"></a>
               <a href="https://instagram.com/geralber12?igshid=YmMyMTA2M2Y=" class="fab fa-instagram" target="_blank"></a>
               <a href="https://www.linkedin.com/in/german-alberto-mart%C3%ADnez-mej%C3%ADa-209b651a0/" target="_blank" class="fab fa-linkedin"></a>
            </div>
            <h3>German Martínez</h3>
         </div>

         <div class="box">
            <img src="images/Julio.png" alt="">
            <div class="share">
               <a href="https://www.facebook.com/profile.php?id=100005682227207" target="_blank" class="fab fa-facebook-f"></a>
               <a href="https://twitter.com/JRuiz476" target="_blank" class="fab fa-twitter"></a>
               <a href="https://instagram.com/julio_ruiz98?igshid=YmMyMTA2M2Y=" target="_blank" class="fab fa-instagram"></a>
               <a href="#" class="fab fa-linkedin"></a>
            </div>
            <h3>Julio Ruiz</h3>
         </div>

         <!--div class="box">
         <img src="images/luis.png" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Luis Marroquín</h3>
      </div-->

      </div>


   </section>
<!-- Gallery -->
<div class="contenedor sombra">
<h1 class="text-center">Galería</h1>
<div class="row" >
  <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
    <img
      src="images/Boda6.jpeg"
      class="w-100 shadow-1-strong rounded mb-4"
      alt="Boat on Calm Water"
    /> 

    <img
      src="images/Boda1.jpg"
      class="w-100 shadow-1-strong rounded mb-4"
      alt="Wintry Mountain Landscape"
    />
  </div>

  <div class="col-lg-4 mb-4 mb-lg-0">
    <img
      src="images/Boda2.jpg"
      class="w-100 shadow-1-strong rounded mb-4"
      alt="Mountains in the Clouds"
    />

    <img
      src="images/Boda3.jpg"
      class="w-100 shadow-1-strong rounded mb-4"
      alt="Boat on Calm Water"
    />
  </div>

  <div class="col-lg-4 mb-4 mb-lg-0">
    <img
      src="images/Boda4.jpg"
      class="w-100 shadow-1-strong rounded mb-4"
      alt="Waves at Sea"
    />

    <img
      src="images/Boda5.jpg"
      class="w-100 shadow-1-strong rounded mb-4"
      alt="Yosemite National Park"
    />
  </div>
  
</div>
</div>
<!-- Gallery -->
   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>
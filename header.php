<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';

$user_id = $_SESSION['user_id'];

if (isset($mensaje)) {
   foreach ($mensaje as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<header class="header">

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Bright Beauty</a>

         <nav class="navbar">
            <a href="home.php">Inicio</a>
            <a href="about.php">Acerca de</a>
            <a href="contact.php">Contáctenos</a>
            <a href="orders.php">Ordenes</a>
          <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tienda<b class="caret"></b>
               </a>
               <ul class="dropdown-menu">
                  <li><a href="shop_vestidos.php">Vestidos</a></li>
                  <li><a href="shop_trajes.php">Trajes</a></li>
                  <li><a href="shop_lugares.php">Lugares</a></li>
                  <li><a href="shop_sonido.php">Sonido</a></li>
                  <li><a href="shop_comida.php">Comida</a></li>
                  <li><a href="shop_pasteles.php">Pasteles</a></li>
               </ul>
            </li> 
         
            </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
            $select_cart_number = $carrito->countDocuments(['user_id' => $user_id]);
            $cart_rows_number = ($select_cart_number);
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p>E-mail: <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Cerrar sesión</a>
         </div>
      </div>
   </div>

</header>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
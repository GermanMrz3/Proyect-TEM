<?php


include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['order_btn'])) {

   $number = $_POST['number'];
   $placed_on = date('d-M-Y');

   $name1 = $_POST['name'];
   $number1 = $_POST['number'];
   $email1 = $_POST['email'];
   $method1 = $_POST['method'];
   $address1 = $_POST['flat'] . ', ' . $_POST['city'];
   $placed_on1 = date('d-M-Y');
   $reserva = $_POST['reserva'];


   $cart_total = 0;
   $cart_products[] = '';


   $filter = array('user_id' => new MongoDB\BSON\ObjectId($user_id));
   $conteo = $carrito->count($filter);
   $i = 0;
   if ($conteo > 0) {


      $cart_query1 = $carrito->find(array('user_id' => new MongoDB\BSON\ObjectId($user_id)));
      foreach ($cart_query1 as $cart_item1) {

         if ($i > 0) {
            $cart_products[] = ' ,' . $cart_item1['name'] . ' x ' . $cart_item1['quantity'];
         } else {
            $cart_products[] = $cart_item1['name'] . ' x ' . $cart_item1['quantity'];
         }
         $sub_total = ($cart_item1['price'] * $cart_item1['quantity']);
         $cart_total += $sub_total;
         $i++;
      }
   }

   $total_products = implode('', $cart_products);


   $filter = array('name' => $name1, 'number' => $number1, 'email' => $email1, 'method' => $method1, 'address' => $address1, 'total_products' => $total_products, 'total_price' => $cart_total);
   $order_query1 = $ordenes->count($filter);

   if ($cart_total == 0) {
      $message[] = 'Tu carrito de compras está vacío.';
   } else {
      if ($order_query1 > 0) {
         $message[] = 'La orden ya fue realizada.';
      } else {

         // VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $insertOneResult = $ordenes->insertOne(
            ['user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $name1, 'number' => $number1, 'email' => $email1, 'method' => $method1, 'address' => $address1, 'total_products' => $total_products, 'total_price' => $cart_total, 'placed_on' => $placed_on, 'reserve_date' => $reserva, 'payment_status' => 'pending']
         );
         $message[] = 'Orden realizada exitosamente.';
         $deleteResult = $carrito->deleteMany(
            ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
         );
         header('location:orders.php');
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
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Comprar</h3>
      <p> <a href="home.php">Inicio</a> / Comprar </p>
   </div>

   <section class="display-order">

      <?php
      $grand_total = 0;
      $filter = array('user_id' => new MongoDB\BSON\ObjectId($user_id));
      $select_cart = $carrito->count($filter);
      echo "<h2>Cuenta a pagar</h2>";
      if ($select_cart > 0) {
         $cart_query1 = $carrito->find(array('user_id' => new MongoDB\BSON\ObjectId($user_id)));
         foreach ($cart_query1 as $fetch_cart1) {
            $total_price = ($fetch_cart1['price'] * $fetch_cart1['quantity']);
            $grand_total += $total_price;
      ?>
            <ul class="list-group list-group-flush">
               <li class="" style="font-size: 15px ;"><?php echo $fetch_cart1['name']; ?> (<?php echo '$' . $fetch_cart1['price'] . ' X ' . $fetch_cart1['quantity']; ?>)</li>
               <hr style="height:1px;border:none;color:#333;background-color:#333;">
            </ul>
      <?php
         }
      } else {
         echo '<p class="empty">Tu carrito de compra está sólo</p>';
      }
      ?>

      <div class="grand-total">Total final: <span>$<?php echo $grand_total; ?></span> </div>

   </section>

   <section class="checkout">

      <form action="" method="post">
         <h3>Haz tu pedido</h3>
         <div class="flex">
            <div class="inputBox">
               <span>Nombre:</span>
               <input type="text" name="name" required placeholder="Ingrese su nombre">
            </div>
            <div class="inputBox">
               <span>Número:</span>
               <input type="number" name="number" required placeholder="Ingrese su número">
            </div>
            <div class="inputBox">
               <span>E-mail :</span>
               <input type="email" name="email" required placeholder="Ingrese su E-mail">
            </div>
            <div class="inputBox">
               <span>Forma de pago:</span>
               <select name="method">
                  <!-- <option value="cash on delivery">cash on delivery</option> -->
                  <option value="credit card">Tarjeta de crédito/débito</option>
                  <option value="paypal">PayPal</option>
                  <!-- <option value="paytm">paytm</option> -->
               </select>
            </div>
            <div class="inputBox">
               <span>Número de tarjeta/cuenta PayPal:</span>
               <input type="number" name="paymentnumber" required placeholder="Ingrese su número de cuenta">
            </div>
            <div class="inputBox">
               <span>Dirección:</span>
               <input type="text" min="0" name="flat" required placeholder="Ingrese su dirección">
            </div>
            <div class="inputBox">
               <span>Departamento:</span>
               <input type="text" name="departamento" required placeholder="Departamento">
            </div>
            <div class="inputBox">
               <span>Municipio:</span>
               <input type="text" name="municipio" required placeholder="Municipio">
            </div>
           


         <div>
            <span>Fecha de reserva:</span>
            <input type="date" id="start" name="reserva" value="2022-06-03" min="2022-01-01" max="2024-12-31">
         </div>
            

            <br>


         </div>
         <input type="submit" value="Pagar y ordenar" class="white-btn" name="order_btn">
      </form>

   </section>

   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>
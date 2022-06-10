<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
};

if (isset($_POST['add_to_cart'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $filter = array('_id' => new \MongoDB\BSON\ObjectId($user_id), 'name' => $product_name);

   $check_cart_numbers = $carrito->count($filter);

   if ($check_cart_numbers>0) {
      $message[] = 'El producto ya está en el carrito.';
   } else {
      $agregarCarritoTienda = $carrito->insertOne(['user_id' => new \MongoDB\BSON\ObjectId($user_id), 'name' => $product_name, 'price' => (int)$product_price,'quantity' => (int)$product_quantity, 'image'=> $product_image]);
      $message[] = 'El producto fue añadido al carrito.';
      
   }
};


?>

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

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   <link rel="icon" href="images/favicon.ico" type="image/x-icon">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato:300,400,700,400italic%7CJosefin+Sans:400,700,300italic">

   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/Style-car.css">


</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Bright Beauty</h3>
      <p>TUS SUEÑOS HECHOS REALIDAD</p>
      <a href="about.php" class="white-btn">Acerca de nosotros</a>
   </div>

</section>
<!-- Portfolio-->
<div class="contenedor sombra">
<section class="section section-md bg-white text-center">
        <div class="shell-fluid">
          <p class="heading-1">Portafolio</p>
          <div class="isotope thumb-ruby-wrap wow fadeIn" data-isotope-layout="masonry" data-isotope-group="gallery" data-lightgallery="group">
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 isotope-item"><a class="thumb-ruby thumb-mixed_height-2 thumb-mixed_md" href="images/Catedral.jpg" data-lightgallery="item"><img class="thumb-ruby__image" src="images/Catedral.jpg" alt="" width="440" height="327"/>
                        <div class="thumb-ruby__caption"> 
                          <p class="thumb-ruby__title heading-3">Imagen #</p>
                          
                        </div></a>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 isotope-item"><a class="thumb-ruby thumb-mixed_height-3 thumb-mixed_md" href="images/Pastel.jpg" data-lightgallery="item"><img class="thumb-ruby__image" src="images/Pastel.jpg" alt="" width="444" height="683"/>
                        <div class="thumb-ruby__caption"> 
                          <p class="thumb-ruby__title heading-3">Imagen #</p>
                         
                        </div></a>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 isotope-item"><a class="thumb-ruby thumb-mixed_height-2 thumb-mixed_md" href="images/Lugar1.jpg" data-lightgallery="item"><img class="thumb-ruby__image" src="images/Lugar1.jpg" alt="" width="440" height="327"/>
                        <div class="thumb-ruby__caption"> 
                          <p class="thumb-ruby__title heading-3">Imagen #</p>
                         
                        </div></a>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 isotope-item"><a class="thumb-ruby thumb-mixed_height-3 thumb-mixed_md" href="images/Boda7.jpg" data-lightgallery="item"><img class="thumb-ruby__image" src="images/Boda7.jpg" alt="" width="444" height="683"/>
                        <div class="thumb-ruby__caption"> 
                          <p class="thumb-ruby__title heading-3">Imagen #</p>
                          
                        </div></a>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 isotope-item"><a class="thumb-ruby thumb-mixed_height-2 thumb-mixed_md" href="images/Catedral2.jpeg" data-lightgallery="item"><img class="thumb-ruby__image" src="images/Catedral2.jpeg" alt="" width="440" height="327"/>
                        <div class="thumb-ruby__caption"> 
                          <p class="thumb-ruby__title heading-3">Imagen #</p>
                        </div></a>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 isotope-item"><a class="thumb-ruby thumb-mixed_height-2 thumb-mixed_md" href="images/Lugar3.jpeg" data-lightgallery="item"><img class="thumb-ruby__image" src="images/Lugar3.jpeg" alt="" width="440" height="327"/>
                        <div class="thumb-ruby__caption"> 
                          <p class="thumb-ruby__title heading-3">Imagen #</p>
                        </div></a>
              </div>
            </div>
          </div>
        </div>
      </section>
      </div>


<section class="products">

<h1 class="title">Combos del mes</h1>

<div class="box-container">

  
      <?php
      $select_products = $productos->find(
         //['name'=>'Conceptos Basicos Php']
      );
      foreach ($select_products as $fetch_products) {
      ?>
         <?php if ($fetch_products['product_type'] == 'combos') { ?>
            <form action="" method="post" class="box">
               <a href="producto.php?dato=<?php echo $fetch_products['_id']; ?>">
               <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt=""></a>
               <div class="product_blog_cont">
                  <div class="name"><?php echo $fetch_products['name']; ?></div> 
                  <div class="price">$<?php echo $fetch_products['price']; ?></div>
                  <input hidden="true" type="number" min="1" name="product_quantity" value="1" class="qty">
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                  <input type="submit" value="Agregar" name="add_to_cart" class="white-btn">
               </div>
            </form>
         <?php } else {
         } ?>
      <?php
         //var_dump($fetch_products1['name']);
      }
      ?>
   </div>

</section>



<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/Boda4.jpg" alt="">
      </div>

      <div class="content">
         <h3>Acerca de</h3>
         <p>Somos una empresa que ayuda a todas aquellas parejas que quieren realizar su boda perfecta</p>
         <a href="about.php" class="white-btn">Ver más</a>
      </div>

   </div>

</section>
<!-- My Best Photos -->
<section class="section text-center">
        <!-- Slick Carousel-->
        <div class="slick-wrap">
          <div class="slick-slider slick-style-1" data-arrows="true" data-autoplay="true" data-loop="true" data-dots="true" data-swipe="true" data-xs-swipe="true" data-sm-swipe="false" data-items="1" data-sm-items="3" data-md-items="3" data-lg-items="3" data-center-mode="true" data-lightgallery="group-slick">
            <div class="item">
              <div class="slick-slide-inner">
                <div class="slick-slide-caption"><a class="thumb-ann thumb-mixed_large" href="images/Boda1.jpg" data-lightgallery="item"><img class="thumb-ann__image" src="images/Boda1.jpg" alt="" width="961" height="664"/>
                    <div class="thumb-ann__caption"> 
                      <p class="thumb-ann__title heading-3">Amor</p>
                      <p class="thumb-ann__text"> “El amor se compone de una sola alma que habita en dos cuerpos”, Aristóteles.</p>
                    </div></a>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="slick-slide-inner">
                <div class="slick-slide-caption"><a class="thumb-ann thumb-mixed_large" href="images/Boda2.jpg" data-lightgallery="item"><img class="thumb-ann__image" src="images/Boda2.jpg" alt="" width="961" height="664"/>
                    <div class="thumb-ann__caption"> 
                      <p class="thumb-ann__title heading-3">Amar</p>
                      <p class="thumb-ann__text">“Amar no es mirarse el uno al otro, es mirar juntos es la misma dirección”, Antonie de Saint-Exupéry.</p>
                    </div></a>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="slick-slide-inner">
                <div class="slick-slide-caption"><a class="thumb-ann thumb-mixed_large" href="images/Boda3.jpg" data-lightgallery="item"><img class="thumb-ann__image" src="images/Boda3.jpg" alt="" width="961" height="664"/>
                    <div class="thumb-ann__caption"> 
                      <p class="thumb-ann__title heading-3">Te quiero</p>
                      <p class="thumb-ann__text">“Te quiero no por quien eres, sino por quien soy cuando estoy contigo”, Gabriel García Márquez.</p>
                    </div></a>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="slick-slide-inner">
                <div class="slick-slide-caption"><a class="thumb-ann thumb-mixed_large" href="images/Boda4.jpg" data-lightgallery="item"><img class="thumb-ann__image" src="images/Boda4.jpg" alt="" width="961" height="664"/>
                    <div class="thumb-ann__caption"> 
                      <p class="thumb-ann__title heading-3">Saber</p>
                      <p class="thumb-ann__text">“Todo lo que sabemos del amor es que el amor es todo lo que hay”, Emily Dickinson.</p>
                    </div></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


<section class="home-contact"> 
   <div class="content">
      <h3>¿Tiene alguna pregunta?</h3>
      <p>Si tiene alguna consulta o duda acerca de los precios o combos, escríbanos, ¡y con gusto le ayudamos!</p>
      <a href="contact.php" class="white-btn">Contáctenos</a>
   </div>

</section>


<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/core.min.js"></script>
<script src="js/script.js"></script>
<script src="js/script_car.js"></script>

</body>
</html>
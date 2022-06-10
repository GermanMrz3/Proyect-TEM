<?php

include 'config.php';
include 'conexion.php';
require 'vendor/autoload.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){
  
   $shopDB = $conexion -> shopDB;
   $productos = $shopDB -> productos;
   $name = $_POST['name'];
   $descr = $_POST['description'];
   $price = $_POST['price'];
   $product_type = $_POST['tipo_producto'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = $productos -> findOne(['name' => $name]);
   if (isset($select_product_name['name'])){
      $message[] = 'El producto ingresado ya existe. Intente de nuevo con un nombre distinto.';
   }else{
      $add_product_query = $productos -> insertOne(['name' => $name, 'price' => $price, 'description' => $descr, 'product_type' => $product_type, 'image' => $image]);

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'La imagen es demasiado grande. Escoja una de menor tamaño e intente de nuevo.';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = '¡El producto fue añadido exitosamente!';
         }
      }else{
         $message[] = 'El producto no pudo ser añadido. Corrobore los datos e intente de nuevo.';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = $productos -> findOne(['_id' => $delete_id]);
   $fetch_delete_image = $productos -> findOne(['_id' => $delete_image_query]);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   $resultadoBorrado = $productos -> deleteOne(['_id' => new MongoDB\BSON\ObjectId($delete_id)]);
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];
   $actualizar = $productos -> updateMany(['_id' => $update_p_id], '$set' == ["name" => $update_name, "price" => $update_price]);
   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'La imagen es bastante grande. Intente con una imagen de menor resolución.';
      }else{
         $actualizar = $productos -> updateMany(['_id' => $update_p_id], '$set' == ["image" => $update_image]);
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }
   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">Productos</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Ingreso de productos</h3>
      <input type="text" name="name" class="box" placeholder="Ingrese el nombre del producto" required>
      <input type="text" name="description" class="box" placeholder="Ingrese la descripción del producto" required>
      <input type="number" min="0" name="price" class="box" placeholder="Ingrese el precio del producto" required>
      <select name="tipo_producto" class="box">
         <option value="vestidos">Vestidos de Novia</option>
         <option value="trajes">Trajes de Novio</option>
         <option value="lugares">Lugares</option>
         <option value="comida">Comida</option>
         <option value="pasteles">Pastel</option>
         <option value="sonido">Sonido</option>
         <option value="combos">Combos</option>
      </select>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="Añadir producto" name="add_product" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = $productos -> find();
         if(isset($select_products)){
            foreach($select_products as $fetch_products){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="descripcion" name="product_descr"><?php echo $fetch_products['description']; ?></div>
         <div class="price">$<?php echo $fetch_products['price']; ?></div>
         <a href="admin_products.php?delete=<?php echo $fetch_products['_id']; ?>" class="delete-btn" onclick="return confirm('¿Quiere eliminar este producto?');">Eliminar</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Aún no hay productos en la base de datos.</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = $productos -> find(['_id' => $update_id]);

         if (isset($update_query)){
            foreach($update_query as $fetch_update){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['_id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Ingrese el nombre del producto">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Ingrese el precio del producto">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
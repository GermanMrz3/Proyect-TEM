<?php

//$conn = mysqli_connect('localhost','root','','shop_db') or die('connection failed');

require 'vendor/autoload.php';
    use MongoDB\Client as Mongo;
    $conexion = new Mongo("mongodb://localhost:27017");
    $shopDB = $conexion -> shopDB;
    $carrito = $shopDB -> carrito;
    $mensaje = $shopDB -> mensaje;
    $ordenes = $shopDB -> ordenes;
    $productos = $shopDB -> productos;
    $usuarios = $shopDB -> usuarios;

?>
<?php
require "./html/html.php";
require "./db/dbfunciones.php";
session_start();
$pagina = basename($_SERVER['PHP_SELF']);
HTMLinicio("Insertar Categoria| Comida Sana para todos los días");
$tipoUsuario = "";
if(isset($_SESSION["id"])){

   $db = DBconexion();
   $datosUsuario = DBgetUsuario($db, $_SESSION["id"]);
   DBdesconexion($db);

   $tipoUsuario = $datosUsuario["tipo"];
}else{
   $tipoUsuario = "visitante";
}

if($tipoUsuario != "administrador"){
   header("Refresh: 0.1; url=./index.php");
}


if(isset($_SESSION["errorLogin"])){
    $errorLogin = TRUE;
}else{
    $errorLogin = FALSE;
}
HTMLnav(4,$tipoUsuario);
HTMLlogout($datosUsuario,$pagina);


$numRecetas = DBgetNumRecetas();
HTMLwidget1($numRecetas);

$topRecetas = DBgetTopRecetas();
HTMLwidget2($topRecetas);

HTMLtituloContenido("Categorías");

HTMLbotonCrearCategoria();
$categorias = DBgetCategorias();
HTMLverCategorias($categorias);


HTMLfin();



?>

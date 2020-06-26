<?php
require "./html/html.php";
require "./db/dbfunciones.php";
session_start();
$pagina = basename($_SERVER['PHP_SELF']);
HTMLinicio("Gestión de Usuarios | Comida Sana para todos los días");
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
HTMLnav(5,$tipoUsuario);
HTMLlogout($datosUsuario,$pagina);


$numRecetas = DBgetNumRecetas();
HTMLwidget1($numRecetas);

$topRecetas = DBgetTopRecetas();
HTMLwidget2($topRecetas);

HTMLtituloContenido("Gestión De Usuarios");
HTMLbotonCrearUsuario();

$usuarios = DBgetUsuarios();
HTMLverUsuarios($usuarios);


HTMLfin();



?>

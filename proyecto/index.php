<?php
require "./html/html.php";
require "./db/dbfunciones.php";
session_start();
$pagina = basename($_SERVER['PHP_SELF']);
HTMLinicio("INICIO | Comida Sana para todos los días");
$tipoUsuario = "";
if(isset($_SESSION["id"])){

   $db = DBconexion();
   $datosUsuario = DBgetUsuario($db, $_SESSION["id"]);
   DBdesconexion($db);

   $tipoUsuario = $datosUsuario["tipo"];
}else{
   $tipoUsuario = "visitante";
}

if(isset($_SESSION["errorLogin"])){
    $errorLogin = TRUE;
}else{
    $errorLogin = FALSE;
}
HTMLnav(0,$tipoUsuario);

$numRecetas = DBgetNumRecetas();
if($tipoUsuario == "visitante"){
   HTMLlogin($errorLogin,$pagina,$numRecetas);
   unset($_SESSION["errorLogin"]);
}else{
   HTMLlogout($datosUsuario,$pagina);
}

HTMLwidget1($numRecetas);

$topRecetas = DBgetTopRecetas();
HTMLwidget2($topRecetas);


if(isset($_SESSION["recetaAleatoria"])){
   $id = $_SESSION["recetaAleatoria"];
}else{
   $id = 1;
}
$receta = DBgetReceta($id);
HTMLverReceta($receta, $tipoUsuario,isset($_SESSION["id"]));
echo "</div>";

HTMLfin();



?>

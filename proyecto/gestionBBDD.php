<?php
require "./html/html.php";
require "./db/dbfunciones.php";
session_start();
$pagina = basename($_SERVER['PHP_SELF']);
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

if (isset($_GET['download'])) {
   if (!is_string($db=DBconexion())) {
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="davidguillermo1920.sql"');
         echo DBBackup();
      DBdesconexion($db);
   }
} else {
   HTMLinicio("Exportar BBDD| Comida Sana para todos los días");
   HTMLnav(7,$tipoUsuario);
   HTMLlogout($datosUsuario,$pagina);


   $numRecetas = DBgetNumRecetas();
   HTMLwidget1($numRecetas);

   $topRecetas = DBgetTopRecetas();
   HTMLwidget2($topRecetas);

   HTMLtituloContenido("Gestión de la Base de Datos");

   HTMLExportarBBDD();
   HTMLImportarBBDD();


   echo "</div></div>";


   HTMLfin();
}

?>

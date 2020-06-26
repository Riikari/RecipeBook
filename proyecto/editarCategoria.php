<?php
require "./html/html.php";
require "./html/htmlforms.php";
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



if(isset($_POST["Eliminar"]) && $_POST["Eliminar"]=='Eliminar'){
   HTMLtituloContenido("Eliminar Categoría");
   if(isset($_POST["id"])){
      $id = htmlentities($_POST['id']);
      $resultado = DBdelete($id, "listacategorias");
      if($resultado){
         HTMLinformar("La categoría se borró de la base de datos correctamente");
         DBaddLog($datosUsuario['email'], "borrado una categoría");
      }else{
         HTMLerror($resultado);
      }
      echo "<p><a href='./insertarCategoria.php'>Volver a la lista</a></p>";
   }

}else if(isset($_POST["Crear"]) && $_POST["Crear"]=='Crear Nueva Categoria'){
   HTMLtituloContenido("Crear Nueva Categoria");
   FORMnuevaCategoria();
}else if(isset($_GET["crearCategoria"])){
   HTMLtituloContenido("Crear Nueva Categoria");
   $dato =  htmlentities($_GET["nombre"]);
   if($dato != ''){
      $resultado = DBaddCategoria($dato);
      if(!$resultado){
         HTMLinformar("La categoría se añadió de la base de datos correctamente");
         DBaddLog($datosUsuario['email'], "añadido nueva categoría");
      }else{
         HTMLerror($resultado);
      }
}
   echo "<p><a href='./insertarCategoria.php'>Volver a la lista</a></p>";
}

echo "</div></div>";
HTMLfin();



?>

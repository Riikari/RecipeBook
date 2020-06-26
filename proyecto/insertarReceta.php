<?php
require "./html/html.php";
require "./html/htmlforms.php";
require "./db/dbfunciones.php";
session_start();
$pagina = basename($_SERVER['PHP_SELF']);
HTMLinicio("Insertar Receta | Comida Sana para todos los días");
$tipoUsuario = "";
if(isset($_SESSION["id"])){

   $db = DBconexion();
   $datosUsuario = DBgetUsuario($db, $_SESSION["id"]);
   DBdesconexion($db);

   $tipoUsuario = $datosUsuario["tipo"];
}else{
   $tipoUsuario = "visitante";
}

if($tipoUsuario == "visitante"){
      header("Refresh: 0.1; url=./index.php");
}

if(isset($_SESSION["errorLogin"])){
    $errorLogin = TRUE;
}else{
    $errorLogin = FALSE;
}
$numRecetas = DBgetNumRecetas();
HTMLnav(2,$tipoUsuario);
if($tipoUsuario == "visitante"){
   HTMLlogin($errorLogin,$pagina,$numRecetas);
   unset($_SESSION["errorLogin"]);
}else{
   HTMLlogout($datosUsuario,$pagina);
}


HTMLwidget1($numRecetas);

$topRecetas = DBgetTopRecetas();
HTMLwidget2($topRecetas);

HTMLtituloContenido("Insertar Receta");

///////////////////
$receta = false;
$accion = '';

if(isset($_POST['accion']) && $_POST['accion']=="Añadir Receta"){
   if($_POST['titulo']==''){
      $receta['info'][]='No ha introducido el titulo';
      $receta['titulo'] = '';
      $accion = 'Corregir';
   } else
      $receta['titulo'] = htmlentities($_POST['titulo']);

   if($_POST['ingredientes']==''){
      $receta['info'][]='No han introducido los ingredientes';
      $receta['ingredientes'] = '';
      $accion = 'Corregir';
   } else
      $receta['ingredientes'] = htmlentities($_POST['ingredientes']);

   if($_POST['preparacion']==''){
      $receta['info'][]='No han introducido los pasos de preparacion';
      $receta['preparacion'] = '';
      $accion = 'Corregir';
   } else
      $receta['preparacion'] = htmlentities($_POST['preparacion']);

   $receta['id'] = isset($_POST['id']) ? htmlentities($_POST['id']) : '';
   $receta['descripcion'] = isset($_POST['descripcion']) ? htmlentities($_POST['descripcion']) : '';

   $categorias = DBgetCategorias();
   foreach($categorias as $c){
      if(isset($_POST[$c['nombre']]))
         $receta['categorias'][$_POST[$c['nombre']]] = htmlentities($_POST[$c['nombre']]);
   }

   if($accion != 'Corregir') $accion = 'Confirmar';
}
else if(isset($_POST['accion']) && $_POST['accion']=='Confirmar'){
   $receta['titulo'] = isset($_POST['titulo']) ? htmlentities($_POST['titulo']) : '';
   $receta['id'] = isset($_POST['id']) ? htmlentities($_POST['id']) : '';
   $receta['descripcion'] = isset($_POST['descripcion']) ? htmlentities($_POST['descripcion']) : '';
   $receta['ingredientes'] = isset($_POST['ingredientes']) ? htmlentities($_POST['ingredientes']) : '';
   $receta['preparacion'] = isset($_POST['preparacion']) ? htmlentities($_POST['preparacion']) : '';

   $categorias = DBgetCategorias();
   foreach($categorias as $c){
      if(isset($_POST[$c['nombre']]))
         $receta['categorias'][htmlentities($_POST[$c['nombre']])] = htmlentities($_POST[$c['nombre']]);
   }

   $accion = 'Enviado';
}
else
   $accion = 'Añadir';


switch($accion){
   case 'Añadir':
      $receta['enviado'] = false;
      $receta['editable'] =  true;
      FORMeditReceta($receta,"Añadir Receta");
   break;
   case 'Corregir':
      $receta['enviado'] = true;
      $receta['editable'] =  true;
      FORMeditReceta($receta,"Añadir Receta");
   break;
   case 'Confirmar':
      $receta['enviado'] = true;
      $receta['editable'] =  false;
      FORMeditReceta($receta,"Confirmar");
   break;
   case 'Enviado':
      $receta['usuario_id'] = $datosUsuario['id'];
      $res = DBaddReceta($receta);
      if ($res){
         HTMLinformar("Receta añadida con éxito ");
         DBaddLog($datosUsuario['email'], "añadido una nueva receta");
         echo "<p class='ml-4'><a href='".$_SERVER["SCRIPT_NAME"]."'>Añada otra Receta</a></p>";
      }else
         HTMLerror($receta['info']);
   break;
}

echo "</div></div>";
HTMLfin();



?>

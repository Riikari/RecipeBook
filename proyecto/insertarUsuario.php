<?php
require "./html/html.php";
require "./html/htmlforms.php";
require "./db/dbfunciones.php";
session_start();
$pagina = basename($_SERVER['PHP_SELF']);
HTMLinicio("Editar Usuario | Comida Sana para todos los días");
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

HTMLtituloContenido("Crear Nuevo Usuario");

///////////////////

$usuario = false;
$accion = '';

if(isset($_POST['accion']) && $_POST['accion']=="Crear Usuario"){
   if($_POST['nombre']==''){
      $usuario['info'][]='No ha introducido el nombre de Usuario';
      $usuario['nombre'] = '';
      $accion = 'Corregir';
   } else
      $usuario['nombre'] = htmlentities($_POST['nombre']);

   if($_POST['apellidos']==''){
      $usuario['info'][]='No ha introducido los apellidos del Usuario';
      $usuario['apellidos'] = '';
      $accion = 'Corregir';
   } else
      $usuario['apellidos'] = htmlentities($_POST['apellidos']);

      if($_POST['email']==''){
         $usuario['info'][]='No ha introducido el email del Usuario';
         $usuario['email'] = '';
         $accion = 'Corregir';
      } else if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
         $usuario['email'] = htmlentities($_POST['email']);
      }else{
         $usuario['info'][]='Introduce un correo válido';
         $usuario['email'] = '';
         $accion = 'Corregir';
      }

      $usuario['id'] = isset($_POST['id']) ? htmlentities($_POST['id']) : '';


   if($_POST['usuario']==''){
      $usuario['info'][]='No ha introducido el nick del usuario';
      $usuario['usuario'] = '';
      $accion = 'Corregir';
   } else
      $usuario['usuario'] = htmlentities($_POST['usuario']);

   if($_POST['tipo']==''){
      $usuario['info'][]='No ha escrito el tipo de usuario';
      $usuario['tipo'] = '';
      $accion = 'Corregir';
   } else if($_POST['tipo'] !='administrador' && $_POST['tipo'] !='colaborador'){
      $usuario['info'][]='No ha escrito el tipo de usuario correctamente (administrador o colaborador)';
      $usuario['tipo'] = '';
      $accion = 'Corregir';
   }else
      $usuario['tipo'] = htmlentities($_POST['tipo']);

   if($_POST['password1']=='' || $_POST['password2']==''){
      $usuario['info'][]='Rellene ambos campos de la contraseña';
      $accion = 'Corregir';
   }else if($_POST['password1'] != $_POST['password2']){
      $usuario['info'][]='Las contraseñas no coinciden';
      $accion = 'Corregir';
   }else{
      $usuario['password'] = htmlentities($_POST['password1']);
   }

   if($accion != 'Corregir') $accion = 'Confirmar';
}
else if(isset($_POST['accion']) && $_POST['accion']=='Confirmar'){
   $usuario['id'] = isset($_POST['id']) ? htmlentities($_POST['id']) : '';
   $usuario['nombre'] = isset($_POST['nombre']) ? htmlentities($_POST['nombre']) : '';
   $usuario['apellidos'] = isset($_POST['apellidos']) ? htmlentities($_POST['apellidos']) : '';
   $usuario['email'] = isset($_POST['email']) ? htmlentities($_POST['email']) : '';
   $usuario['tipo'] = isset($_POST['tipo']) ? htmlentities($_POST['tipo']) : '';
   $usuario['usuario'] = isset($_POST['usuario']) ? htmlentities($_POST['usuario']) : '';
   $usuario['password'] = isset($_POST['password1']) ? htmlentities($_POST['password1']) : '';
   $usuario['foto'] = isset($_POST['foto']) ? htmlentities($_POST['foto']) : '';
   $accion = 'Enviado';
}
else
   $accion = 'Crear';


switch($accion){
   case 'Crear':
      $usuario['enviado'] = false;
      $usuario['tipo'] = '';
      $usuario['password'] = '';
      $usuario['editable'] =  true;
      FORMeditUsuario($usuario,"Crear Usuario");
   break;
   case 'Corregir':
      $usuario['enviado'] = true;
      $usuario['editable'] =  true;
      FORMeditUsuario($usuario,"Crear Usuario");
   break;
   case 'Confirmar':
      $usuario['enviado'] = true;
      $usuario['editable'] =  false;
      FORMeditUsuario($usuario,"Confirmar");
   break;
   case 'Enviado':
      $res = DBaddUsuario($usuario);
      if (!$res){
         HTMLinformar("Usuario añadido con éxito ");
         DBaddLog($datosUsuario['email'], "añadido nuevo usuario");
         echo "<p class='ml-4'><a href='".$_SERVER["SCRIPT_NAME"]."'>Añada otro Usuario</a></p>";
      }else
         HTMLerror($res);
   break;
}



echo ("</div></div>");
HTMLfin();



?>

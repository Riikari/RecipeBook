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

$accion ='';

///////////VARIABLES POST/////////////////////////
if (isset($_POST['accion'])) {

  switch ($_POST['accion']) {
    case 'Borrar':
      $accion = 'Borrar';
    break;
    case 'Confirmar Borrado':
      $accion = 'Confirmar Borrado';
    break;
    case 'Editar':
      $accion = 'Editar';
    break;
   }
   if(isset($_POST['id'])){
      $id = htmlentities($_POST['id']);
   }
}

if(isset($_POST['accion']) && $_POST['accion']=="Editar Usuario"){

   if(!empty($_FILES['foto'])){
     $usuario['name_foto'] = $_FILES['foto']['name'];
     $usuario['size_foto'] = $_FILES['foto']['size'];
     if($usuario['size_foto'] > 1048576){   //1 MB
       $usuario['info'][]='La imagen pesa demasiado';
       $accion = 'Corregir';
     }else{
       $usuario['destino'] = './styles/img/users/';
       move_uploaded_file($_FILES['foto']['tmp_name'],  $usuario['destino'].$usuario['name_foto']);
       $usuario['foto_subida'] = $usuario['destino'].$usuario['name_foto'];
       $accion = 'Confirmar';
    }
   }

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

   if($accion != 'Corregir'){
      $accion = 'Confirmar Usuario';
   }

}else if(isset($_POST['accion']) && $_POST['accion']=='Confirmar Usuario'){
   $usuario['id'] = isset($_POST['id']) ? htmlentities($_POST['id']) : '';
   $usuario['nombre'] = isset($_POST['nombre']) ? htmlentities($_POST['nombre']) : '';
   $usuario['apellidos'] = isset($_POST['apellidos']) ? htmlentities($_POST['apellidos']) : '';
   $usuario['email'] = isset($_POST['email']) ? htmlentities($_POST['email']) : '';
   $usuario['tipo'] = isset($_POST['tipo']) ? htmlentities($_POST['tipo']) : '';
   $usuario['usuario'] = isset($_POST['usuario']) ? htmlentities($_POST['usuario']) : '';
   $usuario['password'] = isset($_POST['password1']) ? htmlentities($_POST['password1']) : '';
   $usuario['foto'] = isset($_POST['foto']) ? htmlentities($_POST['foto']) : '';
   $accion = 'Modificar Usuario';
}

switch ($accion) {
   case 'Borrar':
      HTMLtituloContenido("Eliminar Usuario");
      $db = DBconexion();
      $usuario = DBgetUsuario($db,$id);
      DBdesconexion($db);

      $usuario['editable']=false;
      $usuario['enviado']=true;
      FORMeditUsuario($usuario,'Confirmar Borrado');
   break;
   case 'Confirmar Borrado':
      HTMLtituloContenido("Eliminar Usuario");
      if($datosUsuario['id']==$id){
         $autoborrado = true;
      }else{
         $autoborrado = false;
      }
      $error = DBdelete($id, "usuarios");
      if($error){
         HTMLerror($error);
      }else{
         if($autoborrado){
            HTMLinformar("El usuario se ha borrado éxito");
            DBaddLog($datosUsuario['email'], " borrado a si mismo");
            unset($_SESSION["id"]);
            echo "<p class='ml-4'><a href='index.php'>Menu Principal</a></p>";
         }else{
            HTMLinformar("El usuario se ha borrado éxito");
            DBaddLog($datosUsuario['email'], "ha borrado un usuario");
            echo "<p class='ml-4'><a href='gestionUsuarios.php'>Vuelva a la lista de usuarios</a></p>";
         }

      }
   break;
   case 'Editar':
         HTMLtituloContenido("Editar Usuario");
         $db = DBconexion();
         $usuario = DBgetUsuario($db,$id);
         DBdesconexion($db);
         $usuario['editable']=true;
         $usuario['enviado']=true;
         $usuario["password"] = "";
         FORMeditUsuario($usuario,'Editar Usuario');
   break;
   case 'Corregir':
         HTMLtituloContenido("Editar Usuario");
         $usuario['id'] = $id;
         $usuario['editable']=true;
         $usuario['enviado']=true;
         $usuario["password"] = "";
         if(isset($_POST['foto'])){
            $usuario['foto'] = htmlentities($_POST['foto']);
         }
         FORMeditUsuario($usuario, 'Editar Usuario');
   break;
   case 'Confirmar Usuario':
         HTMLtituloContenido("Editar Usuario");
         $usuario['id'] = $id;
         if(isset($_POST['foto'])){
            $usuario['foto'] = htmlentities($_POST['foto']);
         }
         $usuario['editable']=false;
         $usuario['enviado']=true;
         FORMeditUsuario($usuario, 'Confirmar Usuario');
   break;
   case 'Modificar Usuario':
         HTMLtituloContenido("Editar Usuario");
         $error = DBupdtUsuario($usuario);
         if($error){
            HTMLerror($error);
         }else{
            HTMLinformar("El usuario se ha modificado con éxito");
            DBaddLog($datosUsuario['email'], "modificado un usuario");
            echo "<p class='ml-4'><a href='gestionUsuarios.php'>Vuelva al listado de Usuarios</a></p>";
         }
   break;

}





echo "</div></div>";
HTMLfin();
?>

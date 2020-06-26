<?php
require "./html/html.php";
require "./html/htmlforms.php";
require "./db/dbfunciones.php";
session_start();
$pagina = basename($_SERVER['PHP_SELF']);
HTMLinicio("Lista de Recetas| Comida Sana para todos los días");
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
$numRecetas = DBgetNumRecetas();
HTMLnav(1,$tipoUsuario);
if($tipoUsuario == "visitante"){
   HTMLlogin($errorLogin,$pagina,$numRecetas);
   unset($_SESSION["errorLogin"]);
}else{
   HTMLlogout($datosUsuario,$pagina);
}

HTMLwidget1($numRecetas);

$topRecetas = DBgetTopRecetas();
HTMLwidget2($topRecetas);

$accion ='';
///////////VARIABLES POST/////////////////////////
if (isset($_POST['accion'])) {
  switch ($_POST['accion']) {
    case 'Eliminar': // Presentar formulario y pedir confirmación
      $accion = 'Eliminar';
    break;
    case 'Ver Receta':
      $accion = 'Ver Receta';
    break;
    case 'Editar': // Presentar formulario y pedir confirmación
      $accion = 'Editar';
    break;
    case 'Comentar': // Borrado confirmado
      $accion = 'Comentar';
    break;
    case 'Añadir Comentario':
      $accion = 'Añadir Comentario';
    break;
    case 'Borrar Comentario':
      $accion = 'Borrar Comentario';
    break;
    case 'Valorar':
      $accion = 'Valorar';
    break;
    case 'Confirmar':
      $accion = 'Confirmar';
    break;
    case 'Confirmar Borrado':
      $accion = "Confirmar Borrado";
      break;
    case 'Cancelar': break;
   }
   if(isset($_POST['id'])){
      $id = htmlentities($_POST['id']);
   }

}

if(isset($_POST['accion']) && $_POST['accion']=="Editar Datos"){

   if(!empty($_FILES['fotografia'])){
     $receta['name_foto'] = $_FILES['fotografia']['name'];
     $receta['size_foto'] = $_FILES['fotografia']['size'];
     if($receta['size_foto'] > 1048576){   //1 MB
       $receta['info'][]='La imagen pesa demasiado';
       $accion = 'Corregir';
     }else{
       $receta['destino'] = './styles/img/recetas/';
       move_uploaded_file($_FILES['fotografia']['tmp_name'],  $receta['destino'].$receta['name_foto']);
       $receta['fotografia_subida'] = $receta['destino'].$receta['name_foto'];
       $accion = 'Confirmar';
    }
   }

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
         $receta['categorias'][htmlentities($_POST[$c['nombre']])] = htmlentities($_POST[$c['nombre']]);
   }





   if($accion != 'Corregir') $accion = 'Confirmar';
}
else if(isset($_POST['accion']) && $_POST['accion']=='Confirmar'){
   $receta['fotografia'] = isset($_POST['fotografia']) ? htmlentities($_POST['fotografia']) : '';

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

   $accion = 'Modificar';
}

switch($accion){
   case 'Ver Receta':
      $receta = DBgetReceta($id);
      HTMLverReceta($receta, $tipoUsuario,isset($_SESSION["id"]));
   break;
   case 'Eliminar':
      HTMLtituloContenido("Eliminar Receta");
      $receta = DBgetReceta($id);
      $vector = DBgetCategorias($id);

      foreach($vector as $v){
         $receta['categorias'][$v['nombre']] = $v['nombre'];
      }

      $receta['editable']=false;
      $receta['enviado']=true;


      FORMeditReceta($receta, 'Confirmar Borrado');
      echo ("</div></div>");
      break;
   case 'Confirmar Borrado':
      HTMLtituloContenido("Eliminar Receta");
      $error = DBdelete($id, "receta");
      if($error){
         HTMLerror($error);
      }else{
         HTMLinformar("La receta se ha borrado éxito");
         DBaddLog($datosUsuario['email'], "borrado una receta");
         echo "<p class='ml-4'><a href='index.php'>Vuelva a la página principal</a></p>";
      }
      break;
   case 'Editar':
      HTMLtituloContenido("Editar Receta");
      $receta = DBgetReceta($id);
      $vector = DBgetCategorias($id);
      foreach($vector as $v){
         $receta['categorias'][$v['nombre']] = $v['nombre'];
      }
      $receta['editable']=true;
      $receta['enviado']=true;
      FORMeditReceta($receta, 'Editar Datos');
      echo ("</div>");
      break;
   case 'Confirmar':
      HTMLtituloContenido("Confirmar Receta");
      if(isset($_POST['fotografia'])){
         $receta['fotografia'] = htmlentities($_POST['fotografia']);
      }
      $receta['editable']=false;
      $receta['enviado']=true;
      FORMeditReceta($receta, 'Confirmar');
      echo ("</div>");
      break;
   case 'Modificar':
      HTMLtituloContenido("Editar Receta");
      $error = DBupdtReceta($receta);
      if($error){
         HTMLerror($error);
      }else{
         HTMLinformar("La receta se ha modificado con éxito");
         DBaddLog($datosUsuario['email'], "modificado una receta");
         echo "<p class='ml-4'><a href='listaRecetas.php'>Vuelva al listado de Recetas</a></p>";
      }
      echo ("</div>");
      break;
   case 'Corregir':
      HTMLtituloContenido("Editar Receta");
      $receta['editable']=true;
      $receta['enviado']=true;
      FORMeditReceta($receta, 'Editar Datos');
      echo ("</div>");
   break;
   case 'Comentar':
      HTMLtituloContenido("Añadir Comentario");
      FORMaddComentario($id);
      echo ("</div>");
      break;
   case 'Añadir Comentario':
      HTMLtituloContenido("Añadir Comentario");
      if($tipoUsuario == 'visitante'){
         $usuario_id = 100;
      }else{
         $usuario_id = $datosUsuario['id'];
      }
      if(isset($_POST['comentario'])){

         $comentario = htmlentities($_POST['comentario']);
         $errores = DBaddComentario($id,$comentario,$usuario_id);
      }else{
         $errores = "Comentario Incorrecto";
      }

      if($errores){
         HTMLerror($errores);
      }else{
         HTMLinformar("Su comentario se ha realizado con éxito");
         DBaddLog($datosUsuario['email'], "ha comentado en una receta");
         echo "<p class='ml-4'><a href='index.php'>Vuelva a la página principal</a></p>";
      }
      echo ("</div>");
      break;
      case 'Borrar Comentario':
      HTMLtituloContenido("Borrar Comentario");
      if(isset($_POST['id_comentario'])){
         $id_comentario = htmlentities($_POST['id_comentario']);
         $error = DBdelete($id_comentario,"comentarios");
         if($error){
            HTMLerror($error);
         }else{
            HTMLinformar("El comentario se ha borrado éxito");
            DBaddLog($datosUsuario['email'], "ha borrado un comentario");
            echo "<p class='ml-4'><a href='index.php'>Vuelva a la página principal</a></p>";
         }
      }
      break;
      case 'Valorar':
      if(isset($_POST['estrellas'])){
         $valoracion = htmlentities($_POST['estrellas']);
      }else{
         $valoracion = 0;
      }

         HTMLtituloContenido("Valorar Receta");
         $id_receta = $id;
         $id_usuario = $datosUsuario['id'];
         $error = DBaddValoracion($id_receta,$id_usuario,$valoracion);
         if($error){
            HTMLerror($error);
         }else{
            HTMLinformar("La receta se ha valorado con éxito");
            DBaddLog($datosUsuario['email'], "valorado una receta");
            echo "<p class='ml-4'><a href='index.php'>Vuelva a la página principal</a></p>";
         }
         echo "</div>";
      break;

}

echo "</div>";
HTMLfin();
?>

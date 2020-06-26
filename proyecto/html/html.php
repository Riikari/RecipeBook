<?php

function HTMLinicio($titulo){
echo <<< HTML
   <!DOCTYPE html>
   <html lang="es">
   <head>
     <meta charset="UTF-8">
     <meta name="author" content="David Román Castellano | Guillermo Palomino Sánchez">
     <link rel="icon" type="image/png" href="./styles/img/pages/logo.png">
     <title>{$titulo}</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
     <link rel="stylesheet" href="./styles/valoracion.css">
   </head>
   <body>
      <div class="container-fluid bg-secondary">
         <div class="container bg-light">
            <!-- CABECERA -->
            <header class="bg-dark">
               <div class="row">
                  <div class="col-md-1 text-light ml-2">
                     <img src="./styles/img/pages/logo.png" class="img-fluid mx-2"width="80px" alt="logo">
                  </div>
                  <div class="col-md-10 mx-auto text-light text-right">
                     <h1 class="display-4 ">Comida Sana todos los días</h1>
                  </div>
               </div>
            </header>
HTML;
}

function HTMLfin(){
echo <<< HTML
   <footer class="bg-dark text-center py-2 px-2">
      <p class="text-light">Pagina Web hecha por David Román Castellano y Guillermo Palomino Sánchez</p>
      <a href="./DocumentacionTW.pdf">Enlace a la Documentación</a>
   </footer>

</div>
</div>
</body>
</html>
HTML;
}

//Función que muestra el menú de navegación dependiendo del tipo de usuario que sea
function  HTMLnav($opcionActiva,$tipoUsuario){
   $paginas = ["index.php","listaRecetas.php","insertarReceta.php","misRecetas.php","insertarCategoria.php","gestionUsuarios.php","log.php","gestionBBDD.php"];
    switch ($tipoUsuario) {
       case "administrador":
         $items = ["Inicio","Lista de Recetas","Insertar Receta","Mis Recetas","Insertar Categoría","Gestión de Usuarios","Ver log","Gestión BBDD"];
         break;
       case "colaborador":
         $items = ["Inicio","Lista de Recetas","Insertar Receta","Mis Recetas"];
         break;
       case "invitado":
         $items = ["Inicio","Lista de Recetas","Insertar Receta","Mis Recetas"];
         break;
       case "visitante":
         $items = ["Inicio","Lista de Recetas"];
         break;
    }
echo <<< HTML
    <nav>
    <ul class="nav nav-tabs bg-dark">
HTML;
   foreach ($items as $p => $v) {
      if($p == $opcionActiva){
         echo "<li class='nav-item'>";
         echo "<a class='nav-link active text-dark' href='".$paginas[$p]."'>".$items[$p]."</a>";
         echo "</li>";
      }else{
         echo "<li class='nav-item'>";
         echo "<a class='nav-link text-light' href='".$paginas[$p]."'>".$items[$p]."</a>";
         echo "</li>";
      }
   }
echo <<< HTML
   </ul>
   </nav>
   <img src="./styles/img/pages/imgcabecera.PNG" class="img-fluid" alt="Responsive image">
HTML;
}

// Función que muestra el formulario para que los usuarios puedan loguearse, muestra un error en caso
// de que falle
function HTMLlogin($error,$pagina,$numRecetas){
echo <<< HTML

   <div class="row mt-2">
      <div class="col-md-4">

         <div class="border-dark border border-dark my-2">
            <h4 class="bg-dark text-light px-2 py-2">Login</h4>
               <form action="./db/sesions.php" method="post" class="mx-4 my-3">
                 <div class="form-group">
                   <label>Usuario</label>
                   <input type="text" class="form-control" id="usuario" name="usuario">
                 </div>
                 <input type="hidden" name="pagina" value=$pagina />
                 <input type="hidden" name="numRecetas" value=$numRecetas />
                 <div class="form-group">
                   <label>Contraseña</label>
                   <input type="password" class="form-control" id="clave" name="clave">
HTML;
                   if($error == TRUE){
                      echo "<small class='text-danger'>Error al introducir los datos</small>";
                  }
echo <<< HTML
                 </div>
                 <input type="submit" class="btn btn-success " value="Iniciar Sesión" name="login"></input>
              </form>
         </div>
HTML;
}

// Función que muestra el formulario para desloguearse de la página
function HTMLlogout($datosUsuario,$pagina){

/*
Cogemos el tipo de usuario y modificamos el primer char del string para ponerlo
en mayúsculas porque me da algo verlo todo en minúsculas, y de esta forma no hay
que modificar ni la base de datos ni el resto del código
*/
$tipo = $datosUsuario['tipo'];
$correo = $datosUsuario['email'];
$tipo = ucfirst($tipo);

echo <<< HTML

      <div class="row mt-2">
      <div class="col-md-4">
      <div class="border-dark border border-dark my-2">
         <h4 class="bg-dark text-light px-2 py-2">Logout</h4>
         <p class='text-dark mx-3 my-0'>Usuario: {$datosUsuario['usuario']}</p>
         <div class="row ml-3">
            <p class='text-dark'>Permisos:</p>
            <p class="text-info ml-1">{$tipo}</p>
         </div>
         <img src="{$datosUsuario['foto']}" width="100px"class= "rounded mx-auto d-block my-1" alt="Imagen del usuario">
         <div class="row" id="botones">
HTML;
   if($tipo == "Administrador"){
echo <<< HTML
      <form class="row my-3 mx-auto" action="./editarUsuario.php" method="post">
         <input type="hidden" name="id" value ='{$datosUsuario['id']}'></input>
         <input type="submit" class="btn btn-warning mx-auto" value="Editar" name="accion"/>
      </form>
HTML;
   }

echo <<< HTML
            <form action="./db/sesions.php" method="post" class=" row my-3 mx-auto">
               <input type="hidden" name="pagina" value=$pagina />
               <input type="hidden" name="correo" value=$correo />
              <input type="submit" class="btn btn-danger mx-auto" value="Finalizar Sesión" name="login"></input>
            </form>
         </div>
HTML;
      echo "<input type='hidden' name='idUsuario' value='".$datosUsuario["id"]."'/></form></div>";
}

//Función que muestra el número total de recetas que hay en la BBDD de la página
function HTMLwidget1($numRecetas){
   echo <<< HTML
      <div class="border-dark border border-dark my-2">
         <h4 class="bg-dark text-light px-2 py-2">Nº de Recetas</h4>
         <p class="text-dark mx-2"> En esta página web hay un total de <b>{$numRecetas}</b> recetas</p>
      </div>
HTML;
}

//Función que muestra el título de las 3 recetas mejor valoradas de la BBDD
function HTMLwidget2($topRecetas){
   echo <<< HTML
   <div class="border-dark border border-dark my-2">
      <h4 class="bg-dark text-light px-2 py-2">Recetas mejores valoradas</h4>
      <ol>
HTML;
   foreach ($topRecetas as $r) {
      echo "<li>".$r."</li>";
   }
   echo "</ol></div></div>";
}

//Función que muestra un título del apartado principal de la página
function HTMLtituloContenido($titulo){
echo <<< HTML
   <div class="col-md-8 my-2">
      <div class="bg-dark px-2 py-2">
         <h2 class="display-5 text-light">$titulo</h2>
      </div>
HTML;
}

// Función que muestra una tabla con los 10 eventos más recientes que han ocurrido
// en la página
function HTMLverLogs($logs){
echo <<< HTML
<table class="table table-striped table-dark">
   <thead>
      <tr>
         <th scope="col">Tiempo</th>
         <th scope="col">Descripción</th>
      </tr>
   </thead>
   <tbody>
HTML;
   foreach ($logs as $l) {
   echo "<tr>";
   echo "<td>{$l['fecha']}</td>";
   echo "<td>{$l['descripcion']}</td></tr>";
   }
   echo "</tbody></table></div></div>";
}

// Función que muestra 5 estrellas animadas para realizar una valoración de una
// receta en específico. En caso de que ya estuviera valorada por ese usuario,
// las estrellas aparecerán marcadas en función de la valoración anteriormente
// seleccionada. También muestra la media de valoración que tiene esa receta
function HTMLverValoracion($receta, $tipoUsuario,$usuario){

   $media = DBgetValoraciones($receta['id']);
   if($tipoUsuario != 'visitante'){
      $yaValorada = DBgetValoracion($receta,$usuario);

   $chk1 = "";
   $chk2 = "";
   $chk3 = "";
   $chk4 = "";
   $chk5 = "";

   if($yaValorada){
      switch($yaValorada){
         case 1:
            $chk1 = "checked";
            break;
         case 2:
            $chk2 = "checked";
            break;
         case 3:
            $chk3 = "checked";
            break;
         case 4:
            $chk4 = "checked";
            break;
         case 5:
            $chk5 = "checked";
            break;
      }
   }else{
      $chk1 = "";
      $chk2 = "";
      $chk3 = "";
      $chk4 = "";
      $chk5 = "";
   }
   }


   echo "<form method='post' action='./editarReceta.php'>";
   if($tipoUsuario != 'visitante'){
echo <<< HTML
   <div class="row mx-4">
      <p class="clasificacion mt-3">
         <input type="hidden" name='id' value="{$receta['id']}"/>
         <input id="radio5" type="radio" name="estrellas" value="5" $chk5><label for="radio5">★</label>
         <input id="radio4" type="radio" name="estrellas" value="4" $chk4><label for="radio4">★</label>
         <input id="radio3" type="radio" name="estrellas" value="3" $chk3><label for="radio3">★</label>
         <input id="radio2" type="radio" name="estrellas" value="2" $chk2><label for="radio2">★</label>
         <input id="radio1" type="radio" name="estrellas" value="1" $chk1><label for="radio1">★</label>
      </p>
      <input type='submit' name='accion' value='Valorar' class='btn btn-success btn-xs ml-4 my-3'></input>
      </div>
HTML;
}
echo <<< HTML
     <label class="ml-3">Media: <b>{$media}</b></label>
   </form>
HTML;
}


//Función que muestra toda la información de una receta en específico.
// En el caso de que el usuario sea el propietario de dicha receta o el administrador,
// al final de la página encontrará una tabla de botones donde podrá editar o eliminar
// dicha receta
function HTMLverReceta($receta, $tipoUsuario,$usuario){
   HTMLtituloContenido($receta['titulo']);
   $ingredientes = explode("-",$receta['ingredientes']);
   $pasos = explode("-", $receta['preparacion']);
   $descrp = explode("-",$receta['descripcion']);
echo <<< HTML
   <div class="row">
      <h4 class="col-md-8 mt-4">Autor: <b>{$receta['autor']}</b></h4>
HTML;
   HTMLverValoracion($receta,$tipoUsuario,$usuario);

echo <<< HTML
   </div>
<div class="row">
   <div class="col-md-7 col-sm-12">
      <img src="{$receta['fotografia']}" class="img-fluid rounded float-left" alt="Responsive image">
      <h4 class="mx-3 my-3 display-6 ">Categorias</h4>
         <ul>
HTML;
   foreach ($receta['categorias'] as $c ) {
         echo "<li>{$c['nombre']}</li>";
   }
echo <<< HTML
   </ul>
   </div>
   <div class="col-md-4 bg-light">
      <h4 class="display-6">Ingredientes</h4>
      <ul class="list-group">
HTML;
   foreach ($ingredientes as $ing){
     if($ing != ""){
       echo "<li class='list-group-item'>";
       echo $ing;
       echo "</li>";
     }
   }
   echo "</ul></div></div>";
echo <<< HTML
   <div class="border border-dark my-2">
     <h4 class="col-md-12 display-6 bg-dark py-2 text-light">Descripción</h4>
HTML;
 foreach ($descrp as $des){
   if($des != ""){
   echo "<li class='list-group-item'>";
   echo $des;
   echo "</li>";
   }
 }
 echo "</ul></div>";
echo <<< HTML
 <h4 class="col-md-12 display-6 bg-dark px-2 py-2 mt-2 text-light">Preparación</h4>
<ol class="list-group">
HTML;
   foreach ($pasos as $pas){
     if($pas != ""){
     echo "<li class='list-group-item'>";
     echo $pas;
     echo "</li>";
     }
   }
   echo "</ol>";
   $id = $receta['id'];
   $comentarios = DBgetComentarios($id);
   if($comentarios){
      HTMLverComentarios($comentarios,$tipoUsuario);
      echo ("</div>");
   }

     echo <<< HTML
     <div class="row bg-dark px-2 py-2 mx-0 my-2">
       <form action="./editarReceta.php" method='POST'>
         <input type='hidden' name='id' value='{$id}' />
         <input class="btn btn-success mx-2" type="submit" name='accion' value="Comentar">
HTML;
         if($tipoUsuario == "administrador"){
echo <<< HTML
         <input class="btn btn-warning mx-2 ml-auto" type="submit" name='accion' value="Editar">
         <input class="btn btn-danger mx-2" type="submit" name='accion' value="Eliminar">
HTML;
         }
echo "</form></div></div></div>";

}
//Función que muestra el botón para crear un nuevo usuario, este botón redirigirá
// al administrador a una página con un formulario
function HTMLbotonCrearUsuario(){
echo <<< HTML
<form class="mx-1 my-3" action="insertarUsuario.php" method="post">
      <input type="submit" class="btn btn-info" value="Crear Nuevo Usuario"></input>
   </form>
HTML;
}

//Función que muestra una tabla con la información de los usuarios de la Base de
// datos (Foto, nombre, email...)
function HTMLverUsuarios($usuarios){

   foreach ($usuarios as $u) {
      $tipo = $u['tipo'];
      $tipo = ucfirst($tipo);
echo <<< HTML
         <div class="row my-2 mx-1 border">
            <img class="my-3 mx-3" src="{$u['foto']}" width="100"height=100>
            <div class="mx-3 my-3">
               <div class="row">
                  <p class="mt-0 mb-0">Nombre: <label class="text-info">{$u['nombre']}</label>
                  <p class="ml-3 mt-0 mb-0">Apellidos: <label class="text-info">{$u['apellidos']}</label>
               </div>
               <div class="row">
                  <p class="mt-0 mb-0">Usuario: <label class="text-info">{$u['usuario']}</label>
                  <p class="ml-3 mt-0 mb-0">Email: <label class="text-info">{$u['email']}</label>
               </div>
               <div class="row">
                  <p class="mt-0 mb-0">Rol: <label class="text-success">{$tipo}</p>
               </div>
            </div>
            <div class="my-auto ml-auto">
               <form class="my-auto" action="editarUsuario.php" method="post">
                  <input type="hidden" name="id" value ='{$u['id']}'></input>
                  <div class="row my-3 mr-5">
                     <input type="submit" class="btn btn-warning" name="accion" value="Editar"></input>
                  </div>
                  <div class="row my-3 mr-5">
                     <input type="submit" class="btn btn-danger" name="accion" value="Borrar"></input>
                  </div>
               </form>
            </div>
         </div>
HTML;
   }
   echo "</div></div>";
}

//Función que muestra una tabla con el titulo de las recetas del usuario que ha
// iniciado sesión en la página, además, para cada receta, aparecen botones para
// ver, editar o eliminar dicha receta
function HTMLverMisRecetas($recetas){
echo <<< HTML
   <table class="table table-striped table-dark">
      <thead>
         <tr>
            <th scope="col">Titulo de la Receta</th>
            <th scope="col">Acción</th>
         </tr>
      </thead>
      <tbody>
HTML;
   if($recetas != ""){
   foreach ($recetas as $r){
echo <<< HTML
      <tr>
         <td>{$r['titulo']}</td>
         <td>
            <form action="./editarReceta.php" method='POST' class="mx-auto">
               <input type="submit" class="btn btn-info" name='accion' value="Ver Receta"></input>
               <input type="hidden" name="id" value="{$r['id']}"></input>
               <input type="submit" class="btn btn-warning" name='accion' value="Editar"></input>
               <input type="submit" class="btn btn-danger" name='accion' value="Eliminar"></input>
            </form>
         </td>
      </tr>
HTML;
   }
   }
   echo "</tbody></table></div></div>";
}

//Función que muestra un botón para que el administrador pueda crear una categoría
function HTMLbotonCrearCategoria(){
echo <<< HTML
   <form class="mx-1 my-3" action="editarCategoria.php" method="post">
         <input type="submit" class="btn btn-info" name="Crear" value="Crear Nueva Categoria"></input>
   </form>
HTML;
}

//Función que muestra una tabla con las categorías almacenadas en la base de datos.
//Además, cada fila incluye un botón para poder eliminar dicha categoría
function HTMLverCategorias($categorias){
echo <<< HTML
   <table class="table table-striped table-dark">
      <thead>
         <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Acción</th>
         </tr>
      </thead>
      <tbody>
HTML;
      foreach ($categorias as $c) {
      echo "<tr>";
      echo "<td>{$c['nombre']}</td>";
echo <<< HTML
      <td>
         <form class="mx-auto" action="editarCategoria.php" method="post">
            <input type="hidden" name="id" value="{$c['id']}">
            <input type="submit" class="btn btn-danger" name= "Eliminar" value="Eliminar"></input>
         </form>
      </td>
HTML;
      echo "</tr>";
      }
      echo "</tbody></table></div></div>";
}

//Función que muestra un en,ace para Descargar un archivo con la copia de la BBDD
function HTMLExportarBBDD(){

echo"<a class='ml-2' href='".$_SERVER['SCRIPT_NAME']."?download'>Pulse aquí</a> para
descargar un fichero con los datos de la copia de seguridad";
}

//Función que muestra un botón para que el adminsitrador escoja la copia de seguridad
// de la base de datos que tenga almacenada en su sistema y pueda importarlo al servidor
function HTMLImportarBBDD(){
echo <<< HTML
   <div class=" my-3 bg-dark px-2 py-2">
      <h4 class="display-5 text-light">Importar Base de Datos</h4>
   </div>
HTML;
   if (isset($_POST['restore'])) {
      /* Comprobar que se ha subido algún fichero */
      if ((sizeof($_FILES)==0) || !array_key_exists("archivo",$_FILES))
         $error = "No se ha podido subir el fichero";
      else if (!is_uploaded_file($_FILES['archivo']['tmp_name']))
         $error = "Fichero no subido. Código de error: ".$_FILES['archivo']['error'];
      else
         $error = DBRestore($_FILES['archivo']['tmp_name']);


      if (isset($error) && $error != ''){
         HTMLerror($error);
      }else{
         HTMLinformar("Base de datos restaurada correctamente");
      }
   } else{
echo <<< HTML
   <form class="" action="{$_SERVER['SCRIPT_NAME']}" method="post" enctype="multipart/form-data">
      <label>Fichero</label>
      <input type="file" name="archivo" accept='.sql' value="archivo">
      <input type="submit" name="restore" value="Importar">
   </form>
</div></div>
HTML;
   }
}

//Función que muestra una tabla con las recetas que se le pasen como parámetro.
//Cada receta contará con una sección de botones dependiendo del tipo de usuario
// y si éste es propietario de dicha receta.
function HTMLlistaRecetas($recetas, $tipoUsuario, $id="0"){
echo <<< HTML
   <table class="table table-striped table-dark">
      <thead>
         <tr>
            <th scope="col">Titulo de la Receta</th>
            <th scope="col">Acción</th>
         </tr>
      </thead>
      <tbody>
HTML;

   foreach ($recetas as $r){
echo <<< HTML
      <tr>
         <td>{$r['titulo']}</td>
         <td>
            <form action="./editarReceta.php" method='POST' class="mx-auto">
               <input type="hidden" class="btn btn-info" name="id" value="{$r['id']}"></input>

               <input type="submit" class="btn btn-info" name="accion" value="Ver Receta"></input>
HTML;
            if($tipoUsuario == "administrador" || ($tipoUsuario == "colaborador" && $r['usuario_id'] == $id)){
               echo "<input type='submit' class='btn btn-warning mx-2' name='accion' value='Editar'></input>";
               echo "<input type='submit' class='btn btn-danger' name='accion' value='Eliminar'></input>";
            }
echo <<< HTML
            </form>
         </td>
      </tr>
HTML;
   }
   echo "</tbody></table>";
}

//Función que muestra un paginador para navegar por la lista de recetas
function HTMLpaginador($menu,$activo=''){
  echo "<nav>";
  echo "<ul class='pagination justify-content-center'>";
  foreach ($menu as $elem){
      echo "<li ".($activo==$elem['texto']?"class='page-item disabled' ":"class='page-item'")." >";
         echo "<a ".($activo==$elem['texto']?"class='page-link disabled' ":"class='page-link'")."href='{$elem['url']}'>{$elem['texto']}</a>";
      echo "</li>";
   }

   echo '</ul>';
   echo '</nav>';
   echo "</div></div>";
}


//Función que muestra todos los errores almacenados en el arrey que se le pase
// como parámetro
function HTMLerror($error){
echo <<< HTML
      <div class="alert alert-danger" role="alert">
HTML;
if(is_array($error)){
   echo "<ul>";
   foreach ($error as $e) {
      echo "<li>$e</li>";
   }
   echo "</ul>";
}else{
   echo $error;
}
   echo "</div>";
}

// Función que informa del evento que se le pase como parámetro
function HTMLinformar($datos){
echo <<< HTML
   <div class="alert alert-success" role="alert">{$datos}</div>
HTML;
}

//Función que muestra la información de un comentario (quién ha comentado, a qué
// hora y el propio comentario). En caso de que el tipo de usuario sea administrador,
// este podrá borrar ese comentario
function HTMLverComentario($comentario, $tipoUsuario){
   $db=DBconexion();
   $datosUsuario = DBgetUsuario($db,$comentario['usuario_id']);
   DBdesconexion($db);
echo <<< HTML
   <div class="border border-dark mt-2 my-2">
      <p class="bg-dark text-light">{$comentario['fecha']}. {$datosUsuario['nombre']}</p>
HTML;
      if($tipoUsuario == 'administrador'){
         echo "<div class='row'><form class='mx-4 my-3' action='./editarReceta.php' method='post' enctype='multipart/form-data'>";
         echo "<input type='hidden' value={$comentario['id']} name='id_comentario'/>";
         echo "<input type='submit' class='mx-auto btn btn-danger' value='Borrar Comentario' name='accion'/>";
      }
echo <<< HTML
      <p class="bg-text-dark ml-2">{$comentario['comentario']}</p>
   </div></form>
HTML;
}
// Función que muestra todos los comentarios que se le pase como parámetro
function HTMLverComentarios($comentarios, $tipoUsuario){
   foreach($comentarios as $c){
      HTMLverComentario($c, $tipoUsuario);
   }

}

?>

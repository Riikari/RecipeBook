<?php

function FORMbuscarReceta($datos,$categorias){
   $btitulo = isset($datos['titulo']) ? " value='{$datos['titulo']}' " : '';
   $breceta = isset($datos['receta']) ? " value='{$datos['receta']}' " : '';
   $datos['orden'] = isset($datos['orden']) ? $datos['orden'] : '';
   $datos['categorias'] = isset($datos['categorias']) ? $datos['categorias'] : '';

   if($datos['orden'] == "Alfabético"){
      $oa="checked";
      $oc="";
      $op="";
   }else if($datos['orden'] == "De más a menos comentadas"){
      $oa="";
      $oc="checked";
      $op="";
   }else if($datos['orden'] == "De más a menos puntuación"){
      $oa="";
      $oc="";
      $op="checked";
   }else{
      $oa="";
      $oc="";
      $op="";
   }

echo <<< HTML
   <form class="mx-4 my-3" method="get">
     <div class="form-group row">
        <label class="col-md-3">Buscar en Título:</label>
        <input type="text" class="form-control col-md-7" name="titulo" $btitulo id="titulo">
     </div>
     <div class="form-group row">
        <label class="col-md-3">Buscar en Receta:</label>
        <input type="text" class="form-control col-md-7" name="receta" $breceta id="receta">
     </div>
     <div class="form-group row">
        <label class="col-md-3">Categoría:</label>
        <div class="row">
HTML;
         $i = 0;
         foreach ($categorias as $c) {
            if(isset($datos['categorias'][$c['nombre']]) == $c['nombre']){
               $i += 1;
               $activo = "checked";
            }else{
               $activo = "";
            }
            echo "<label><input class='mr-1 ml-4' type='checkbox' name='{$c['nombre']}' value='{$c['nombre']}' $activo>{$c['nombre']}</label>";
         }
echo <<< HTML
        </div>
       <div class="my-2 form-group row">
        <label class="ml-3 col-md-3">Ordenar por:</label>
        <div class="col-md-12">
            <input class="mr-1 ml-4" type="radio" name="orden" value="Alfabético" $oa><label>Alfabético</label>
            <input class="mr-1 ml-4" type="radio" name="orden" value="De más a menos comentadas" $oc ><label>De más a menos comentadas</label>
            <input class="mr-1 ml-4" type="radio" name="orden" value="De más a menos puntuación" $op ><label>De más a menos puntuación</label>
        </div>
     </div>
     <input type="submit" class="btn btn-info" name="buscar" value="Aplicar criterios de ordenación y búsqueda"></input>
     </div>
  </form>
HTML;
}

function FORMeditReceta($datos,$accion){
   if($datos['enviado'] == false){
       $datos['id'] = '';
       $datos['titulo'] = '';
       $datos['autor'] = '';
       $datos['categorias'] = '';
       $datos['descripcion'] = '';
       $datos['ingredientes'] = '';
       $datos['preparacion'] = '';
       $datos['fotografia'] = '';
       $datos['info']= '';
       $datos['destino'] ='';
       $datos['size_foto'] = '';
   }
   if(isset($datos['editable']) && $datos['editable']==false)
     $disabled='readonly="readonly"';
   else {
     $disabled= '';
   }
   echo "<form class='mx-4 my-3' action='".$_SERVER['SCRIPT_NAME']."' method='post' enctype='multipart/form-data'>";
echo <<< HTML
   <input type='hidden' value='{$datos["id"]}' name='id'/>
   <div class="form-group row">
      <label>Titulo:
         <input type='text'  value='{$datos["titulo"]}' $disabled placeholder='Titulo de la Receta' name='titulo' />
      </label>
   </div>
   <div class="form-group row">
   <label>Descripción: <input type='text' value='{$datos["descripcion"]}' $disabled placeholder='Descripción de la Receta' name='descripcion'/></label>
   </div>
   <div class="form-group row">
   <label>Ingredientes (separe con guiones -): <input type='text' value='{$datos["ingredientes"]}' $disabled placeholder='Ingredientes de la Receta' name='ingredientes'/></label>
   </div>
   <div class="form-group row">
   <label>Preparación: <input type='text' value='{$datos["preparacion"]}' $disabled placeholder='Preparación de la Receta' name='preparacion'/></label>
   </div>
   <div class="form-group row">
   <label>Categorias:
HTML;
 $categorias = DBgetCategorias();
 foreach ($categorias as $c) {
   if(isset($datos['categorias'][$c['nombre']]) == $c['nombre']){
      $activo = "checked";
   }else{
      $activo = "";
   }
   echo "<label><input class='mr-1 ml-4' type='checkbox' $disabled name='{$c['nombre']}' value='{$c['nombre']}' $activo>{$c['nombre']}</label>";
 }
   echo "</label></div>";
   if($accion == "Añadir Receta"){
      if(isset($datos['info']) && $datos['info'] != '')
         HTMLerror($datos['info']);

   }else if($accion == "Editar Datos"){
      if(isset($datos['info']) && $datos['info'] != '')
         HTMLerror($datos['info']);
      echo "<div class='form-group row'><label>Fotografía:<input type='file' $disabled name='fotografia' accept='image/png, .jpeg, .jpg, image/gif'></label></div>";
      echo "<input type='hidden' name='fotografia' value='{$datos['fotografia']}'/>";
      echo "<div class='form-group row'><img width='200' src={$datos['fotografia']}></div>";
   }else if($accion == "Confirmar"){
      if(!empty($_FILES['fotografia'])){
      $ruta = './styles/img/recetas/'.$_FILES['fotografia']['name'];

      if($ruta != './styles/img/recetas/'){
         echo "hola";
        echo "<div class='form-group row'><img width='200' src={$ruta}></div>";
        $ruta = addslashes($ruta);

        echo "<input type='hidden' name='fotografia' value='{$ruta}'/>";
      }else{

         echo "<input type='hidden' name='fotografia' value='{$datos['fotografia']}'/>";
         echo "<div class='form-group row'><img width='200' src={$datos['fotografia']}></div>";
      }
   }

   }

   echo "<input type='submit' class='btn btn-info' value='{$accion}' name='accion'/> </form>";
}

function FORMnuevaCategoria(){
echo "<form class='mx-4 my-3' action='".$_SERVER['SCRIPT_NAME']."' method='get' enctype='multipart/form-data'>";
echo <<< HTML
<div class="form-group row">
<label>Nombre de la Categoría: <input type='text' name='nombre'/></label>
</div>
<input type='submit' class='btn btn-info' value='Crear Nueva Categoria' name='crearCategoria'/>
HTML;
echo "</form>";
}

function FORMaddComentario($id){
   echo "<form class='mx-4 my-3' action='".$_SERVER['SCRIPT_NAME']."' method='post' enctype='multipart/form-data'>";
echo <<< HTML
   <div class="form-group row">
   <label>Comentario: <input type='text' name='comentario'/></label>
   </div>
   <input type="hidden" name="id" value='{$id}'>
   <input type='submit' class='btn btn-info' value='Añadir Comentario' name='accion'/>
HTML;
   echo "</form>";
}

function FORMeditUsuario($datos,$accion){
   if($datos['enviado'] == false){
       $datos['id'] = '';
       $datos['nombre'] = '';
       $datos['apellidos'] = '';
       $datos['email'] = '';
       $datos['foto'] = '';
       $datos['usuario'] = '';
       $datos['info']= '';
       $datos['destino'] ='';
       $datos['size_foto'] = '';
   }
   if(isset($datos['editable']) && $datos['editable']==false)
     $disabled='readonly="readonly"';
   else {
     $disabled= '';
   }
   echo "<form class='mx-4 my-3' action='".$_SERVER['SCRIPT_NAME']."' method='post' enctype='multipart/form-data'>";
echo <<< HTML
      <input type='hidden' value='{$datos["id"]}' name='id'/>
      <div class="form-group row">
         <label>Nombre:
            <input type='text'  value='{$datos["nombre"]}' $disabled placeholder='Nombre del usuario' name='nombre' />
         </label>
      </div>
      <div class="form-group row">
      <label>Apellidos: <input type='text' value='{$datos["apellidos"]}' $disabled placeholder='Apellidos del usuario' name='apellidos'/></label>
      </div>
      <div class="form-group row">
      <label>Email: <input type='text' value='{$datos["email"]}' $disabled placeholder='Email del usuario' name='email'/></label>
      </div>
      <div class="form-group row">
      <label>Tipo: <input type='text' value='{$datos["tipo"]}' $disabled placeholder='Tipo de Usuario' name='tipo'/></label>
      </div>
      <div class="form-group row">
      <label>Usuario: <input type='text' value='{$datos["usuario"]}' $disabled placeholder='Nick del Usuario' name='usuario'/></label>
      </div>
HTML;
      if($accion != "Confirmar Borrado"){
echo <<< HTML
         <div class="form-group row">
         <label>Contraseña:
            <input type='password' value='{$datos["password"]}' $disabled placeholder='Contraseña' name='password1'/>
            <input type='password' value='{$datos["password"]}' $disabled placeholder='Repita la Contraseña' name='password2'/>
         </label>
         </div>
HTML;
      }
      if($accion == "Crear Usuario"){
         if(isset($datos['info']) && $datos['info'] != '')
            HTMLerror($datos['info']);
   }else if($accion == "Editar Usuario"){
         if(isset($datos['info']) && $datos['info'] != '')
            HTMLerror($datos['info']);
         echo "<div class='form-group row'><label>Fotografía:<input type='file' $disabled name='foto' accept='image/png, .jpeg, .jpg, image/gif'></label></div>";
         echo "<input type='hidden' name='foto' value='{$datos['foto']}'/>";
         echo "<div class='form-group row'><img width='200' src={$datos['foto']}></div>";
      }else if($accion == "Confirmar Usuario"){
         if(!empty($_FILES['foto'])){
         $ruta = './styles/img/users/'.$_FILES['foto']['name'];
         if($ruta != './styles/img/users/'){
           echo "<div class='form-group row'><img width='200' src={$ruta}></div>";
           $ruta = addslashes($ruta);
           echo "<input type='hidden' name='foto' value='{$ruta}'/>";
        }else{
           echo "<input type='hidden' name='foto' value='{$datos['foto']}'/>";
           echo "<div class='form-group row'><img width='200' src={$datos['foto']}></div>";
        }
        }

      }




   echo "<input type='submit' class='btn btn-info' value='{$accion}' name='accion'/> </form>";
}
?>

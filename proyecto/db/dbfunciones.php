<?php
require_once('dbcredenciales.php');

// Función para conectarse a la base de datos
function DBconexion() {
$db = mysqli_connect(DB_HOST,DB_USER,DB_PASSWD,DB_DATABASE);
if (!$db)
return "Error de conexión a la base de datos (".mysqli_connect_errno().") : ".mysqli_connect_error();
mysqli_set_charset($db,"utf8");
return $db;
}

// Función para desconectarse de la base de datos
function DBdesconexion($db) {
mysqli_close($db);
}

//-------------------------------------------FUNCIONES USUARIO--------------------------------------------------------------------
//Función que busca a un cliente dado su usuario y su clave, en caso de que no exista devolverá falso
// y en caso de que exista obtendrá todos los datos. Se usa exclusivamente para el login
function DBbuscarUsuario($usuario,$clave){
   $db = DBconexion();
   $usuario = mysqli_real_escape_string($db,$usuario);

   /* Aquí es donde se realiza el cifrado de la contraseña del usuario, en este caso es la introducida en el formulario
      del login, y que se usará para comparar con la contraseña (ya cifrada) que hay almacenada en la base de datos.
      Lo primero que se hace es obtener la clave privada que hemos generado mediante openSSL y que se encuentra en el
      fichero clave.txt que, en caso de usarse para una aplicación web para el publico, se encontraría con permisos
      de solo lectura para un usuario que compartiría con la aplicación. En este caso para que a la hora de evaluar se
      pueda acceder y ver la clave, se ha dejado como está. Lo siguiente sería obtener la clave introducida. Tras ello,
      se utiliza la función hash_hmac(), se cifra la contraseña indicando el algoritmo (sha256), la contraseña y
      la clave privada, de esta forma nos aseguramos de obtener el mismo texto cifrado que el almacenado si se introduce
      el mismo texto original.
      Esta misma metodología se utiliza tanto para crear un usuario como para cambiar su contraseña.
   */
   $key = file_get_contents('./clave.txt');
   $clave = mysqli_real_escape_string($db,$clave);
   $clave = hash_hmac('sha256', $clave, $key);

   $res = mysqli_query($db,"SELECT COUNT(*) FROM usuarios WHERE usuario ='$usuario' AND password='$clave'");
   $num = mysqli_fetch_row($res)[0];
   mysqli_free_result($res);
   if($num == 0){
      $datosUsuario = false;
   }else{
      $prep = mysqli_prepare($db,"SELECT * FROM usuarios WHERE usuario=? AND password=?");
      mysqli_stmt_bind_param($prep,'ss',$usuario,$clave);
      if(mysqli_stmt_execute($prep)){
           mysqli_stmt_bind_result($prep,$uid,$unombre,$uapellidos,$uemail,$ufoto,$upassword,$utipo,$uusuario);
           if (mysqli_stmt_fetch($prep)) {
             $datosUsuario['id'] = $uid;
             $datosUsuario['nombre'] = $unombre;
             $datosUsuario['apellidos'] = $uapellidos;
             $datosUsuario['email'] = $uemail;
             $datosUsuario['foto'] = $ufoto;
             $datosUsuario['clave'] = $upassword;
             $datosUsuario['tipo'] = $utipo;
             $datosUsuario['usuario'] = $uusuario;
          }
      }
      mysqli_stmt_close($prep);
   }
   DBdesconexion($db);
   return $datosUsuario;
}

//Función que busca un usuario dado su id y devuelve todos sus datos.
function DBgetUsuario($db,$id){
   $prep = mysqli_prepare($db,"SELECT * FROM usuarios WHERE id=?");
   mysqli_stmt_bind_param($prep,'i',$id);
   if(mysqli_stmt_execute($prep)){
        mysqli_stmt_bind_result($prep,$uid,$unombre,$uapellidos,$uemail,$ufoto,$upassword,$utipo,$uusuario);
        if (mysqli_stmt_fetch($prep)) {
          $datosUsuario['id'] = $uid;
          $datosUsuario['nombre'] = $unombre;
          $datosUsuario['apellidos'] = $uapellidos;
          $datosUsuario['email'] = $uemail;
          $datosUsuario['foto'] = $ufoto;
          $datosUsuario['clave'] = $upassword;
          $datosUsuario['tipo'] = $utipo;
          $datosUsuario['usuario'] = $uusuario;
       }else
          $datosUsuario = false;
   }
   else
      $datosUsuario = false;

   mysqli_stmt_close($prep);

   return $datosUsuario;
}

//Función que devuelve en forma de tabla la lista de todos los usuarios
function DBgetUsuarios(){
   $db = DBconexion();
   $res = mysqli_query($db,"SELECT * FROM usuarios");
   if ($res) {
     if (mysqli_num_rows($res)>0) {
       $usuarios = mysqli_fetch_all($res,MYSQLI_ASSOC);
     } else {
       $usuarios = [];
     }
   } else {
     $usuarios = false;
   }
   mysqli_free_result($res);
   DBdesconexion($db);
   return $usuarios;
}

//Función que actualiza los datos de un usario dado en la base de datos
function DBupdtUsuario($usuario){
   $db = DBconexion();
   $id = $usuario['id'];
   $nombre = mysqli_real_escape_string($db, $usuario['nombre']);
   $apellidos = mysqli_real_escape_string($db, $usuario['apellidos']);
   $email= mysqli_real_escape_string($db, $usuario['email']);
   $foto = mysqli_real_escape_string($db, $usuario['foto']);
   if($foto == ""){
      $foto = "./styles/img/users/default.jpg";
   }

   //Cifrado de contraseña
   $key = file_get_contents('./db/clave.txt');
   $password = mysqli_real_escape_string($db, $usuario['password']);
   $password = hash_hmac('sha256', $password, $key);

   $tipo = mysqli_real_escape_string($db, $usuario['tipo']);
   $usuario = mysqli_real_escape_string($db, $usuario['usuario']);

   $query = "UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', email='$email', foto='$foto', password='$password', tipo='$tipo', usuario='$usuario' WHERE id={$id}";
   $res = mysqli_query($db, $query);
   DBdesconexion($db);

   if($res){
      return false;
   }else{
      return "Hubo un error al modificar el usuario";
   }

}

//Función que añade una tupla a la tabla de usuarios en la base de datos
function DBaddUsuario($usuario){
   $db = DBconexion();
   $nombre = mysqli_real_escape_string($db,$usuario['nombre']);
   $apellidos = mysqli_real_escape_string($db,$usuario['apellidos']);
   $email = mysqli_real_escape_string($db,$usuario['email']);
   $foto = "./styles/img/users/default.jpg";

   //Cifrado de contraseña
   $key = file_get_contents('./db/clave.txt');
   $password =  mysqli_real_escape_string($db,$usuario['password']);
   $password = hash_hmac('sha256', $password, $key);

   $tipo = mysqli_real_escape_string($db,$usuario['tipo']);
   $usuario = mysqli_real_escape_string($db,$usuario['usuario']);
   $res = mysqli_query($db, "INSERT INTO usuarios (nombre,apellidos,email,foto,password,tipo,usuario) VALUES ('$nombre','$apellidos','$email','$foto','$password','$tipo','$usuario')");
   DBdesconexion($db);

   if($res){
      return false;
   }else{
      return "Hubo un error al crear el usuario";
   }
}


//-------------------------------------------FUNCIONES RECETA--------------------------------------------------------------------
//Función que calcula el número total de recetas almacenadas en la base de datos
function DBgetNumRecetas($cadenab=''){
   $db = DBconexion();
   if($cadenab!=''){
      $cadenab = ' WHERE '.$cadenab;
   }
   $res = mysqli_query($db, 'SELECT COUNT(*) FROM receta $cadenab');
   $num = mysqli_fetch_row($res)[0];
   mysqli_free_result($res);
   DBdesconexion($db);
   return $num;
}

//Función que obtiene las 3 recetas con mayor valoración media
function DBgetTopRecetas(){
   $db = DBconexion();
   $res = mysqli_query($db,
         "SELECT titulo FROM receta
          ORDER BY (
             SELECT AVG(valoracion) FROM valoraciones
             WHERE receta_id = receta.id) DESC
          LIMIT 3"
          );
   DBdesconexion($db);
   //Dentro de este if se va recorriendo el resultado obtenido de la query y se
   //van almacenando los distintos elementos en el array $tabla
   if ($res) {
     if (mysqli_num_rows($res)>0) {
       $tabla = [];
       $i = 0;
       while($row = mysqli_fetch_array($res,MYSQLI_NUM)){
         $tabla[$i] = $row[0];
         $i = $i+1;
       }
     } else {
       $tabla = [];
     }
     mysqli_free_result($res);
   } else {
     $tabla = false;
   }
   return $tabla;
}

//Función que obtiene el autor de una receta dado el id de esta
function DBgetAutorReceta($id){
   $db = DBconexion();
   $autor = false;

   $res = mysqli_query($db, "SELECT usuario FROM usuarios WHERE id=$id");
   $autor = mysqli_fetch_row($res)[0];

   mysqli_free_result($res);
   DBdesconexion($db);

   return $autor;
}

//Función que obtiene los datos completos de una receta dado el id de esta
function DBgetReceta($id){
   $db = DBconexion();
   $receta = false;
   $prep = mysqli_prepare($db,"SELECT * FROM receta WHERE id=?");
   mysqli_stmt_bind_param($prep,'i',$id);
   if (mysqli_stmt_execute($prep)) {
     mysqli_stmt_bind_result($prep,$rid,$rtitulo,$rdescripcion,$ringredientes,$rpreparacion,$rfotografia,$rusuarioID);
     if (mysqli_stmt_fetch($prep)) {
      $receta['id'] = $rid;
      $receta['titulo'] = $rtitulo;
      $receta['autor'] = DBgetAutorReceta($rusuarioID);
      $receta['valoracion'] = DBgetValoraciones($id);
      $receta['descripcion'] = $rdescripcion;
      $receta['ingredientes'] = $ringredientes;
      $receta['preparacion'] = $rpreparacion;
      $receta['categorias'] = DBgetCategorias($id);
      $receta['fotografia'] = $rfotografia;
      $receta['comentarios'] = DBgetComentarios($id);
     }
   }
   mysqli_stmt_close($prep);

   DBdesconexion($db);
   return $receta;
}

//Funcion que obtiene una sección de la tabla de recetas en base a un valor de posición de inicio y un número de tuplas
//a obtener. Se puede usar tanto para conseguir todas las recetas almacenadas como para obtener la lista de recetas de
//un usuario en concreto.
function DBgetListReceta($miRec="0", $ini=0, $nItems=5, $busc=''){
   $db = DBconexion();
   $listReceta = false;

   if($nItems){
      $rango = 'LIMIT '.(int)($nItems).' OFFSET '.abs($ini);
   }else
      $rango = '';

   if($miRec)
      $query = "SELECT titulo,id FROM receta WHERE usuario_id=$miRec ORDER BY titulo $rango";
   else
      $query = "SELECT titulo, usuario_id, id FROM receta $busc $rango";

   $res = mysqli_query($db, $query);


   if($res){
      if (mysqli_num_rows($res)>0) {
        $listReceta = mysqli_fetch_all($res,MYSQLI_ASSOC);
      }
      mysqli_free_result($res);
   }

    return $listReceta;

}

//Funcion que añade una receta a la tabla de recetas de la base de datos. Asimismo, se encarga de añadir las
//tuplas correspondientes en la lista de categorías
function DBaddReceta($receta){
   $info='';
   $db = DBconexion();
   $titulo = mysqli_real_escape_string($db,$receta['titulo']);
   $descripcion = mysqli_real_escape_string($db,$receta['descripcion']);
   $ingredientes = mysqli_real_escape_string($db,$receta['ingredientes']);
   $preparacion = mysqli_real_escape_string($db,$receta['preparacion']);
   $usuario_id =  mysqli_real_escape_string($db,$receta['usuario_id']);
   $categoria = $receta['categorias'];
   $fotografia = "./styles/img/recetas/default.jpg";
   $res = mysqli_query($db, "INSERT INTO receta (titulo,usuario_id,descripcion,ingredientes,preparacion,fotografia) VALUES ('$titulo','$usuario_id','$descripcion','$ingredientes','$preparacion','$fotografia')");
   if (!$res) {
      $info = mysqli_error($db);
  }else{
     $id = mysqli_query($db, "SELECT id FROM receta ORDER BY id DESC LIMIT 1");

     if(!$id){
      $info = mysqli_error($db);
     }else{
        $categorias = DBgetCategorias();
        $num = mysqli_fetch_row($id)[0];
        //Los indices del array categoria son los propios nombres de las categorías, por ello se obtiene primero el array
        //que contiene todas las categorías, para poder ir recorriéndolo
        foreach($categorias as $c){
           if(isset($categoria[$c['nombre']]) == $c['nombre']){
             $id_categoria = $c['id'];
             $res = "INSERT INTO categorias (receta_id,categorias_id) VALUES ({$num},{$id_categoria})";
            $query = mysqli_query($db, $res);
           }
       }
   }
 }

   DBdesconexion($db);
   if ($info!=''){
     return $info;
   }else
     return true;

}

//Función que actualiza y modifica los valores de la tupla correspondiente a una receta dada en la tabla de recetas,
//así como en las tuplas correspondientes de la tabla de categorías
function DBupdtReceta($receta){
   $info='';
   $db = DBconexion();

   $titulo = mysqli_real_escape_string($db, $receta['titulo']);
   $desc = mysqli_real_escape_string($db, $receta['descripcion']);
   $ingr = mysqli_real_escape_string($db, $receta['ingredientes']);
   $prep = mysqli_real_escape_string($db, $receta['preparacion']);
   $fotografia = mysqli_real_escape_string($db, $receta['fotografia']);


   $query = "UPDATE receta SET titulo='$titulo', descripcion='$desc', ingredientes='$ingr', preparacion='$prep', fotografia='$fotografia' WHERE id={$receta['id']}";
   $res = mysqli_query($db, $query);

   $categorias = DBgetCategorias($receta['id']);

   /* Para modificar las categorías vinculadas a la receta lo que se hace es separar estas en 2 arrays,
      uno que almacena las categorías nuevas que se han seleccionado, y otro que almacena las categorías
      que se han deseleccionado, para así hacer las menores inserciones posibles.
      Para ello, primero se obtiene un array con la nueva lista de categorías vinculadas a la receta y
      otro array con la lista original. Entonces, se recorre la lista nueva y se va comparando con cada
      elemento de la vieja, si se encuentra una coincidencia se elimina la entrada en ambos arrays y se
      pasa al siguiente elemento de la lista. Al terminar el bucle anidado, en la lista vieja nos quedamos
      con las categorías a eliminar y en la nueva con las categorías a insertar.
   */
   foreach ($receta['categorias'] as $c) {
      $i = 0;
      foreach($categorias as $cs){
         if($c == $cs["nombre"]){
            unset($receta['categorias'][$c]);
            $i = array_search($cs["nombre"], $categorias);
            unset($categorias[$i]);
            break;
         }
      }
   }

   foreach ($categorias as $cs)
      $res = mysqli_query($db, "DELETE FROM categorias WHERE receta_id={$receta['id']} AND categorias_id IN (SELECT id FROM listacategorias WHERE nombre='{$cs['nombre']}')");

   foreach ($receta['categorias'] as $c){
      $query = "SELECT id FROM listacategorias WHERE nombre='{$c}'";
      $res = mysqli_query($db, $query);
      $id_cat = mysqli_fetch_row($res)[0];
      mysqli_query($db, "INSERT INTO categorias (receta_id, categorias_id) VALUES ({$receta['id']}, $id_cat)");
   }
   DBdesconexion($db);
   if($res){
      return false;
   }else{
      return "Hubo un error al modificar la receta";
   }

}

//Funcion que añade una valoración a la tabla de valoraciones y la vincula a una receta, en caso de haber ya una creada, se actualiza
function DBaddValoracion($id_receta,$id_usuario,$valoracion){
   $db = DBconexion();
   $id_receta = mysqli_real_escape_string($db,$id_receta);
   $id_usuario = mysqli_real_escape_string($db,$id_usuario);
   $valoracion = mysqli_real_escape_string($db,$valoracion);
   $query = "SELECT COUNT(*) FROM valoraciones WHERE receta_id ='$id_receta' AND usuario_id='$id_usuario'";
   $res = mysqli_query($db,$query);
   $num = mysqli_fetch_row($res)[0];

   if($num == 0){
      $query = "INSERT INTO valoraciones (receta_id,usuario_id,valoracion) VALUES ('$id_receta','$id_usuario','$valoracion')";
   }else if($num > 0){
      $query = "UPDATE valoraciones SET valoracion='$valoracion' WHERE usuario_id='$id_usuario' and receta_id='$id_receta'";
   }
   $consulta = mysqli_query($db,$query);
   DBdesconexion($db);
   if(!$consulta){
      return "No se pudo valorar la receta";
   }else{
      return false;
   }
}

//Funcion que calcula el valor medio de todas las valoraciones vinculadas a una receta dada. hemos
// usado la función round para truncar los decimales a uno
function DBgetValoraciones($id){
   $db = DBconexion();
   $query = "SELECT AVG(valoracion) FROM valoraciones WHERE receta_id = $id";
   $res = mysqli_query($db, $query);
   $media = $res->fetch_array(MYSQLI_NUM);
   DBdesconexion($db);

   /* En un principio esta era la forma que habíamos implementado para calcular la media de todas las valoraciones,
      antes de descubrir que se puede hacer directamente dentro de la consulta. De todos modos, como nos costó
      un poco desarrollar esta forma de calcular la media, y es completamente funcional, hemos decidido dejarlo

   $n = mysqli_fetch_row($n)[0];
   $total = 0;
   if($n){
      $res = mysqli_query($db, "SELECT valoracion FROM valoraciones WHERE receta_id=$id");

      while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $total += intval($row['valoracion']);
      }
      $total = $total/intval($n);
      mysqli_free_result($res);

      $tabla = mysqli_fetch_row($res)[0];
      mysqli_free_result($res);
   }*/

   return round($media[0], 1);
}

//Función que obtiene la valoración que un usuario dado le ha otorgado a una receta concreta
function DBgetValoracion($receta,$usuario){
   $db = DBconexion();
   $receta_id = $receta['id'];
   $usuario_id = $usuario;
   $query = "SELECT valoracion FROM valoraciones WHERE usuario_id = '$usuario_id' AND receta_id = '$receta_id'";
   $res = mysqli_query($db,$query);
   $num = mysqli_fetch_row($res)[0];
   DBdesconexion($db);
   if($num){
      return $num;
   }else{
      return false;
   }

}

//Función que añade un comentario a la tabla de comentarios y lo vincula a la receta y el usuario dados
function DBaddComentario($id,$descripcion,$usuario){
   $db = DBconexion();
   $usuario = mysqli_real_escape_string($db,$usuario);
   $descripcion = mysqli_real_escape_string($db,$descripcion);
   $query = "INSERT INTO comentarios (usuario_id,receta_id,comentario) VALUES ('$usuario','$id','$descripcion')";
   $res = mysqli_query($db,$query);
   DBdesconexion($db);
   if(!$res){
      return "No se pudo añadir su comentario";
   }else{
      return false;
   }
}

//Función que obtiene todos los comentarios vinculados a una receta dada
function DBgetComentarios($id){
   $db = DBconexion();
   $comentarios = false;
   $res = mysqli_query($db, "SELECT * FROM comentarios WHERE receta_id=$id");
   DBdesconexion($db);
   if($res){
      if (mysqli_num_rows($res)>0) {
        $comentarios = mysqli_fetch_all($res,MYSQLI_ASSOC);
      } else {
        $comentarios = [];
      }
      mysqli_free_result($res);
    } else {
      $comentarios = false;
    }
    return $comentarios;
}

//Funcion que añade una categoría nueva a la tabla listacategorias, en caso de que ya exista esa categoría
// devolverá un error
function DBaddCategoria($dato){
   $db = DBconexion();
   $dato = mysqli_real_escape_string($db,$dato);
   $res = mysqli_query($db,"SELECT COUNT(*) FROM listacategorias WHERE nombre ='$dato'");
   $num = mysqli_fetch_row($res)[0];
   if($num == 0){
      $query = "INSERT INTO listacategorias (nombre) VALUES ('{$dato}')";
      $res = mysqli_query($db,$query);
      DBdesconexion($db);
      if(!$res){
         return "Hubo un error al crear la categoría";
      }else{
         return false;
      }
   }else{
      return "Ya existe una categoría con ese nombre";
   }
}

//Función que obtiene tanto la lista de todas las categorias almacenadas en la base de datos como los
//nombres de las categorias vinculadas a una receta dada, en función de si se le proporciona un id a la función o no
function DBgetCategorias($id="0"){
   $db = DBconexion();

   if($id){
      $query = "SELECT nombre FROM listacategorias WHERE (listacategorias.id IN (SELECT categorias_id FROM categorias WHERE receta_id=$id))";

   }else{
      $query = "SELECT * FROM listacategorias";
   }
   $res = mysqli_query($db,$query);
   DBdesconexion($db);
   if($res){
      if (mysqli_num_rows($res)>0) {
        $tabla = mysqli_fetch_all($res,MYSQLI_ASSOC);
      } else {
        $tabla = [];
      }
      mysqli_free_result($res);
    } else {
      $tabla = false;
    }

    return $tabla;
}

//-------------------------------------------FUNCIONES AUXILIARES RECETA--------------------------------------------------------------------
//Funcion que compone una query de búsqueda en función de un array que se pasa como parámetro y que contiene las opciones para dicha consulta
//Se usa en conjunción con la función DBgetListReceta
function DBarray2SQL($cadenab){
   $db = DBconexion();

   //Para componer la query, se empieza con una vacía y se van concatenando las distintas sentencias en base al array proporcionado.
   //Como las opciones de búsqueda y su propio orden pueden variar, se va comprobando cada vez que se concatena una sentencia si la
   //query está vacía.
   $query = '';
   if(array_key_exists('titulo', $cadenab) && $cadenab['titulo'] != '')
      $query .= " WHERE titulo LIKE '%".mysqli_real_escape_string($db,$cadenab['titulo'])."%'";

   if(array_key_exists('receta', $cadenab) && $cadenab['receta'] != ''){
      if($query == '')
         $query .= " WHERE titulo LIKE '%".mysqli_real_escape_string($db,$cadenab['receta'])."%'";

      $query .= " OR descripcion LIKE '%".mysqli_real_escape_string($db,$cadenab['receta'])."%'";
      $query .= " OR ingredientes LIKE '%".mysqli_real_escape_string($db,$cadenab['receta'])."%'";
      $query .= " OR preparacion LIKE '%".mysqli_real_escape_string($db,$cadenab['receta'])."%'";
   }

   if(array_key_exists('categorias', $cadenab)){
      if($query == '')
         $query .= " WHERE ";
      else
         $query .= " AND ";

      $query .= "receta.id IN
                     (SELECT receta_id FROM categorias WHERE categorias_id IN
                        (SELECT id FROM listacategorias WHERE ";

      $i = 0;
      $categorias = DBgetCategorias();
      foreach($categorias as $c){
         if(isset($cadenab['categorias'][$c['nombre']]) == $c['nombre']){
            if(!$i)
               $query .= " nombre = '".mysqli_real_escape_string($db,$c['nombre'])."' ";
            else
               $query .= " OR nombre = '".mysqli_real_escape_string($db,$c['nombre'])."' ";

            $i += 1;
         }
      }

      $query .= "))";

   }

   if(array_key_exists('orden', $cadenab)){
      if($cadenab['orden'] == "Alfabético")
         $query .= " ORDER BY titulo ";
      else if($cadenab['orden'] == "De más a menos comentadas")
         $query .= " ORDER BY (SELECT COUNT(*) FROM comentarios WHERE receta_id = receta.id) DESC";
      else if($cadenab['orden'] == "De más a menos puntuación")
         $query .= " ORDER BY (SELECT AVG(valoracion) FROM valoraciones WHERE receta_id = receta.id) DESC";
   }

   DBdesconexion($db);

   return $query;
}


//-------------------------------------------FUNCIONES LOGS------------------------------------------------------------------------------
//Función que añade un log al registro cuando se realiza una acción. Está implementada de forma que se pueda reutilizar para todas las posibles
//acciones a registrar, haciendo que se tengan que proporcionar dicha acción y el correo del usuario que la ha realizado.
function DBaddLog($correo, $accion){
   $db = DBconexion();
   $descripcion = "El usuario ".$correo." ha ".$accion;
   $descripcion = mysqli_real_escape_string($db,$descripcion);
   $res = mysqli_query($db,"INSERT INTO log (descripcion) VALUES ('$descripcion')");
   DBdesconexion($db);
}

//Función que obtinen la lista de los 10 logs más recientes
function DBgetLogs(){
   $db = DBconexion();
   $res = mysqli_query($db,"SELECT * FROM log ORDER BY fecha DESC LIMIT 10");
   DBdesconexion($db);
   if($res){
      if (mysqli_num_rows($res)>0) {
        $tabla = mysqli_fetch_all($res,MYSQLI_ASSOC);
      } else {
        $tabla = [];
      }
      mysqli_free_result($res);
    } else {
      $tabla = false;
    }
    return $tabla;
}


//-------------------------------------------FUNCIONES GESTION DB------------------------------------------------------------------------------
//Función que genera un archivo backup de la base de datos
function DBBackup(){
   $db = DBconexion();
   // Obtener listado de tablas
   $tablas = array();
   $result = mysqli_query($db,'SHOW TABLES');
   while ($row = mysqli_fetch_row($result))
      $tablas[] = $row[0];

   // Salvar cada tabla
   $salida = '';
   foreach ($tablas as $tab) {
      $result = mysqli_query($db,'SELECT * FROM '.$tab);
      $num = mysqli_num_fields($result);
      $salida .= 'DROP TABLE '.$tab.';';
      $row2 = mysqli_fetch_row(mysqli_query($db,'SHOW CREATE TABLE '.$tab));
      $salida .= "\n\n".$row2[1].";\n\n"; // row2[0]=nombre de tabla
      while ($row = mysqli_fetch_row($result)) {
         $salida .= 'INSERT INTO '.$tab.' VALUES(';
         for ($j=0; $j<$num; $j++) {
            $row[$j] = addslashes($row[$j]);
            $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
            if (isset($row[$j]))
               $salida .= '"'.$row[$j].'"';
            else
               $salida .= '""';
            if ($j < ($num-1)) $salida .= ',';
         }
         $salida .= ");\n";
      }
      $salida .= "\n\n\n";
   }
   DBdesconexion($db);
   return $salida;
}

//Función que restaura la base de datos dado un archivo backup de la misma
function DBrestore($archivo){
   $db = DBconexion();
   mysqli_query($db,'SET FOREIGN_KEY_CHECKS=0');
   $result = mysqli_query($db,'SHOW TABLES');
   while ($row = mysqli_fetch_row($result)){
      mysqli_query($db,'DELETE * FROM '.$row[0]);
   }
   $error = '';
   $sql = file_get_contents($archivo);
   $queries = explode(';',$sql);
   unset($queries[sizeof($queries)-1]);

   foreach ($queries as $q) {
      if (!mysqli_query($db,$q)){
         $error .= mysqli_error($db);
      }
   }
   mysqli_query($db,'SET FOREIGN_KEY_CHECKS=1');
   DBdesconexion($db);
   return $error;
}


//-------------------------------------------FUNCIONES AUXILIARES ------------------------------------------------------------------------------
//Función que borra una tupla de una tabla dada. Está implementada de forma que se pueda usar con, prácticamente, todas las tablas de la base de datos,
//ya que valoraciones se sobreescriben y las categorias asignadas a una receta se modifican en la edición de la misma.
function DBdelete($id, $tabla){
   $db = DBconexion();
   $query = "DELETE FROM $tabla WHERE id=$id";
   $res = mysqli_query($db, $query);
   DBdesconexion($db);
   if(!$res){
      return "Hubo un error al borrar el registro";
   }else{
      return false;
   }
}

?>

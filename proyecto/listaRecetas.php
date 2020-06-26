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

///////////////////////////////////////////////////////
$accion='';
// ************* Argumentos POST de la página
  if (isset($_POST['buscar'])) {
    if (isset($_POST['titulo']) && $_POST['titulo']!='')
      $cadenab['titulo']=htmlentities($_POST['titulo']);
    if (isset($_POST['receta']) && $_POST['receta']!='')
        $cadenab['receta']=htmlentities($_POST['receta']);
    if (isset($_POST['orden']) && $_POST['orden']!='')
      $cadenab['orden']=htmlentities($_POST['orden']);
    if (isset($cadenab) && count($cadenab)>0) {
      $accion='Buscar';
      $primero=0;
      $numitems=5;
    } else{
      $info = 'No ha indicado ningún campo de búsqueda';
      $numitems = "";
    }
  } else { // ************* Argumentos GET de la página
    // primero: Primer item a visualizar
    // items : cuantos items incluir (<=0 para ver todos)
  if (!isset($_GET['items']))
    $numitems = 5; // Valor por defecto
  else if (!is_numeric($_GET['items']) || $_GET['items']<1)
    $numitems = 0; // Para mostrar todos los items
  else
    $numitems = htmlentities($_GET['items']);
  if ($numitems==0)
    $primero=0; // Ver todos los items
  else {
    $primero = isset($_GET['primero']) ? $_GET['primero'] : 0;
    if (!is_numeric($primero) || $primero<0)
      $primero=0;
  }
  $cadenab = [];
  $categorias = DBgetCategorias();
  if (isset($_GET['titulo']))
    $cadenab['titulo']=htmlentities($_GET['titulo']);
  if (isset($_GET['receta']))
     $cadenab['receta']=htmlentities($_GET['receta']);
  if (isset($_GET['orden']))
    $cadenab['orden']=htmlentities($_GET['orden']);
  if(isset($_GET['buscar'])){

     foreach ($categorias as $c) {
        if (isset($_GET[$c['nombre']])){
          $cadenab['categorias'][htmlentities($_GET[$c['nombre']])] = htmlentities($_GET[$c['nombre']]);
        }
   }
 }


  if (count($cadenab)>0)
    $accion="Buscar";
}
////////////////// contenido
HTMLtituloContenido("Lista de Recetas");
if (isset($cadenab)){
   FORMbuscarReceta($cadenab,$categorias);
}else{
   FORMbuscarReceta('',$categorias);
}

if($tipoUsuario == "colaborador")
   $usuarioID = $_SESSION["id"];
else
   $usuarioID = 0;


if($accion == "Buscar"){
   $busqueda = DBarray2SQL($cadenab);
   $recetas = DBgetListReceta(0, $primero, $numitems, $busqueda);

   HTMLlistaRecetas($recetas, $tipoUsuario, $usuarioID);

}else{
   $recetas = DBgetListReceta(0, $primero, $numitems, '');

   HTMLlistaRecetas($recetas, $tipoUsuario, $usuarioID);

}




if ($numRecetas>0 && $numitems>0) {
   $ultima = $numRecetas - ($numRecetas%$numitems);
   $anterior = $numitems>$primero ? 0 : ($primero-$numitems);
   $siguiente = ($primero+$numitems)>$numRecetas ? $ultima : ($primero+$numitems);

   HTMLpaginador([
      ['texto'=>'Primera',
      'url'=>'?primero=0&items='.urlencode($numitems).'&'.http_build_query($cadenab)],
      ['texto'=>'Anterior',
      'url'=>'?primero='.urlencode($anterior).'&items='.urlencode($numitems).'&'.http_build_query($cadenab)],
      ['texto'=>'Siguiente',
      'url'=>'?primero='.urlencode($siguiente).'&items='.urlencode($numitems).'&'.http_build_query($cadenab)],
      ['texto'=>'Última',
      'url'=>'?primero='.urlencode($ultima).'&items='.urlencode($numitems).'&'.http_build_query($cadenab)]]);
}



HTMLfin();



?>

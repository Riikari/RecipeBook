<?php
require "dbfunciones.php";
if(isset($_POST['login'])){
  if($_POST['login'] == "Iniciar Sesión"){
    login($_POST['pagina'],$_POST['numRecetas']);
  }else if($_POST['login'] == "Finalizar Sesión"){
    logout($_POST['correo'],$_POST['pagina']);
  }
}

function login($pagina,$numRecetas){
   session_start();
   $usuario = "";
   $clave = "";
   if(isset($_POST['usuario']) && isset($_POST['clave'])){
     $usuario = $_POST['usuario'];
     $clave = $_POST['clave'];
   }
   $datosUsuario = DBbuscarUsuario($usuario,$clave);
   if($datosUsuario){
      $_SESSION['id'] = $datosUsuario["id"];
      DBaddLog($datosUsuario['email'], "iniciado sesión");
      $recetaAleatoria = rand(1, $numRecetas);
      $_SESSION['recetaAleatoria'] = $recetaAleatoria;
   }else{
      $_SESSION['errorLogin'] = true;
   }
   header("Refresh: 0.1; url=../$pagina");
}

function logout($correo,$pagina){
   DBaddLog($correo, "cerrado sesión");
   if (session_status()==PHP_SESSION_NONE)
   session_start();
   session_unset();
   $param = session_get_cookie_params();
   setcookie(session_name(), $_COOKIE[session_name()], time()-2592000, $param['path'], $param['domain'], $param['secure'], $param['httponly']);
   session_destroy();
   header("Refresh: 0.1; url=../$pagina");
}

?>

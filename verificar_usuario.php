<?php

require_once 'modelo/Conexion.php';
require_once 'modelo/Usuario.php';
require_once 'librerias_backend/autoload.php';

$user=new Usuario();
    if($user->validarUsuario($_POST)){
     header('Location: ./inicio.php');
    }
  else 
  {
     session_destroy();
     header('Location: vistas/Login.html');
  }
?>

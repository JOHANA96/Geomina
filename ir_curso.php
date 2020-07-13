<?php
session_start();

// Llamar el archivo de conexion a la base de datos
require_once 'modelo/Conexion.php';
require_once 'librerias_backend/autoload.php';

// función para comprobar el estado del usuario conectado
// si el usuario no está conectado, cambie a la página de inicio de sesión y envie mensaje en pantalla = 1
if (empty($_SESSION['email']) && empty($_SESSION['password'])){
    header('Location:  vistas/Login.html');
}
//  el usuario ya ha iniciado sesión, a continuación, ejecutar el comando para insertar, actualizar y borrar
else {

$loader = new Twig_Loader_Filesystem('vistas');
$twig = new Twig_Environment($loader);
echo $twig->render("curso.html");
}
?>
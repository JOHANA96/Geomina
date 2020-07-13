<?php
 require_once 'librerias_backend/autoload.php';
 require_once 'modelo/Conexion.php';
 require_once 'modelo/Laboratorio.php';

 $laboratorios = new Laboratorio();
 $datos['laboratorios'] = $laboratorios->getLaboratorios($error);

 $loader = new Twig_Loader_Filesystem('vistas');
 $twig = new Twig_Environment($loader);
 echo $twig->render("vista_laboratorio.html", array('datos'=>$datos));
?>
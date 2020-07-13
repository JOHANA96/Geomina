<?php
 require_once 'librerias_backend/autoload.php';
 require_once 'modelo/Conexion.php';
 require_once 'modelo/Docente.php';

 $docente = new Docente();
 $datos['docente'] = $docente->getDocentes($error);

 $loader = new Twig_Loader_Filesystem('vistas');
 $twig = new Twig_Environment($loader);
 echo $twig->render("vista_docentes.html", array('datos'=>$datos));
?>
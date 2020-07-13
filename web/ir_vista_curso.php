<?php
 require_once 'librerias_backend/autoload.php';
 require_once 'modelo/Conexion.php';
 require_once 'modelo/Curso.php';

 $cursos = new Curso();
 $datos['cursos'] = $cursos->getCursos($error);

 $loader = new Twig_Loader_Filesystem('vistas');
 $twig = new Twig_Environment($loader);
 echo $twig->render("vista_cursos.html", array('datos'=>$datos));
?>
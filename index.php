<?php
 require_once 'librerias_backend/autoload.php';
 
 $loader = new Twig_Loader_Filesystem('vistas');
 $twig = new Twig_Environment($loader);
 echo $twig->render("index.html");
?>
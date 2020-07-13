<?php
 require_once 'librerias_backend/autoload.php';
 require_once 'modelo/Conexion.php';
 require_once 'modelo/Infraestructura.php';

 $infraestructura = new Infraestructura();
 $datos['infraestructura'] = $infraestructura->getInfraestructura($error);

 $loader = new Twig_Loader_Filesystem('vistas');
 $twig = new Twig_Environment($loader);
 echo $twig->render("vista_infraestructura.html", array('datos'=>$datos));
?>
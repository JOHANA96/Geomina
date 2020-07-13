<?php
try
{ 
  if($_POST['accion'] == 'add') //agregar laboratorio
    {
     $twig = iniciar(false);
     require_once "../modelo/Infraestructura.php";
     $infraestructura = new Infraestructura();

     $tamaño_file = $_FILES['imagen_infraestructura']['size'];
     $nombre_file = $_FILES['imagen_infraestructura']['name'];
     $tmp_name = $_FILES['imagen_infraestructura']['tmp_name'];
     // determinar la extensión permisible
     $allowed_extensions = array('jpg','jpeg','png');
     $file = explode(".", $nombre_file);
     $extension  = array_pop($file);
     if(!empty($nombre_file)){
     if(in_array($extension, $allowed_extensions)){
        if($tamaño_file <= 1500000) { // Comprueba si el tamaño del archivo subido menos igual a 1 MB
          $id_infraestructura = $infraestructura->añadirInfraestructura($error, $_POST); 
          move_uploaded_file( $tmp_name,"../vistas/imagenes/infraestructura/".$nombre_file);

          $array_infraestructura = array(
            "id_infraestructura" => $id_infraestructura,
            "titulo" => $_POST["titulo_infraestructura"],
            "descripcion" => $_POST["descripcion_infraestructura"],
            "imagen" => $_FILES['imagen_infraestructura']['name'],
              );
          $data = array(
                'ok' => "Infraestructura agregado correctamente",
                'infraestructura' => $array_infraestructura
             );
        } 
        else{
          $data = array(
            'alert' => "El tamaño de la imagen supera 1MB"
              );
        }
    }
    }
      header('Content-Type: application/json');
      echo json_encode($data);
}

  else if ($_POST['accion'] == 'datos') //Cargar datos Docente
  {
    $twig = iniciar(false);
     require_once "../modelo/Infraestructura.php";
     $infraestructura = new Infraestructura();
     $infraestructuras = $infraestructura->getInfraestructura($error);

     if (!is_null($error))
                $data = array('err' => $error);
    else
    {
      $data = array(
        "ok"=> "datos actualizados",
        'infraestructura' => $infraestructuras
      );
      }
      header('Content-Type: application/json');
      echo json_encode($data);
  }
  
  else if ($_POST['accion'] == 'eliminar') //Eliminar docente
  {
     $twig = iniciar(false);
     require_once "../modelo/Infraestructura.php";
     $infraestructura= new Infraestructura();
     $infraestructura->eliminarInfraestructura($error, $_POST);
     $data = array(
         'ok' => "Lugar eliminado correctamente"
     );
 
 header('Content-Type: application/json');
 echo json_encode($data);
  } 

  else if ($_POST['accion'] == 'editar') {
    $twig = iniciar(false);
    require_once "../modelo/Infraestructura.php";
    $infraestructura = new Infraestructura();

    $tamaño_file = $_FILES['edit_imagen_infraestructura']['size'];
    $nombre_file = $_FILES['edit_imagen_infraestructura']['name'];
    $tmp_name = $_FILES['edit_imagen_infraestructura']['tmp_name'];
    // determinar la extensión permisible
    $allowed_extensions = array('jpg','jpeg','png');
    $file = explode(".", $nombre_file);
    $extension  = array_pop($file);

    if (empty($nombre_file)) {
     $id_infraestructura= $infraestructura->modificarInfraestructura($error, $_POST); 
    }
    else {
    if(in_array($extension, $allowed_extensions)){
       if($tamaño_file <= 1500000) { // Comprueba si el tamaño del archivo subido menos igual a 1 MB
        $id_infraestructura= $infraestructura->modificarInfraestructuraImagen($error, $_POST); 
         move_uploaded_file( $tmp_name,"../vistas/imagenes/infraestructura/".$nombre_file);
         $data = array(
               'ok' => "Infraestructura agregado correctamente",
            );
       } 
       else{
         $data = array(
           'alert' => "El tamaño de la imagen supera 1MB"
             );
       }
   }
   header('Content-Type: application/json');
     echo json_encode($data);
  }
 }

}

 catch (PDOException $er)
    {
        $data = array(
            'err' => "Se ha generado un error");
    }

 function iniciar($vista_twig = true)
 {
  require_once '../modelo/Conexion.php';    

    if ($vista_twig) {
        require_once '../librerias_backend/autoload.php';
    
        $loader = new Twig_Loader_Filesystem('../vistas');
        return new Twig_Environment($loader);
      }
 }
?>


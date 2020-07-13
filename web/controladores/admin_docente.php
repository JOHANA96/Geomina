<?php
try
{ 
  if($_POST['accion'] == 'add') //agregar docente
    {
     $twig = iniciar(false);
     require_once "../modelo/Docente.php";
     $docente = new Docente();

     $tamaño_file = $_FILES['imagen_docente']['size'];
     $nombre_file = $_FILES['imagen_docente']['name'];
     $tmp_name = $_FILES['imagen_docente']['tmp_name'];
     // determinar la extensión permisible
     $allowed_extensions = array('jpg','jpeg','png');
     $file = explode(".", $nombre_file);
     $extension  = array_pop($file);
     if(in_array($extension, $allowed_extensions)){
        if($tamaño_file <= 1500000) { // Comprueba si el tamaño del archivo subido menos igual a 1 MB
          $id_docente = $docente->añadirDocente($error, $_POST); 
          move_uploaded_file( $tmp_name,"../vistas/imagenes/docente/".$nombre_file);
          $data = array(
                'ok' => "Docente agregado correctamente",
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

  else if ($_POST['accion'] == 'datos') //Cargar datos Docente
  {
    $twig = iniciar(false);
     require_once "../modelo/Docente.php";
     $docente = new Docente();
     $docentes = $docente->getDocentes($error);

     if (!is_null($error))
                $data = array('err' => $error);
    else
    {
      $data = array(
        "ok"=> "datos actualizados",
        'docente' => $docentes
      );
      }
      header('Content-Type: application/json');
      echo json_encode($data);
  } 

  else if ($_POST['accion'] == 'eliminar') //Eliminar docente
  {
     $twig = iniciar(false);
     require_once "../modelo/Docente.php";
     $docente = new Docente();
     $docente->eliminarDocente($error, $_POST);
     $data = array(
         'ok' => "Lugar eliminado correctamente"
     );
 
 header('Content-Type: application/json');
 echo json_encode($data);
  } 

else if ($_POST['accion'] == 'editar') {
     $twig = iniciar(false);
     require_once "../modelo/Docente.php";
     $docente = new Docente();

     $tamaño_file = $_FILES['edit_img_docente']['size'];
     $nombre_file = $_FILES['edit_img_docente']['name'];
     $tmp_name = $_FILES['edit_img_docente']['tmp_name'];
     // determinar la extensión permisible
     $allowed_extensions = array('jpg','jpeg','png');
     $file = explode(".", $nombre_file);
     $extension  = array_pop($file);

     if (empty($nombre_file)) {
      $id_docente = $docente->modificarDocente($error, $_POST); 
     }
     else {
     if(in_array($extension, $allowed_extensions)){
        if($tamaño_file <= 1500000) { // Comprueba si el tamaño del archivo subido menos igual a 1 MB
          $id_docente = $docente->modificarDocenteImagen($error, $_POST); 
          move_uploaded_file( $tmp_name,"../vistas/imagenes/docente/".$nombre_file);
          $data = array(
                'ok' => "Docente agregado correctamente",
                'docente' => $array_docente
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


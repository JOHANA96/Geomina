<?php
try
{ 
  if($_POST['accion'] == 'add') //agregar laboratorio
    {
     $twig = iniciar(false);
     require_once "../modelo/Laboratorio.php";
     $laboratorio = new Laboratorio();

     $tamaño_file = $_FILES['imagen_laboratorio']['size'];
     $nombre_file = $_FILES['imagen_laboratorio']['name'];
     $tmp_name = $_FILES['imagen_laboratorio']['tmp_name'];
     // determinar la extensión permisible
     $allowed_extensions = array('jpg','jpeg','png');
     $file = explode(".", $nombre_file);
     $extension  = array_pop($file);
     if(!empty($nombre_file)){
     if(in_array($extension, $allowed_extensions)){
        if($tamaño_file <= 1500000) { // Comprueba si el tamaño del archivo subido menos igual a 1 MB
          $id_laboratorio = $laboratorio->añadirLaboratorio($error, $_POST); 
          move_uploaded_file( $tmp_name,"../vistas/imagenes/laboratorio/".$nombre_file);

          $array_laboratorio = array(
            "id_laboratorio" => $id_laboratorio,
            "nombre" => $_POST["nombre_laboratorio"],
            "descripcion" => $_POST["descripcion_laboratorio"],
            "imagen" => $_FILES['imagen_laboratorio']['name'],
              );
          $data = array(
                'ok' => "Laboratorio agregado correctamente",
                'laboratorio' => $array_laboratorio
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
     require_once "../modelo/Laboratorio.php";
     $laboratorio = new Laboratorio();
     $laboratorios = $laboratorio->getLaboratorios($error);

     if (!is_null($error))
                $data = array('err' => $error);
    else
    {
      $data = array(
        "ok"=> "datos actualizados",
        'laboratorio' => $laboratorios
      );
      }
      header('Content-Type: application/json');
      echo json_encode($data);
  }
  
  else if ($_POST['accion'] == 'eliminar') //Eliminar docente
  {
     $twig = iniciar(false);
     require_once "../modelo/Laboratorio.php";
     $laboratorio = new Laboratorio();
     $laboratorio->eliminarLaboratorio($error, $_POST);
     $data = array(
         'ok' => "Lugar eliminado correctamente"
     );
 
 header('Content-Type: application/json');
 echo json_encode($data);
  } 
  
  else if ($_POST['accion'] == 'editar') {
    $twig = iniciar(false);
    require_once "../modelo/Laboratorio.php";
    $laboratorio = new Laboratorio();

    $tamaño_file = $_FILES['edit_imagen_laboratorio']['size'];
    $nombre_file = $_FILES['edit_imagen_laboratorio']['name'];
    $tmp_name = $_FILES['edit_imagen_laboratorio']['tmp_name']; 
    // determinar la extensión permisible
    $allowed_extensions = array('jpg','jpeg','png');
    $file = explode(".", $nombre_file);
    $extension  = array_pop($file);

    if (empty($nombre_file)) {
     $id_laboratorio = $laboratorio->modificarLaboratorio($error, $_POST); 
    }
    else {
    if(in_array($extension, $allowed_extensions)){
       if($tamaño_file <= 1500000) { // Comprueba si el tamaño del archivo subido menos igual a 1 MB
         $id_laboratorio= $laboratorio->modificarLaboratorioImagen($error, $_POST); 
         move_uploaded_file( $tmp_name,"../vistas/imagenes/laboratorio/".$nombre_file);
         $data = array(
               'ok' => "Laboratorio agregado correctamente",
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


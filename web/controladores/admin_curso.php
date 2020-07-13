<?php
try
{ 
  if($_POST['accion'] == 'add') //agregar docente
    {
     $twig = iniciar(false);
     require_once "../modelo/Curso.php";
     $docente = new Curso();

     $tamaño_file = $_FILES['imagen_curso']['size'];
     $nombre_file = $_FILES['imagen_curso']['name'];
     $tmp_name = $_FILES['imagen_curso']['tmp_name'];
     // determinar la extensión permisible
     $allowed_extensions = array('jpg','jpeg','png');
     $file = explode(".", $nombre_file);
     $extension  = array_pop($file);
     if(!empty($nombre_file)){
     if(in_array($extension, $allowed_extensions)){
        if($tamaño_file <= 1000000) { // Comprueba si el tamaño del archivo subido menos igual a 1 MB
          $id_docente = $docente->añadirCurso($error, $_POST); 
          move_uploaded_file( $tmp_name,"../vistas/imagenes/curso/".$nombre_file);

          $array_docente = array(
            "id_docente" => $id_docente,
            "nombre" => $_POST["nombre_docente"],
            "apellido" => $_POST["apellido_docente"],
            "correo" => $_POST["correo_docente"],
            "cvlac" => $_POST["cvlac_docente"],
            "categoria" => $_POST["categoria"],
            "imagen" => $_POST["imagen"],
              );
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
    }
      header('Content-Type: application/json');
      echo json_encode($data);
}

  else if ($_POST['accion'] == 'datos') //Cargar datos Docente
  {
    $twig = iniciar(false);
     require_once "../modelo/Curso.php";
     $docente = new Curso();
     $docentes = $docente->getCursos($error);

     if (!is_null($error))
                $data = array('err' => $error);
    else
    {
      $data = array(
        "ok"=> "datos actualizados",
        'curso' => $docentes
      );
      }
      header('Content-Type: application/json');
      echo json_encode($data);
  } 

  else if ($_POST['accion'] == 'eliminar') //Eliminar docente
  {
     $twig = iniciar(false);
     require_once "../modelo/Curso.php";
     $curso = new Curso();
     $curso->eliminarCurso($error, $_POST);
     $data = array(
         'ok' => "Lugar eliminado correctamente"
     );
 
 header('Content-Type: application/json');
 echo json_encode($data);
  } 

  else if ($_POST['accion'] == 'editar') {
    $twig = iniciar(false);
    require_once "../modelo/Curso.php";
    $curso = new Curso();

    $tamaño_file = $_FILES['edit_imagen_curso']['size'];
    $nombre_file = $_FILES['edit_imagen_curso']['name'];
    $tmp_name = $_FILES['edit_imagen_curso']['tmp_name'];
    // determinar la extensión permisible
    $allowed_extensions = array('jpg','jpeg','png');
    $file = explode(".", $nombre_file);
    $extension  = array_pop($file);

    if (empty($nombre_file)) {
     $id_docente = $curso->modificarCurso($error, $_POST); 
    }
    else {
    if(in_array($extension, $allowed_extensions)){
       if($tamaño_file <= 1500000) { // Comprueba si el tamaño del archivo subido menos igual a 1 MB
         $id_curso= $curso->modificarCursoImagen($error, $_POST); 
         move_uploaded_file( $tmp_name,"../vistas/imagenes/curso/".$nombre_file);

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


<?php

class Curso extends Conexion 
{
    public function bc()
    {
        parent::__construct();
    }

   
   public function añadirCurso(&$error, array $datos){

    $nombre     = utf8_encode(trim(utf8_decode($datos['nombre_curso'])));
    $descripcion    = utf8_encode(trim(utf8_decode($datos['descripcion_curso'])));
    $tiempo    = utf8_encode(trim(utf8_decode($datos['tiempo_curso'])));
    $costo    = utf8_encode(trim(utf8_decode($datos['costo_curso'])));
    $contenido   = utf8_encode(trim(utf8_decode($datos['contenido_curso'])));
    $contacto    = utf8_encode(trim(utf8_decode($datos['contacto_curso'])));
    $imagen    = utf8_encode(trim(utf8_decode($_FILES['imagen_curso']['name'])));

    $resultado = mysqli_query($this->conexion, "INSERT INTO cursos(nombre,nombre_imagen,descripcion,tiempo_duracion,costo,contenido, contacto)
                                 VALUES('$nombre', '$imagen', '$descripcion', '$tiempo', '$costo', '$contenido', '$contacto')");
    
    $id_docente =  mysqli_insert_id($this->conexion);
    return $id_docente;
}

public function getCursos(&$error){
    $resultado = mysqli_query($this->conexion, "SELECT * FROM cursos ORDER by nombre");
    while($datos = $resultado->fetch_assoc())
    {
        $data[] = $datos;
    }
    return $data;
}

public function eliminarCurso(&$error, $datos){
    $id     = utf8_encode(trim(utf8_decode($datos['id'])));
    $resultado = mysqli_query($this->conexion, "DELETE FROM cursos WHERE id='$id'");
    return true;
}
public function modificarCurso(&$error, array $datos){
 
    $id    = utf8_encode(trim(utf8_decode($datos['id'])));
    $nombre     = utf8_encode(trim(utf8_decode($datos['edit_nom_curso'])));
    $descripcion    = utf8_encode(trim(utf8_decode($datos['edit_descripcion_curso'])));
    $tiempo    = utf8_encode(trim(utf8_decode($datos['edit_td_curso'])));
    $costo    = utf8_encode(trim(utf8_decode($datos['edit_costo_curso'])));
    $contenido   = utf8_encode(trim(utf8_decode($datos['edit_contenido_curso'])));
    $contacto    = utf8_encode(trim(utf8_decode($datos['edit_contacto_curso'])));
    

    $resultado = mysqli_query($this->conexion, "UPDATE cursos SET nombre = '$nombre', descripcion = '$descripcion',
                                                tiempo_duracion = '$tiempo',  costo = '$costo', contenido = '$contenido', contacto = '$contacto'
                                                WHERE id='$id'"); 

}

public function modificarCursoImagen(&$error, array $datos){
   
    $id    = utf8_encode(trim(utf8_decode($datos['id'])));
    $nombre     = utf8_encode(trim(utf8_decode($datos['edit_nom_curso'])));
    $descripcion    = utf8_encode(trim(utf8_decode($datos['edit_descripcion_curso'])));
    $tiempo    = utf8_encode(trim(utf8_decode($datos['edit_td_curso'])));
    $costo    = utf8_encode(trim(utf8_decode($datos['edit_costo_curso'])));
    $contenido   = utf8_encode(trim(utf8_decode($datos['edit_contenido_curso'])));
    $contacto    = utf8_encode(trim(utf8_decode($datos['edit_contacto_curso'])));
    $imagen    = utf8_encode(trim(utf8_decode($_FILES['edit_imagen_curso']['name'])));

    $resultado = mysqli_query($this->conexion, "UPDATE cursos SET nombre = '$nombre',nombre_imagen = '$imagen', descripcion = '$descripcion',
    tiempo_duracion = '$tiempo',  costo = '$costo', contenido = '$contenido', contacto = '$contacto'
    WHERE id='$id'");
}

}
?>
<?php


class Docente extends Conexion 
{
    public function bc()
    {
        parent::__construct();
    }

   
   public function añadirDocente(&$error, array $datos){

    $nombre     = utf8_encode(trim(utf8_decode($datos['nombre_docente'])));
    $apellido     = utf8_encode(trim(utf8_decode($datos['apellido_docente'])));
    $correo     = utf8_encode(trim(utf8_decode($datos['correo_docente'])));
    $cvlac     = utf8_encode(trim(utf8_decode($datos['cvlac_docente'])));
    $categoria    = utf8_encode(trim(utf8_decode($datos['categoria'])));
    $estado    = utf8_encode(trim(utf8_decode($datos['estado'])));
    $imagen    = utf8_encode(trim(utf8_decode($_FILES['imagen_docente']['name'])));

    $resultado = mysqli_query($this->conexion, "INSERT INTO docente(nombre,apellido,correo,cvlac,categoria,estado,imagen)
                                 VALUES('$nombre', '$apellido', '$correo', '$cvlac', '$categoria','$estado', '$imagen')");
    
    $id_docente =  mysqli_insert_id($this->conexion);
    return $id_docente;
}

public function getDocentes(&$error){
    $resultado = mysqli_query($this->conexion, "SELECT * FROM docente ORDER by nombre");
    while($datos = $resultado->fetch_assoc())
    {
        $data[] = $datos;
    }
    return $data;
}

public function eliminarDocente(&$error, $datos){
    $id     = utf8_encode(trim(utf8_decode($datos['id'])));
    $resultado = mysqli_query($this->conexion, "DELETE FROM docente WHERE id='$id'");
    return true;
}

public function modificarDocente(&$error, array $datos){

    $id    = utf8_encode(trim(utf8_decode($datos['id'])));
    $nombre     = utf8_encode(trim(utf8_decode($datos['edit_nom_docente'])));
    $apellido     = utf8_encode(trim(utf8_decode($datos['edit_apellido_docente'])));
    $correo     = utf8_encode(trim(utf8_decode($datos['edit_correo_docente'])));
    $cvlac     = utf8_encode(trim(utf8_decode($datos['edit_cvlac_docente'])));
    $categoria    = utf8_encode(trim(utf8_decode($datos['categoria'])));
    $estado    = utf8_encode(trim(utf8_decode($datos['estado'])));

    $resultado = mysqli_query($this->conexion, "UPDATE docente SET nombre = '$nombre',apellido = '$apellido',
                                                correo = '$correo', cvlac = '$cvlac', categoria = '$categoria',
                                                estado = '$estado' WHERE id='$id'");                                

}

public function modificarDocenteImagen(&$error, array $datos){
    $id    = utf8_encode(trim(utf8_decode($datos['id'])));
    $nombre     = utf8_encode(trim(utf8_decode($datos['edit_nom_docente'])));
    $apellido     = utf8_encode(trim(utf8_decode($datos['edit_apellido_docente'])));
    $correo     = utf8_encode(trim(utf8_decode($datos['edit_correo_docente'])));
    $cvlac     = utf8_encode(trim(utf8_decode($datos['edit_cvlac_docente'])));
    $categoria    = utf8_encode(trim(utf8_decode($datos['categoria'])));
    $estado    = utf8_encode(trim(utf8_decode($datos['estado'])));
    $imagen    = utf8_encode(trim(utf8_decode($_FILES['edit_img_docente']['name'])));

    $resultado = mysqli_query($this->conexion, "UPDATE docente SET nombre = '$nombre',apellido = '$apellido',
                                                correo = '$correo', cvlac = '$cvlac', categoria = '$categoria',
                                                estado = '$estado', imagen = '$imagen' WHERE id='$id'");

}

}
?>


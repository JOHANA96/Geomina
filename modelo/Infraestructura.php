<?php
class Infraestructura extends Conexion 
{
    public function bc()
    {
        parent::__construct();
    }

   
   public function añadirInfraestructura(&$error, array $datos){

    $titulo     = utf8_encode(trim(utf8_decode($datos['titulo_infraestructura'])));
    $descripcion    = utf8_encode(trim(utf8_decode($datos['descripcion_infraestructura'])));
    $imagen    = utf8_encode(trim(utf8_decode($_FILES['imagen_infraestructura']['name'])));

    $resultado = mysqli_query($this->conexion, "INSERT INTO infraestructura(imagen,titulo,descripcion)
                                 VALUES('$imagen', '$titulo', '$descripcion')");
    
    $id_infraestructura =  mysqli_insert_id($this->conexion);
    return $id_infraestructura;
}

public function getInfraestructura(&$error){
    $resultado = mysqli_query($this->conexion, "SELECT * FROM infraestructura ORDER by titulo");
    while($datos = $resultado->fetch_assoc())
    {
        $data[] = $datos;
    }
    return $data;
}

public function eliminarInfraestructura(&$error, $datos){
    $id     = utf8_encode(trim(utf8_decode($datos['id'])));
    $resultado = mysqli_query($this->conexion, "DELETE FROM infraestructura WHERE id='$id'");
    return true;
}

public function modificarInfraestructura(&$error, array $datos){

    $id    = utf8_encode(trim(utf8_decode($datos['id'])));
    $titulo     = utf8_encode(trim(utf8_decode($datos['edit_tit_infraestructura'])));
    $descripcion    = utf8_encode(trim(utf8_decode($datos['edit_des_infraestructura'])));

    $resultado = mysqli_query($this->conexion, "UPDATE infraestructura SET titulo = '$titulo', descripcion = '$descripcion '
                                                WHERE id='$id'");                                

}

public function modificarInfraestructuraImagen(&$error, array $datos){

    $id    = utf8_encode(trim(utf8_decode($datos['id'])));
    $titulo     = utf8_encode(trim(utf8_decode($datos['edit_tit_infraestructura'])));
    $descripcion    = utf8_encode(trim(utf8_decode($datos['edit_des_infraestructura'])));
    $imagen    = utf8_encode(trim(utf8_decode($_FILES['edit_imagen_infraestructura']['name'])));

    $resultado = mysqli_query($this->conexion, "UPDATE infraestructura SET imagen = '$imagen',
                                             titulo = '$titulo', descripcion = '$descripcion '
                                            WHERE id='$id'");  

}

}
?>
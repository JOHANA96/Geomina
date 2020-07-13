<?php

class Laboratorio extends Conexion 
{
    public function bc()
    {
        parent::__construct();
    }

   
   public function añadirLaboratorio(&$error, array $datos){

    $nombre     = utf8_encode(trim(utf8_decode($datos['nombre_laboratorio'])));
    $descripcion    = utf8_encode(trim(utf8_decode($datos['descripcion_laboratorio'])));
    $imagen    = utf8_encode(trim(utf8_decode($_FILES['imagen_laboratorio']['name'])));

    $resultado = mysqli_query($this->conexion, "INSERT INTO laboratorio(nombre,descripcion,imagen)
                                 VALUES('$nombre', '$descripcion', '$imagen')");
    
    $id_laboratorio =  mysqli_insert_id($this->conexion);
    return $id_laboratorio;
}

public function getLaboratorios(&$error){
    $resultado = mysqli_query($this->conexion, "SELECT * FROM laboratorio ORDER by nombre");
    while($datos = $resultado->fetch_assoc())
    {
        $data[] = $datos;
    }
    return $data;
}

public function eliminarLaboratorio(&$error, $datos){
    $id     = utf8_encode(trim(utf8_decode($datos['id'])));
    $resultado = mysqli_query($this->conexion, "DELETE FROM laboratorio WHERE id='$id'");
    return true;
}

public function modificarLaboratorio(&$error, array $datos){

    $id    = utf8_encode(trim(utf8_decode($datos['id'])));
    $nombre     = utf8_encode(trim(utf8_decode($datos['edit_nom_laboratorio'])));
    $descripcion    = utf8_encode(trim(utf8_decode($datos['edit_des_laboratorio'])));
    
    $resultado = mysqli_query($this->conexion, "UPDATE laboratorio SET nombre = '$nombre', descripcion = '$descripcion'
                                                WHERE id='$id'");                                

}

public function modificarLaboratorioImagen(&$error, array $datos){

    $id    = utf8_encode(trim(utf8_decode($datos['id'])));
    $nombre     = utf8_encode(trim(utf8_decode($datos['edit_nom_laboratorio'])));
    $descripcion    = utf8_encode(trim(utf8_decode($datos['edit_des_laboratorio'])));
    $imagen    = utf8_encode(trim(utf8_decode($_FILES['edit_imagen_laboratorio']['name'])));

    
    $resultado = mysqli_query($this->conexion, "UPDATE laboratorio SET nombre = '$nombre', descripcion = '$descripcion', 
                                                imagen = '$imagen' WHERE id='$id'");  

}

}
?>
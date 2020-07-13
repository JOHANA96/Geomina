<?php

class Usuario extends Conexion
{

public function bd(){
  parent::__construct();
}

 public function validarUsuario(array $datos)
 {
   $dato=$datos['usuario'];
   $password= $datos['contraseña'];
   $resultado = mysqli_query($this->conexion, "SELECT * FROM usuario WHERE email='$dato'");
   $res = mysqli_fetch_assoc($resultado);

    if ($res['password']== $password) {
     $data  = $res;
      session_start();
      $_SESSION['nombre']= $data['nombre'];
      $_SESSION['email']= $data['email'];
      $_SESSION['password']= $data['password'];
      $_SESSION['url_sesion']=$_SERVER['HTTP_HOST'];
      var_dump( $_SESSION['nombre']);
return true;
}
return false;

     }

 }

?>







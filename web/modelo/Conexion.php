<?php 

 class Conexion{

//variables de conexion a la base de datos
 private $host="localhost";
 private $usuario="root";
 private $clave="";
 private $db="geomi";
 private $db_charset;
 public $conexion ;

public function __construct(){
    
     $this->conexion=new mysqli($this->host,$this->usuario, $this->clave, $this->db); 

     if($this->conexion->connect_error){
         echo "Fallo al conectar a Mysql: " . $this->conexion->connect_error;
         return;
     }
 }
}
?>
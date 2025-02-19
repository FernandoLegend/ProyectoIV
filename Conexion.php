<?php
// Conexión a la base de datos mediante mysqli
$con = mysqli_connect("localhost", "root", "", "db_personal_admin_system");

// Variables de conexión para la función "conectar()"
$host="localhost";
$usuario="root";
$bd="db_personal_admin_system";
$contrasenia="";

// Función para conectar a la base de datos
function conectar(){
    $host="localhost";    
    $usuario="root";
    $pass="";
    $contrasenia="";    

    $bd="db_personal_admin_system";

    $con=mysqli_connect($host,$usuario,$pass,$contrasenia);

    mysqli_select_db($con,$bd);

    return $con;
}

conectar();

// Conexión a la base de datos mediante PDO
try {
    $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);

} catch ( Exception $ex) {

echo $ex->getMessage();
}

    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "db_personal_admin_system";

    $conexion = mysqli_connect($host, $user , $pass, $bd);

    if (!$con) {
     echo "Conexion fallida";
    }

    ?>

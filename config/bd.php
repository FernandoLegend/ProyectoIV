<?php
$host = 'localhost';

function openbd() {
    // Configuración de la base de datos
    $dbname = 'db_personal_admin_system';
    $host = 'localhost';
    $username = 'root';
    $password = '';

    try {
        // Crear una conexión PDO
        $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}

function closebd($conexion) {
    $conexion = null;
    return $conexion;
}
?>
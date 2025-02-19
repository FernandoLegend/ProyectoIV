<?php
session_start();
include ("./template/head.php");
include('config/verify_token.php');
include ("./template/function_form.php");

verificarToken($token);
token_valid($_SESSION['user'],$_SESSION['token']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar datos recibidos
    $staff_id = $_POST['staff_id'] ?? null;
    $familiar_nombre = $_POST['familiar_nombre'] ?? null;
    $familiar_apellido = $_POST['familiar_apellido'] ?? null;
    $familiar_parentesco = $_POST['familiar_parentesco'] ?? null;
    $familiar_fecha_nacimiento = $_POST['familiar_fecha_nacimiento'] ?? null;

    // Verificar que todos los datos obligatorios están presentes
    if ($staff_id && $familiar_nombre && $familiar_apellido && $familiar_parentesco && $familiar_fecha_nacimiento) {
        // Conectar a la base de datos
        $pdo = openbd();

        // Preparar la consulta de inserción
        $sql = "INSERT INTO family_list (staff_id, familiar_nombre, familiar_apellido, familiar_parentesco, familiar_fecha_nacimiento) 
                VALUES (:staff_id, :familiar_nombre, :familiar_apellido, :familiar_parentesco, :familiar_fecha_nacimiento)";
        $stmt = $pdo->prepare($sql);

        // Vincular los valores
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
        $stmt->bindParam(':familiar_nombre', $familiar_nombre, PDO::PARAM_STR);
        $stmt->bindParam(':familiar_apellido', $familiar_apellido, PDO::PARAM_STR);
        $stmt->bindParam(':familiar_parentesco', $familiar_parentesco, PDO::PARAM_STR);
        $stmt->bindParam(':familiar_fecha_nacimiento', $familiar_fecha_nacimiento, PDO::PARAM_STR);

        // Ejecutar la consulta
        try {
            $stmt->execute();
            echo "<p>Familiar agregado exitosamente.</p>";
        } catch (PDOException $e) {
            echo "<p>Error al agregar familiar: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Por favor, complete todos los campos del formulario.</p>";
    }
}
?>
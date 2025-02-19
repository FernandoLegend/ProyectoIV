<?php
session_start();
include ("./template/head.php");
include('config/verify_token.php');

verificarToken($token);
token_valid($_SESSION['user'],$_SESSION['token']);

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_system'])) {
    $conexion = openbd();
    $id_system = $_POST['id_system'];

    try {
        // Consulta para eliminar el registro
        $sql = "DELETE FROM family_list WHERE id = :id_system";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_system', $id_system, PDO::PARAM_STR);
        $stmt->execute();

        // Redirigir a la página principal con mensaje de éxito
        header("Location: home.php?message=Registro eliminado con éxito");
        exit();
    } catch (PDOException $e) {
        echo "Error al eliminar el registro: " . $e->getMessage();
    }

    closebd($conexion);
} else {
    // Si no se recibe un formulario válido, redirigir a la página principal
    header("Location: home.php?error=Acción no permitida");
    exit();
}
?>
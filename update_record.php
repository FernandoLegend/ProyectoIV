<?php
session_start();
include ("./template/head.php");
include('config/verify_token.php');
include ("./template/function_form.php");

verificarToken($token);
token_valid($_SESSION['user'],$_SESSION['token']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_system = $_POST['id_system'];
    $names = trim($_POST['names']);
    $surnames = trim($_POST['surnames']);
    $birthdate = $_POST['birthdate'];
    $date_in = $_POST['date_in'];

    $conexion = openbd();

    try {
        $query = $conexion->prepare("UPDATE staff_list 
            SET names = :names, surnames = :surnames, birthdate = :birthdate, date_in = :date_in 
            WHERE id = :id_system");

        $query->bindParam(":names", $names);
        $query->bindParam(":surnames", $surnames);
        $query->bindParam(":birthdate", $birthdate);
        $query->bindParam(":date_in", $date_in);
        $query->bindParam(":id_system", $id_system);

        $query->execute();
        header("Location: home.php?success=Registro actualizado correctamente.");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    closebd($conexion);
} else {
    header("Location: home.php");
    exit();
}
?>

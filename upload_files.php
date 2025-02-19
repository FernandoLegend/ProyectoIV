<?php
session_start();

include("./template/head.php");
include('config/verify_token.php');
include('template/function_form.php');

// Verificar autenticación
verificarToken($token);
token_valid($_SESSION['user'], $_SESSION['token']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'], $_POST['directory_id']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $pdo = openbd();
        $personId = intval($_POST['directory_id']);

        try {
            // Consultar la carpeta asociada a la persona
            $stmt = $pdo->prepare("SELECT directory FROM staff_list WHERE id = :id");
            $stmt->execute(['id' => $personId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['directory'])) {
                $personDir = $result['directory'];
                $uploadDir = __DIR__ . "/directorys/" . $personDir;

                // Crear la carpeta si no existe
                if (!file_exists($uploadDir)) {
                    if (!mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                        header("Location: error.php?message=Error al crear el directorio");
                        exit();
                    }
                }

                // Generar un nombre único para el archivo
                $originalName = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
                $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $newFileName = uniqid($originalName . "_", true) . '.' . $extension;

                // Ruta completa del archivo renombrado
                $uploadFile = $uploadDir . '/' . $newFileName;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                    header("Location: success.php?message=Archivo subido correctamente");
                    exit();
                } else {
                    header("Location: error.php?message=Error al mover el archivo");
                    exit();
                }
            } else {
                header("Location: error.php?message=No se encontró una carpeta para esta persona");
                exit();
            }
        } catch (PDOException $e) {
            header("Location: error.php?message=Error en la base de datos: " . urlencode($e->getMessage()));
            exit();
        } finally {
            closebd($pdo);
        }
    } else {
        header("Location: error.php?message=No se seleccionó ningún archivo o hubo un error");
        exit();
    }
} else {
    header("Location: error.php?message=Método no permitido");
    exit();
}
?>
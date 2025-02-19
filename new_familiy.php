<?php
session_start();
include ("./template/head.php");
include('config/verify_token.php');
include ("./template/function_form.php");

verificarToken($token);
token_valid($_SESSION['user'],$_SESSION['token']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $staff_id = $_POST['staff_id'];
        $staff_dir = $_POST['staff_dir'];
        $nombre = trim($_POST['familiar_nombre']);
        $apellido = trim($_POST['familiar_apellido']);
        $parentesco = $_POST['familiar_parentesco'];
        $fecha_nacimiento = $_POST['familiar_fecha_nacimiento'];

        if (empty($nombre) || empty($apellido) || empty($parentesco) || empty($fecha_nacimiento)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        $random_number = mt_rand(0, 2**16 - 1);
        $current_date = date('Y-m-d');
        $unique_identifier = $random_number . '_' . $current_date;
        $directory_path = 'directorys/'.$staff_dir ."/". $unique_identifier;

        if (!mkdir($directory_path, 0777, true)) {
            throw new Exception('No se pudo crear el directorio.');
        }

        $pdo = openbd();
        $sql = "INSERT INTO family_list (staff_id, name, surname, relationship, birthdate, directory) 
                VALUES (:staff_id, :name, :surname, :relationship, :birthdate, :directory)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':staff_id' => $staff_id,
            ':name' => $nombre,
            ':surname' => $apellido,
            ':relationship' => $parentesco,
            ':birthdate' => $fecha_nacimiento,
            ':directory' => $staff_dir."/".$unique_identifier
        ]);

        // Mostrar alerta SweetAlert2 con redirección
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Operación completada correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = 'home.php';
        });
        </script>";
    } catch (Exception $e) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: '" . $e->getMessage() . "',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        </script>";
    }
} else {
    echo "Acceso no permitido.";
}
?>
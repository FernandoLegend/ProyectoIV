<?php
session_start();
include ("./template/head.php");
include('config/verify_token.php');
include('template/function_form.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_id'])) {
    $conexion = openbd();

    try {
        // Preparar la consulta SQL para insertar los datos
        $query = $conexion->prepare("
            INSERT INTO `hiring_periods`(
                `staff_id`, `in_date`, `off_date`, 
                `type_in`, `type_off`, `workstation`, `salary`, `cargo`
            ) VALUES (
                :staff_id, :in_date, :off_date, 
                :type_in, :type_off, :workstation, :salary, :cargo
            )
        ");

        // Vincular los parámetros con los valores del formulario
        $query->bindParam(':staff_id', $_POST['staff_id']);
        $query->bindParam(':in_date', $_POST['date_in']);
        $query->bindParam(':off_date', $_POST['date_off']);
        $query->bindParam(':type_in', $_POST['type_in']);
        $query->bindParam(':type_off', $_POST['type_off']);
        $query->bindParam(':workstation', $_POST['workstation']);
        $query->bindParam(':salary', $_POST['salary']);
        $query->bindParam(':cargo', $_POST['cargo']);

        // Ejecutar la consulta
        $query->execute();

        echo "<script>
            Swal.fire({
                title: 'Éxito',
                text: 'Período de contratación registrado correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'home.php';
                }
            });
        </script>";
    } catch (PDOException $e) {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al registrar el período: " . addslashes($e->getMessage()) . "',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'home.php';
                }
            });
        </script>";
    } finally {
        closebd($conexion);
    }
}
?>
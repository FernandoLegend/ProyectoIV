<?php

function get_staff_list()
{
    $conexion = openbd(); // Abrir conexión a la BD

    // Preparar y ejecutar consulta
    $consulta = $conexion->prepare("SELECT `id`, `names`, `surnames`, `identity_card_number`, `assignment_id` FROM `staff_list`");
    $consulta->execute();

    // Obtener los resultados
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

    closebd($conexion); // Cerrar conexión

    return $resultados; // Devolver los resultados
}

function get_assignments() {
    $conexion = openbd();
    $stmt = $conexion->prepare("SELECT id, adress FROM assignament");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
<?php
$token = $_SESSION['token'];

function verificarToken($token) {
    try {
        $conexion = openbd(); // Conexión a la base de datos
        $sql = "SELECT * FROM users_system WHERE token = :token AND token_expiracion > NOW()";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    } catch (PDOException $e) {
        return false;
    } finally {
        closebd($conexion); // Cierra la conexión
    }
}

function token_valid($user, $token_verify){

    if (!isset($user) || !isset($token_verify) || !verificarToken($token_verify)) {
        header("Location: login.php?error=Acceso denegado. Inicie sesión nuevamente.");
        exit();
    }

}
?>
<?php
session_start();
include ("config/bd.php");

if (isset($_POST['user']) && isset($_POST['pass_word'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user = validate($_POST['user']); 
    $pass_word = validate($_POST['pass_word']);

    if (empty($user)) {
        header("Location: Login.php?error=El Usuario Es Requerido");
        exit();
    } elseif (empty($pass_word)) {
        header("Location: Login.php?error=La contraseña Es Requerida");
        exit();
    } else {
        try {
            $conexion = openbd(); // Conectar a la base de datos

            // Consulta para verificar las credenciales
            $sql = "SELECT * FROM users_system WHERE user = :user AND pass_word = :pass_word";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':user', $user, PDO::PARAM_STR);
            $stmt->bindParam(':pass_word', $pass_word, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Generar token
                $token = bin2hex(random_bytes(16)); // Generar un token único
                $expiracion = date('Y-m-d H:i:s', strtotime('+30 minutes')); // Establecer expiración

                // Actualizar el token y la expiración en la base de datos
                $updateSql = "UPDATE users_system SET token = :token, token_expiracion = :expiracion WHERE user = :user";
                $updateStmt = $conexion->prepare($updateSql);
                $updateStmt->bindParam(':token', $token, PDO::PARAM_STR);
                $updateStmt->bindParam(':expiracion', $expiracion, PDO::PARAM_STR);
                $updateStmt->bindParam(':user', $user, PDO::PARAM_STR);
                $updateStmt->execute();

                // Almacenar el token en la sesión
                $_SESSION['user'] = $row['user'];
                $_SESSION['token'] = $token;

                // Redirigir al usuario
                header("Location: home.php");
                exit();
            } else {
                header("Location: login.php?error=El usuario o la clave son incorrectas");
                exit();
            }
        } catch (PDOException $e) {
            // Manejo de errores
            header("Location: login.php?error=Error en el servidor: " . $e->getMessage());
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>
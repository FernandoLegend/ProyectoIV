<?php
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Operación exitosa.';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Éxito</title>
</head>
<body>
    <h1>Éxito</h1>
    <p><?php echo $message; ?></p>
    <a href="edit_form.php">Volver al formulario</a>
</body>
</html>
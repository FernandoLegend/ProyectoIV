<?php
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Ha ocurrido un error.';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
</head>
<body>
    <h1>Error</h1>
    <p><?php echo $message; ?></p>
    <a href="edit_form.php">Volver al formulario</a>
</body>
</html>
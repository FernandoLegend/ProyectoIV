<?php
session_start();
include("./template/head.php");
include('config/verify_token.php');
include('template/function_form.php');

// Verificar autenticación
verificarToken($token);
token_valid($_SESSION['user'], $_SESSION['token']);

// Obtener id
if (!isset($_GET['id'])) {
    header("Location: home.php?error=No se recibió el id.");
    exit();
}

$id_system = $_GET['id'];
// $directory_name = $_POST['directory_name'];

$conexion = openbd();

try {
    $query = $conexion->prepare("SELECT * FROM staff_list WHERE id = :id");
    $query->bindParam(":id", $id_system);
    $query->execute();
    $registro = $query->fetch(PDO::FETCH_ASSOC);

    if (!$registro) {
        echo "Registro no encontrado.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

closebd($conexion);
?>

<title>Editar Trabajador</title>
<link rel="stylesheet" href="css/modal.css">
<link rel="stylesheet" href="./css/new.css">
<section class="home scroll_hidden" id="home">
    <h1 style="text-align: center; margin-top: 2vw;">Editar Trabajador <?php echo htmlspecialchars($registro['id']); ?></h1>
    <form method="POST" action="update_record.php" id="formulario">
        <div class="formulario_de_edicion">
            <input type="hidden" name="id_system" value="<?php echo htmlspecialchars($registro['id']); ?>">


            <div class="wrapper" style="grid-column: 2">
                <div class="input-data">
                    <input type="text" placeholder="" name="names" id="names" value="<?php echo htmlspecialchars($registro['names']); ?>" required>
                    <div class="underline"></div>
                    <label>Nombres</label>
                </div>
            </div>

            <div class="wrapper" style="grid-column: 4">
                <div class="input-data">
                    <input type="text" placeholder="" name="surnames" id="surnames" value="<?php echo htmlspecialchars($registro['surnames']); ?>" required>
                    <div class="underline"></div>
                    <label>Apellidos</label>
                </div>
            </div>

            <div class="wrapper" style="grid-column: 2">
                <div class="input-data">
                    <input type="date" placeholder="" name="date_in" id="date_in" value="<?php echo htmlspecialchars($registro['date_in']); ?>" required>
                    <div class="underline"></div>
                    <label>Fecha de ingreso</label>
                </div>
            </div>

            <div class="wrapper" style="grid-column: 4">
                <div class="input-data">
                    <input type="date" placeholder="" name="birthdate" id="birthdate" value="<?php echo htmlspecialchars($registro['birthdate']); ?>" required>
                    <div class="underline"></div>
                    <label>Fecha de nacimiento</label>
                </div>
            </div>
    </form>

    <!-- formulario para subida de archivos -->
    <form action="upload_files.php" style="grid-column: 2; grid-row: 3;" method="post" id="uploadForm" enctype="multipart/form-data">
        <label for="file">Subir archivo:</label>

        <input class="form-control" type="file" id="file" name="file" style="font-size:20px; width:40vw;">
        <input type="hidden" name="directory_id" value="<?php echo htmlspecialchars($registro['id']); ?>">
        <br>
        <button class="btn btn-info" type="submit">Subir archivo</button>
    </form>

    <button class="btn btn-info" type="button" id="btnAgregarFamiliares" style="grid-column: 2; grid-row: 4; font-size: 18px;">
        Agregar Familiares
    </button>

    <button class="btn btn-info" type="button" id="btnMostrarArchivos" style="grid-column: 2; grid-row: 5; font-size: 18px;">
        Mostrar Archivos
    </button>

    <input class="btn btn-success" type="submit" value="Actualizar" style="grid-column: 2; grid-row: 6; font-size: 18px;">
</section>

<script src="./js/sweetalert2@11"></script>

<?php
// Ruta de la carpeta dinámica
$carpeta = "directorys/" . htmlspecialchars($registro['directory']);
// Verificar si la carpeta existe
if (is_dir($carpeta)) {
    $archivos = scandir($carpeta); // Listar todos los archivos y carpetas
} else {
    $archivos = [];
}
?>

<section>
    <!-- Modal para mostrar archivos -->
    <div id="modalArchivos" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" id="close_modalarchivos">&times;</span>
            <h2>Lista de Archivos</h2>
            <ul style="list-style: none; padding: 0;">
                <?php if (!empty($archivos) && count($archivos) > 2): ?>
                    <?php foreach ($archivos as $archivo): ?>
                        <?php if ($archivo !== '.' && $archivo !== '..'): ?>
                            <li>
                                <a href="<?php echo $carpeta . '/' . htmlspecialchars($archivo); ?>" target="_blank">
                                    <?php echo htmlspecialchars($archivo); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No se encontraron archivos en la carpeta o la carpeta no existe.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Modal de Agregar Familiares -->
    <div id="modalFamiliares" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" id="close_modalFamiliares">&times;</span>
            <h2>Agregar Familiar</h2>

            <form id="formFamiliares" method="POST" action="new_familiy.php" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

                <input type="hidden" name="staff_id" value="<?php echo htmlspecialchars($registro['id']); ?>"> <!-- ID del trabajador -->
                <input type="hidden" name="staff_dir" value="<?php echo htmlspecialchars($registro['directory']); ?>">

                <div class="wrapper" style="position: static; max-width: 300px !important; max-height: 20px !important;">
                    <div class="input-data">
                        <input type="text" value="" name="familiar_nombre" id="familiar_nombre" required>
                        <div class="underline"></div>
                        <label>Nombre del Familiar</label>
                    </div>
                </div>

                <div class="wrapper" style="position: static; max-width: 300px !important; max-height: 20px !important;">
                    <div class="input-data">
                        <input type="text" value="" name="familiar_apellido" id="familiar_apellido" required>
                        <div class="underline"></div>
                        <label>Apellido del Familiar</label>
                    </div>
                </div>

                <div class="wrapper" style="position: static; max-width: 300px !important;">
                    <div class="input-data">
                        <select name="familiar_parentesco" id="familiar_parentesco" style="height: auto" required>
                            <option value="">Seleccione...</option>
                            <option value="Padre/Madre">Padre/Madre</option>
                            <option value="Hijo/Hija">Hijo/Hija</option>
                            <option value="Cónyuge">Cónyuge</option>
                            <option value="Hermano/Hermana">Hermano/Hermana</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <div class="underline"></div>
                        <label style="top: -20px;">Parentesco</label>
                    </div>
                </div>

                <div class="wrapper" style="position: static; max-width: 300px !important;">
                    <div class="input-data">
                        <input type="date" value="" name="familiar_fecha_nacimiento" id="familiar_fecha_nacimiento" required>
                        <div class="underline"></div>
                        <label style="top: -20px;">Fecha de Nacimiento</label>
                    </div>
                </div>

                <input type="submit" class="btn btn-info" value="Agregar Familiar" style="font-size: 20px; width: 200px;">
            </form>
        </div>
    </div>
</section>
</div>

<script src="./js/sweetalert2@11.js"></script>
<script src="js/script_edit_form.js"></script>
<?php include("./template/foot.php"); ?>
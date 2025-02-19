<?php
session_start();
$id_system = $_POST['id_system'];
include ("./template/head.php");
include ("./template/function_form.php");
include('config/verify_token.php');
verificarToken($token);
token_valid($_SESSION['user'],$_SESSION['token']);

$conexion = openbd();

try {
    $query = $conexion->prepare("SELECT * FROM family_list WHERE id = :id");
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
$conexion_2 = openbd();

// Error: SQLSTATE[HY093]: Invalid parameter number: no parameters were bound


try {
    // $consulta = $conexion->query("SELECT `id`, `names`, `surnames`, `identity_card_number` FROM `staff_list`");

    $consulta_familiares = $conexion_2->prepare("SELECT * FROM `family_list` WHERE staff_id = :staff_id");
    $consulta_familiares->bindParam(":staff_id", $id_system);
    $consulta_familiares->execute();


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


closebd($conexion_2);
?>

<title>Editar Trabajador</title>
<link rel="stylesheet" href="./css/hiring_form.css">
<link rel="stylesheet" href="css/modal.css">
<link rel="stylesheet" type="text/css" href="./css/data_tables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<section class="home scroll_hidden" id="home">
<h1 class="text">Datos del Familiar</h1>
<?php
?>
    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label class="input-read">Nombres</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars($registro['name']); ?></p>
            <div class="underline"></div>
        </div>
    </div>

    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label class="input-read">Apellidos</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars($registro['surname']); ?></p>
            <div class="underline"></div>
        </div>
    </div>

    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label class="input-read">Parentezco</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars($registro['relationship']); ?></p>
            <div class="underline"></div>
        </div>
    </div>
    
    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label class="input-read">Fecha de nacimiento</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars($registro['birthdate']);?></p>
            <div class="underline"></div>
        </div>
    </div>
    
    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label class="input-read">Edad</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars(calcularEdad($registro['birthdate']));?></p>
            <div class="underline"></div>
        </div>
    </div>

    <?php
    // Ruta de la carpeta dinámica
    $carpeta = "directorys/".htmlspecialchars($registro['directory']);
    // Verificar si la carpeta existe
    if (is_dir($carpeta)) {
        $archivos = scandir($carpeta); // Listar todos los archivos y carpetas
    } else {
        $archivos = [];
    }
    ?>

        <form action="upload_files_family.php" style="grid-column: 2; grid-row: 3;" method="post" id="uploadForm" enctype="multipart/form-data">
        <label for="file">Subir archivo:</label>

        <input class="form-control" type="file" id="file" name="file" style="font-size:20px; width:40vw;">
        <input type="hidden" name="directory_id" value="<?php echo htmlspecialchars($registro['id']); ?>">
        <br>
        <button class="btn btn-info" type="submit">Subir archivo</button>
    </form>

        
    <!-- <?php echo $host. '/proyectoIV/upload_files.php'; ?> -->

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

    <!-- Botón para abrir el modal -->

    <button class="btn btn-success" type="button" id="btnMostrarArchivos" style="font-size: 18px;">
        Mostrar Archivos
    </button>
    
</body>
<script>
    // Modal de archivos
const modalArchivos = document.getElementById('modalArchivos');
const btnMostrarArchivos = document.getElementById('btnMostrarArchivos');
const btnCerrarModalArchivos = document.getElementById('close_modalarchivos');

btnMostrarArchivos.onclick = function () {
    modalArchivos.style.display = 'block';
};

btnCerrarModalArchivos.onclick = function () {
    modalArchivos.style.display = 'none';
};

window.onclick = function (event) {
    if (event.target === modalArchivos) {
        modalArchivos.style.display = 'none';
    }
};
</script>
<?php include ("./template/foot.php"); ?>
</html>
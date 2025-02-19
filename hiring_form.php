<?php
session_start();
include ("./template/head.php");
include('config/verify_token.php');
include('template/function_form.php'); // Aquí incluyo el archivo con las funciones personalizadas

// Verificar autenticación
verificarToken($token);
token_valid($_SESSION['user'],$_SESSION['token']);

// Obtener id
if (!isset($_POST['id_system'])) {
    header("Location: home.php?error=No se recibió el id.");
    exit();
}

$id_system = $_POST['id_system'];

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

if(isset($_POST['staff_id'])){
    $dates = array(
        // name 0
        trim($_POST['staff_id']),

        // surname 1
        trim($_POST['type_in']),

        // ci 2
        trim($_POST['type_off']),

        //fecha de ingreso 3
        trim($_POST['date_in']),

        //fecha de nacimiento 4
        trim($_POST['date_off']),

        // tipo de cedula 5
        trim($_POST['workstation']),

        // id de asignacion 6
        trim($_POST['salary']),

    );
}

?>

<title>Editar Trabajador</title>
<!-- <link rel="stylesheet" href="css/modal.css"> -->
<link rel="stylesheet" href="./css/hiring_form.css">
<section class="home scroll_hidden" id="home">
    <h1 style="text-align: center; margin-top: 2vw;">Establecer Periodos</h1>
    <form method="POST" action="submit_hiring.php" id="">
        <div class="formulario_de_edicion">
        <input type="hidden" name="staff_id" value="<?php echo htmlspecialchars($registro['id']); ?>">
        
            <div class="wrapper" style="grid-column: 2">
                <div class="input-data" style="text-align: center;">
                    <label class="input-read">Nombres</label>
                    <p class="example_text"><?php echo htmlspecialchars($registro['names']); ?></p>
                    <!-- <input type="text" placeholder="" name="names" id="names" value="<?php echo htmlspecialchars($registro['names']); ?>" required> -->
                    <div class="underline"></div>
                </div>
            </div>

            <div class="wrapper" style="grid-column: 4">
                <div class="input-data" style="text-align: center;">
                    <label class="input-read" >Apellidos</label>
                    <p class="example_text"><?php echo htmlspecialchars($registro['surnames']); ?></p>
                    <!-- <input type="text" placeholder="" name="surnames" id="surnames" value="" required> -->
                    <div class="underline"></div>
                </div>
            </div>
            
            <div class="wrapper" style="grid-column: 2">
                <div class="input-data" style="text-align: center;">
                    <label class="input-read" style="">Fecha de ingreso</label>
                    <p class="example_text"><?php echo htmlspecialchars($registro['date_in']); ?></p>
                    <!-- <input type="date" placeholder="" name="date_in" id="date_in" value="<?php echo htmlspecialchars($registro['date_in']); ?>" required> -->
                    <div class="underline"></div>
                </div>
            </div>

            <div class="wrapper" style="grid-column: 4">
                <div class="input-data" style="text-align: center;">
                    <label class="input-read">Fecha de nacimiento</label>
                    <p class="example_text"><?php echo htmlspecialchars($registro['birthdate']); ?></p>
                    <!-- <input type="date" placeholder="" name="birthdate" id="birthdate" value="" required> -->
                    <div class="underline"></div>
                </div>
            </div>

            <div class="wrapper" style="grid-column: 2">
                <div class="input-read">
                    <label class="label_styles" style="bottom:0; top: -22px;">Tipo de Periodo</label>
                    <br>
                    <select name="type_in" id="category" class="" required>
                        <option value="">Seleccione...</option>
                        <option value="contrato_a_tiempo_determinado">Contrato a tiempo determinado</option>
                        <option value="renovacion_de_contrato">Renovación de Contrato</option>
                        <option value="contrato_sin_fecha_de_culminacion">Contrato sin Fecha de culminación</option>
                        <option value="empleado_fijo">Empleado Fijo</option>
                        <option value="comision_de_servicio">Comision de servicio</option>
                        <!-- comision_de_servicio -->
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            </div>

            <div class="wrapper" style="grid-column: 4">
                <div class="input-read">
                    <label class="label_styles" style="bottom:0; top: -22px;">Razón de Fin del Periodo</label>
                    <br>
                    <select name="type_off" id="subcategory" class="data-select" required>
                        <option value="">Seleccione...</option>
                    </select>
                </div>
            </div>

            <div class="wrapper" style="grid-column: 2">
                <div class="input-data input-read">
                    <label class="input-up">Inicio del Periodo de trabajo</label>
                    <br>
                    <input type="date" placeholder="" name="date_in" id="date_in" required>
                    <!-- <div class="underline" style="margin: 0 auto;"></div> -->
                </div>
            </div>

            <div class="wrapper" style="grid-column: 4; grid-row: 4;">
                <div class="input-data input-read">
                    <label class="input-up">Final del Periodo de trabajo</label>
                    <br>
                    <input type="date" placeholder="" name="date_off" id="date_off">
                    <!-- <div class="underline"></div> -->
                </div>
            </div>

            <div class="wrapper" style="grid-column: 2; grid-row: 5;">
                <div class="input-data input-read">
                    <label class="input-up">Estacion de trabajo/Oficina</label>
                    <br>
                    <input type="text" placeholder="" name="workstation" id="" required>
                    <!-- <div class="underline"></div> -->
                </div>
            </div>

            <div class="wrapper" style="grid-column: 4; grid-row: 5;">
                <div class="input-data input-read">
                    <label class="input-up">Salario</label>
                    <br>
                    <input type="number" placeholder="" name="salary" id="" required>
                    <!-- <div class="underline"></div> -->
                </div>
            </div>

            <div class="wrapper" style="grid-column: 2; grid-row: 6;">
                <div class="input-data input-read">
                    <label class="input-up">Cargo</label>
                    <br>
                    <input type="text" placeholder="" name="cargo" id="" required>
                    <!-- <div class="underline"></div> -->
                </div>
            </div>
<button class="btn btn-info" type="submit">Subir Periodo</button>
    </form>

    
            
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/hiring_form.js"></script>
<?php include ("./template/foot.php"); ?>
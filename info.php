<?php
session_start();
$id_system = $_GET['id'];
include ("./template/head.php");
include ("./template/function_form.php");
include('config/verify_token.php');
verificarToken($token);
token_valid($_SESSION['user'],$_SESSION['token']);

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
$conexion_2 = openbd();

// Error: SQLSTATE[HY093]: Invalid parameter number: no parameters were bound


try {
    // $consulta = $conexion->query("SELECT `id`, `names`, `surnames`, `identity_card_number` FROM `staff_list`");

    $consulta_familiares = $conexion_2->prepare("SELECT `id`, `name`, `surname`, `relationship`, `birthdate`, `directory` FROM `family_list` WHERE staff_id = :staff_id");
    $consulta_familiares->bindParam(":staff_id", $id_system);
    $consulta_familiares->execute();


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


closebd($conexion_2);
?>

<title>Editar Trabajador</title>
<link rel="stylesheet" href="./css/hiring_form.css">
<link rel="stylesheet" type="text/css" href="./css/data_tables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<section class="home scroll_hidden" id="home">
<h1 class="text">Datos del trabajador <?php echo htmlspecialchars($registro['identity_card_number']); ?></h1>
<?php
?>
    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label style="color:#0099CC">Nombres</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars($registro['names']); ?></p>
            <div class="underline"></div>
        </div>
    </div>

    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label style="color:#0099CC">Apellidos</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars($registro['surnames']); ?></p>
            <div class="underline"></div>
        </div>
    </div>

    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label style="color:#0099CC">Fecha de Ingreso</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars($registro['date_in']); ?></p>
            <div class="underline"></div>
        </div>
    </div>
    
    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label style="color:#0099CC">Fecha de nacimiento</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars($registro['birthdate']);?></p>
            <div class="underline"></div>
        </div>
    </div>
    
    <div class="wrapper" style="margin-top: -4vh;">
        <div class="input-data" style="text-align: left;">
            <label style="color:#0099CC">Edad</label>
            <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars(calcularEdad($registro['birthdate']));?></p>
            <div class="underline"></div>
        </div>
    </div>

    <div class="table">
    <table id="data_table">

        <thead>
            <tr>
                <!-- <th class="columna" style="text-align: center;" >Selección</th> -->
                <th class="columna" style="text-align: center;" >Nombres</th>
                <th class="columna" style="text-align: center;" >Apellidos</th>
                <th class="columna" style="text-align: center;" >Parentezco</th>
                <th class="columna" style="text-align: center;" >Opciones</th>
            </tr>
        </thead>
        <tbody>
        <?php

while ($fila = $consulta_familiares->fetch(PDO::FETCH_ASSOC)) {
    $relationship = htmlspecialchars($fila['relationship'], ENT_QUOTES, 'UTF-8');
    $id_system = htmlspecialchars($fila['id'], ENT_QUOTES, 'UTF-8');
    $names = htmlspecialchars($fila['name'], ENT_QUOTES, 'UTF-8');
    $surname = htmlspecialchars($fila['surname'], ENT_QUOTES, 'UTF-8');
    echo "<tr>";
    // echo '<td class="checkbox"><input type="checkbox" name="seleccion" id="' . $relationship . '"></td>';
    echo "<td style='text-align: center;'>$names</button></form></td>";
    echo "<td style='text-align: center;'>$surname</td>";
    echo "<td style='text-align: center;'>$relationship</td>";
    echo '<td style="text-align: center;">

        <form method="POST" action="info_family.php">
            <input type="hidden" name="id_system" value="' . $id_system . '">
            <button type="submit" class="btn btn-success">
                <span class="glyphicon glyphicon-trash"></span> Mas información
            </button>
        </form>

    </td>';
    echo "</tr>";
}
?>
        </tbody>
        <?php
if (isset($_GET['message'])) {
    echo "<div class='alert alert-success'>" . htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8') . "</div>";
}
if (isset($_GET['error'])) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') . "</div>";
}
?>
    </table>
    </div>
    <script>
    $(document).ready(function() {
        $('#data_table').DataTable({
            columnDefs: [
                { width: '19%', targets: 1 },  // Ancho de la primera columna
                { width: '19%', targets: 2 },  // Ancho de la segunda columna
                { width: '15%', targets: 3 },  // Ancho de la tercera columna
                { width: '10%', targets: 4 },  // Ancho de la cuarta columna
                { width: '12%', targets: 0 },   // Ancho de la sexta columna
            ],
            
            language: {
                search: "Buscar ",  // Cambia el texto del cuadro de búsqueda
            },

            infoCallback: function (settings, start, end, max, total, pre) {
            return ' Mostrando ' + end + ' registro(s)';
            },

            paging: false,
            scrollY: 505,
            searching: true,
            
        });
    });
</script>
</body>
<?php include ("./template/foot.php"); ?>
</html>
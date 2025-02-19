<?php
session_start();
include("./template/head.php");
include('config/verify_token.php');
include('template/function_form.php'); // Aquí incluyo el archivo con las funciones personalizadas

// Verificar autenticación
verificarToken($token);
token_valid($_SESSION['user'], $_SESSION['token']);

// Obtener id
if (!isset($_GET['id'])) {
    header("Location: home.php?error=No se recibió el id.");
    exit();
}

$id_system = $_GET['id'];

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

if (isset($_POST['staff_id'])) {
    $dates = array(
        // name 0
        trim($_POST['staff_id']),

    );
}

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Editar Trabajador</title>
<!-- <link rel="stylesheet" href="css/modal.css"> -->
<link rel="stylesheet" href="./css/hiring_form.css">
<section class="home scroll_hidden" id="home">

    </div>

    <link rel="stylesheet" type="text/css" href="./css/data_tables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <section>

        <h1 class="text">Informe de períodos de contratación</h1>

        <div class="wrapper" style="margin-top: -4vh;">
            <div class="input-data" style="text-align: left;">
                <label style="color:#0099CC">Nombres</label>
                <p class="example_text" style="text-align: left;"><?php echo htmlspecialchars($registro['names']); ?></p>
                <!-- <input type="text" placeholder="" name="names" id="names" value="<?php echo htmlspecialchars($registro['names']); ?>" required> -->
                <div class="underline"></div>
            </div>
        </div>

        <div class="wrapper" style="margin-top: -6vh;">
            <div class="input-data" style="text-align: left;">
                <label style="color:#0099CC">Apellidos</label>
                <p class="example_text" style="text-align: left !important;"><?php echo htmlspecialchars($registro['surnames']); ?></p>
                <!-- <input type="text" placeholder="" name="surnames" id="surnames" value="" required> -->
                <div class="underline"></div>
            </div>
        </div>

        <form method="POST" action="hiring_form.php" id="">
            <input type="hidden" name="id_system" value="<?php echo htmlspecialchars($registro['id']); ?>">
            <button class="btn btn-success btn-sm" type="submit">Cargar Nuevo Periodo de trabajo</button>
        </form>
        <?php
        $conexion = openbd();

        try {
            // Consulta SQL ajustada con filtrado por $id_system
            $consulta = $conexion->prepare("
        SELECT 
            id, workstation, salary, in_date, off_date ,cargo
        FROM 
            hiring_periods
        WHERE 
            staff_id = :id_system
    ");
            $consulta->bindParam(':id_system', $id_system, PDO::PARAM_INT);
            $consulta->execute();
        } catch (PDOException $e) {
            // Manejo de excepciones relacionadas con PDO
            echo "Error: " . $e->getMessage();
        }

        $assignment_id = $registro['assignment_id'];

        try {
            // Consulta SQL ajustada con filtrado por $assignment_id
            $consulta_2 = $conexion->prepare("
        SELECT 
            * 
        FROM 
            `assignament` 
        WHERE 
            id = :assignment_id
    ");
            $consulta_2->bindParam(':assignment_id', $assignment_id, PDO::PARAM_INT);
            $consulta_2->execute();

            // Almacenar el resultado como un array asociativo
            $resultado_assignment = $consulta_2->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejo de excepciones relacionadas con PDO
            echo "Error: " . $e->getMessage();
        }

        closebd($conexion);


        ?>
        <hr>
        <div class="table">
            <table id="data_table">
                <thead>
                    <tr>
                        <th class="columna" style="text-align: center;">ID</th>
                        <th class="columna" style="text-align: center;">Puesto</th>
                        <th class="columna" style="text-align: center;">Salario</th>
                        <th class="columna" style="text-align: center;">Inicio del Periodo</th>
                        <th class="columna" style="text-align: center;">Fin del Periodo</th>
                        <th class="columna" style="text-align: center;">Generar Reporte</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                            $id = htmlspecialchars($fila['id'], ENT_QUOTES, 'UTF-8');
                            $workstation = htmlspecialchars($fila['workstation'], ENT_QUOTES, 'UTF-8');
                            $salary = htmlspecialchars($fila['salary'], ENT_QUOTES, 'UTF-8') . " B.s.";
                            $in_date = htmlspecialchars($fila['in_date'], ENT_QUOTES, 'UTF-8');
                            $cargo = htmlspecialchars($fila['cargo'], ENT_QUOTES, 'UTF-8');
                            $off_date = htmlspecialchars($fila['off_date'], ENT_QUOTES, 'UTF-8');
                            $names = htmlspecialchars($registro['names'], ENT_QUOTES, 'UTF-8');
                            $surnames = htmlspecialchars($registro['surnames'], ENT_QUOTES, 'UTF-8');
                            $ci = htmlspecialchars($registro['identity_card_number'], ENT_QUOTES, 'UTF-8');
                            $director = htmlspecialchars($resultado_assignment['director'], ENT_QUOTES, 'UTF-8');
                            $nivel_academico = htmlspecialchars($resultado_assignment['nivel_academico'], ENT_QUOTES, 'UTF-8');

                            // Definir el nombre y la URL del botón según el valor de assignment_id
                            if ($assignment_id == 1) {
                                $button_text = "Constancia de Trabajo";
                                $action_url = "pdf_trabajo.php";
                            } else {
                                $button_text = "Constancia de Ubicación";
                                $action_url = "pdf_ubicacion.php"; // Ajusta la URL según el caso
                            }

                            echo "<tr>";
                            echo "<td style='text-align: center;'>$id</td>";
                            echo "<td style='text-align: center;'>$workstation</td>";
                            echo "<td style='text-align: center;'>$salary</td>";
                            echo "<td style='text-align: center;'>$in_date</td>";
                            echo "<td style='text-align: center;'>$off_date</td>";
                            echo "<td style='text-align: center;'>
                                <form action='$action_url' method='post'>
                                    <input type='hidden' name='date_in' value='$in_date'>
                                    <input type='hidden' name='off_date' value='$off_date'>
                                    <input type='hidden' name='names' value='$names'>
                                    <input type='hidden' name='surnames' value='$surnames'>
                                    <input type='hidden' name='ci' value='$ci'>
                                    <input type='hidden' name='cargo' value='$cargo'>
                                    <input type='hidden' name='director' value='$director'>
                                    <input type='hidden' name='nivel_academico' value='$nivel_academico'>
                                    
                                    <button class='btn btn-info btn-sm' type='submit'>$button_text</button>
                                </form>
                            </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#data_table').DataTable({
                    columnDefs: [{
                            width: '10%',
                            targets: 0
                        }, // ID
                        {
                            width: '20%',
                            targets: 1
                        }, // Puesto
                        {
                            width: '15%',
                            targets: 2
                        }, // Salario
                        {
                            width: '20%',
                            targets: 3
                        }, // Fecha de ingreso
                        {
                            width: '20%',
                            targets: 4
                        }, // Fecha de salida
                        {
                            width: '15%',
                            targets: 5
                        }, // Fecha de salida

                    ],
                    language: {
                        search: "Buscar", // Cambia el texto del cuadro de búsqueda
                    },
                    infoCallback: function(settings, start, end, max, total, pre) {
                        return ' Mostrando ' + end + ' registro(s)';
                    },
                    paging: false,
                    scrollY: 505,
                    searching: true,
                });
            });
        </script>
    </section>
    </body>
    <?php include("./template/foot.php"); ?>

    </html>
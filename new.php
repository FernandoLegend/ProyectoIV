<?php
session_start();
include ("./template/head.php");
include('config/verify_token.php');
include ("./template/function_form.php");

verificarToken($token);
token_valid($_SESSION['user'],$_SESSION['token']);

if(isset($_POST['input_1'])){
    $dates = array(
        // name 0
        trim($_POST['input_1']),

        // surname 1
        trim($_POST['input_2']),

        // ci 2
        trim($_POST['input_3']),

        //fecha de ingreso 3
        trim($_POST['input_4']),

        //fecha de nacimiento 4
        trim($_POST['input_5']),

        // tipo de cedula 5
        trim($_POST['input_7']),

        // id de asignacion 6
        trim($_POST['assignment_id']),

    );
}

$conexion = openbd();

if(isset($_POST['input_1'])){
    $cedula_completa = $dates[5]."-".$dates[2];

    try {
        $query = $conexion->prepare("SELECT * FROM staff_list WHERE identity_card_number = :ci_register");
        $query->bindParam(":ci_register", $cedula_completa);
        $query->execute();
        $registro = $query->fetch(PDO::FETCH_ASSOC);

        if(!$registro){
            if(namecheck($dates[0]) && cedulacheck($cedula_completa) && namecheck($dates[1]) && datecheck($dates[3]) && datecheck($dates[4])){
                ?>
                <script>
                    // alert ('ola');
                </script>
                <?php
                // generacion de un random de 16bits para usar en la direccion de la carpeta
                $random_number = mt_rand(0, 2**16 - 1);
                $current_date = date('Y-m-d');
                $unique_identifier = $random_number . '_' . $current_date;
                mkdir('directorys/'.$unique_identifier, 0777, true);
                $NULL="";
                $zero = 0;
                // $conexion= openbd();
        
                $SQLinsert = $conexion->prepare("INSERT INTO `staff_list` 
                (assignment_id,names,surnames,identity_card_number,directory,birthdate,working_status,date_in,date_off,date_create) VALUES 
                (:assignment_id, :names, :surnames,:identity_card,:directory,:birthdate,:working_status,:date_in,:date_off,:date_create)");
        
                    $SQLinsert->bindParam(":assignment_id", $dates[6]);
                    $SQLinsert->bindParam(":names", $dates[0]);
                    $SQLinsert->bindParam(":surnames", $dates[1]);
                    $SQLinsert->bindParam(":identity_card", $cedula_completa);
                    $SQLinsert->bindParam(":directory", $unique_identifier);
                    $SQLinsert->bindParam(":birthdate", $dates[4]);
                    $SQLinsert->bindParam(":working_status", $zero);
                    $SQLinsert->bindParam(":date_in", $dates[3]);
                    $SQLinsert->bindParam(":date_off", $NULL);
                    $SQLinsert->bindParam(":date_create", $current_date);
                    // $SQLinsert->bindValue(":assignment_id", $dates[6]);
        
                    $SQLinsert->execute();
                    $redirect = "home.php";
                    ?>
                <script>
                    Swal.fire({
                        title: 'Gurdado exitoso',
                        text: 'Se ha guardado de manera exitosa en la base de datos',
                        icon: 'success',
                        confirmButtonText: 'Ok',
                        customClass: {
                            confirmButton: 'text_chart',
                            popup: 'text_chart', // Clase personalizada para el contenedor de la alerta
                        }
                        
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('Confirmed!');
                            var redirectUrl = "<?php echo $redirect; ?>";
                            location.href = redirectUrl;
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Code to execute after canceling the alert
                            console.log('Canceled!');
                            var redirectUrl = "<?php echo $redirect; ?>";
                            location.href = redirectUrl;
                        }
                    })
                    
                </script>
                <?php    
                echo $dates[0];
            }else{
                if(!namecheck($dates[0]) && $dates[0] != ""){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">Complete el nombre sin numeros ni simbolos especiales.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }elseif(trim($dates[0]) === "" && $dates[0] === ""){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">El campo de nombres está vacio.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }
                if(!namecheck($dates[1]) && $dates[1] != ""){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">Complete los apellidos sin numeros ni simbolos especiales.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }elseif(trim($dates[1]) === "" && $dates[1] === ""){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">El campo de apellidos está vacio.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }
                if(!cedulacheck($dates[2]) && $dates[2] != ""){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">Inserte un formato de cedula valido.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }elseif(trim($dates[2]) === "" && $dates[2] === ""){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">El campo de cedula está vacio.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }
                if(!datecheck($dates[3]) && $dates[3] != ""){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">Inserte una fecha de ingreso valida.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }elseif(trim($dates[3]) === "" && $dates[3] === ""){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">Inserte una fecha de ingreso.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }
                if(!datecheck($dates[4]) && $dates[4] != ""){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">Inserte una fecha de nacimiento valida.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }elseif(trim($dates[4]) === $dates[4]){
                    ?>
                    <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">Inserte una fecha de nacimiento.</span>
                        <span class="warning_xd"></span>
                    </div>
                    <?php
                }
            }

        }else{
            ?>
            <script>
                Swal.fire({
                title: 'Cedula ya registrado',
                text: 'Usuario ya registrado en el sistema, registre una nueva cedula.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
                });
            </script>    
            <?php
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// Abrir la conexión a la base de datos
$conexion = openbd();

try {
    // Realizar la consulta para obtener las columnas id y adress de la tabla assignament
    $query = $conexion->query("SELECT id, adress FROM assignament");
    $query->execute();
    $assignments = $query->fetchAll(PDO::FETCH_ASSOC);

    // Generar las opciones del select
    $select_options = '';
    foreach ($assignments as $assignment) {
        $select_options .= '<option value="' . htmlspecialchars($assignment['id'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($assignment['adress'], ENT_QUOTES, 'UTF-8') . '</option>';
    }

} catch (PDOException $e) {
    // Manejar errores de la base de datos
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
closebd($conexion);


?>
<title>Nuevo</title>
<link rel="stylesheet" href="./css/new.css">
<script src="./js/alert_script.js"></script>

<section class="home scroll_hidden" id="home">
    <h1 style="text-align: center; margin-top: 2vw;">Registro de trabajadores</h1>

    <form method="POST" class="formulario_de_edicion">

        <div class="wrapper" style="grid-column: 2">
            <div class="input-data">
                <input type="text" placeholder="" required name="input_1" id="input_1" value="<?php input_dates(empty($_POST['input_1']),"0")?>">
                <div class="underline"></div>
                <label>Nombres<p style="color:red; display:inline">*</p></label>
            </div>            
        </div>

        <div class="wrapper" style="grid-column: 4">
            <div class="input-data">
                <input type="text" placeholder="" required name="input_2" value="<?php input_dates(empty($_POST['input_2']),"0")?>">
                <div class="underline"></div>
                <label>Apellidos<p style="color:red; display:inline">*</p></label>
            </div>
        </div>
        
        <select name="input_7" class="select_input" style="grid-column: 1; width: 2vw;">
            <option class="" value="V" selected>V</option>
            <option class="" value="E">E</option>
        </select>

        <div class="wrapper" style="grid-column: 2">
            <div class="input-data">
                <input type="text" placeholder="" required name="input_3" style="display:inline-block;" value="<?php empty($_POST['input_3'])?>">
                <div class="underline"></div>
                <label>Cedula de identidad<p style="color:red; display:inline">*</p></label>
            </div>            
        </div>

        <div class="wrapper" style="grid-column: 4">
            <div class="input-data">
                <input type="date" placeholder="" required name="input_4" value="<?php input_dates(empty($_POST['input_4']),"0")?>">
                <div class="underline"></div>
                <label style="transform: translateY(-20px); font-size: 15px; color: #0099CC;">Fecha de ingreso<p style="color:red; display:inline">*</p></label>
            </div>            
        </div>

        <div class="wrapper" style="grid-column: 2">
            <div class="input-data">
                <input type="date" placeholder="" required name="input_5" value="<?php input_dates(empty($_POST['input_5']),"0")?>">
                <div class="underline"></div>
                <label style="transform: translateY(-20px); font-size: 15px; color: #0099CC;">Fecha de nacimiento<p style="color:red; display:inline">*</p></label>
            </div>            
        </div>

        <div class="wrapper" style="grid-column: 4">
            <div class="input-data">
                <select name="assignment_id" id="" class="select_input" style="width: 33.7vw;" required>
                    <option value="" selected disabled>Seleccione...</option>
                    <?php echo $select_options; ?>
                </select>
                <label class="label_styles" style="bottom:0; top: -22px;">Institucion Afiliada<p style="color:red; display:inline">*</p></label>
            </div>
        </div>

        <input type="submit" style="grid-column: 3; grid-row: 4" class="btn btn-info" value="Guardar"></button>
</form>
<br><br><br><br><br><br>
</section>
<?php include ("./template/foot.php"); ?>
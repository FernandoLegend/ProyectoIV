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
        // trim($_POST['input_2']),
        // // ci 2
        // trim($_POST['input_3']),
        // //fecha de ingreso 3
        // trim($_POST['input_4']),
        // //fecha de nacimiento 4
        // trim($_POST['input_7']),
        // institucion
        // trim($_POST['input_6']),
        // tipo de cedula 5
        // trim($_POST['input_7']),

    );
}

if(isset($_POST['input_1'])){
    $cedula_completa = $dates[4]."-".$dates[3];

    if(namecheck($dates[0]) && numbercheck($dates[2]) && namecheck($dates[1]) && namecheck($dates[3])){
        ?>
        <script>
            // alert ('ola');
        </script>
        <?php
        // generacion de un random de 16bits para usar en la direccion de la carpeta
        $conexion= openbd();

        $SQLinsert = $conexion->prepare("INSERT INTO `assignament`(`type`,`adress`,`rif`, `description`) VALUES (:names,:direccion,:Rif,:ministerio)");

            $SQLinsert->bindParam(":names", $dates[0]);
            $SQLinsert->bindParam(":direccion", $dates[1]);
            $SQLinsert->bindParam(":Rif", $dates[2]);
            $SQLinsert->bindParam(":ministerio", $dates[3]);

            // $SQLinsert->bindValue(":assignment_id", $dates[6]);

            $SQLinsert->execute();
            $redirect = "new_two.php";
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
                    <span class="msg">Complete la direccion sin simbolos especiales.</span>
                    <span class="warning_xd"></span>
                </div>
            <?php
        }elseif(trim($dates[1]) === "" && $dates[1] === ""){
            ?>
            <div class="alert show" id="alerta">
                <i class='bx bx-message-error warning_icons'></i>
                <span class="msg">El campo de direccion está vacio.</span>
                <span class="warning_xd"></span>
            </div>
            <?php
        }
        if(!cedulacheck($dates[2]) && $dates[2] != ""){
            ?>
            <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">Inserte un formato de rif valido.</span>
                        <span class="warning_xd"></span>
                    </div>
            <?php
        }elseif(trim($dates[2]) === "" && $dates[2] === ""){
            ?>
            <div class="alert show" id="alerta">
                        <i class='bx bx-message-error warning_icons'></i>
                        <span class="msg">El campo de rif está vacio.</span>
                        <span class="warning_xd"></span>
                    </div>
            <?php
        }
        if(!namecheck($dates[3]) && $dates[3] != ""){
            ?>
                <div class="alert show" id="alerta">
                    <i class='bx bx-message-error warning_icons'></i>
                    <span class="msg">Complete el Ministerio sin simbolos especiales.</span>
                    <span class="warning_xd"></span>
                </div>
            <?php
        }elseif(trim($dates[3]) === "" && $dates[3] === ""){
            ?>
            <div class="alert show" id="alerta">
                <i class='bx bx-message-error warning_icons'></i>
                <span class="msg">El campo de Ministerio está vacio.</span>
                <span class="warning_xd"></span>
            </div>
            <?php
        }
    }
}
?>
<title>Nuevo</title>
<link rel="stylesheet" href="./css/new.css">
<script src="./js/alert_script.js"></script>

<section class="home scroll_hidden" id="home">
    <h1 style="text-align: center; margin-top: 2vw;">Registro de Periodos</h1>

    <form method="POST" class="formulario_de_edicion">

        <div class="wrapper" style="grid-column: 2">
            <div class="input-data">
                <input type="text" name="input_1" id="input_1" placeholder="" required>
                <div class="underline"></div>
                <label><p style="color:red; display:inline">*</p></label>
            </div>            
        </div>
<!-- 
        <div class="wrapper" style="grid-column: 4">
            <div class="input-data">
                <input type="text" name="input_2" placeholder="" required>
                <div class="underline"></div>
                <label>Dirección<p style="color:red; display:inline">*</p></label>
            </div>
        </div>
        
        <select name="input_7" class="select_input" style="grid-column: 1">
            <option class="" value="R" selected>R</option>
            <option class="" value="J">J</option>
        </select>

        <div class="wrapper" style="grid-column: 2">
            <div class="input-data">
                <input type="text" name="input_3" placeholder="" required style="width: 28vw;display:inline-block;">
                <div class="underline"></div>
                <label>Rif<p style="color:red; display:inline">*</p></label>
            </div>            
        </div>

        <div class="wrapper" style="grid-column: 4">
            <div class="input-data">
                <input type="text" name="input_4" placeholder="" required>
                <div class="underline"></div>
                <label>Ministerio<p style="color:red; display:inline">*</p></label>
            </div>            
        </div> -->

        <!-- <div class="wrapper" style="grid-column: 4">
            <div class="input-data">
                <select>
                    <option selected value="0">Pure CSS Select</option>
                    <option value="1">No Wrapper</option>
                    <option value="2">No JS</option>
                    <option value="3" selected>Nice!</option>
                </select>
                <div class="underline"></div>
            </div>            
        </div> -->

        <input type="submit" style="grid-column: 3; grid-row: 4; border-radius:5px; width:100px; height:30px;background: silver;font-size:17px;color: (--text-color)" value="Guardar"></button>
</form>
<br><br><br><br><br><br>
</section>
<?php include ("./template/foot.php"); ?>
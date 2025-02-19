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
        // institucion
        // trim($_POST['input_6']),
        // tipo de cedula 5
        trim($_POST['input_7']),

    );
}

if(isset($_POST['input_1'])){
    $cedula_completa = $dates[5]."-".$dates[2];

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
        $conexion= openbd();

        $SQLinsert = $conexion->prepare("INSERT INTO `staff_list` 
        (names,surnames,identity_card_number,directory,birthdate,working_status,date_in,date_off,date_create) VALUES 
        (:names, :surnames,:identity_card,:directory,:birthdate,:working_status,:date_in,:date_off,:date_create)");

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
    }elseif(!namecheck($dates[0])){
        ?>
        <div class="alert show" id="alerta">
            <i class='bx bx-message-error warning_icons'></i>
            <span class="msg">Complete el nombre sin numeros ni simbolos especiales.</span>
            <span class="warning_xd"></span>
        </div>
        <?php
    }elseif(trim($dates[0]) == ""){
        ?>
        <div class="alert show" id="alerta">
            <i class='bx bx-message-error warning_icons'></i>
            <span class="msg">El campo de nombres está vacio.</span>
            <span class="warning_xd"></span>
        </div>
        <?php
    }elseif(!namecheck($dates[1])){
        ?>
        <div class="alert show" id="alerta">
                    <span class="glyphicon glyphicon-info-sign "></span>
                    <span class="msg">Complete los apellidos sin numeros ni simbolos especiales.</span>
                    <span class="warning_xd"></span>
                </div>
        <?php
    }elseif(trim($dates[1]) === $dates[1]){
        ?>
        <div class="alert show" id="alerta">
                    <span class="glyphicon glyphicon-info-sign "></span>
                    <span class="msg">El campo de apellidos está vacio.</span>
                    <span class="warning_xd"></span>
                </div>
        <?php
    }elseif(!cedulacheck($dates[2])){
        ?>
        <div class="alert show" id="alerta">
                    <span class="glyphicon glyphicon-info-sign "></span>
                    <span class="msg">Inserte un formato de cedula valido.</span>
                    <span class="warning_xd"></span>
                </div>
        <?php
    }elseif(trim($dates[2]) === $dates[2]){
        ?>
        <div class="alert show" id="alerta">
                    <span class="glyphicon glyphicon-info-sign "></span>
                    <span class="msg">El campo de cedula está vacio.</span>
                    <span class="warning_xd"></span>
                </div>
        <?php
    }elseif(!datecheck($dates[3])){
        ?>
        <div class="alert show" id="alerta">
                    <span class="glyphicon glyphicon-info-sign "></span>
                    <span class="msg">Inserte una fecha de ingreso valida.</span>
                    <span class="warning_xd"></span>
                </div>
        <?php
    }elseif(trim($dates[3]) === $dates[3]){
        ?>
        <div class="alert show" id="alerta">
                    <span class="glyphicon glyphicon-info-sign "></span>
                    <span class="msg">Inserte una fecha de ingreso.</span>
                    <span class="warning_xd"></span>
                </div>
        <?php
    }elseif(!datecheck($dates[4])){
        ?>
        <div class="alert show" id="alerta">
                    <span class="glyphicon glyphicon-info-sign "></span>
                    <span class="msg">Inserte una fecha de nacimiento valida.</span>
                    <span class="warning_xd"></span>
                </div>
        <?php
    }elseif(trim($dates[4]) === $dates[4]){
        ?>
        <div class="alert show" id="alerta">
                    <span class="glyphicon glyphicon-info-sign "></span>
                    <span class="msg">Inserte una fecha de nacimiento.</span>
                    <span class="warning_xd"></span>
                </div>
        <?php
    }else{
    }
}

?>
<title>Nuevo</title>
<link rel="stylesheet" href="./css/new.css">
<script src="./js/alert_script.js"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->

<section class="home scroll_hidden" id="home">
    <h1 style="text-align: center; margin-top: 2vw;">Registro de instituciones</h1>

    <form method="POST">

        <div class="wrapper" style="grid-column: 2">
            <div class="input-data">
                <input type="text" name="input_1" id="input_1">
                <div class="underline"></div>
                <label>Nombre de la institución<p style="color:red; display:inline">*</p></label>
            </div>            
        </div>

        <div class="wrapper" style="grid-column: 4">
            <div class="input-data">
                <input type="number" name="input_2">
                <div class="underline"></div>
                <label>Rif de la institucion<p style="color:red; display:inline">*</p></label>
            </div>
        </div>

        <div class="wrapper" style="grid-column: 4">
            <div class="input-data">
                <input type="text" name="input_4">
                <div class="underline"></div>
                <label>Telefono<p style="color:red; display:inline">*</p></label>
            </div>            
        </div>

        <div class="wrapper" style="grid-column: 2; grid-row: 2;">
            <div class="input-data">
                <input type="text" name="input_5">
                <div class="underline"></div>
                <label>Descripción de funciones<p style="color:red; display:inline">*</p></label>
            </div>            
        </div>

        <input type="submit" style="grid-column: 3; grid-row: 4; border-radius:5px; width:100px; height:30px;background: silver;font-size:17px;color: (--text-color)" value="Guardar"></button>
</form>
<br><br><br><br><br><br>
</section>
<?php include ("./template/foot.php"); ?>
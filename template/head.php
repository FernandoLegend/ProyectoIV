<?php
include("./config/bd.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="shortcut icon" href="sources/583437.a05fe325.160x160o.d3b480d501af.png" type="image/x-icon"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/head.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <script src="./js/select2.js"></script> -->

    <link rel="stylesheet" href="./css/input_style.css">
</head>

<body class="">
    <nav class="sidebar close">
        <header>
            <div class="text logo">
                <span class="name">Proyecto</span>
                <span class="recursos">Desarrollador</span>
            </div>

            <i class="bx bx-menu toggle icon"></i>

        </header>

        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class="bx bx-search icon"></i>
                    <input type="text" placeholder="Buscar...">
                </li>


                <li class="nav-link">
                    <a href="./home.php">
                        <i class="bx bx-home-alt icon"></i>
                        <span class="text nav text">Inicio</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="./new.php">
                        <i class='bx bx-user-plus alt icon'></i>
                        <span class="text nav text">Nuevo</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="./new_two.php">
                        <i class="bx bx-pie-chart-alt icon"></i>
                        <span class="text nav text">Nueva Institución</span>
                    </a>

                </li>

                <li class="nav-link">
                    <a href="./manual_de_usuario.pdf">
                        <i class="bx bx-book icon"></i>
                        <span class="text nav text">Ayuda</span>
                    </a>

                </li>

                <li class="nav-link">
                    <a href="#">
                        <!-- <i class="bx bx-wallet icon"></i> -->
                        <!-- <span class="text nav text">Info</span> -->
                    </a>
                </li>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="CerrarSesion.php">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-tex">Salir</span>
                    </a>
                </li>
                <!-- <li class="mode">
                    <div class="sun-moon">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>
                    <span class="mode-text text">Modo oscuro</span>

                    <div class="toggle-switch" onclick="toggleTheme()">
                        <span class="switch"></span>
                    </div>
                </li> -->
            </div>
        </div>
    </nav>
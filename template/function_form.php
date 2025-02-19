<?php

function input_dates($valor,$valor2){
    if($valor == true){
        return "";

    }elseif($valor == false){
        global $dates;
        $value = $dates[$valor2];
        echo $value;
        return $value;
    }
}

// Función para calcular la edad
function calcularEdad($fechaNacimiento) {
    $fechaNacimiento = new DateTime($fechaNacimiento);
    $fechaActual = new DateTime();
    $diferencia = $fechaNacimiento->diff($fechaActual);
    $edad = $diferencia->y;
    return $edad;
}

//funcion de comprobacion de campos alfabeticos
function namecheck($valor) {
    // Eliminar espacios en blanco extras

    // Verificar si el valor está vacío después de eliminar espacios en blanco
    
    if (preg_match('/^[a-zA-ZÀ-ÿ\s]{1,40}$/', $valor)) {
        return true; // El valor es válido, retornar verdadero
        
    }elseif (trim($valor) === "" && $valor === "") {
        return false; // El valor está vacío, retornar falso
        
    }else{
        return false;
    }
    
}

function location_dates($valor) {

    if(preg_match('/^[A-Za-z0-9\s]{0,40}$/', $valor)){
        return true;

    }elseif(trim($valor) == ""){
        return "";

    }elseif($valor != ""){
        $numero = preg_replace('/^[A-Za-z0-9\s]{0,40}$/', '', $valor);
        return false;
    }else{
        return false;
    }
}

function cedulacheck($valor) {

    if(preg_match('/^[A-Za-z]-[0-9]{7,10}$/', $valor)){
        return true;

    }elseif(trim($valor) == ""){
        return "";

    }elseif($valor != ""){
        $numero = preg_replace('/^[A-Za-z]-[0-9]{7,10}$/', '', $valor);
        return false;
    }else{
        return false;
    }
}

//funcion de comporbacion de campos numericos
function numbercheck($valor) {

    if(is_numeric($valor)){
        return true;

    }elseif($valor != ""){
        $numero = preg_replace('/[^0-9]/', '', $valor);
        return false;

    }elseif(trim($valor == "")){
        return "";
    }
}

function number_cell_check($valor) {

    if(is_numeric($valor)){
        return true;

    }elseif($valor != ""){
        $numero = preg_replace('/[^0-9]/', '', $valor);
        return false;

    }elseif($valor == "" && trim($valor) == ""){
        return true;

    }elseif(trim($valor == "")){
        return "";
    }
}

//funcion para validar el genero
function gendercheck($valor) {

    if($valor == "Masculino" || $valor == "Femenino"){
        return true;

    }elseif(trim($valor != "")){
        preg_replace('/[^A-Za-záéíóúüñÁÉÍÓÚÜÑ\s]/u', '', $valor);
        return false;

    }elseif($valor == ""){
        return "";
    }
}

// funcion para validar el tipo de cedula
function cicheck($valor) {

    if($valor == "V" || $valor == "E"){
        return true;

    }elseif(trim($valor) != ""){
        preg_replace('/[^A-Za-záéíóúüñÁÉÍÓÚÜÑ\s]/u', '', $valor);
        return false;

    }else{
        return "";
    }
}

//funcion para validar el estado civil
function civilcheck($valor) {

    if($valor == "Soltero(a)" || $valor == "Casado(a)" || $valor == "Viudo(a)"){
        return true;

    }elseif(trim($valor) != ""){
        preg_replace('/[^A-Za-záéíóúüñÁÉÍÓÚÜÑ\s]/u', '', $valor);
        return false;

    }elseif($valor == ""){
        return "";
    }
}

//funcion para validar fechas
function datecheck($valor) {

    if (strtotime($valor)) {
        return true;

    }elseif(trim($valor != "")){
        $date = preg_replace('/^(0[1-9]|1[0-9]|2[0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$/', '', $valor);
        return false;

    }elseif($valor == ""){
        return "";
    }
}

function textnumbers($valor) {

    if (preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ0-9.,\s]{0,40}$/', $valor)) {
        return true;

    }elseif(trim($valor != "")){
        $date = preg_replace('/^[A-Za-záéíóúÁÉÍÓÚñÑ0-9.,\s]{0,40}$/', '', $valor);
        return false;

    }elseif($valor == ""){
        return "";
    }
}
?>
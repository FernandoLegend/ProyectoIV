<?php
$directorio = "./directorys/33859_2024-12-07";

if (is_dir($directorio)) {
    if (is_readable($directorio)) {
        echo "El directorio es accesible y se puede leer.";
    } else {
        echo "El directorio existe, pero no se puede leer.";
    }

    if (is_writable($directorio)) {
        echo "El directorio también es escribible.";
    } else {
        echo "El directorio no es escribible.";
    }
} else {
    echo "El directorio no existe.";
}
?>
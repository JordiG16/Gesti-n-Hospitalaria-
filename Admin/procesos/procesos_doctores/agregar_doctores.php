<?php
include (__DIR__ . "/../../../includes/conexiones.php");
include (__DIR__ . "/../../../includes/funciones.php");


if ($id){
    crear($pdo, "doctores", $_POST);
}
#Nos vamos a la carpeta de Front_admin despues F_doctores y de ahi elige el proceso de agregar_doctores.php
header("Location: ../../Front_admin/F_doctores/agregar_doctores.php?mensaje=Doctor+agregado+exitosamente!");
exit;
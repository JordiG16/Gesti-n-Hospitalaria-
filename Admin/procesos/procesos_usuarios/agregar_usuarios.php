<?php
include (__DIR__ . "/../../../includes/conexiones.php");
include (__DIR__ . "/../../../includes/funciones.php");


if ($id){
    crear($pdo, "usuarios", $_POST);
}
header("Location: ../../Front_admin/agregar_usuario.php?mensaje=Usuario+agregado+exitosamente!");
exit;
<?php
include (__DIR__ . "/../../../includes/conexiones.php");
include (__DIR__ . "/../../../includes/funciones.php");

$id=$_GET["id_usuario"] ?? null;

if ($id){
    eliminar($pdo, "doctores", $id);
}
header("Location: ../../Front_admin/F_doctores/eliminar_doctores.php?mensaje=Doctor+eliminado");
exit;

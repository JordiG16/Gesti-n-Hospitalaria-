<?php
include (__DIR__ . "/../../../includes/conexiones.php");
include (__DIR__ . "/../../../includes/funciones.php");

$id=$_GET["id_usuario"] ?? null;

if ($id){
    eliminar($pdo, "usuarios", $id);
}
header("Location: ../../Front_admin/eliminar_usuarios.php?mensaje=Usuario+eliminado");
exit;

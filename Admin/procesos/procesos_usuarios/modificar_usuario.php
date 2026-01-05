<?php
$id = $_GET["id_usuario"] ?? null;

if($id){
    header("Location: ../../componentes/tablas_usuarios/mod/final_front_mod_usuarios.php?id_usuario=" . $id);
    exit;
}

?>
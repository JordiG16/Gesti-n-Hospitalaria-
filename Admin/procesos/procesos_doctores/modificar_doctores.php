<?php
$id = $_GET["id_doctor"] ?? null;
if($id){
    header("Location: ../../componentes/tablas_doctores/mod_d/final_front_mod_doc.php?id_doctor=" . $id);
    exit;
}

?>
<?php
include (__DIR__ . "/../../../includes/conexiones.php");
include (__DIR__ . "/../../../includes/funciones.php");

$curp=$_GET["curp"] ?? null;

try{
    $usuarios=Consultar($pdo, "usuarios", $curp);
}catch (Exception $e){
    $usuarios=[];
}

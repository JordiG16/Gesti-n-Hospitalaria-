<?php
include (__DIR__ . "/../../../includes/conexiones.php");
include (__DIR__ . "/../../../includes/funciones.php");

$curp=$_GET["curp"] ?? null;

try{
    $usuarios=Consultar($pdo, "doctores", $curp);
}catch (Exception $e){
    $usuarios=[];
}

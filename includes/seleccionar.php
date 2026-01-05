<?php
require_once(__DIR__ . "/conexiones.php");
header("Content-Type: application/json");



$accion=$_POST["accion"] ?? null;
$tabla=$_POST["tabla"] ?? null;

if (!$accion || !$tabla) {
    echo json_encode(["error"=>"Faltan parámetros"]);
    exit;
}

try {
    switch ($accion){
        case "consult":
            $curp=$_POST["curp"] ?? null;
            $res=Consultar($pdo, $tabla, $curp);
            break;

        case "delete":
            $id=$_POST["id"] ?? null;
            if (!$id) throw new Exception("ID requerido");
            $res=eliminar($pdo, $tabla, $id);
            break;

        case "create":
            // Filtrar datos (evita enviar "accion" y "tabla" a la función crear)
            $datos=$_POST;
            unset($datos["accion"], $datos["tabla"]);
            $res=crear($pdo, $tabla, $datos);
            break;

        default:
            throw new Exception("Acción no válida");
    }

    echo json_encode($res);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}


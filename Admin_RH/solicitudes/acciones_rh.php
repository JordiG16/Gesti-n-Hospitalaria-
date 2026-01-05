<?php
session_start();

// 1. CONEXIÓN
include ( __DIR__ . "/../../includes/conexiones.php");

// 2. VALIDACIÓN: Verificamos que lleguen los datos del enlace
if (isset($_GET['id']) && isset($_GET['accion'])) {
    
    $id = $_GET['id'];
    $accion = $_GET['accion'];
    
    // 3. LÓGICA: Convertimos la acción del botón en el estado para la BD
    $nuevo_estado = match($accion) {
        'aceptar'  => 'aceptado',
        'rechazar' => 'rechazado',
        default    => null
    };

    if ($nuevo_estado) {
        try {
            // 4. ACTUALIZACIÓN: Usamos la tabla real 'solicitudes_empleo'
            $sql = "UPDATE solicitudes_empleo SET estado = :estado WHERE id_solicitud = :id";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':estado' => $nuevo_estado,
                ':id'     => $id
            ]);
            
            // 5. ÉXITO: Regresamos a la tabla
            header("Location: solicitudes.php?mensaje=ok");
            exit();

        } catch (PDOException $e) {
            die("Error crítico al actualizar: " . $e->getMessage());
        }
    }
}

// Si entran sin datos, los sacamos
header("Location: ./solicitudes.php");
exit();
?>
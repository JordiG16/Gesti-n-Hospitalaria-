<?php
session_start();


include(__DIR__ . "/../../../includes/conexiones.php");
include(__DIR__ . "/../../../includes/funciones.php"); 

#2. VALIDAR ID
if (isset($_GET['id'])) {
    $id_med = $_GET['id'];
    
    #LLAMAR A TU FUNCIÓN SEGURA
    $resultado=eliminar_medicamento_seguro(
        $pdo, 
        $_SESSION['id_admin'], 
        $_SESSION['usuario_admin'] ?? 'Admin', 
        $id_med
    );

    #4. REDIRECCIONAR CON MENSAJE
    #Guardamos el mensaje en sesión para mostrarlo en el index
    #(Un truco pro para pasar mensajes entre páginas)
    if (isset($resultado['error'])) {
        $_SESSION['mensaje_sistema'] = $resultado['error'];
        $_SESSION['tipo_mensaje'] = "error";
    } else {
        $_SESSION['mensaje_sistema'] = $resultado['mensaje'];
        $_SESSION['tipo_mensaje'] = "success";
    }
}

#Nos regresamos a la lista
header("Location: ../medicamentos.php");
exit;
?>
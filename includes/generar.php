<?php
// 1. CONEXIÓN
// Buscamos el archivo de conexión (ajusta si tu carpeta se llama diferente)
include("conexiones.php");
// 2. DATOS DEL NUEVO ADMINISTRADOR
$nombre = "Administrador General";  // Nombre real
$usuario = "admin_jefe";            // Usuario para login
$fecha_registro = date("Y-m-d H:i:s"); // Fecha de ahorita

// 3. CONTRASEÑA SEGURA
// Requisitos: Mayúscula, Minúscula, Número, Carácter especial, Min 8 chars
$password_plana = "Admin12v!"; 

// 4. GENERAR HASH (La encriptación)
$password_hash = password_hash($password_plana, PASSWORD_DEFAULT);

try {
    // 5. INSERTAR EN LA TABLA 'administradores'
    // OJO: Según tu foto, las columnas son: nombre, usuarios, contrasena, fecha_registro
    $sql = "INSERT INTO administradores (nombre, usuarios, contrasena, fecha_registro) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $ejecutar = $stmt->execute([$nombre, $usuario, $password_hash, $fecha_registro]);

    if ($ejecutar) {
        echo "<div style='font-family:sans-serif; max-width:500px; margin:50px auto; padding:20px; background:#dcfce7; border:2px solid #22c55e; border-radius:10px; text-align:center;'>";
        echo "<h1 style='color:#15803d;'>¡Éxito nena! ✨</h1>";
        echo "<p>Se creó el administrador correctamente.</p>";
        echo "<hr style='border:1px solid #86efac; margin:15px 0;'>";
        echo "<p style='text-align:left;'>👤 <b>Usuario:</b> $usuario</p>";
        echo "<p style='text-align:left;'>🔑 <b>Contraseña:</b> $password_plana</p>";
        echo "<p style='margin-top:20px; font-size:12px; color:#666;'>Borra este archivo después de usarlo por seguridad.</p>";
        echo "</div>";
    }

} catch (PDOException $e) {
    echo "<div style='font-family:sans-serif; max-width:500px; margin:50px auto; padding:20px; background:#fee2e2; border:2px solid #ef4444; border-radius:10px;'>";
    echo "<h1 style='color:#b91c1c;'>Error 😢</h1>";
    echo "<p>Algo salió mal con la base de datos:</p>";
    echo "<code>" . $e->getMessage() . "</code>";
    echo "</div>";
}
?>
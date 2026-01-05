<?php
// --- AGREGAMOS ESTE IF PARA QUE NO SE ROMPA SI SE CARGA DOBLE ---
if (!function_exists('cargarEnv')) {
    
    function cargarEnv($ruta) {
        if (!file_exists($ruta)) {
            return;
        }
        
        $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lineas as $linea) {
            if (strpos(trim($linea), '#') === 0) { continue; }
            list($nombre, $valor) = explode('=', $linea, 2);
            $nombre = trim($nombre);
            $valor = trim($valor);
            
            if (!array_key_exists($nombre, $_SERVER) && !array_key_exists($nombre, $_ENV)) {
                putenv(sprintf('%s=%s', $nombre, $valor));
                $_ENV[$nombre] = $valor;
                $_SERVER[$nombre] = $valor;
            }
        }
    }

}   

cargarEnv(__DIR__ . '/../.env');

$host = $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['DB_NAME'] ?? 'hospital';
// ... etc

// 2. Leemos las variables (Ojo: Si no existen, usa valores por defecto o vacíos)
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['DB_NAME'] ?? 'hospital';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASSWORD'] ?? '';

try {
    // 3. Conexión usando las variables cargadas
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // IMPORTANTE: En producción, nunca muestres el error real al usuario ($e->getMessage())
    // Mejor usa: die("Error de conexión a la base de datos.");
    die("Error de conexión: " . $e->getMessage());
}
?>
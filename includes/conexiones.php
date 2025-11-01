<?php

$host="localhost";
$db="hospital";
$user="root";
$pass="";

try {
    $pdo=new PDO("mysql:host=$host;dbname=$db",$user,$pass);#estas es la forma de conectar la fucking base cuando usamos PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

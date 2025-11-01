<?php
include("includes/conexiones.php");
session_start();

$usuario=$_POST['usuario'];
$contrasena=$_POST['contrasena'];

$sql= "SELECT * FROM administrador WHERE usuario = ?";
$stmt=$pdo->prepare($sql);
$stmt->execute([$usuario]);
$user=$stmt->fetch(PDO::FETCH_ASSOC); #permite leer los datos fila por fila el metodo fetch.

if(empty($usuario) || empty($contrasena)) {
    echo "<script>alert('Completa todos los campos'); window.location='login.php';</script>";
    exit;
}

if ($user && $contrasena === $user['contrasena']) {
    $_SESSION['usuario'] = $user['usuario'];
    $_SESSION['rol'] = $user['rol'];
    header("Location: index.php");
    exit;
} else {
    echo "<script>alert('Usuario o contraseña incorrectos'); window.location='login.php';</script>";
}
?>

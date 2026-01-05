<?php
include("../includes/conexiones.php");
include("../includes/funciones.php");
session_start();


#Datos
$nombre=$_POST['nombre'];
$usuario=$_POST['usuarios'];
$correo=$_POST['correo'];
$contrasena=$_POST['contrasena'];
$telefono=$_POST['telefono'];
$curp=$_POST['curp'];

#Validar
es_vacio($nombre,$usuario,$correo,$contrasena,$telefono,$curp);

$errores=[];

if(verificar_cont($contrasena)){
    $errores[]="No puedes usar caracteres seguidos (abc, 123, etc).";
}
if(!preg_match('/[a-z]/',$contrasena)){
    $errores[]="Debe contener al menos una letra minúscula.";
}
if(!preg_match('/[A-Z]/',$contrasena)){
    $errores[]="Debe contener al menos una letra mayúscula.";
}
if(!preg_match('/[0-9]/',$contrasena)){
    $errores[]="Debe contener al menos un número.";
}
if(strlen($contrasena)<8){
    $errores[]="Debe tener al menos 8 caracteres.";
}

if(!empty($errores)){
    $mensaje=implode("\\n",$errores);
    echo "<script>alert('Errores en la contraseña:\\n\\n$mensaje'); window.location='registro.php';</script>";
    exit;
}

#Encriptamos
$pass=password_hash($contrasena,PASSWORD_DEFAULT);

#Tabla destino
$tabla="usuarios"; // Usuarios normales

#Evitar duplicados
$check=$pdo->prepare("SELECT * FROM $tabla WHERE usuarios=?");
$check->execute([$usuario]);

if($check->fetch()){
    echo "<script>alert('Este usuario ya existe'); window.location='registro.php';</script>";
    exit;
}

#Insertar
$sql="INSERT INTO $tabla (nombre,usuarios,correo,contrasena,telefono,curp) VALUES (?,?,?,?,?,?)";
$stmt=$pdo->prepare($sql);

if($stmt->execute([$nombre,$usuario,$correo,$pass,$telefono,$curp])){
    echo "<script>alert('Registrado exitosamente'); window.location='../index.php';</script>";
}else{
    echo "<script>alert('Error al registrar, intenta de nuevo'); window.location='registro.php';</script>";
}
?>

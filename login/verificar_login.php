<?php
include("../includes/conexiones.php");
session_start();

if (!isset($_POST['usuarios']) || !isset($_POST['contrasena'])) {
    die("Error: Formulario incompleto.");
}

$u=trim($_POST['usuarios']);
$p=trim($_POST['contrasena']);

if($u === "" || $p === ""){
    echo "<script>alert('Campos vacíos'); window.location='login.php';</script>";
    exit;
}

try{
    #BUSCAR EN ADMINISTRADORES
    $sql="SELECT * FROM administradores WHERE usuarios=?";
    $stmt=$pdo->prepare($sql);      
    $stmt->execute([$u]);
    $user=$stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($p, $user['contrasena'])){
        $_SESSION['usuario']=$user['usuarios'];
        $_SESSION['id_admin']=$user['id_admin'];
        #si no existe la ruta gg
        header("Location: ../index.php"); 
        exit;
    }

    #BUSCAR EN USUARIOS (PACIENTES)
    $sql="SELECT * FROM usuarios WHERE usuarios=?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$u]);
    $user=$stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($p, $user['contrasena'])){
        $_SESSION['usuario']=$user['usuarios'];
        $_SESSION['id_usuario']=$user['id_usuario'];
        #Guardamos también el nombre para el portal
        $_SESSION['usuario_paciente']=$user['nombre']; 
        header("Location: ../usuarios/index.php");
        exit;
    }

    #BUSCAR EN RH
    $sql="SELECT * FROM rh WHERE usuarios=?"; 
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$u]);
    $user=$stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($p, $user['contrasena'])){
        $_SESSION['usuario']=$user['usuarios'];
        $_SESSION['id']=$user['id_rh'];
        header("Location: ../Admin_RH/index.php");
        exit;
    }

    echo "<script>
            alert('Usuario o contraseña incorrectos'); 
            window.location='login.php';
          </script>";
    exit;

} catch (Exception $e) {
    // El catch solo se activa si falla la conexión a la BD
    echo "Error crítico: " . $e->getMessage();
    exit;
}
?>
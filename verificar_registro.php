<?php
include("includes/conexiones.php");
session_start();

#funciones
function es_vacio($n,$c,$co,$tel,$cu,$ro){
    if (empty($n) || empty($c) || empty($co) || empty($tel) || empty($cu) || empty($ro)) {
        echo "<script>alert('Completa todos los campos'); window.location='login.php';</script>";
        exit;#Detiene el script si hay campos vacíos
    }
}

function verificar_cont($valores){
    $cad_limpia=strtolower($valores);
    $long=strlen($cad_limpia);
    if($long<3){
        return false;
    }
    #hace la logica de analiar la contraseña si abc o cde y así   
    for($i=0;$i<=$long-3;$i++){
        $cad1=ord($cad_limpia[$i]);
        $cad2=ord($cad_limpia[$i+1]);
        $cad3=ord($cad_limpia[$i+2]);
    
        if (($cad2===$cad1 + 1) && ($cad3===$cad2 + 1))
            return true;
    }
    return false;
}

#Recibir datos del formulario
$nombre=$_POST['nombre'];
$correo=$_POST['correo'];
$contrasena=$_POST['contrasena'];
$telefono=$_POST['telefono'];
$curp=$_POST['curp'];
$rol=$_POST['rol'];

#Llamo a la función de validación de vacíos
es_vacio($nombre, $correo, $contrasena, $telefono, $curp, $rol);

#Muestra los errores como salida
$errores=[];
if (verificar_cont($contrasena)){
  $errores[]="No puedes usar caracteres seguidos (ej. 'abc', '123').";
}
if (!preg_match('/[a-z]/', $contrasena)){
  $errores[]="Debe contener al menos una letra minúscula.";
}

if (!preg_match('/[A-Z]/', $contrasena)){
  $errores[]="Debe contener al menos una letra mayúscula.";
}
if (!preg_match('/[0-9]/', $contrasena)){
  $errores[]="Debe contener al menos un número.";
}
if (strlen($contrasena) < 8){
   $errores[]="Debe tener al menos 8 caracteres.";
}

    if (!empty($errores)){
    #Si hubo errores, los juntamos todos en un solo mensaje
    $mensaje_error=implode("\\n", $errores);

    echo "<script>
            alert('Errores en la contraseña:\\n\\n$mensaje_error');
            window.location='registro.php';
            </script>";
    
    }else{
        #Cifrar la contraseña antes de guardarla
        $contrasena_hash=password_hash($contrasena, PASSWORD_DEFAULT);

        #Consulta SQL con placeholders (más segura)
        $sql="INSERT INTO administrador (nombre, correo, contrasena, telefono, curp) 
            VALUES (?, ?, ?, ?, ?)";

        $stmt=$pdo->prepare($sql);

        #Ejecutar con los valores en orden
        if ($stmt->execute([$nombre, $correo, $contrasena_hash, $telefono, $curp])) {
            echo "<script>alert('Registrado Exitosamente'); window.location='registro.php</script>";
        } else {
            echo "<script>alert('Registrado Exitosamente'); window.location='registro.php</script>";
        }
    }
?>

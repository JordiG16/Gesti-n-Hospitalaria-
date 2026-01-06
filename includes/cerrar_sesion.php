<?php
session_start();


#Borramos todas las variables de sesión
$_SESSION=array();

#Destruimos la sesión completamente (el "carnet")
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();#Matamos la sesión en el servidor

header("Location: ../../login/login.php");
exit;
?>
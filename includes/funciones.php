<?php
include(__DIR__ . "/conexiones.php");

const TABLAS=["usuarios", "administradores", "doctores","medicamentos"];

function es_vacio($n,$u,$co,$c,$tel,$cu){
    if (empty($n) || empty($u) || empty($co) || empty($c) || empty($tel) || empty($cu)) {
        echo "<script>alert('Completa todos los campos'); window.location='registro.php';</script>";
        exit;
    }
}

function verificar_cont($valores){
    $cad_limpia=strtolower($valores);
    $long=strlen($cad_limpia);
    if ($long < 3){return false;}

    for ($i=0; $i<=$long-3; $i++){
        $cad1=ord($cad_limpia[$i]);
        $cad2=ord($cad_limpia[$i + 1]);
        $cad3=ord($cad_limpia[$i + 2]);

        if (($cad2 === $cad1 + 1) && ($cad3 === $cad2 + 1))
            return true;
    }
    return false;
}

#INICIO DE SESION (nunca funcionó xd, sabrá dios cual fue el error)
function inicio_sesion($pdo,$tabla,$usuario){
    if (!in_array($tabla, TABLAS)) {
        throw new Exception("Tabla no válida");
    }

    $sql="SELECT * FROM $tabla WHERE usuarios = ?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$usuario]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    
}

#PARA CONSULTAR->TENDREMOS QUE TENER UNA TABLA ADMINS, USUARIOS Y DOCTORES,
#LOS CUALES, LOS 3 SEAN CONSULTADOS MEDIANTE EL CURP
#AHORA, EN ESTE CASO, PUEDO SI O SI
function Consultar($pdo, $tabla, $curp=null){
    if(!in_array($tabla,TABLAS))
         throw new Exception("Tabla no valida");

    if ($curp){
        $sql="SELECT * FROM $tabla WHERE curp= ?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$curp]);
        $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data ?: [];
    }else{
        $sql="SELECT * FROM $tabla";
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $sql="SELECT * FROM  $tabla WHERE id_medicamento=?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

#AHORA, PARA ELIMINAR->SOLAMENTE PONDREMOS EN SALIDA EL NOMBRE, EL CORREO Y EL USUARIO Y SU ROL,
#EL CUAL CLARAMENTE TODO DEPENDERÁ DE LA TABLA A ELIMINAR
function eliminar ($pdo,$tabla,$id){

    if(!in_array($tabla,TABLAS))
        throw new Exception("Tabla no valida");

    $ID_MAP=[
        "medicamentos"=>"id_medicamento",
        "usuarios"=>"id_usuario",
        "administradores"=>"id_admin",
        "doctores"=>"id_doctor"
    ];
    try{
        $idCampo=$ID_MAP[$tabla];
        $sql="DELETE FROM $tabla WHERE $idCampo= ?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() === 0){
            return ["mensaje" => "No se encontró el registro o ya estaba eliminado"];
        }
        return ["mensaje" => "Registro eliminado correctamente"];

    }catch (Exception $e){
        return ["error" => $e->getMessage()];
    }
}

function crear($pdo, $tabla, $datos) {

    if (!in_array($tabla, TABLAS))
        throw new Exception("Tabla no valida");

    $nombre=$datos["nombre"];
    $usuario=$datos["usuarios"] ?? null; 
    $correo=$datos["correo"];
    $contrasena=$datos["contrasena"];
    $telefono=$datos["telefono"];
    $curp=$datos["curp"];
    $direccion=$datos["direccion"];

    #Solo usuarios tienen afiliado xd
    $afiliado = ($tabla === "usuarios") ? ($datos["es_afiliado"] ?? 0) : null;

    #Validacion de contraseña
    $errores = [];

    if (verificar_cont($contrasena)) {
        $errores[] = "No puedes usar caracteres seguidos (ej. 'abc', '123').";
    }
    if (!preg_match('/[a-z]/', $contrasena)) {
        $errores[] = "Debe contener al menos una letra minúscula.";
    }
    if (!preg_match('/[A-Z]/', $contrasena)) {
        $errores[] = "Debe contener al menos una letra mayúscula.";
    }
    if (!preg_match('/[0-9]/', $contrasena)) {
        $errores[] = "Debe contener al menos un número.";
    }
    if (strlen($contrasena) < 8) {
        $errores[] = "Debe tener al menos 8 caracteres.";
    }

    if (!empty($errores)) {
        $mensaje_error = implode("\\n", $errores);
        echo "<script>alert('Errores en la contraseña:\\n\\n$mensaje_error'); window.history.back();</script>";
        exit;
    }

    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    #PARA USUARIOS ESTA PARTE
    if ($tabla === "usuarios") {
        $sql="INSERT INTO usuarios (nombre, usuarios, correo, contrasena, telefono, curp, es_afiliado, direccion)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$nombre, $usuario, $correo, $contrasena_hash, $telefono, $curp, $afiliado, $direccion]);
        return ["status" => "ok", "id_insertado" => $pdo->lastInsertId()];
    }
    #APARTADO DE DOCTORES
    $especialidad=$datos["especialidad"];
    $sql="INSERT INTO doctores (nombre, especialidad, correo, contrasena, telefono, curp, direccion)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$nombre, $especialidad, $correo, $contrasena_hash, $telefono, $curp, $direccion]);
    return ["status" => "ok", "id_insertado" => $pdo->lastInsertId()];
}

function modificar($pdo,$tabla,$nombre,$telefono,$direccion,$usuario,$contrasena,$id){

    if(!in_array($tabla,TABLAS))
        throw new Exception("Tabla no valida");

    $ID_MAP = ["usuarios" => "id_usuario", "doctores" => "id_doctor"];

    try{
        $idcampo=$ID_MAP[$tabla];
        #Si no se envia contraseña, no se modifica
        if($idcampo==="id_usuario"){
            if ($contrasena === null) {
                $sql="UPDATE $tabla SET nombre=?, usuarios=?, direccion=?, telefono=? WHERE $idcampo=?";
                $stmt=$pdo->prepare($sql);
                $stmt->execute([$nombre, $usuario, $direccion, $telefono, $id]);
            } else{
                #contraseña si modificada xd
                $sql="UPDATE $tabla SET nombre=?, usuarios=?, direccion=?, telefono=?, contrasena=? WHERE $idcampo=?";
                $stmt=$pdo->prepare($sql);
                $stmt->execute([$nombre, $usuario, $direccion, $telefono, $contrasena, $id]);
            }
            return ["mensaje"=>"Registro actualizado"];
        }else{
                if ($contrasena === null){
                    $sql="UPDATE $tabla SET nombre=?,especialidad=?, direccion=?, telefono=? WHERE $idcampo=?";
                    $stmt=$pdo->prepare($sql);
                    $stmt->execute([$nombre, $usuario, $direccion, $telefono, $id]);
                }else{
                    #contraseña si modificada xd
                    $sql="UPDATE $tabla SET nombre=?, especialidad=?, direccion=?, telefono=?, contrasena=? WHERE $idcampo=?";
                    $stmt=$pdo->prepare($sql);
                    $stmt->execute([$nombre, $usuario, $direccion, $telefono, $contrasena, $id]);
                }
                return ["mensaje"=>"Registro actualizado"];
        }

    }catch (Exception $e){
        return ["error" => $e->getMessage()];
    }
}


function crear_medicamento($pdo, $id_admin, $usuario_nombre, $principio, $presentacion, $gramaje, $stock_inicial){
    #Permisos (Ajusta los IDs según tus admins reales)
    $admins_autorizados = [1, 2, 3, 4]; 
    if (!in_array($id_admin, $admins_autorizados)){
        return ["error" => "Acceso denegado: No tienes permisos para crear medicamentos."];
    }

    #Validaciones
    if (empty($principio) || empty($presentacion) || empty($gramaje)){
        return ["error" => "Faltan datos obligatorios."];
    }
    if (!is_numeric($stock_inicial) || $stock_inicial < 0){
        return ["error" => "El stock debe ser un número positivo."];
    }

    try {
        #Checar duplicados
        $sql_check="SELECT id_medicamento FROM medicamentos WHERE principio_activo = ? AND presentacion = ? AND gramaje = ?";
        $stmt_check=$pdo->prepare($sql_check);
        $stmt_check->execute([$principio, $presentacion, $gramaje]);

        if ($stmt_check->rowCount() > 0) {
            return ["error" => "Este medicamento ya existe en el inventario."];
        }

        #Insertar
        $sql_insert="INSERT INTO medicamentos (principio_activo, presentacion, gramaje, cantidad_stock, id_admin, fecha_registro) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt=$pdo->prepare($sql_insert);
        $ejecucion=$stmt->execute([$principio, $presentacion, $gramaje, $stock_inicial, $id_admin]);

        if ($ejecucion){
            #Guardar Historial
            registrar_historial($pdo, $usuario_nombre, 'Administrador', 'INVENTARIO', "Registró nuevo: $principio ($gramaje)");
            
            return ["mensaje" => "Medicamento registrado con éxito.", "tipo" => "success"];
        } else{
            return ["error" => "Error al guardar en la base de datos."];
        }

    } catch (PDOException $e) {
        return ["error" => "Error técnico: " . $e->getMessage()];
    }
}


function actualizar_medicamento_completo($pdo, $id_admin, $usuario_nombre, $id_med, $nombre, $presentacion, $gramaje, $nuevo_stock){
    
    $admins_autorizados=[1, 2, 3, 4]; 
    if (!in_array($id_admin, $admins_autorizados)){
        return ["error" => "Acceso denegado."];
    }

    if (!is_numeric($nuevo_stock) || $nuevo_stock < 0){
        return ["error" => "Stock inválido."];
    }

    try {
        #Actualizamos TODO, no solo el stock
        $sql="UPDATE medicamentos SET principio_activo=?, presentacion=?, gramaje=?, cantidad_stock=? 
                WHERE id_medicamento=?";
        $stmt=$pdo->prepare($sql);
        $ejecucion=$stmt->execute([$nombre, $presentacion, $gramaje, $nuevo_stock, $id_med]);

        if ($ejecucion){
            if ($stmt->rowCount() > 0){
                registrar_historial($pdo, $usuario_nombre, 'Administrador', 'EDITAR STOCK', "Modificó medicamento ID $id_med ($nombre)");
                return ["mensaje" => "Datos actualizados correctamente.", "tipo" => "success"];
            } else {
                return ["mensaje" => "No se detectaron cambios (los datos eran iguales).", "tipo" => "warning"];
            }
        } else {
            return ["error" => "Error al ejecutar la actualización."];
        }

    } catch (PDOException $e){
        return ["error" => "Error de BD: " . $e->getMessage()];
    }
}


function eliminar_medicamento_seguro($pdo, $id_admin, $usuario_nombre, $id_med) {
    
    #Permisos (Solo admins autorizados)
    $admins_autorizados = [1, 2, 3, 4]; 
    if (!in_array($id_admin, $admins_autorizados)) {
        return ["error" => "Acceso denegado."];
    }

    try {
        #Obtener nombre antes de borrar (Para el chisme/historial)
        $stmt_info = $pdo->prepare("SELECT principio_activo, gramaje FROM medicamentos WHERE id_medicamento = ?");
        $stmt_info->execute([$id_med]);
        $med = $stmt_info->fetch(PDO::FETCH_ASSOC);

        if (!$med) {
            return ["error" => "El medicamento no existe o ya fue borrado."];
        }

        $nombre_med = $med['principio_activo'] . " " . $med['gramaje'];

       #borrar
        $sql = "DELETE FROM medicamentos WHERE id_medicamento = ?";
        $stmt = $pdo->prepare($sql);
        $ejecucion = $stmt->execute([$id_med]);

        if ($ejecucion) {
            #Registrar en Historial
            registrar_historial($pdo, $usuario_nombre, 'Administrador', 'ELIMINAR STOCK', "Eliminó del sistema: $nombre_med");
            
            return ["mensaje" => "Medica    mento eliminado correctamente.", "tipo" => "success"];
        } else {
            return ["error" => "No se pudo eliminar."];
        }

    } catch (PDOException $e){
        #Error común: Si ya se usó en recetas, la BD no dejará borrarlo (Integridad referencial)
        if ($e->getCode() == '23000') {
             return ["error" => "No se puede eliminar: Este medicamento ya está ligado a recetas o historiales."];
        }
        return ["error" => "Error de BD: " . $e->getMessage()];
    }
}



/**
 *
 * Guarda una acción en la base de datos para auditoría.
 * * @param PDO $pdo         La conexión a la base de datos
 * @param string $usuario  Nombre o ID del usuario que hizo la acción
 * @param string $rol      Rol del usuario (Ej: 'Paciente', 'Admin RH')
 * @param string $accion   Palabra clave (Ej: 'AGENDAR', 'ELIMINAR', 'LOGIN')
 * @param string $detalles Descripción larga de lo que pasó
 */
function registrar_historial($pdo, $usuario, $rol, $accion, $detalles){
    try {
        #Obtenemos fecha y hora actual
        $fecha = date("Y-m-d H:i:s");
        
        #OJO: Asegúrarme de que la tabla se llame 'historial_logs'
        $sql="INSERT INTO historial_logs (usuario, rol, accion, descripcion, fecha) VALUES (:usuario, :rol, :accion, :detalles, :fecha)";
        $stmt=$pdo->prepare($sql);

        #Ejecutamos con seguridad
        $stmt->execute([
            ':usuario' => $usuario,
            ':rol' => $rol,
            ':accion' => $accion,
            ':detalles' => $detalles,
            ':fecha' => $fecha
        ]);
        
        return true;
    } catch (PDOException $e) {
        #Si falla, guardamos el error en un archivo de texto del servidor para no romper la página
        error_log("Error en registrar_historial: " . $e->getMessage());
        return false;
    }
}
function limpiar_datos($datos) {
    $datos=trim($datos);             #Quita espacios al inicio y final
    $datos=stripslashes($datos);     #Quita barras invertidas
    $datos=htmlspecialchars($datos); #Convierte caracteres especiales a HTML
    return $datos;
}

?>
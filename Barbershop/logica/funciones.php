<?php

function conecta(){
    $conexion=new mysqli("127.0.0.1","root","","barberia");
    $conexion->set_charset("utf8");
    return $conexion;
}

//compruebo si el que inicia sesión es empleado o cliente
function todoOk($usuario,$passwd){
    $conexion=conecta();
    
    $ordenCliente = "SELECT * FROM clientes WHERE usuario='" . $usuario . "' AND asientra='" . $passwd . "'";
    $ordenEmp = "SELECT * FROM empleados WHERE nombre='" . $usuario . "' AND codentrada='" . $passwd . "'";
    
    $resultadoCliente=$conexion->query($ordenCliente);
    $resultadoEmp=$conexion->query($ordenEmp);
    
    $devuelvo="niMielda";
    if ($resultadoCliente->num_rows > 0) {
        $devuelvo="cliente";
        
    }else if ($resultadoEmp->num_rows > 0) {
        $devuelvo="empleado";
        
    }
    return $devuelvo;
}

// COMPRUEBA SI EL LOGIN ES DE ADMIN
function soyAdmin($usuario,$passwd){
    $conexion=conecta();
    $usuario = mysqli_real_escape_string($conexion, $usuario);
    $passwd = mysqli_real_escape_string($conexion, $passwd);
    $sies=false;
    $orden="SELECT paentrar,usuario FROM admin";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=$resultado->fetch_array();
    if($usuario==$respuesta['usuario'] && $passwd==$respuesta['paentrar']){
        $sies=true;
    }
    return($sies);
}

//Comprobación para que no haya dos personas registradas con la misma info
function existePersona($correo,$usuario){
    $conexion=conecta();
    $orden1="SELECT usuario FROM clientes WHERE correo='".$correo."'";
    $orden2="SELECT usuario FROM clientes WHERE usuario='".$usuario."'";
    $resultado1=mysqli_query($conexion,$orden1);
    $resultado2=mysqli_query($conexion,$orden2);
    $existe=false;
    if($resultado1->num_rows >0 || $resultado2->num_rows >0){
        $existe=true;
    }
    return $existe;
}
// Creacion de clientes en la base de datos
function insertoCliente($nombre,$usuario,$contrasena,$correo){
    $conexion=conecta();
    $orden="INSERT INTO clientes (nombre,usuario,asientra,correo) VALUES ('".$nombre."','".$usuario."','".$contrasena."','".$correo."')";
    mysqli_query($conexion,$orden);
}

function dameCliente($usuario){
    $conexion=conecta();
    $orden="SELECT nombre, cod_cliente FROM clientes WHERE usuario ='".$usuario."'";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=array();
    while($registro=$resultado->fetch_array()){
        $respuesta[$registro[0]]=$registro[1];
    }
    return $respuesta;
}


function dameEmpleados(){
    $conexion=conecta();
    $orden="SELECT cod_empleado,nombre FROM empleados WHERE activo=1";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=array();
        while($registro=$resultado->fetch_array()){
            $respuesta[$registro[0]]=$registro[1];
        }
        return $respuesta;
}
function dameCodEmp($usuario,$passwd){
    $conexion=conecta();
    $orden="SELECT cod_empleado FROM empleados WHERE nombre='".$usuario."' AND codentrada='".$passwd."' AND activo=1";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=$resultado->fetch_array();
    return $respuesta;
}


function dameServicios(){
    $conexion=conecta();
    $orden="SELECT cod_servicio,nombre FROM servicio WHERE activo=1 AND precio>0";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=array();
        while($registro=$resultado->fetch_array()){
            $respuesta[$registro[0]]=$registro[1];
        }
        return $respuesta;
}
function descripcionPrecio($cod_servicio){
    $conexion=conecta();
    $orden="SELECT descripcion,precio FROM servicio WHERE cod_servicio='".$cod_servicio."'";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=array();
        while($registro=$resultado->fetch_array()){
            $respuesta[$registro[0]]=$registro[1];
        }
        return $respuesta;
}

function hayCita($fecha,$hora,$peluquero){
    $conexion=conecta();
    $orden="SELECT cod_cita FROM citas where fecha='".$fecha."' AND hora='".$hora."' AND cod_empleado='".$peluquero."'";
    $resultado=mysqli_query($conexion,$orden);
    $existe=false;
    if($resultado->num_rows>0){
        $existe=true;
    }
    return $existe;
}
function insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio){
    $conexion=conecta();
    $orden="INSERT INTO citas (cod_cliente,cod_empleado,cod_servicio,fecha,hora) VALUES('".$codcliente."','".$codempleado."','".$codservicio."','".$fecha."','".$hora."')";
    mysqli_query($conexion,$orden);
}
function dameCita($fecha,$codempleado,$hora){
    $conexion=conecta();
    $orden="SELECT cod_cita FROM citas WHERE fecha='".$fecha."' AND cod_empleado='".$codempleado."' AND hora='".$hora."'";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=$resultado->fetch_array();
    return $respuesta;
}
function cuantasCitas($cod_cliente){
    $conexion=conecta();
    $orden="SELECT COUNT(cod_cita) FROM citas c WHERE (c.fecha, c.cod_servicio, c.cod_cita) IN (SELECT fecha, cod_servicio, MIN(cod_cita) AS min_cod_cita FROM citas WHERE fecha > NOW() AND cod_cliente ='".$cod_cliente."' GROUP BY fecha, cod_servicio)";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=$resultado->fetch_array();

    return $respuesta[0];
}
function dameMisCitas($cod_cliente){
    $conexion=conecta();
    $orden="SELECT nombre, fecha, hora
    FROM citas c
    JOIN servicio s ON s.cod_servicio = c.cod_servicio
    WHERE (c.fecha, c.cod_servicio, c.cod_cita) IN (
        SELECT fecha, cod_servicio, MIN(cod_cita) AS min_cod_cita
        FROM citas 
        WHERE fecha > NOW() AND cod_cliente ='".$cod_cliente."'
        GROUP BY fecha, cod_servicio
    )";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=array();
    $cont=0;
        while($registro=$resultado->fetch_array()){
            $respuesta[$cont][$registro[0]][$registro[1]]=$registro[2];
            $cont++;
        }

    return $respuesta;
}
function canceloCita($fechacita,$servicio){
    $conexion=conecta();
    $orden="DELETE FROM citas WHERE fecha='".$fechacita."' AND cod_servicio=(SELECT cod_servicio FROM servicio WHERE nombre='".$servicio."')";
    mysqli_query($conexion,$orden);
}

function dameNombreCliente($cod_cita){
    $conexion=conecta();
    $orden="SELECT nombre FROM clientes WHERE cod_cliente=(SELECT cod_cliente from citas WHERE cod_cita='".$cod_cita."')";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=$resultado->fetch_array();
    return $respuesta;
}
function dameNombreServicio($cod_cita){
    $conexion=conecta();
    $orden="SELECT nombre FROM servicio WHERE cod_servicio=(SELECT cod_servicio from citas WHERE cod_cita='".$cod_cita."')";
    $resultado=mysqli_query($conexion,$orden);
    $respuesta=$resultado->fetch_array();
    return $respuesta;
}
function insertoHoraLibre($tiempo,$codbarbero,$fecha){
    $conexion=conecta();
    $orden="INSERT INTO citas (cod_cliente,cod_empleado,cod_servicio,fecha,hora) VALUES( 0,'".$codbarbero."',0,'".$fecha."','".$tiempo."')";
    mysqli_query($conexion,$orden);
}

?>
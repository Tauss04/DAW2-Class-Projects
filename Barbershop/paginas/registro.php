<?php
include"../logica/funciones.php";

if(!isset($_COOKIE['registro'])){
    echo"<script>
        alert('Ha expirado su tiempo para registrarse')
        window.location.href = '../index.php';
    </script>";
}else{
    // Sí pulso botón enviar, compruebo que no existe nadie en la bd con sus datos
    if(isset($_POST['btnEnviar'])){
        $correo=$_POST['correo'];
        $nombre=$_POST['nombre'];
        $usuario=$_POST['usuario'];
        $contrasena=$_POST['contrasena1'];

        if(!existePersona($correo,$usuario)){
            insertoCliente($nombre,$usuario,$contrasena,$correo);
            header("Location:../index.php");
        }else{
            echo"<script>alert('Ya existe un usuario con los mismos datos')</script>";
        }
        

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <link rel="icon" type="image/x-icon" href="../imagenes/icono.ico">
    <link rel="stylesheet" href="../estilos/registro.css">
    <title>Registrate</title>
    <script src="../logica/registro.js"></script>
</head>
<body>
    <header>

    </header>
    <main>
        <form action="registro.php" method="post" class="form">
            <p class="title">Registrate </p>
            <p class="message">Registrate ahora y pide cita en nuestra web</p>
            <div class="flex">
                <label>
                    <input type="text" name="nombre" class="input" required="required" placeholder="" max="10" min"3">
                    <span>Nombre</span>
                </label>
                <label>
                    <input type="text" name="usuario" class="input" required="required" placeholder="" max="15" min"3">
                    <span>Usuario</span>
                </label>
            </div>
            <label>
                <input type="email" name="correo" class="input" required="required" placeholder="">
                <span>Email</span>
            </label>
            <label>    
                <input type="password" name="contrasena1" class="input" id="contrasena1" required="required" placeholder="">
                <span>Contraseña</span>
            </label>
            <label>
                <input type="password" id="contrasena2" class="input" required="required" placeholder="" oninput="compruebo()">
                <span>Confirma la contraseña</span>            
            </label>
                <input class="submit" type="submit" id="btnEnviar" name="btnEnviar" value="Enviar">
                <p class="signin">Ya tienes una cuenta? <a href="../index.php">Iniciar sesion</a> </p>
        </form>
    </main>
    <footer>
    </footer>
</body>
</html>
<?php
}
?>
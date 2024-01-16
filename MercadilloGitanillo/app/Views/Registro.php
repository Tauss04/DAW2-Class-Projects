<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo"<link rel='icon' type='image/x-icon' href='".base_url()."imagenes/logo.png'>";?>
    <?php echo"<link rel='stylesheet' href='".base_url()."estilos/Registro.css'>";?>
    <title>Registro</title>
</head>
<body>
<div class="form-container">
    <p class="title">Registrate</p>
    <form class="form" action="registrarse" method="post">
        <input type="text" class="input" name="nombre" required placeholder="Nombre">
        <input type="email" class="input" name="correo" required placeholder="Email">
        <input type="password" class="input" name="contrasena" required placeholder="Contraseña">
        <input type="submit" class="form-btn" value="Crear Cuenta">
    </form>
    <p class="sign-up-label">
        ¿No tienes cuenta? <a class="sign-up-link" href="<?php echo base_url('entrar'); ?>">Iniciar Sesión</a>
    </p> 
    </br>
    <?php
        if(isset($error)){
            echo"<p id='error'>El correo introducido ya esta registrado</p>";
        }
    ?>
</div>

</body>
</html>
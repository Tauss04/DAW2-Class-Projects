<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo"<link rel='icon' type='image/x-icon' href='".base_url()."imagenes/logo.png'>";?>
    <?php echo"<link rel='stylesheet' href='".base_url()."estilos/login.css'>";?>
    <title>Inicio</title>
</head>
<body>
<div class="form-container">
    <p class="title">Inicia Sesión</p>
    <form class="form" action="comprueba" method="post">
        <input type="email" name="correo" class="input" placeholder="Email">
        <input type="password" name="contrasena" class="input" placeholder="Contraseña">
        <p class="page-link">
            <span class="page-link-label">Has olvidado la contraseña?</span>
        </p>
        <input type="submit" class="form-btn" value="Inicio">
    </form>
<p class="sign-up-label">
    ¿No tienes cuenta? <a class="sign-up-link" href="<?php echo base_url('registro'); ?>">Registrarme</a>
</p>
    <?php
        if(isset($error)){
            echo"<p id='error'>Los datos introducidos son icorrectos</p>";
        }
    ?>
    
</div>
</body>
</html>






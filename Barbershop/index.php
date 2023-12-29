<?php
session_start();
//AGREGO SEGURIDAD PARA QUE NADIE PUEDA ENTRAR COMO ADMIN SI ESTE VUELVE A INDEX
if(isset($_SESSION['admin']) || isset($_SESSION['empleado'])){
  session_destroy();  
}


include "logica/funciones.php";

if(isset($_POST['signup'])){
    echo"ENTRA";
    setcookie('registro',"a",time()+120);
    header("Location:paginas/registro.php");
}else if(isset($_POST['login'])){
    $usuario=$_POST['usuario'];
    $passwd=$_POST['passwd'];
    if(todoOk($usuario,$passwd)=="cliente"){
        $_SESSION['tiempoinicio']=time();
        $_SESSION['cliente']=$usuario;
        echo"Si que esta todo Ok";
        header("Location:paginas/cliente.php");
    }else if(todoOk($usuario,$passwd)=="empleado"){
        $_SESSION['empleado']=$usuario;
        $codemp=dameCodEmp($usuario,$passwd);
        $_SESSION['codempleado']=$codemp['cod_empleado'];
        header("Location:paginas/empleado.php");
       
    }else if(soyAdmin($usuario,$passwd)){
        $_SESSION['admin']=$usuario;
        $_SESSION['empleado']=$usuario;
        header("Location:paginas/empleado.php");
    }else{
    ?>
        <script>alert("Datos Introducidos Incorrectos")</script>
    <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ivan Taus">
    <link rel="icon" type="image/x-icon" href="imagenes/icono.ico">
    <link rel="stylesheet" href="estilos/index.css">
    <title>TeCalva</title>
</head>
<body>
    <header>
        <img id="tijera" src="imagenes/tijera.png">
        <h1>Te Calva Barbershop<span>Pelados con estilo</span></h1>
        <img id="blade" src="imagenes/blade1.png">
    </header>
    
    <main>
        
        <form class="form_main" action="index.php" method="post">
            <h2 class="heading">Inicia Sesión</h2>
            <div class="inputContainer">
                <svg class="inputIcon"  width="16" height="16" fill="#2e2e2e" viewBox="0 0 16 16">
                <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                </svg>
                <input class="inputField" type="text" name="usuario" placeholder="Usuario">
            </div>

            <div class="inputContainer">
                <svg class="inputIcon"  width="16" height="16" fill="#2e2e2e" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                </svg>
                <input class="inputField" type="password" name="passwd" placeholder="Contraseña">
            </div>
            <input type="submit" class="button" name="login" value="Entrar">
            <input type="submit" class="button" name="signup" value="No tengo cuenta">
        </form>
        
    </main>
    <footer>

    </footer>
</body>
</html>
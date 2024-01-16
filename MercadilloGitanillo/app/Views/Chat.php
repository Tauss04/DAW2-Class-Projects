<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
    <header>
        <h1><?php echo $nombre_producto ?></h1>
    </header>
    <main>
        <?php 
        $cod_chat=0;
        foreach($chat as $mensaje){
            $cod_chat=$mensaje['cod_chat'];
            if($mensaje['cod_usuario']== session()->get("cod_usuario")){
                echo"<div class='msj-propio'><p>".$mensaje['contenido']."</p><p>".$mensaje['hora']."</p>";
            }else{
                echo"<div class='msj-ajeno'><p>".$mensaje['contenido']."</p><p>".$mensaje['hora']."</p>";
            }
        }
        ?>
        <form action="enviarMensaje" method="post">
            <input id="mensaje" type="text" name="contenido" maxlength='100' minlength='1'>
            <input type="hidden" name="cod_chat" value="<?php echo $cod_chat; ?>">
            <input type="hidden" name="cod_usuario" value="<?php echo session()->get("cod_usuario"); ?>">
            <input type="hidden" name="cod_articulo" value="<?php echo $cod_producto;?>">
            <input type="hidden" name="nombre_articulo" value="<?php echo $nombre_producto;?>">
            <input type="image" src="<?php echo base_url()."imagenes/enviar.png";?>">
        </form>
    </main>
</body>
</html>
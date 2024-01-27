<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo"<link rel='stylesheet' href='".base_url()."estilos/chat.css'>";?>
    <?php echo"<link rel='stylesheet' href='".base_url()."estilos/fuente.css'>";?>
    
    <title>Chat</title>
</head>
<body>
    <header>
        <button onclick="window.close()" id="btnSalir">Salir</button>
        <h1><?php echo $nombre_producto ?></h1>
    </header>
    <main>
        <?php
        if(isset($misChats)){
            echo"<h1>Mis chats</h1>";
            echo"<div class='contenedor'>";
            echo "<ul>";
            foreach($misChats as $chat){
                
                echo"<li>";
                    echo"<form action='verChat' method='post' class='formVerChat'>";
                        echo"<h4>".$chat['cod_comprador']." ".ucfirst($chat['nombre_comprador'])."</h4>";
                        echo"<input type='hidden' name='cod_articulo' value='".$chat['cod_articulo']."'>";
                        echo"<input type='hidden' name='nombre_articulo' value='".$nombre_producto."'>";
                        echo"<input type='hidden' name='interesado' value='".$chat['cod_comprador']."'>";
                        echo"<input type='hidden' name='nombreComprador' value='".$chat['nombre_comprador']."'>";
                        echo"<input type='hidden' name='vengoVendedor' value='a'>";
                        echo"<input type='submit' class='btnVerChat' value=''>";
                    echo"</form>";
                echo"</li>";
            }
            echo"</ul>";
            echo"</div>";
        }else{
            if(isset($nombreComprador)){
               echo"<h1>".ucfirst($nombreComprador)."</h1>"; 
            }
            
            echo"<div id='contenedor2'>";
            echo"<div id='cajaMensajes'>";
            $cod_chat=0;
            foreach($chat as $mensaje){
                $cod_chat=$mensaje['cod_chat'];
                if($mensaje['cod_usuario']== session()->get("cod_usuario")){
                    echo"<div class='msj-propio'><p>".$mensaje['contenido']."</p><p>".$mensaje['hora']."</p></div>";
                }else{
                    echo"<div class='msj-ajeno'><p>".$mensaje['contenido']."</p><p>".$mensaje['hora']."</p></div>";
                }
            }
            ?>
                </div>
                <form action="enviarMensaje" method="post" id="formEnviarMensaje">
                    <input id="mensaje" type="text" name="contenido" maxlength='100' minlength='1'>
                    <input type="hidden" name="cod_chat" value="<?php echo $cod_chat; ?>">
                    <input type="hidden" name="cod_vendedor" value="<?php echo session()->get("cod_usuario"); ?>">
                    <input type="hidden" name="cod_articulo" value="<?php echo $cod_producto;?>">
                    <?php
                    if(isset($nombreComprador)){
                        echo"<input type='hidden' name='nombreComprador' value='".$nombreComprador."'>";
                    }
                    ?>
                    <input type="hidden" name="nombre_articulo" value="<?php echo $nombre_producto;?>">
                    <input type="image" id="btnEnviar" src="<?php echo base_url()."imagenes/enviar.png";?>">
                </form>
            </div>
    <?php } ?>
    </main>
    <script src="<?php echo base_url()."logica/chat.js"?>"></script>
</body>
</html>
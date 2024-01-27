
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo"<link rel='icon' type='image/x-icon' href='".base_url()."imagenes/logo.png'>";?>
    <?php echo"<link rel='stylesheet' href='".base_url()."estilos/Perfil.css'>";?>
    <?php echo"<link rel='stylesheet' href='".base_url()."estilos/fuente.css'>";?>
    <title>Perfil</title>
</head>
<body>
    <header>   
        <h2 id="cabecera1"><?php echo "Hola ".ucfirst(session()->get("inicio")) ?></h2>
        <div id="cabecera2">
            <a href="subirArticulo" id="btn-anadir">
                <img src="<?php echo base_url()."imagenes/subirProducto.svg";?>" >
                Subir producto
            </a>
            <?php if(isset($formulario)) { ?>
                <form action="perfil" method="post" id="btn_perfil">
                    <input type="image" src="<?php echo base_url()."imagenes/usuario.png";?>">
                </form>
            <?php } ?>
            
            <form action="inicio" method="post" id="btn_inicio">
                <input type="image" src="<?php echo base_url()."imagenes/hogar.png";?>">
            </form>
        </div>
    </header>
    <main>
    <div id="cajaProductos">

    
    <?php if(isset($articulos)){ ?>
        <div id="filtros">
        <form action="perfil" method="post" >
            <?php if($filtro==1){ ?>
                <input type="button" onclick="this.form.submit()" id="marcado" class="btn-activo"  value="En venta">
            <?php }else{ ?>
                <input type="button" onclick="this.form.submit()" class="btn-activo"  value="En venta">
            <?php } ?>
            <input type="hidden" name="filtro" value="1">
        </form>
        <form action="perfil" method="post" >
            <?php if($filtro==1){ ?>
                <input type="button" onclick="this.form.submit()" class="btn-activo" value="Oculto">
            <?php }else{ ?>
                <input type="button" onclick="this.form.submit()" id="marcado" class="btn-activo" value="Oculto">
            <?php } ?>
                <input type="hidden" name="filtro" value="0">
        </form>
        
        </div>
        
        <section>
        <?php
            foreach($articulos as $articulo){
                // SI SE EL ESTADO DEL PRODUCTO COINCIDE CON LO QUE QUIERE VER EL USUARIO SE MUESTRA
                if($articulo['activo']==$filtro){
                    echo"<article class='articulos'>";
                        echo"<img src='".base_url()."fotoProducto/".$articulo['foto']."' alt='No foto'></img>";
                        echo"<h4>".ucfirst($articulo['nombre'])."</h4>";
                        echo"<div class='descripcion'>";
                            echo"<p>".$articulo['descripcion']."</p>";
                        echo"</div>";
                        echo"<div class='caracteristicas'>";
                            echo"<div class='linea'><p class='enunciado'>-Categoria: </p>";
                            echo"<p>".$articulo['categoria']."</p></div>";
                            echo"<div class='linea'><p class='enunciado'>-Estado: </p>";
                            echo"<p>".$articulo['estado']."</p></div>";
                            echo"<div class='linea'><p class='enunciado'>-Precio: </p>";
                            echo"<p>".$articulo['precio']."€</p></div>";
                        echo"</div>";
                        echo"<div class='botonera'>";

                            // BTN VER CHATS
                            echo"<div class='div-chat'>";
                                echo"<form action='verMisChats' target='_blank' method='post' class='form-chat'>";
                                    echo"<input class='btn-chat' type='image' src='".base_url()."imagenes/mensajes.png'>";
                                    echo"<input type='hidden' name='cod_articulo' value='".$articulo['cod_articulo']."'>";
                                    echo"<input type='hidden' name='nombre_articulo' value='".$articulo['nombre']."'>";
                                echo"</form>";
                            echo"</div>";
                            
                            // BTN PARA EDITAR PRODUCTO
                            echo"<div class='div-lapiz'>";
                                echo"<form action='editar' method='post' class='form-lapiz'>";
                                    echo"<input class='btn-lapiz' type='image' src='".base_url()."imagenes/lapiz.png'>";
                                    echo"<input type='hidden' name='cod_articulo' value='".$articulo['cod_articulo']."'>";
                                    echo"<input type='hidden' name='nombre_articulo' value='".$articulo['nombre']."'>";
                                echo"</form>";
                            echo"</div>";

                            // BTN CAMBIAR ESTADO
                            echo"<div class='div-vendido'>";
                                echo"<form action='vendido' method='post' class='form-vendido'>";
                                if($filtro==0){
                                    echo"<input class='btn-vendido' type='submit' value='Vender'>";
                                }else{
                                    echo"<input class='btn-vendido' type='submit' value='Vendido'>";
                                }
                                    echo"<input type='hidden' name='cod_articulo' value='".$articulo['cod_articulo']."'>";
                                echo"</form>";
                            echo"</div>";
                            echo"</div>";
                    echo"</article>";
                }
            }
        ?>
            </section> 
        </div>
    <!-- SI PULSA SUBIR PRODUCTO SE MUESTRA LA VISTA SUBIR PRODUCTO DENTRO DE PERFIL.PHP  -->
    <?php }else if(isset($formulario)) {
        echo $formulario;
    }else if(isset($editor)){
        echo"<h1>".$nombre."</h1>";
        echo $formulario;
    }
    ?>
    </main>
    
</body>

</html>
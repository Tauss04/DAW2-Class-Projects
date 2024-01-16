<?php
/*
if(!isset($_SESSION)){
   session_start(); 
}
*/
if(isset($_COOKIE['RESTART'])){
    echo"<form action='perfil' method='post' id='restart'></form><script>document.getElementById('restart').submit()</script>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ivan Taus Ruiz">
    <meta name="description" content="Página de compra venta de artículos de segunda mano">
    <meta name="keywords" content="mercadillo, compra, venta, segunda mano, mercado">
    
    <?php echo"<link rel='icon' type='image/x-icon' href='".base_url()."imagenes/logo.png'>";?>
    <?php echo"<link rel='stylesheet' href='".base_url()."estilos/Index.css'>";?>
    <title>Mercadillo Gitanillo</title>
    
</head>
<body>
    <header>
        <div id="cabecera">
            <!-- SALUDO AL USUARIO Y CREO SESIÓN CON SU NOMBRE -->
            <h2>
                <?php 
                // Zona horaria de Madrid
                date_default_timezone_set('Europe/Madrid');
                    if(isset($nombre)){
                        //$_SESSION['inicio']=$nombre;
                        //$_SESSION['cod_usuario']=$cod_usuario;
                        session()->set("inicio",$nombre);
                        session()->set("cod_usuario",$cod_usuario);
                    }    
                        
                    if(null !==(session()->get("inicio"))){

                        if(date("H")<13 && date("H")>5){
                            echo"Buenos días ";
                        }else if(date("H")>=13 && date("H")<21){
                        echo"Buenas tardes ";
                        }else{
                            echo"Buenas noches ";
                        }
                    
                        echo ucfirst(session()->get("inicio"));
                    }else{
                        echo"MercadilloGitanillo";
                    } 
                ?>
            </h2>
            <!-- SI EXISTE LA SESION, EL BOTON CAMBIA A CERRAR SESION Y ELIMINA LA SESION -->
            <?php if(null !==(session()->get("inicio"))){?>
                    <form action="cerrarSesion" method="post" >
                        <input type="submit" value="Cerrar Sesión" class="btn-sesion">
                    </form>
                    <form action="perfil" method="post" id="btn_perfil">
                        <input type="image" src="<?php echo base_url()."imagenes/usuario.png";?>">
                    </form>
            <?php }else{?>
                    <form action="entrar" method="post" >
                        <input type="submit" value="Iniciar Sesión" class="btn-sesion">
                    </form>

            <?php }?>
        </div>

        <div id="busqueda">
            <form action="buscar" method="post">
                <svg class="svg-icon" viewBox="0 0 20 20">
                    <path fill="none" d="M12.323,2.398c-0.741-0.312-1.523-0.472-2.319-0.472c-2.394,0-4.544,1.423-5.476,3.625C3.907,7.013,3.896,8.629,4.49,10.102c0.528,1.304,1.494,2.333,2.72,2.99L5.467,17.33c-0.113,0.273,0.018,0.59,0.292,0.703c0.068,0.027,0.137,0.041,0.206,0.041c0.211,0,0.412-0.127,0.498-0.334l1.74-4.23c0.583,0.186,1.18,0.309,1.795,0.309c2.394,0,4.544-1.424,5.478-3.629C16.755,7.173,15.342,3.68,12.323,2.398z M14.488,9.77c-0.769,1.807-2.529,2.975-4.49,2.975c-0.651,0-1.291-0.131-1.897-0.387c-0.002-0.004-0.002-0.004-0.002-0.004c-0.003,0-0.003,0-0.003,0s0,0,0,0c-1.195-0.508-2.121-1.452-2.607-2.656c-0.489-1.205-0.477-2.53,0.03-3.727c0.764-1.805,2.525-2.969,4.487-2.969c0.651,0,1.292,0.129,1.898,0.386C14.374,4.438,15.533,7.3,14.488,9.77z"></path>
                </svg>   
                <input id="cuadroBusqueda" name="busqueda" type="text" placeholder="Busca tu producto" maxlength="45">
            </form>
        </div>
        <div id="filtrar">
            <form action="filtrar" method="post">
                <?php
                // SI NO SE RECIBE NINGUN FILTRO SELECCIONO POR DEFECTO LA PRIMERA OPCIÓN
                    if(!isset($filtroPrecio)){
                      $filtroPrecio=0;
                        $filtroCat=0;
                        $filtroEst=0;  
                    }
                ?>
                <select id="precio" name="filtroPrec" class="filtros" onchange="this.form.submit()">
                    <option value="0" <?= ($filtroPrecio == 0) ? 'selected' : '' ?> >Precio</option>
                    <option value="2" <?= ($filtroPrecio == 2) ? 'selected' : '' ?>>-100</option>
                    <option value="3" <?= ($filtroPrecio == 3) ? 'selected' : '' ?>>-500</option>
                    <option value="4" <?= ($filtroPrecio == 4) ? 'selected' : '' ?>>+500</option>
                </select>
                <select id="categoria" name="filtroCat" class="filtros" onchange="this.form.submit()">
                    <option value="0" <?= ($filtroCat == 0) ? 'selected' : '' ?> >Categoria</option>
                    <option value="Chatarra" <?= ($filtroCat == 'Chatarra') ? 'selected' : '' ?>>Chatarra</option>
                    <option value="Muebles" <?= ($filtroCat == 'Muebles') ? 'selected' : '' ?>>Muebles</option>
                    <option value="Vehículos" <?= ($filtroCat == 'Vehículos') ? 'selected' : '' ?>>Vehículos</option>
                    <option value="Deportes" <?= ($filtroCat == 'Deportes') ? 'selected' : '' ?>>Deportes</option>
                    <option value="Ropa" <?= ($filtroCat == 'Ropa') ? 'selected' : '' ?>>Ropa</option>
                    <option value="Otra" <?= ($filtroCat == 'Otra') ? 'selected' : '' ?>>Otra</option>
                </select>
                <select id="estado" class="filtros" name="filtroEst" onchange="this.form.submit()">
                    <option value="0" <?= ($filtroEst == 0) ? 'selected' : '' ?> >Estado</option>
                    <option value="Nuevo" <?= ($filtroEst == 'Nuevo') ? 'selected' : '' ?>>Nuevo</option>
                    <option value="Como Nuevo" <?= ($filtroEst == 'Como Nuevo') ? 'selected' : '' ?>>Como Nuevo</option>
                    <option value="En buen estado" <?= ($filtroEst == 'En buen estado') ? 'selected' : '' ?>>En buen estado</option>
                    <option value="En condiciones aceptables" <?= ($filtroEst == 'En condiciones aceptables') ? 'selected' : '' ?>>En condiciones aceptables</option>
                    <option value="Toca repararlo" <?= ($filtroEst == 'Toca repararlo') ? 'selected' : '' ?>>Toca repararlo</option>
                </select>
            </form>
        </div>
    </header>
    <main>
       
    <section>
        <?php
            foreach($articulos as $articulo){
                $mostrarArticulo = true;
                //Verifico la busqueda del usuario
                if(isset($busqueda)){
                    if(similar_text($articulo['nombre'],$busqueda)>3){
                        $mostrarArticulo= true;
                    }else{
                        $mostrarArticulo= false;
                    }
                }

                 // Verificar filtro de precio
                if (isset($filtroPrecio) && $filtroPrecio != 0) {
                    if ($articulo['precio'] > 0 && $articulo['precio'] <= 100 && $filtroPrecio != 2) {
                        $mostrarArticulo = false;
                    } elseif ($articulo['precio'] > 100 && $articulo['precio'] <= 500 && $filtroPrecio != 3) {
                        $mostrarArticulo = false;
                    } elseif ($articulo['precio'] > 500 && $filtroPrecio != 4) {
                        $mostrarArticulo = false;
                    }
                }

                // Verificar filtro de categoría
                if (isset($filtroCat) && $filtroCat != 0 && $articulo['categoria'] != $filtroCat) {
                    $mostrarArticulo = false;
                }

                // Verificar filtro de estado
                if (isset($filtroEst) && $filtroEst != 0 && $articulo['estado'] != $filtroEst) {
                    $mostrarArticulo = false;
                }
                
                // Mostrar el artículo si cumple con todos los filtros
                if ($mostrarArticulo) {
                        
                    
                
                // SI SE EL ESTADO DEL PRODUCTO COINCIDE CON LO QUE QUIERE VER EL USUARIO SE MUESTRA
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
                            echo"<div class='div-chat'>";
                            // SI NO HA INICIADO SESION AL DARLE AL CHAT LE OBLIGA A INICIAR
                            if(null ==(session()->get("inicio"))){
                                echo"<form action='entrar' method='post' class='form-chat'>";
                                    echo"<input class='btn-chat' type='image' src='".base_url()."imagenes/mensajes.png'>";
                                    echo"<input type='hidden' name='cod_articulo' value='".$articulo['cod_articulo']."'>";
                                    
                                echo"</form>";
                            }else{
                                echo"<form action='verChat' target='_blank' method='post' class='form-chat'>";
                                    echo"<input class='btn-chat' type='image' src='".base_url()."imagenes/mensajes.png'>";
                                    echo"<input type='hidden' name='nombre_articulo' value='".$articulo['nombre']."'>";
                                    echo"<input type='hidden' name='cod_articulo' value='".$articulo['cod_articulo']."'>";
                                echo"</form>";
                            }
                            echo"</div>";
                            echo"</div>";

                    echo"</article>";

                }
            }
        ?>
    </section>
    </main>
    <script>

    </script>
</body>
</html>
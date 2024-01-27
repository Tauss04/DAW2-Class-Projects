<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="<?= base_url('css/estilo1.css') ?>">
</head>

<body>
    <header>
        <h1>Chatarras Taus</h1>
        <div>
            <form action="filtrar" method="post">
                <select name="tipo" onchange="this.form.submit()">
                    <option value="0" <?php if($tipo==0){echo "selected";}?> >Tipo</option>
                    <option value="1" <?php if($tipo==1){echo "selected";}?> >Como nuevo</option>
                    <option value="2" <?php if($tipo==2){echo "selected";}?>>Buen estado</option>
                    <option value="3" <?php if($tipo==3){echo "selected";}?>>Reparable</option>
                    <option value="4" <?php if($tipo==4){echo "selected";}?>>Mal estado</option>
                    <option value="5" <?php if($tipo==5){echo "selected";}?>>Siniestro Total</option>
                </select>

                <select name="ubicacion" onchange="this.form.submit()">
                    <option value="0" <?php if($ubicacion==0){echo "selected";}?>>Ubicacion</option>
                    <option value="1" <?php if($ubicacion==1){echo "selected";}?>>Vehículos</option>
                    <option value="2" <?php if($ubicacion==2){echo "selected";}?>>Electrodomesticos</option>
                    <option value="3" <?php if($ubicacion==3){echo "selected";}?>>Chapa</option>
                    <option value="4" <?php if($ubicacion==4){echo "selected";}?>>Industrial</option>
                </select>
            </form>
            <form action="agregar" method="post">
                <input type="submit" value="Añadir" class="añadir">
            </form>
        </div>
    </header>
    <main>
        <table>
            <tr>
                <th>Código</th>
                <th>Tipo</th>
                <th>Ubicación</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
            <?php 
            foreach ($productos as $producto){ 
                if($tipo==0 || $tipo==$producto['cod_tipo']){
                    if($ubicacion==0 || $ubicacion==$produco['cod_ubicacion']){
            ?>      
                <tr>
                    <td><?= $producto['cod_articulo'] ?></td>
                    <td><?= $producto['nombre_tipo'] ?></td>
                    <td><?= $producto['nombre_ubicacion'] ?></td>
                    <td><?= $producto['nombre_articulo'] ?></td>
                    <td>
                        <form action="eliminar" method="post">
                            <input type="submit" value="Eliminar" class="eliminar">
                            <input type="hidden" name="cod_articulo" value="<?php echo $producto['cod_articulo']; ?>">
                        </form>
                        <form action="actualizar" method="post">
                            <input type="submit" value="Actualizar" class="actualizar">
                            <input type="hidden" name="vengoPrincipal" value="a">
                            <input type="hidden" name="cod_articulo" value="<?php echo $producto['cod_articulo']; ?>">
                            <input type="hidden" name="nombre" value="<?php echo $producto['nombre_articulo']; ?>">
                            <input type="hidden" name="cod_tipo" value="<?php echo $producto['cod_tipo']; ?>">
                            <input type="hidden" name="cod_ubicacion" value="<?php echo $producto['cod_ubicacion']; ?>">
                        </form>
                        
                    </td>
                </tr>
            <?php 
                    }
                }
            }
            ?>
        </table>
    </main>
    <footer>
        © 2024 Chatarras Taus
    </footer>
</body>

</html>

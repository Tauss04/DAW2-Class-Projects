<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Artículo</title>
    <link rel="stylesheet" href="<?= base_url('css/actualizar.css') ?>">
</head>

<body>
    <div class="container">
        <h1>Actualizar Artículo</h1>
        <form action="actualizar" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre ; ?>" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select name="tipo">
                    <option value="1" <?php if($tipo==1){echo "selected";}?>>Como nuevo</option>
                    <option value="2" <?php if($tipo==2){echo "selected";}?> >Buen estado</option>
                    <option value="3" <?php if($tipo==3){echo "selected";}?>>Reparable</option>
                    <option value="4" <?php if($tipo==4){echo "selected";}?>>Mal estado</option>
                    <option value="4" <?php if($tipo==5){echo "selected";}?>>Siniestro Total</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación:</label>
                <select name="ubicacion" >
                    <option value="1" <?php if($ubicacion==1){echo "selected";}?>>Vehículos</option>
                    <option value="2" <?php if($ubicacion==2){echo "selected";}?> >Electrodomesticos</option>
                    <option value="3" <?php if($ubicacion==3){echo "selected";}?> >Chapa</option>
                    <option value="4" <?php if($ubicacion==4){echo "selected";}?> >Industrial</option>
                </select>
            </div>
            <input type="hidden" name="codigo_articulo" value="<?php echo $codigo_articulo ; ?>">
            <button type="submit">Actualizar</button>
        </form>
    </div>
</body>

</html>

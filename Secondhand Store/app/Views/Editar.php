<!DOCTYPE html>
<html lang="en">
<body>
    <h1 id="titulo">Actualizar Artículo</h1>
    <div id="cajaForm">
        <form method="post" id="formularioSubir" action="actualizarProducto">
            <div class='lineaForm'>
                <label for="nombre">Nombre: </label>
                <input type="text" <?php echo"value='".$nombre."'";?> placeholder="Nombre artículo" id="nombre" name="nombre">   
            </div>
            <div class="lineaForm">
                <label for="precio">Precio: </label>
                <input type="number" <?php echo"value='".$precio."'";?> placeholder="Precio" id="precio" name="precio" >
            </div>
            <div class="lineaForm">
                <label for="descripcion">Descripcion</label>
                <input type="text" <?php echo"value='".$descripcion."'";?> name="descripcion" id="descripcion">
            </div>
            <div class="lineaForm">
                <select name="categoria" id="categoria" required="required">
                    <option value="Chatarra" <?php if($categoria=="Chatarra"){echo"selected";}?>>Chatarra</option>
                    <option value="Muebles" <?php if($categoria=="Muebles"){echo"selected";}?>>Muebles</option>
                    <option value="Vehículos" <?php if($categoria=="Vehículos"){echo"selected";}?>>Vehículos</option>
                    <option value="Deportes" <?php if($categoria=="Deportes"){echo"selected";}?>>Deportes</option>
                    <option value="Ropa" <?php if($categoria=="Ropa"){echo"selected";}?>>Ropa</option>
                    <option value="Otra" <?php if($categoria=="Otra"){echo"selected";}?>>Otra</option>
                </select>
            </div>
            <div class="lineaForm">
                <select name="estado" id="estado" required="required">
                        <option value="Nuevo" <?php if($estado=="Nuevo"){echo"selected";}?>>Nuevo</option>
                        <option value="Como Nuevo" <?php if($estado=="Como Nuevo"){echo"selected";}?>>Como Nuevo</option>
                        <option value="En buen estado" <?php if($estado=="En buen estado"){echo"selected";}?>>En buen estado</option>
                        <option value="En condiciones aceptables" <?php if($estado=="En condiciones aceptables"){echo"selected";}?>>En condiciones aceptables</option>
                        <option value="Toca repararlo" <?php if($estado=="Toca repararlo"){echo"selected";}?>>Toca repararlo</option>
                </select>
            </div>
            <input type="hidden" name="cod_producto" value="<?php echo $codigoProducto; ?>">
            <input type="submit" value="Actualizar Producto">
            <input type="reset" value="Borrar Todo">
        </form>
    </div>
</body>
</html>
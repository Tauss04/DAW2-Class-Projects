
<!DOCTYPE html>
<html lang="en">
    <h2 id="titulo">Sube tu producto</h2>
    <?php
        if(isset($error)){
            echo"<p>".$error."</p>";
        }
    ?>
    <div id="cajaForm">
        <form id="formularioSubir" ENCTYPE="multipart/form-data" action="subirChimba"  method="post" id="formularioSubir">
            <fieldset>
                <legend>Informacion del Producto</legend>
                <label for="nombre">Nombre del producto</label>
                <input type="text" id="nombre" name="nombre" maxlength="25" minlenght="4" required="required">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" minlength="0" maxlength="100" value="">
                <label for="categoria">Categoría</label>
                <select name="categoria" id="categoria" required="required">
                        <option value="0" selected disabled>Categoria</option>
                        <option value="Chatarra">Chatarra</option>
                        <option value="Muebles">Muebles</option>
                        <option value="Vehículos">Vehículos</option>
                        <option value="Deportes">Deportes</option>
                        <option value="Ropa">Ropa</option>
                        <option value="Otra">Otra</option>
                </select>
                <label for="estado">Estado del producto</label>
                <select name="estado" id="estado" required="required">
                        <option value="0" selected disabled>Estado</option>
                        <option value="Nuevo">Nuevo</option>
                        <option value="Como Nuevo">Como Nuevo</option>
                        <option value="En buen estado">En buen estado</option>
                        <option value="En condiciones aceptables">En condiciones aceptables</option>
                        <option value="Toca repararlo">Toca repararlo</option>
                </select>
                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" max="99000" min="1" required="required">
            </fieldset>
            <fieldset>
                <legend>Foto del producto</legend>
                <input type="file" required="required" name="archivo" accept=".jpg, .jpeg, .png">
            </fieldset>
            <input type="submit" class="btn-subirProd" value="Subir Producto">
        </form>
    </div>
</html>
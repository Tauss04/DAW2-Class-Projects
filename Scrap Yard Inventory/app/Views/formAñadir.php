<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Artículo</title>
    <link rel="stylesheet" href="<?= base_url('css/formulario.css') ?>">
</head>

<body>
    <div class="container">
        <h1>Añadir Nuevo Artículo</h1>
        <form action="agregar" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select id="tipo" name="tipo" required>
                    <option value="">Selecciona un tipo</option>
                    <option value="1">Como nuevo</option>
                    <option value="2">Buen estado</option>
                    <option value="3">Reparable</option>
                    <option value="4">Mal estado</option>
                    <option value="5">Siniestro total</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación:</label>
                <select id="ubicacion" name="ubicacion" required>
                    <option value="">Selecciona una ubicación</option>
                    <option value="1">Vehículos</option>
                    <option value="2">Electrodomésticos</option>
                    <option value="3">Chapa</option>
                    <option value="4">Industrial</option>
                </select>
            </div>
            <button type="submit">Agregar Artículo</button>
        </form>
    </div>
</body>

</html>


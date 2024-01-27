<?php
namespace App\models;

use CodeIgniter\Model;

class Modelo extends Model
{
    // Función para obtener todos los productos
    function dameProductos(){
    $orden = "SELECT a.cod_articulo, a.nombre as nombre_articulo, 
                     a.cod_tipo, t.nombre as nombre_tipo, 
                     a.cod_ubicacion, u.nombre as nombre_ubicacion 
              FROM articulos a 
              JOIN tipo t ON a.cod_tipo = t.cod_tipo 
              JOIN ubicaciones u ON a.cod_ubicacion = u.cod_ubicacion WHERE a.activo=1";
    
    $respuesta = $this->db->query($orden);
    $articulos = array();

    foreach ($respuesta->getResult() as $fila) {
        $chorizo['cod_articulo'] = $fila->cod_articulo;
        $chorizo['nombre_articulo'] = $fila->nombre_articulo;
        $chorizo['cod_tipo'] = $fila->cod_tipo;
        $chorizo['nombre_tipo'] = $fila->nombre_tipo;
        $chorizo['cod_ubicacion'] = $fila->cod_ubicacion;
        $chorizo['nombre_ubicacion'] = $fila->nombre_ubicacion;

        $articulos[] = $chorizo;
    }

    return $articulos;
}


    // Función para agregar un nuevo artículo
    function agregarArticulo($nombre,$tipo,$ubicacion)
    {
        
        $orden="INSERT INTO articulos (cod_tipo,cod_ubicacion,nombre,activo) VALUES ('".$tipo."','".$ubicacion."','".$nombre."',1)";
        $this->db->query($orden);   
    }

    // Función para actualizar un artículo existente
    function actualizarArticulo($codigo,$nombre,$tipo,$ubicacion)
    {
        $orden="UPDATE articulos SET nombre='".$nombre."', cod_tipo='".$tipo."', cod_ubicacion='".$ubicacion."' WHERE cod_articulo='".$codigo."'";
        $this->db->query($orden); 
        // Lógica para actualizar un artículo en la base de datos
    }

    // Función para eliminar un artículo
    function eliminarArticulo($codigo)
    {
        $orden="UPDATE articulos SET activo=0 WHERE cod_articulo='".$codigo."'";
        $this->db->query($orden); 
        // Lógica para eliminar un artículo de la base de datos
    }
}
?>
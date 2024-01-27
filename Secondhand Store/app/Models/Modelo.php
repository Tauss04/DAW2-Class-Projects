<?php
namespace App\models;
use CodeIgniter\Model;

class Modelo extends Model{

    function dameArticulos(){
        $orden="SELECT * FROM articulos WHERE activo=1";
        $resultado = $this->db->query($orden);
        $articulos = array(); 
    
        foreach ($resultado->getResult() as $fila) {
            $chorizo['cod_articulo'] = $fila->cod_articulo;
            $chorizo['nombre'] = $fila->nombre;
            $chorizo['descripcion'] = $fila->descripcion;
            $chorizo['foto'] = $fila->foto;
            $chorizo['precio'] = $fila->precio;
            $chorizo['categoria'] = $fila->categoria;
            $chorizo['estado'] = $fila->estado;
            $chorizo['activo'] = $fila->activo;
            $articulos[] = $chorizo; 
        }
        return $articulos;
    }

    function existe($correo,$contrasena){
        $orden = "SELECT cod_usuario,nombre FROM usuarios WHERE correo = ? and contrasena= ?";
        $resultado = $this->db->query($orden, [$correo, $contrasena]);
        $fila = $resultado->getRow();
        if(isset($fila)){
            $chorizo['cod_usuario']=$fila->cod_usuario;
            $chorizo['nombre']=$fila->nombre;
            return $chorizo;
        }else{
            return 0;
        }
    }
    function registro($correo, $nombre, $contrasena) {
        // Consulta para verificar si el correo ya existe
        $orden = "SELECT cod_usuario FROM usuarios WHERE correo = ?";
        $resultado = $this->db->query($orden, [$correo]);
        $fila = $resultado->getRow();
    
        if ($fila) {
            return 0; // El correo ya existe
        } else {
            // insertar un nuevo usuario
            $orden = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)";
            $this->db->query($orden, [$nombre, $correo, $contrasena]);
            return 1; // Usuario registrado con éxito
        }
    }
    function insertaProducto($cod_usuario,$nombre,$descripcion,$categoria,$estado,$precio,$foto) {
        //throw new \CodeIgniter\Database\Exceptions\DatabaseException();
        $orden ="INSERT INTO articulos (cod_usuario,nombre,descripcion,foto,precio,categoria,estado,activo)
                VALUES(?,?,?,?,?,?,?,?)";
        
        $comprueba="SELECT cod_articulo FROM articulos WHERE nombre='".$nombre."' AND descripcion='".$descripcion."' AND foto='".$foto."'";
        $r=$this->db->query($comprueba);
        $fila=$r->getRow();
        if(isset($fila)){

        }else{
            $this->db->query($orden,[$cod_usuario,$nombre,$descripcion,$foto,$precio,$categoria,$estado,1]);
        }
    }

    function cambiaEstadoVenta($cod_producto){
        $consulta="SELECT activo FROM articulos WHERE cod_articulo='".$cod_producto."'";
        $result=$this->db->query($consulta);
        $fila = $result->getRow(); 
        $valorActivo = $fila->activo;
        $activo="";
        if($valorActivo=="1"){
            $activo=0;    
            
        }else{
            $activo=1;
            
        }
       
        $ordenActualizar ="UPDATE articulos SET activo='".$activo."' WHERE cod_articulo='".$cod_producto."'";
        $this->db->query($ordenActualizar);
    }


    function dameMisProductos($cod_usuario) {
        $orden = "SELECT * FROM articulos WHERE cod_usuario=?";
        $resultado = $this->db->query($orden, [$cod_usuario]);
    
        $articulos = array(); 
    
        foreach ($resultado->getResult() as $fila) {
            $chorizo['cod_articulo'] = $fila->cod_articulo;
            $chorizo['nombre'] = $fila->nombre;
            $chorizo['descripcion'] = $fila->descripcion;
            $chorizo['foto'] = $fila->foto;
            $chorizo['precio'] = $fila->precio;
            $chorizo['categoria'] = $fila->categoria;
            $chorizo['estado'] = $fila->estado;
            $chorizo['activo'] = $fila->activo;
            $articulos[] = $chorizo; 
        }
        return $articulos;
    }

    function dameMisChats($cod_producto,$cod_vendedor){
        $orden="SELECT * FROM chats WHERE cod_articulo='".$cod_producto."' AND cod_vendedor='".$cod_vendedor."'";
        $resultado=$this->db->query($orden);
        $misChats=array();
        foreach ($resultado->getResult() as $fila){
            $chorizo['cod_articulo']= $fila->cod_articulo;
            $chorizo['cod_chat']= $fila->cod_chat;
            $chorizo['cod_comprador']= $fila->cod_comprador;
            
            // POR CADA CHAT QUE ENCUENTRE GUARDO EL NOMBRE DEL COMPRADOR DE ESE CHAT 
            $orden="SELECT nombre FROM usuarios WHERE cod_usuario='".$fila->cod_comprador."'";
            $resultado=$this->db->query($orden);
            $fila = $resultado->getRow();
            $chorizo['nombre_comprador']= $fila->nombre;
            //--------------------------------------------

            $misChats[] = $chorizo;
        }
        return $misChats;
    }

    function dameMisMensajes($cod_producto,$cod_interesado,$vengoVendedor,$comprador){
        $orden="";
        if($vengoVendedor==true){
            $orden="SELECT * FROM mensajes m JOIN chats c ON m.cod_chat=c.cod_chat WHERE c.cod_articulo='".$cod_producto."' AND cod_vendedor='".$cod_interesado."' AND cod_comprador='".$comprador."' ORDER BY cod_mensaje";
        }else{
            $orden="SELECT * FROM mensajes m JOIN chats c ON m.cod_chat=c.cod_chat WHERE c.cod_articulo='".$cod_producto."' AND cod_comprador='".$cod_interesado."' ORDER BY cod_mensaje";
        }
        
        $resultado = $this->db->query($orden);
        $mensajes= array();
        
        foreach ($resultado->getResult() as $fila){
            $chorizo['cod_mensaje']= $fila->cod_mensaje;
            $chorizo['cod_usuario']= $fila->cod_usuario;
            $chorizo['cod_chat']= $fila->cod_chat;
            $chorizo['contenido']= $fila->contenido;
            $chorizo['hora']=$fila->hora;

            $mensajes[] = $chorizo;
        }
        return $mensajes;
    }

    function insertaMensaje($contenido, $cod_chat, $cod_vendedor, $cod_interesado, $cod_producto) {
        $orden = "";
    
        if ($cod_chat == 0) {
            $cod_chat = $cod_vendedor . "" . $cod_producto . "" . $cod_interesado;
    
            // Insertar chat si no existe
            $orden = "INSERT INTO chats (cod_chat, cod_comprador, cod_vendedor, cod_articulo) 
                      VALUES ('$cod_chat', '$cod_interesado', '$cod_vendedor', '$cod_producto')";
            $this->db->query($orden);
    
            // Insertar mensaje
            $orden = "INSERT INTO mensajes (cod_chat, contenido, cod_usuario) 
                      VALUES ('$cod_chat', '$contenido', '$cod_interesado')";
        } else {
            // Insertar mensaje en chat existente
            $orden = "INSERT INTO mensajes (contenido, cod_chat, cod_usuario) 
                      VALUES ('$contenido', '$cod_chat', '$cod_interesado')";
        }
    
        $this->db->query($orden);
    }

    function dameCodVendedor($cod_producto){
        $orden="SELECT cod_usuario FROM articulos WHERE cod_articulo='".$cod_producto."'";
        $resultado=$this->db->query($orden);
        $fila = $resultado->getRow();
        return $fila->cod_usuario;
    }

    function dameProducto($cod_producto){
        $orden="SELECT * FROM articulos WHERE cod_articulo='".$cod_producto."'";
        $resultado=$this->db->query($orden);
        $fila = $resultado->getRow();
        $chorizo= array();
        $chorizo['nombre']=$fila->nombre;
        $chorizo['descripcion']=$fila->descripcion;
        $chorizo['precio']=$fila->precio;
        $chorizo['categoria']=$fila->categoria;
        $chorizo['estado']=$fila->estado;
        return $chorizo;
    }
    function actualizaProducto($cod_producto,$nombre,$precio,$descripcion,$categoria,$estado){
        $orden="UPDATE articulos SET nombre='".$nombre."', precio='".$precio."', descripcion='".$descripcion."', categoria='".$categoria."', estado='".$estado."' WHERE cod_articulo='".$cod_producto."'";
        $this->db->query($orden);
    }
}
?>
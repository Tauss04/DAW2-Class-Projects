<?php

namespace App\Controllers;
use App\Models\Modelo;
class Home extends BaseController{
    
    public function index(): string
    {
        $modelo= new Modelo();
        $respuesta=$modelo->dameArticulos();
        $maleta['articulos']=$respuesta;

        // SI SE USA ALGUN FILTRO
        if(null !==$this->request->getPost("filtroPrec")){
            $precio=$this->request->getPost("filtroPrec");
            $categoria=$this->request->getPost("filtroCat");
            $estado=$this->request->getPost("filtroEst");

            $maleta['filtroPrecio']=$precio;
            $maleta['filtroCat']=$categoria;
            $maleta['filtroEst']=$estado;
        }

        $busqueda = $this->request->getPost("busqueda");
        // COMPRUEBO QUE NO SE HAN INTRODUCIDO CARÁCTERES VACÍOS COMO ESPACIOS
        if (null !== $busqueda && !empty(trim($busqueda))) {
            $maleta['busqueda'] = $busqueda;
        }
        return view('Usuario',$maleta);
    }

    

    //Muestro pagina de LOGIN
    public function entrar(): string{
            return view('LogIn');
    }
    // Comprueba si existe el usuario
    public function comprueba(){
        $correo=$this->request->getPost("correo");
        $contrasena=$this->request->getPost("contrasena");
        
        //Llamo al modelo
        $modelo= new Modelo();
        $respuesta=$modelo->existe($correo, $contrasena);
        if($respuesta!=0){
            $maleta['cod_usuario']=$respuesta['cod_usuario'];
            $maleta['correo']=$correo;
            $maleta['contrasena']=$contrasena; 
            $maleta['nombre']=$respuesta['nombre'];

            // PASO ARTICULOS A LA VISTA USUARIO
            $respuesta=$modelo->dameArticulos();
            $maleta['articulos']=$respuesta;

            return view('Usuario',$maleta);
        }else{
            $maleta['error']="a";
            return view('LogIn',$maleta);
        }
    }

    //Muestro pagina de Registro
    public function registro(){
        return view('Registro');
    }
    // Se registra el usuario
    public function registrarse(){
        $modelo= new Modelo();
        $nombre=$this->request->getPost("nombre");
        $correo=$this->request->getPost("correo");
        $contrasena=$this->request->getPost("contrasena");
        $registro=$modelo->registro($correo,$nombre,$contrasena);
        if($registro !=0){
            // Reciclo la función existe una vez registrado para coger el cod_usuario
            $respuesta=$modelo->existe($correo, $contrasena);
            $maleta['cod_usuario']=$respuesta['cod_usuario'];

            $maleta['nombre']=$nombre;
            $maleta['correo']=$correo;
            $maleta['contrasena']=$contrasena;
            
            // PASO ARTICULOS A LA VISTA USUARIO
            $respuesta=$modelo->dameArticulos();
            $maleta['articulos']=$respuesta;

            return view('Usuario',$maleta);
        }else{
            $maleta['error']="a";
            return view('Registro.php', $maleta);
        } 
    }

    public function cerrarSesion(){
        
        // ELIMINO LA SESIÓN
        session()->remove("inicio");
        session()->remove("cod_usuario");
        session()->remove("vengoVendedor");

        // PASO ARTICULOS A LA VISTA USUARIO
        $modelo= new Modelo();
        $respuesta=$modelo->dameArticulos();
        $maleta['articulos']=$respuesta;
        
        return view('Usuario',$maleta);
    }

    public function verPerfil(){
        $modelo=new Modelo();

        //PASO LOS PRODUCTOS DEL USUARIO A LA VISTA
        $maleta['articulos']=$modelo->dameMisProductos(session()->get("cod_usuario"));
        
        //Por defecto se muestran los articulos en venta, sino, se lee los botones de filtraje "EN VENTA" U "OCULTO"
        $maleta['filtro']=1;
        $filtro = $this->request->getPost('filtro');

        if ($filtro==="0" || $filtro ==="1") {
            $maleta['filtro']=$this->request->getPost('filtro');
        }

        return view('Perfil.php',$maleta);
    }

    //MUESTRA LA VISTA DE SUBIR PRODUCTO
    public function subirArticulo(){
        
        $formulario = view('SubirProducto.php');
        return view('Perfil', array('formulario' => $formulario));
    }

    //INSERTA EL PRODUCTO
    public function subirAguacate(){
        $info=pathinfo($_FILES['archivo']['name']);

        // SI LA EXTENSION ESTA BIEN INSERTO Y LA VISTA VUELVE AL PERFIL
            if($info['extension'] == 'jpg' || $info['extension'] == 'png' || $info['extension'] == 'jpeg'){
                $nombre=$this->request->getPost("nombre");
                $descripcion=$this->request->getPost("descripcion");
                $categoria=$this->request->getPost("categoria");
                $estado=$this->request->getPost("estado");
                $precio=$this->request->getPost("precio");

                // CREO EL NOMBRE DEL ARCHIVO CON EL CODIGO DEL USUARIO Y EL NOMBRE DEL PRODUCTO Y FINALMENTE LE AÑADO SU EXTENSION
                $nombreFichero=session()->get("cod_usuario")."".$nombre.".".$info['extension'];
                
                // EN MI PC XAMPP SE ENCUENTRA EN D: (RUTA A CAMBIAR)
                copy($_FILES['archivo']['tmp_name'],"c:/xampp/htdocs/public/fotoProducto/".$nombreFichero."");
                
                //INSERTO PRODUCTOS
                $modelo = new Modelo();
                $modelo->insertaProducto(session()->get("cod_usuario"),$nombre,$descripcion,$categoria,$estado,$precio,$nombreFichero);

                //SACO LOS PRODUCTOS DE LA BD
                $maleta['articulos']=$modelo->dameMisProductos(session()->get("cod_usuario"));
        
                //Por defecto se muestran los articulos en venta, sino, se lee los botones de filtraje "EN VENTA" U "OCULTO"
                $maleta['filtro']=1;
                return view('Perfil.php',$maleta);
                
                
            }else{  
                // SI NO ESTA BIEN LA EXTENSION TE DEVUELVO UN ERROR Y VUELVES AL FORMULARIO
                $error="El archivo debe ser .jpg, .png o .jpeg";
                $maleta = view('SubirProducto.php', array('error' => $error));
                
                return view('Perfil.php', array('formulario' => $maleta));
            }   
    }

    public function cambiarEstadoVenta(){
        
        $modelo = new Modelo();
        $cod_producto=$this->request->getPost('cod_articulo');
        $modelo->cambiaEstadoVenta($cod_producto);
        

        $maleta['articulos']=$modelo->dameMisProductos(session()->get("cod_usuario"));
        //Por defecto se muestran los articulos en venta, sino, se lee los botones de filtraje "EN VENTA" U "OCULTO"
        $maleta['filtro']=1;
        return view('Perfil.php',$maleta);
    }

    public function verMisChats(){
        $cod_usuario=session()->get("cod_usuario");
        session()->remove("vengoVendedor");
        $cod_producto=$this->request->getPost("cod_articulo");
        $nombre_producto=$this->request->getPost("nombre");
        $maleta['nombre_producto']=$nombre_producto;
        
        $modelo = new Modelo();

        $maleta['misChats']=$modelo->dameMisChats($cod_producto,$cod_usuario);
        return view('Chat.php',$maleta);
    }

    public function verChat(){
        $cod_producto=$this->request->getPost('cod_articulo');
        $cod_interesado=session()->get("cod_usuario");
        $nombre=$this->request->getPost('nombre_articulo');
        
        
        // (197-203) ES POR SI EL VENDEDOR QUIERE VER LOS CHATS DE SU ARTICULO
        $vengoVendedor=false;
        $comprador=0;
        $nombreComprador="";
        if(!NULL==$this->request->getPost('vengoVendedor')){
            $nombreComprador=$this->request->getPost('nombreComprador');
            $comprador=$this->request->getPost('interesado');
            session()->set("vengoVendedor",$comprador);
            $vengoVendedor=true;
        }


        // MODELO VA A DEVOLVER LOS MENSAJES DEL CHAT SI EXISTEN
        $modelo=new Modelo();
        $maleta['chat']=$modelo->dameMisMensajes($cod_producto,$cod_interesado,$vengoVendedor,$comprador);
        $maleta['nombreComprador']=$nombreComprador;
        $maleta['nombre_producto']=$nombre;
        $maleta['cod_producto']=$cod_producto;
        return view('Chat.php',$maleta);
    }

    public function enviarMensaje(){
        $modelo=new Modelo();

        $contenido=$this->request->getPost('contenido');
        $cod_chat=$this->request->getPost('cod_chat');
        $cod_producto=$this->request->getPost('cod_articulo');
        

        $cod_vendedor=$modelo->dameCodVendedor($cod_producto);
        $cod_interesado=session()->get("cod_usuario");
        $nombre=$this->request->getPost('nombre_articulo');
        
        if(!empty(trim($contenido))){
             $modelo->insertaMensaje($contenido, $cod_chat, $cod_vendedor,$cod_interesado,$cod_producto);
        }
       
        

        
        $vengoVendedor=false;
        $comprador=0;
        if(null!==session()->get("vengoVendedor")){
            $vengoVendedor=true;
            $comprador=session()->get("vengoVendedor");
            $nombreComprador=$this->request->getPost('nombreComprador');
            $maleta['nombreComprador']=$nombreComprador;
        }
        
        $maleta['chat']=$modelo->dameMisMensajes($cod_producto,$cod_interesado,$vengoVendedor,$comprador);
        $maleta['nombre_producto']=$nombre;
        $maleta['cod_producto']=$cod_producto;

        return view('Chat.php',$maleta);
    }
    
    public function editar(){
        $modelo = new Modelo();
        $cod_producto=$this->request->getPost('cod_articulo');
        $producto=$modelo->dameProducto($cod_producto);
        $maleta['nombre']=$producto['nombre'];
        $maleta['descripcion']=$producto['descripcion'];
        $maleta['precio']=$producto['precio'];
        $maleta['categoria']=$producto['categoria'];
        $maleta['estado']=$producto['estado'];
        $maleta['codigoProducto']=$cod_producto;

        $formulario = view('Editar.php',$maleta);
        $maleta['formulario']=$formulario;
        return view('Perfil.php',$maleta);
    }
    public function actualizarProducto(){
        $cod_producto=$this->request->getPost('cod_producto');
        $nombre=$this->request->getPost('nombre');
        $precio=$this->request->getPost('precio');
        $descripcion=$this->request->getPost('descripcion');
        $categoria=$this->request->getPost('categoria');
        $estado=$this->request->getPost('estado');
        
        $modelo= new Modelo();
        $modelo->actualizaProducto($cod_producto,$nombre,$precio,$descripcion,$categoria,$estado);
        
        $maleta['articulos']=$modelo->dameMisProductos(session()->get("cod_usuario"));
        $maleta['filtro']=1;
        return view('Perfil.php',$maleta);
    }
}

<?php

namespace App\Controllers;

use App\Models\Modelo;

class Home extends BaseController
{
    public function index()
    {
        $maleta=[];
        if(NULL!=$this->request->getPost('tipo')){
            $maleta['tipo']=$this->request->getPost('tipo');
            $maleta['ubicacion']=$this->request->getPost('ubicacion');
        }else{
            $maleta['tipo']=0;
            $maleta['ubicacion']=0;
        }
        $modelo = new Modelo();
        $chorizo = $modelo->dameProductos();
        $maleta['productos'] = $chorizo;
        return view('Principal', $maleta);
    }

    public function agregar()
    {
        if(NULL!=$this->request->getPost('nombre')){
            $nombre=$this->request->getPost('nombre');
            $tipo=$this->request->getPost('tipo');
            $ubicacion=$this->request->getPost('ubicacion');

            $modelo = new Modelo();
            $modelo->agregarArticulo($nombre,$tipo,$ubicacion); // Ajusta los datos necesarios para la inserción
    
            return redirect()->to(site_url('/'));
        }else{
            return view('formAñadir.php');
        }
        
    }

    public function actualizar(){
        if(NULL!=$this->request->getPost('vengoPrincipal')){
            $maleta['nombre']=$this->request->getPost('nombre');
            $maleta['tipo']=$this->request->getPost('cod_tipo');
            $maleta['ubicacion']=$this->request->getPost('cod_ubicacion');
            $maleta['codigo_articulo']=$this->request->getPost('cod_articulo');
            return view('formActualizar.php',$maleta);
        }else{
            $codigo=$this->request->getPost('codigo_articulo');
            $nombre=$this->request->getPost('nombre');
            $tipo=$this->request->getPost('tipo');
            $ubicacion=$this->request->getPost('ubicacion');
            $modelo = new Modelo();
            $modelo->actualizarArticulo($codigo,$nombre,$tipo,$ubicacion); // Ajusta los datos necesarios para la actualización
        
            return redirect()->to(site_url('/'));
        }
        // Lógica para actualizar un artículo existente
        
    }

    public function eliminar()
    {   $codigo=$this->request->getPost('cod_articulo');
        
        
        // Lógica para eliminar un artículo
        $modelo = new Modelo();
        $modelo->eliminarArticulo($codigo);
        
        return redirect()->to(site_url('/'));
    }
}

?>
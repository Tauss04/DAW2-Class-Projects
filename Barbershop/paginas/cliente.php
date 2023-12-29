<?php
include"../logica/funciones.php";
session_start();

if(!isset($_SESSION['cliente'])){
    header("Location:../index.php");
}else{
    $tiempoinicio=$_SESSION['tiempoinicio'];
    $usuario=$_SESSION['cliente'];
    $nombre;
    $codcliente;
    foreach(dameCliente($usuario) as $nombrecli=>$codigo){
        $nombre=$nombrecli;
        $codcliente=$codigo;
    }

    if($tiempoinicio-time()>300){
        header("Location:../index.php");
    }
    if(isset($_POST['codservicio'])){
        
        $codservicio=$_POST['codservicio'];
    }
    if(isset($_POST['codbarbero'])){
        
        $codbarbero=$_POST['codbarbero'];
        $nombrebarbero=$_POST['nombrebarbero'];
    }
    if(isset($_POST['fecha'])){
      
        $fecha=$_POST['fecha'];
        $fechaObj = new DateTime($fecha);
        $dia = $fechaObj->format('d');

    }
    //si cancelan alguna cita
    if(isset($_POST['btnCancelo'])){
        $servicioCita=$_POST['servicioCancel'];
        $fechaCita=$_POST['fechaCancel'];
        canceloCita($fechaCita,$servicioCita);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagenes/icono.ico">
    <link rel="stylesheet" href="../estilos/cliente.css">
    <title>TeCalva Citas</title>
    <?php
        // Si hay cita muestro alert;
        if(isset($_COOKIE['haycita'])){
            echo"<script>alert('No puedes pedir la cita a esa hora')</script>";
        }
    ?>
</head>
<body>
    <header>
        
        <?php
            echo"<h1>Bienvenido ".$nombre."</h1>";
        ?>   
        
    </header>
    <hr> 
    <main>
            <?php
//----------------------------------------------------------- Botones de navegación------------------------------------------------------------------
            echo"<form action='cliente.php' id='form-navegacion' method='post'>";
            if(isset($_POST['pedirCita']) || isset($_POST['codservicio'])){
                echo"<input type='submit' class='botones' name='volver' value='Volver atrás'>";
                echo"<input type='submit' class='botones' name='verCita' value='Ver mis citas'>"; 
            }else if(isset($_POST['verCita'])){
                echo"<input type='submit' class='botones' name='volver' value='Volver atrás'>";
                echo"<input type='submit' class='botones' name='pedirCita' value='Pedir cita'>";
            }else{
                echo"<input type='submit' class='botones' name='pedirCita' value='Pedir cita'>";
                echo"<input type='submit' class='botones' name='verCita' value='Ver mis citas'>"; 
            }
            echo"</form>";
//-------------------------------------------------------------------- VER CITAS-------------------------------------------------------------------------
            if(isset($_POST['verCita'])){
                $cuantas=0;
                $cuantas=cuantasCitas($codcliente);
                $citas=array();
                $citas=dameMisCitas($codcliente);
                if($cuantas==0){
                    echo"<p id='noHayCita'>No hay citas actualmente</p>";
                }else{
                    echo"<form method='post' action='cliente.php'>";
                    echo"<table id='tablahoras'>";
                    echo"<tr>";
                    for($i=0;$i<$cuantas;$i++){
                        foreach($citas[$i] as $servicio=>$fechahora){
                            foreach($fechahora as $fecha=>$hora){
                                if($i%4!=0){
                                    echo"<td class='tdCita'><div id='divservicioCancel'>".$servicio."</div><div id='divfechaCancel'>".$fecha."</div>".$hora."</td>";
                                }else{
                                    echo"</tr><tr><td class='tdCita'><div id='divservicioCancel'>".$servicio."</div><div id='divfechaCancel'>".$fecha."</div>".$hora."</td>";
                                } 
                            }  
                        }      
                    }
                    echo"</tr>";
                    echo"</table>";
                    echo"<input type='hidden' id='envServicioCancel' name='servicioCancel' >";
                    echo"<input type='hidden' id='envFechaCancel' name='fechaCancel' >";
                    echo"<input type='hidden' name='verCita' >";
                    echo"<div id='caja-canceloCita'>";
                    echo"<input type='submit' class='botones' name='btnCancelo' value='Cancelar Cita'>";
                    echo"</div>";
                    echo"</form>";
                }
            }           


//----------------------------------------------------------------- PEDIR CITA----------------------------------------------------------------------------
            if(!isset($_POST['codservicio']) && isset($_POST['pedirCita'])){
                echo"<form class='form-barbero' action='cliente.php' method='post'>";
                    echo"<h1>¿Que necesitas?</h1>";
                    foreach(dameServicios() as $indice=>$valor){
                        
                            echo"<input type='radio' id=".$indice." name='codservicio' value=".$indice.">";
                        foreach(descripcionPrecio($indice) as $descripcion=>$precio){    
                            echo"<label for=".$indice.">".$valor." (".$descripcion.") (".$precio."€)</label>";
                            echo"</br>";   
                        }       
                    }  
                    echo"<input id='btnSiguiente' class='botones' type='submit' value='Siguiente'>";
                echo"</form>";   
            }else if(isset($_POST['codservicio']) && !isset($_POST['codbarbero'])){
                echo"<div class='form-barbero'>";
                echo"<h1 id='h1barbero'>Pide cita con su barbero</h1>";
                foreach(dameEmpleados() as $indice=>$valor){
                        echo"<form class='opcion-barbero' action='cliente.php' method='post'>";     
                            echo"<div class='btn-barbero'>".$valor."</div>";
                                echo"<input type='hidden' name='codbarbero' value=".$indice.">";
                                echo"<input type='hidden' name='nombrebarbero' value=".$valor.">";
                                echo"<input type='hidden' name='codservicio' value=".$codservicio.">";
                        echo"</form>";
                
                } 
                echo"</div>";          
            }else if(isset($_POST['codbarbero'])){
                echo"<div class='contenedor-fechahora'>";
                echo"<div id='carta-fecha'>";
                if(isset($_POST['fecha'])){
                    echo"<h2>Pide cita con ".$nombrebarbero." el día ".$dia."</h2>";
                }else{
                    echo"<h2>Pide cita con ".$nombrebarbero."</h2>";
                }
                echo"<div id='divfechahora'>";
                echo"<form class='form-dia' action='cliente.php' method='post'>
                        <input type='date' name='fecha' class='inp-dia' onchange='this.form.submit()'>
                        <input type='hidden' name='codbarbero' value=".$codbarbero.">
                        <input type='hidden' name='nombrebarbero' value=".$nombrebarbero.">
                        <input type='hidden' name='codservicio' value=".$codservicio.">
                    </form>";
                if(!isset($_POST['fecha'])){
                    echo"<div id='btnHoradisabled'>Ver Horas</div>";
                    echo"</div>";
                }else{
                    
                        $fechaformato=date('y/m/d', strtotime($fecha));
                    
                    if($fechaformato > date('y/m/d')){
                        echo"<div id='btnHoraable' onclick='muestroHoras()'>Ver horas</div>";
                        echo"</div>";
                        echo"<form id='form-muestrohoras' action='../paginas/cita.php' method='post'>";
                        echo"<div id='cajahoras'>";
                        echo"<table id='tablahoras'><tr>";
                        $cont=-1;
                        for($i=9;$i<=19;$i++){
                            for($a=0;$a<60;$a+=15){
                                if($i==13 && $a>0){
                                    $i=16;
                                    $a=0;
                                }
                                if($i==20 && $a>15){
                                    break;
                                }

                                $hora;
                                $minutos;
                                
                                if($i<10){
                                    $hora="0".$i;
                                }else{
                                    $hora="".$i;
                                }
                                if($a>0){
                                    $minutos="".$a;
                                }else{
                                    $minutos="00";
                                }
                                $horaminutos="".$hora.":".$minutos."";
                                $cont++;
                                
                                // Si ya hay citas en esa hora le cambio los estilos para que se vea desactivada;
                                if(hayCita($fecha,$horaminutos,$codbarbero)){
                                    if($cont%5==0){
                                        echo"</tr><tr><td class='nohorasdisp'>".$horaminutos."</td>";
                                    }else{
                                        echo"<td class='nohorasdisp'>".$horaminutos."</td>";
                                    } 
                                }else{
                                    if($cont%5==0){
                                        echo"</tr><tr><td class='horasdisp'>".$horaminutos."</td>";
                                    }else{
                                        echo"<td class='horasdisp'>".$horaminutos."</td>";
                                    }
                                }
                                
                            }
                        }
                        echo"<td colspan=2><input type='submit' id='btnPidoCita' name='pidoCita' value='Pedir Cita' disabled='disabled'></td>";
                        echo"</tr></table>";
                        echo"<input type='hidden' name='codbarbero' value=".$codbarbero.">";
                        echo"<input type='hidden' name='fecha' value=".$fecha.">";
                        echo"<input type='hidden' name='nombrebarbero' value=".$nombrebarbero.">";
                        echo"<input type='hidden' name='codcliente' value=".$codcliente.">";
                        echo"<input type='hidden' name='codservicio' value=".$codservicio.">";
                        echo"<input id='envhoracita' type='hidden' name='horacita'>";
                        
                        echo"</form>";
                        echo"</div>";
                    }else{
                        echo"<div id='btnHoradisabled'>Ver horas</div>";
                    }
                }
                echo"</div>";
                echo"</div>";
                
            }   
                
                
                // if(isset($_POST['fecha'])){
                //     if($fechaformato > date('y/m/d')){
                //         echo"<div id='btnHoraable' onclick='muestroHoras()'>Ver horas</div>";
                //         echo"</div>";
                //         echo"<form action='../paginas/cita.php' method='post'>";
                //         echo"<div id='cajahoras'>";
                //         echo"<table id='tablahoras'><tr>";
                //         $cont=-1;
                //         for($i=9;$i<=19;$i++){
                //             for($a=0;$a<60;$a+=15){
                //                 if($i==13 && $a>0){
                //                     $i=16;
                //                     $a=0;
                //                 }
                //                 if($i==20 && $a>15){
                //                     break;
                //                 }

                //                 $hora;
                //                 $minutos;
                                
                //                 if($i<10){
                //                     $hora="0".$i;
                //                 }else{
                //                     $hora="".$i;
                //                 }
                //                 if($a>0){
                //                     $minutos="".$a;
                //                 }else{
                //                     $minutos="00";
                //                 }
                //                 $horaminutos="".$hora.":".$minutos."";
                //                 $cont++;
                                
                //                 // Si ya hay citas en esa hora le cambio los estilos para que se vea desactivada;
                //                 if(hayCita($fecha,$horaminutos,$codbarbero)){
                //                     if($cont%5==0){
                //                         echo"</tr><tr><td class='nohorasdisp'>".$horaminutos."</td>";
                //                     }else{
                //                         echo"<td class='nohorasdisp'>".$horaminutos."</td>";
                //                     } 
                //                 }else{
                //                     if($cont%5==0){
                //                         echo"</tr><tr><td class='horasdisp'>".$horaminutos."</td>";
                //                     }else{
                //                         echo"<td class='horasdisp'>".$horaminutos."</td>";
                //                     }
                //                 }
                                
                //             }
                //         }
                //         echo"<td colspan=2><input type='submit' id='btnPidoCita' name='pidoCita' value='Pedir Cita' disabled='disabled'></td>";
                //         echo"</tr></table>";
                //         echo"<input type='hidden' name='codbarbero' value=".$codbarbero.">";
                //         echo"<input type='hidden' name='fecha' value=".$fecha.">";
                //         echo"<input type='hidden' name='nombrebarbero' value=".$nombrebarbero.">";
                //         echo"<input type='hidden' name='codcliente' value=".$codcliente.">";
                //         echo"<input type='hidden' name='codservicio' value=".$codservicio.">";
                //         echo"<input id='envhoracita' type='hidden' name='horacita'>";
                        
                //         echo"</form>";
                //         echo"</div>";
                //     }else{
                //         echo"<div id='btnHoradisabled'>Ver horas</div>";
                //     }
                // }
                
                
            ?>
            
    </main>
    <footer>
        <form action="../index.php" id="form-atras">
            <input id="btn-atras" type="image" src='../imagenes/atras2.png' />
        </form>
    </footer>
    <script>
     
     // -----------------------Cancelar Cita--------------------------------------------------  
     var tdCancel = document.getElementsByClassName('tdCita');
     for (var i = 0; i < tdCancel.length; i++) {
        tdCancel[i].addEventListener("click", function () {
            if (this.id) {
                this.removeAttribute("id");
                document.getElementById('envServicioCancel').value = "";
                document.getElementById('envFechaCancel').value = "";
            } else {
                for (var j = 0; j < tdCancel.length; j++) {
                    tdCancel[j].removeAttribute("id");
                }
                this.setAttribute("id", "marcado");
                var servicioCancel = this.querySelector("#divservicioCancel").textContent;
                var fechaCancel = this.querySelector("#divfechaCancel").textContent;
                document.getElementById('envServicioCancel').value = servicioCancel;
                document.getElementById('envFechaCancel').value = fechaCancel;
            }                
        });
    }




    //  ---------------------------PEDIR CITA-------------------------------------------------   
        var botones = document.getElementsByClassName('btn-barbero');
        for (var i = 0; i < botones.length; i++) {
            botones[i].addEventListener("click", recargo);
        }

        function recargo() {
            this.closest('.opcion-barbero').submit();
        }

        function muestroHoras(){
            var divHoras=document.getElementById('cajahoras');
            if(divHoras.style.display=="flex"){
                divHoras.style.display="none";
            }else{
                divHoras.style.display="flex";
            }
        }

        // SELECCIONAR UNA HORA, LE DOY ID PARA DARLE ESTILOS Y LE PASO EL VALOR A INPUT HIDDEN
        var lostd = document.getElementsByClassName('horasdisp');
        for(var i=0;i<lostd.length;i++){
            lostd[i].addEventListener("click",function(){    
                if(this.id){
                    this.removeAttribute("id");
                    document.getElementById('envhoracita').value="";
                }else{
                    for (var j = 0; j < lostd.length; j++) {
                        lostd[j].removeAttribute("id");
                    }
                    this.setAttribute("id","marcado");
                    document.getElementById('envhoracita').value=this.textContent;
                }
                if(document.getElementById("marcado")==null){
                document.getElementById("btnPidoCita").setAttribute("disabled","disabled");
            }else{
                document.getElementById("btnPidoCita").removeAttribute("disabled");
            }
            });
        
            
        }
    

        
   
    </script>
</body>
</html>
<?php
    }
?>
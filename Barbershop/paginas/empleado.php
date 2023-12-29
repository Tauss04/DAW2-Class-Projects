<?php
include"../logica/funciones.php";
session_start();
if(!isset($_SESSION['empleado'])){
    header("Location:../index.php");
}else{
    $nombre=$_SESSION['empleado'];
    $fecha;
    if(isset ($_SESSION['codempleado'])){
        $codbarbero=$_SESSION['codempleado'];
    }else{
        $codbarbero=1;
    }

    if(isset($_POST['pidoLibre'])){
        $horaLibre=$_POST['horacita'];
        $cont=0;
        $tiempo=array();
        $fechalibre=$_POST['fechaLibre'];
        for ($i = 0; $i < strlen($horaLibre); $i += 5) {
            $hora = substr($horaLibre, $i, 5);
            $cont++;
            $tiempo[$cont] = $hora;
            insertoHoraLibre($tiempo[$cont], $codbarbero, $fechalibre);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagenes/icono.ico">
    <link rel="stylesheet" href="../estilos/empleado.css">
    <title>TeCalva Citas</title>

</head>
<body>
    <header>
        <?php
            echo"<h1>Bienvenido ".$nombre."</h1>";
            if(isset($_POST['fecha'])){
                echo"<h2>Viendo citas para el día ".$_POST['fecha'];
                $fecha=$_POST['fecha'];
                $fechaformato=date('y/m/d', strtotime($fecha));
            }else{
                $fecha=date('Y-m-d');
                echo"<h2>Viendo citas para el día ".$fecha;
                $fechaformato=date('y/m/d', strtotime($fecha));
            }
            
        ?>
        <hr>    
    </header>
    <main>
        <form action="empleado.php" id="form-dia" method="post">
            Selecciona una fecha: <input type="date" name="fecha" onchange="this.form.submit()">
        </form>
        <?php
           echo"<form action='empleado.php' method='post'>";
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
                        $cod_cita=dameCita($fecha,$codbarbero,$horaminutos);
                        $servicio=dameNombreServicio($cod_cita['cod_cita']);
                        $nombreCliente=dameNombreCliente($cod_cita['cod_cita']);
                       if($cont%9==0){
                           echo"</tr><tr><td class='nohorasdisp'>".$horaminutos."<div>".$servicio['nombre']." ".$nombreCliente['nombre']."</div></td>";
                       }else{
                           echo"<td class='nohorasdisp'>".$horaminutos."<div>".$servicio['nombre']." ".$nombreCliente['nombre']."</div></td>";
                       } 
                   }else{
                        if($fechaformato > date('y/m/d')){
                            if($cont%9==0){
                                echo"</tr><tr><td class='horasdisp'>".$horaminutos."</input></td>";
                            }else{
                                echo"<td class='horasdisp'>".$horaminutos."</input></td>";
                            }
                        }else{
                            if($cont%9==0){
                                echo"</tr><tr><td class='nohorasdisp'>".$horaminutos."</td>";
                            }else{
                                echo"<td class='nohorasdisp'>".$horaminutos."</td>";
                            } 
                        }
                   }
               }
           }
           echo"<td id='tdBtn' colspan='3'><input type='submit' id='btnLibre' name='pidoLibre' value='Ausentarme'></td></tr></table>";
           echo"<input type='hidden' name='codbarbero' value=".$codbarbero.">";
           echo"<input type='hidden' name='fechaLibre' value=".$fecha.">";
           echo"<input id='envhoracita' type='hidden' name='horacita'>";
           echo"</form>";
           echo"</div>";
        ?>
        </table>
    </main>
    <footer>
        <form action="../index.php" id="form-atras">
            <input id="btn-atras" type="image" src='../imagenes/atras.png' />
        </form>
    </footer>
</body>
<script>
    var lostd = document.getElementsByClassName('horasdisp');
        var horas="";
        for(var i=0;i<lostd.length;i++){
            lostd[i].addEventListener("click",function(){    
                if(this.id){
                    this.removeAttribute("id");
                    document.getElementById('envhoracita').value="";
                }else{
                    this.setAttribute("id","marcado");
                    horas=horas+""+this.textContent
                    document.getElementById('envhoracita').value=horas;
                }                
            });
        }
    
</script>
</html>


















<?php
    }
?>
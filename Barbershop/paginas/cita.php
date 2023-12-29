<?php
session_start();
include"../logica/funciones.php";

if(isset($_SESSION['pidoCita']) && isset($_POST['confirmo'])){
    $hora=$_COOKIE['horacita'];
    $codservicio=$_COOKIE['codservicio'];
    $codempleado=$_COOKIE['codbarbero'];
    $codcliente=$_COOKIE['codcliente'];
    $nombrebarbero=$_COOKIE['nombrebarbero'];
    $fecha=$_COOKIE['fecha'];
    //servicio 1= 15min
    //servicio 2= 15min
    //servicio 3=45min -> 15 0 15
    //servicio 4=30min -> 15 15 
    //servicio 5=1:15 min ->15 15 15 0 15
    $partehora=intval($hora[0]."".$hora[1]);
    $partemin=intval($hora[3]."".$hora[4]);
    $entra="no";
    if($codservicio==1 || $codservicio==2){
        insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
    // Si el servicio es mascarilla
    }else if($codservicio==3){
        if($partemin<30){
            if($partehora<10){
                $ultimaHora="0".$partehora.":".$partemin+30;
            }else{
                $ultimaHora=$partehora.":".$partemin+30;
            }
            
            if(!hayCita($fecha,$ultimaHora,$codbarbero)){
                insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
                insertoCita($fecha,$ultimaHora,$codempleado,$codcliente,$codservicio);
            }
        }
        else if($partemin==30){
            $ultimaHora=($partehora+1).":00";
            if(!hayCita($fecha,$ultimaHora,$codbarbero)){
                insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
                insertoCita($fecha,$ultimaHora,$codempleado,$codcliente,$codservicio);
            }
        }else if($partemin==45){
            $ultimaHora=($partehora+1).":15";
            if(!hayCita($fecha,$ultimaHora,$codbarbero)){
                insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
                insertoCita($fecha,$ultimaHora,$codempleado,$codcliente,$codservicio);
            }
        }
    }else if($codservicio==4){
            if($partemin==45){
                $ultimaHora=($partehora+1).":00";
                if(!hayCita($fecha,$ultimaHora,$codbarbero)){
                    insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$ultimaHora,$codempleado,$codcliente,$codservicio);
                }
            }else{
                if($partehora<10){
                    $ultimaHora="0".$partehora.":".$partemin+15;
                }else{
                    $ultimaHora=$partehora.":".$partemin+15;
                }
                
                if(!hayCita($fecha,$ultimaHora,$codbarbero)){
                    insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$ultimaHora,$codempleado,$codcliente,$codservicio);
                }
            }
        }else if($codservicio==5){
            if($partemin==00){
                if($partehora<10){
                    $segundaHora="0".$partehora.":".$partemin+15;
                    $terceraHora="0".$partehora.":".$partemin+30;
                }else{
                    $segundaHora=$partehora.":".$partemin+15;
                    $terceraHora=$partehora.":".$partemin+30;
                }
                $quintaHora=($partehora+1).":00";
                if(!hayCita($fecha,$segundaHora,$codbarbero) && !hayCita($fecha,$terceraHora,$codbarbero) && !hayCita($fecha,$quintaHora,$codbarbero)){
                    insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$segundaHora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$terceraHora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$quintaHora,$codempleado,$codcliente,$codservicio);
                }
            }else if($partemin==15){
                if($partehora<10){
                    $segundaHora="0".$partehora.":".$partemin+15;
                    $terceraHora="0".$partehora.":".$partemin+30;
                }else{
                    $segundaHora=$partehora.":".$partemin+15;
                    $terceraHora=$partehora.":".$partemin+30;
                }
            
                $quintaHora=($partehora+1).":".$partemin;
                if(!hayCita($fecha,$segundaHora,$codbarbero) && !hayCita($fecha,$terceraHora,$codbarbero) && !hayCita($fecha,$quintaHora,$codbarbero)){
                    insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$segundaHora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$terceraHora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$quintaHora,$codempleado,$codcliente,$codservicio);
                }
            }else if($partemin==30){
                if($partehora<10){
                    $segundaHora="0".$partehora.":".$partemin+15;
                    $terceraHora="0".$partehora.":".$partemin+30;
                }else{
                    $segundaHora=$partehora.":".$partemin+15;
                }
                
                $terceraHora=($partehora+1).":00";
                $quintaHora=($partehora+1).":".$partemin;
                if(!hayCita($fecha,$segundaHora,$codbarbero) && !hayCita($fecha,$terceraHora,$codbarbero) && !hayCita($fecha,$quintaHora,$codbarbero)){
                    insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$segundaHora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$terceraHora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$quintaHora,$codempleado,$codcliente,$codservicio);
                }
            }else if($partemin==45){
                $segundaHora=($partehora+1).":00";
                $terceraHora=($partehora+1).":15";
                $quintaHora=($partehora+1).":".$partemin;
                if(!hayCita($fecha,$segundaHora,$codbarbero) && !hayCita($fecha,$terceraHora,$codbarbero) && !hayCita($fecha,$quintaHora,$codbarbero)){
                    insertoCita($fecha,$hora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$segundaHora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$terceraHora,$codempleado,$codcliente,$codservicio);
                    insertoCita($fecha,$quintaHora,$codempleado,$codcliente,$codservicio);
                }
            }
        }
        
        header("Location:../index.php");
    }

if(isset($_POST['pidoCita'])){
    $_SESSION['pidoCita']=2;
    $hora=$_POST['horacita'];
    $codservicio=$_POST['codservicio'];
    $codbarbero=$_POST['codbarbero'];
    $codcliente=$_POST['codcliente'];
    $nombrebarbero=$_POST['nombrebarbero'];
    $fecha=$_POST['fecha'];
    setcookie('horacita',"".$hora."",time()+60);
    setcookie('codservicio',$codservicio,time()+60);
    setcookie('codbarbero',$codbarbero,time()+60);
    setcookie('codcliente',$codcliente,time()+60);
    setcookie('nombrebarbero',$nombrebarbero,time()+60);
    setcookie('fecha',$fecha,time()+60);

    $partehora=intval($hora[0]."".$hora[1]);
    $partemin=intval($hora[3]."".$hora[4]);

    if($codservicio==3){
        if($partemin<30){
            $ultimaHora=$partehora.":".$partemin+30;
            if(hayCita($fecha,$ultimaHora,$codbarbero)){
                setcookie('haycita',$hora,time()+3);
                header("Location:cliente.php");
            }
        }else if($partemin==30){
            $ultimaHora=(($partehora+1)).":00";
            if(hayCita($fecha,$ultimaHora,$codbarbero)){
                setcookie('haycita',$hora,time()+3);
                header("Location:cliente.php");
            }
        }else if($partemin==45){
            $ultimaHora=(($partehora+1)).":15";
            if(hayCita($fecha,$ultimaHora,$codbarbero)){
                setcookie('haycita',$hora,time()+3);
                header("Location:cliente.php");
            }
        }
    }else if($codservicio==4){
        if($partemin==45){
            $ultimaHora=(($partehora+1)).":00";
            if(hayCita($fecha,$ultimaHora,$codbarbero)){
                setcookie('haycita',$hora,time()+3);
                header("Location:cliente.php");
            }
        }else{
            $ultimaHora=$partehora.":".$partemin+15;
            if(hayCita($fecha,$ultimaHora,$codbarbero)){
                setcookie('haycita',$hora,time()+3);
                header("Location:cliente.php");
            }
        }
    }else if($codservicio==5){
        if($partemin==00){
            $segundaHora=$partehora.":".$partemin+15;
            $terceraHora=$partehora.":".$partemin+30;
            $quintaHora=($partehora+1).":00";
            if(hayCita($fecha,$segundaHora,$codbarbero) || hayCita($fecha,$terceraHora,$codbarbero) || hayCita($fecha,$quintaHora,$codbarbero)){
                setcookie('haycita',$hora,time()+3);
                header("Location:cliente.php");
            }
        }else if($partemin==15){
            $segundaHora=$partehora.":".$partemin+15;
            $terceraHora=$partehora.":".$partemin+30;
            $quintaHora=($partehora+1).":".$partemin;
            if(hayCita($fecha,$segundaHora,$codbarbero) || hayCita($fecha,$terceraHora,$codbarbero) || hayCita($fecha,$quintaHora,$codbarbero)){
                setcookie('haycita',$hora,time()+3);
                header("Location:cliente.php");
            }
        }else if($partemin==30){
            $segundaHora=$partehora.":".$partemin+15;
            $terceraHora=($partehora+1).":00";
            $quintaHora=($partehora+1).":".$partemin;
            if(hayCita($fecha,$segundaHora,$codbarbero) || hayCita($fecha,$terceraHora,$codbarbero) || hayCita($fecha,$quintaHora,$codbarbero)){
                setcookie('haycita',$hora,time()+3);
                header("Location:cliente.php");
            }
        }else if($partemin==45){
            $segundaHora=($partehora+1).":00";
            $terceraHora=($partehora+1).":15";
            $quintaHora=($partehora+1).":".$partemin;
            if(hayCita($fecha,$segundaHora,$codbarbero) || hayCita($fecha,$terceraHora,$codbarbero) || hayCita($fecha,$quintaHora,$codbarbero)){
                setcookie('haycita',$hora,time()+3);
                header("Location:cliente.php");
            }
        }
    }









?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>¿Desea Confirmar su cita?</h1>
    <?php
        echo"<h2>Cita el día: ".$fecha;
        echo "<h2>A las ".$hora."</h2>";
        echo "<h2>Le atenderá ".$nombrebarbero."</h2>";
    ?>
    <form action="cita.php" method="post">
        <?php 
        echo"<input type='hidden' name='codbarbero' value=".$codbarbero.">";
        echo"<input type='hidden' name='nombrebarbero' value=".$nombrebarbero.">";
        echo"<input type='hidden' name='codservicio' value=".$codservicio.">";
        ?>
        <input type="submit" name="confirmo" value="Confirmar">
    </form>
    <form action="cliente.php">
        <?php
        echo"<input type='hidden' name='codbarbero' value=".$codbarbero.">";
        echo"<input type='hidden' name='nombrebarbero' value=".$nombrebarbero.">";
        echo"<input type='hidden' name='codservicio' value=".$codservicio.">";
    ?>
        <input type="submit" value="Cancelar">
    </form>
</body>
</html>

<?php
}
?>
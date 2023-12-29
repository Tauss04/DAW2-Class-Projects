function compruebo(){
    var contrasena1=document.getElementById('contrasena1').value;
    var contrasena2=document.getElementById('contrasena2').value;

    if(contrasena1!=contrasena2){
        document.getElementById('btnEnviar').setAttribute("disabled","disabled");
        document.getElementById('contrasena2').style.backgroundColor="red";
    }else if(contrasena1==contrasena2){
        document.getElementById('btnEnviar').removeAttribute("disabled");
        document.getElementById('contrasena2').style.backgroundColor="";
    }
}
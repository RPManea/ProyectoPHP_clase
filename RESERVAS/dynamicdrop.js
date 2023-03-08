var nombrerec;
var obnombre;
var ubirec;
var obubi;
var k;

// Función para obtener los valores introducidos en el desplegable de ubicacion (centro) y enviarlos al searchPin.php.
function selectubi(){
    // alert(nombrerec);
    obubi = document.getElementById("ubicacion");
    ubirec = obubi.options[obubi.selectedIndex].text;
    // alert(nombrerec);
    k='ubi';
    $.ajax({
        url:"searchPin.php",
        type:"POST",
        data:{
            id:ubirec,
            key:k,
        },
        success:function(data){
            $('#nombre').html(data);
        }
    })
    setTimeout(function(){
        if (ubirec == "Selecciona un centro"){
            document.getElementById("sin-seleccion").style.display="flex";
            document.getElementById("sin-seleccion").innerHTML="<p>Aún no hay nada que mostrar. <br><br>Seleccione un centro y un recurso.</p>";
            document.getElementById("center").style.display="none"
            $('html,body').css('overflow', 'hidden');
        }else{
            document.getElementById("sin-seleccion").innerHTML="<p>Aún no hay nada que mostrar. <br><br>Seleccione un recurso.</p>";
            document.getElementById("center").style.display="none"
            $('html,body').css('overflow', 'hidden');
        }
        setTimeout(function(){
            selectnombre();
        },50);
    },100);
    
    
}

// Función para obtener los valores introducidos en el desplegable de nombre (recursos) y enviarlos al searchPin.php.
function selectnombre(){
    obnombre = document.getElementById("nombre");
    nombrerec = obnombre.options[obnombre.selectedIndex].text;
    // alert (ubirec);
    k = 'nom'
    $.ajax({
        url:"searchPin.php",
        type:"POST",
        data:{
            id1:ubirec,
            id2:nombrerec,
            key:k,
        },
        success:function(data){
            $('#tabla').html(data);
        }
    })
    setTimeout(function(){
        if (nombrerec == "Selecciona un recurso" && ubirec == "Selecciona un centro"){
            document.getElementById("sin-seleccion").style.display="flex";
            document.getElementById("sin-seleccion").innerHTML="<p>Aún no hay nada que mostrar. <br><br>Seleccione un centro y un recurso.</p>";
            document.getElementById("center").style.display="none"
            $('html,body').css('overflow', 'hidden');
        }else if (nombrerec == "Selecciona un recurso"){
            document.getElementById("sin-seleccion").style.display="flex";
            document.getElementById("sin-seleccion").innerHTML="<p>Aún no hay nada que mostrar. <br><br>Seleccione un recurso.</p>";
            document.getElementById("center").style.display="none"
            $('html,body').css('overflow', 'hidden');
        }else{
            document.getElementById("sin-seleccion").style.display="none";
            $("html, body").css("overflow","auto");
            setTimeout(function(){
                document.getElementById("titulo-reservas").innerHTML="Reservas";
                document.getElementById("center").style.display="flex"
            },500);
        }    
    },100);
}

// Función que obtiene el ID del recurso seleccionado cuando se presiona el botón de "reservar".
function IDres(){
    $id_rec = document.getElementById('IDRecRes').innerHTML;
    document.getElementById("IDres").value = $id_rec;
    
}

// Función que cambia el valor minimo del input de la hora inicial de la reserva según el día introducido.
function minHora(){
    $fechares = document.getElementById("fechares").value;
    $tiempo = new Date();
    $mes = ($tiempo.getMonth() +1);
    $fechaAc = $tiempo.getFullYear() + "-" + ('0' + $mes).slice(-2).toString() + "-" + ('0' + $tiempo.getDate()).slice(-2).toString();
    
    $horaAc = ('0' + $tiempo.getHours()).slice(-2).toString() + ':' + ('0' + $tiempo.getMinutes()).slice(-2).toString();
    if ($fechares == $fechaAc){
        document.getElementById("horaini1").outerHTML="<input onchange='minRes()' id='horaini1' name='hora_inicio' required styles type='time' min='"+ $horaAc +"'></input>"
        document.getElementById("horafin1").innerHTML="<label for='from'>Hora Final </label><input name='hora_final' readonly required styles type='time'> "
        // alert("Es igual")
    }else{
        document.getElementById("horaini1").outerHTML="<input onchange='minRes()' id='horaini1' name='hora_inicio' required styles type='time'></input>"
        document.getElementById("horafin1").innerHTML="<label for='from'>Hora Final </label><input name='hora_final' readonly required styles type='time'> "
        // alert("No es igual")
    }
}

// Función que cambia el valor minimo del input de la hora final de la reserva según el la hora inicial introducida.
function minRes(){
    $horafin = document.getElementById("horaini1").value;
    document.getElementById("horafin1").innerHTML="<label for='from'>Hora Final </label><input name='hora_final' required styles type='time' min='"+ $horafin +"'> "
}

<?php 
session_start();
if (empty($_SESSION['admin'])) {
    header("Location: ../LOGIN/logout.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="../CALENDARIO/css/bootstrap.min.css">
<link rel="stylesheet" href="../CALENDARIO/fullcalendar/lib/main.css">
<script src="../CALENDARIO/js/jquery-3.6.0.min.js"></script>
<script src="../CALENDARIO/js/bootstrap.min.js"></script>
<script src="../CALENDARIO/fullcalendar/lib/main.min.js"></script>
<script src="../CALENDARIO/fullcalendar/lib/locales/es.js"></script>
<link rel="stylesheet" href="../CSS/login.css">
<style>
    select{
        width: 40px;
        height: 40px;
        text-align: center;
    }
</style>
<script>
    function Toggle() {
        var temp = document.getElementById("typepass");
        if (temp.type === "password") {
            temp.type = "text";
        }else {
            temp.type = "password";
        }
    }
    function keyDown(e) { 
        var e = window.event || e;
        var key = e.keyCode;
        //space pressed
        if (key == 32) { //space
            e.preventDefault();
        }         
    }
    function checkWhitespace(event){
	var data = event.clipboardData.getData("text/plain");
    var isNullOrContainsWhitespace = (!data || data.length === 0 || /\s/g.test(data));  
        if(isNullOrContainsWhitespace)
        {
        event.preventDefault(); 
        }
    }
</script>
</head>
<body id="body">
<div class="divCabecera">
<button onclick="location.href='../../index.php'" class="botonsesion" >Volver al calendario</button>
<!-- ////////////////////////////////// -->
        <h1 class="tituloACC">REGISTRO</h1>
<!-- ////////////////////////////////// -->
</div>
<form action="./conexionReg.php" method="post">
<div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="modal-body">
                <h4 class="titulo">Introduce los datos del nuevo usuario</h4>
                <p>(usuario y contraseña no admite espacios en blanco)</p>
                <div class="datos">    
                    <div class="form-group">
                        <span class="input-icon"><i class="fa fa-user"></i><b>Usuario</b></span>
                        <input name="username" type="user" class="form-control" onkeydown="keyDown(event)" onpaste="checkWhitespace(event)">
                    </div>
                    <div class="form-group">
                        <span class="input-icon"><i class="fa fa-user"></i><b>Nombre y apellidos</b></span>
                        <input minlength="2" name="nombreCompleto" type="user" class="form-control">
                    </div>
                    <div class="form-group">
                        <span class="input-icon"><i class="fas fa-key"></i><b>Contraseña</b></span>
                        <input id="typepass" name="password" type="password" class="form-control" onkeydown="keyDown(event)" onpaste="checkWhitespace(event)">
                    </div>
                    <div class="form-group">
                        <p class="description"><strong>Introduce el nivel de acceso: 0=invalido, 1=usuario, 9=administrador</strong></p>
                        <select name="nivelacceso">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="9">9</option>
                        </select>
                    </div>

                </div>
                <div class="errores">
                    <?php
                            if(isset($_GET["correcto"]) && $_GET["correcto"] == 'true')
                            {
                            echo "<div style='color:green '>Usuario registrado correctamente</div>";
                            }
                        ?>
                        <?php
                            if(isset($_GET["vacio"]) && $_GET["vacio"] == 'true')
                            {
                            echo "<div style='color:red'>Debe rellenar todos los campos</div>";
                            }
                        ?>
                        <?php
                            if(isset($_GET["user"]) && $_GET["user"] == 'true')
                            {
                            echo "<div style='color:red'>El usuario o el nombre completo ya estan registrados</div>";
                            }
                    ?>
                <div class="mostrarPASS">
                    <input type="checkbox" onclick="Toggle()">
                    <b>Mostrar contraseña</b>
                </div>    
                </div>
                    <button name="register" class="btn">REGISTRAR</button>
                    <br>
                    <button onclick="location.href='../../index.php'" class="btn" type="button" >VOLVER AL CALENDARIO</button>
                </div>
                <img style="height: 35%;" src="../IMAGENES/fotologo.jpg" alt="logopagina">
            </div>
        </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>
</html>
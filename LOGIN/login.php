<?php 
session_start(); 
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
<script>
    function Toggle() {
        var temp = document.getElementById("typepass");
        if (temp.type === "password") {
            temp.type = "text";
        }else {
            temp.type = "password";
        }
    }
</script>
</head>
<body id="body">
<div class="divCabecera">
<button onclick="location.href='../../index.php'" class="botonsesion" >Volver al calendario</button>
<!-- ////////////////////////////////// -->
        <h1 class="tituloACC">ACCESO</h1>
<!-- ////////////////////////////////// -->
</div>
<form action="../CONEXIONES/conexionMYSQL.php" method="post">
<div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="modal-body">
                <h4 class="titulo">Introduce tu usuario y contraseña</h4>
                <div class="datos">    
                    <div class="form-group">
                        <span class="input-icon"><i class="fa fa-user"></i><b>Usuario</b></span>
                        <input name="username" type="user" class="form-control">
                    </div>
                    <div class="form-group">
                        <span class="input-icon"><i class="fas fa-key"></i><b>Contraseña</b></span>
                        <input id="typepass" name="password" type="password" class="form-control">
                    </div>
                </div>
                <div class="errores">
                    <?php
                        if(isset($_GET["fallo"]) && $_GET["fallo"] == 'true')
                        {
                            echo "<div style='color:red'>Usuario o contraseña invalido </div>";
                        }
                    ?>
                    <?php
                        if(isset($_GET["vacio"]) && $_GET["vacio"] == 'true')
                        {
                            echo "<div style='color:red'>Debes rellenar todos los campos</div>";
                        }
                    ?>
                <div class="mostrarPASS">
                    <input type="checkbox" onclick="Toggle()">
                    <b>Mostrar contraseña</b>
                </div>    
                </div>
                    <button name="submit" class="btn">Acceder</button>
                </div>
                <img src="../IMAGENES/fotologo.jpg" alt="logopagina">
            </div>
        </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>
</html>
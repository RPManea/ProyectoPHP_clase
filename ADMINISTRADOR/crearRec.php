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
    .errores{
        margin-bottom: 10px;
    }
    img{
        margin-left: -60px;
    }
</style>
</head>
<body id="body">
<div class="divCabecera">
<button onclick="location.href='../../index.php'" class="botonsesion" >Volver al calendario</button>
<!-- ////////////////////////////////// -->
        <h1 class="tituloACC">RECURSO</h1>
<!-- ////////////////////////////////// -->
</div>
<form action="./conexionRec.php" method="post" enctype="multipart/form-data">
<div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="modal-body">
                <h4 class="titulo">-Introduce los datos del nuevo recurso-</h4>
                <br>
                <br>
                <div class="datos">    
                    <div class="form-group">
                        <h4>Introducir Nombre del recurso</h4>
                        <input id="mitad1" name="nombre" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <h4>Introducir Ubicacion del recurso</h4>
                        <input id="mitad1" name= "ubicacion" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <h4>Introducir Aforo del recurso</h4>
                        <input id="mitad1" name="aforo" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <h4>Introducir Descripcion del recurso</h4>
                        <input id="mitad1" name="descripcion" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <h4>Introducir Contenido del recurso</h4>
                        <input id="mitad1" name="contenido" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <h4>Introducir foto del recurso</h4>
                        <input type="file" name="foto">
                        <!--<p>Para insertar la foto del recurso es necesario convertir la imagen a "base64" puede hacerlo pinchando <a href="https://base64.guru/converter/encode/image/jpg" target="_blank" class="link-info">"aqui"</b></a> o <a href="https://codebeautify.org/image-to-base64-converter" target="_blank" class="link-info">"aqui"</b></a>  
                        <input id="mitad1" name="foto" id="foto" type="text" maxlenght="1000000" class="form-control" required>-->
                    </div>

                </div>
                <div class="errores">
                    <?php
                        if(isset($_GET["correcto"]) && $_GET["correcto"] == 'true')
                        {
                        echo "<div style='color:green '>Registro insertado correctamente</div>";
                        }
                    ?>
                    <?php
                        if(isset($_GET["recurso"]) && $_GET["recurso"] == 'valido')
                        {
                        echo "<div style='color:red'>El recurso ya esta registrado</div>";
                        }
                    ?>
                    <?php
                        if(isset($_GET["error"]) && $_GET["error"] == 'true')
                        {
                        echo "<div style='color:red'>Ha habido un error al insertar el recurso</div>";
                        }
                    ?>  
                </div>
                    <button name="register" class="btn">INSERTAR RECURSO</button>
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
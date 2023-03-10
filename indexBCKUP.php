<?php
@session_destroy();
session_start();
require('./CONEXIONES/conexionBD.php') 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./calendario/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="./calendario/fullcalendar/lib/main.css">
    <script src="./calendario/js/jquery-3.6.0.min.js"></script>
    <script src="./calendario/js/bootstrap.min.js"></script>
    <script src="./calendario/fullcalendar/lib/main.min.js"></script>
    <script src="./calendario/fullcalendar/lib/locales/es.js"></script>
    <style>
        .botonsesion{
            margin-right: 120px;
            font-size: 10px;
        }
        .botonreservas{
            position: absolute;
            margin-right: 240px;
        }
        dd{
            max-width:500px;
            word-wrap:break-word;
        }

        .nombreUsuario{
            margin-top: 40px;
        }
        select{
            border-radius: 6px;
            font-size: 17px;
            background-color: #dda15e !important;
            border-color: 1px solid #dda15e !important;
            font-weight: bold;
            height: 42px;
            width: 100%;
            margin-right: 50px;
            transition:1s;
        }
        #divOpciones{
            margin-left: 65%;
            font-size: 10px;
        }
        .tituloprin{
            position: absolute;
        }
    </style>
</head>
<body class="cuerpoCalendario">
    <div class="divCabecera">
          <?php
            if(!empty($_SESSION['admin'])):
                
        ?>
            <p class="nombre_usuario" style="text-decoration: underline; color: #8D220B;">SESION ADMINISTRADOR<p style="margin-top: 30px; text-transform: uppercase;"> <br> <?php  echo($_SESSION['admin']); ?> <p></p>
            <td >
                <div id="divOpciones" class="btn-group">
                    <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option>Mas opciones</option>
                        <option value="./registro/registro.php">Crear usuarios</option>
                        <option value="./ADMINISTRADOR/crearRec.php">Crear recursos</option>
                        <option value="./ADMINISTRADOR/usuariosREG.php">Editar usuarios</option>
                        <option value="./ADMINISTRADOR/recursos.php">Editar recursos</option>
                        <option value="./ADMINISTRADOR/controlADMIN.php">Editar reservas</option>
                    </select>
                </div>
            </td>
            <a href="./LOGIN/logout.php"><button class="botonsesion"><b>Cerrar Sesi??n</b></button></a>
        <?php
            elseif(!empty($_SESSION['nombre'])):
        ?>
            <p class="nombre_usuario" style="text-decoration: underline;">Usuario conectado <p class="nombreUsuario" style="text-transform: uppercase;"> <br> <?php  echo($_SESSION['nombre']); ?> <p></p>
            <a href="./LOGIN/logout.php"><button class="botonsesion">Cerrar Sesi??n</button></a>
            <a href="./RESERVAS/reservas.php"><button>Reservar</button></a>
            <a href="./RESERVAS/misreservas.php"><button class="botonreservas">Ver mis reservas</button></a>
        <?php
            else:
        ?>
            <a href="./LOGIN/login.php"><button>Iniciar Sesion</button></a>
            <p class="nombre_usuario" style="text-decoration: underline;">No hay ninguna sesion iniciada</p>      
        <?php
            endif;
        ?>
<!-- ////////////////////////////////// -->
        <h1 class="tituloprin"><b>EVENTOS</b></h1>
<!-- ////////////////////////////////// -->
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles de Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <dl>
                            <dt class="text-muted">Nombre y ubicacion</dt>
                            <dd id="nombre_recurso" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Nombre Completo</dt>
                            <dd id="nombre_completo" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">T??tulo</dt>
                            <dd id="titulo" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Descripci??n</dt>
                            <dd id="descripcion" class=""></dd>
                            <dt class="text-muted">Fecha Inicio</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">Fecha Final</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                </div>
            </div>
        </div>
    </div>
<?php 
$schedules = $conn->query("SELECT * FROM schedule_list");

$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $sched_res[$row['id']] = $row;
}
?>
<?php 
if(isset($conn)) $conn->close();
?>
</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="./CALENDARIO/js/script.js"></script>

</html>
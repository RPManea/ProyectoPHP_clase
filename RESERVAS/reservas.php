<?php
    session_start();
    if (empty($_SESSION['nombre'])) {
        header("Location: ../LOGIN/logout.php");
        exit();
    }

    require("../CONEXIONES/conexionBD.php");
    $sql = ("SELECT DISTINCT ubicacion FROM recursos ORDER BY ubicacion");
    $result = mysqli_query($conn, $sql);
    $conn -> set_charset("utf8");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="./dynamicdrop.js"></script>
    <link rel="stylesheet" href="../CSS/reservas.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="../CALENDARIO/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../CALENDARIO/assets/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />
    <link rel="stylesheet" href="../CALENDARIO/assets/css/format.css">
    <section class="content-header">
</head>
<body  draggable=true>
    <!-- Div para crear un fondo negro detrás del menú popup de login y reserva -->
    <div id="fondo-negro"></div>
    <!-- Div para la cabecera con los desplegables -->
    <div class="desplegables">
        <!-- Tabla para organizar los desplegables dentro de la cabecera -->
        <table class="tabla-desplegables">
            <?php
                if (!empty($_SESSION['nombre'])):
            ?>
                <p class="nombre_usuario" style="text-decoration: underline;">Usuario conectado: <?php  echo($_SESSION['nombre']); ?></p>
            <?php
                else:
            ?>
                <p class="nombre_usuario" style="text-decoration: underline;">No hay ninguna sesion iniciada</p>
            <?php
                endif;
            ?>
            <?php
                if(isset($_GET["fallo"]) && $_GET["fallo"] == 'true'){
                    echo "<div style='color:red'>Ya hay una reserva en esa fecha/hora </div>";
                }
                    ?>
            <tr>
                <td rowspan="3" style="text-align:center;" ><h1>RESERVAS</h1></td>
                <td class="td-espacio"></td>
                <td class="td-nombres">Centro</td>
                <td class="td-nombres">Recurso</td>
                <td class="td-nombres" id="opcionesres">Opciones</td>
            </tr>
            <tr>  
                <tr>
                    <td>
                    </td>
                    <td class="td-ubi">
                        <select id="ubicacion" name="ubicacion" onchange="selectubi()">
                            <option value="">Selecciona un centro</option>
                            <?php
                                while ($rows = mysqli_fetch_array($result)){
                                    echo '<option class="opcion" value='.$rows["ubicacion"].'>'.$rows["ubicacion"].'</option>';
                                } 
                            ?>
                        </select>
                    </td>
                    <td id="nom">
                        <select id="nombre" name="nombre " onchange="selectnombre()">
                        <option>Selecciona un recurso</option>
                    </td>
                    <td >
                        <div id="divOpciones" class="btn-group">
                        <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option>Mas opciones</option>
                            <option value='../LOGIN/logout.php'>CERRAR SESION</option>
                            <option value='../../index.php'>VOLVER A CALENDARIO</option>
                            <option value='./misreservas.php'>VER MIS RESERVAS</option>
                        </select>
                        </div>
                    </td>
                </tr>
            </tr>
        </table>
    </div>
    <!-- Menú que se muestra cuando no hay nada seleccionado en los desplegables -->
    <div id="sin-seleccion">
        <p>Aún no hay nada que mostrar. <br><br>
        Seleccione un centro y un recurso.</p>
    </div>
    <!-- Tabla donde se muestra la información del recurso seleccionado -->
    <div class="" id="tabla"></div>
    <!-- Botón para efectuar  la reserva -->
    <div id="center">
        <button id="show-login" onclick="IDres()">Reservar</button>
    </div>
    <!--   Big container   -->
    <div class="popup">
    <!-- Botón de cerrar el menú popup de login -->
    <div class="close-btn">&times;</div>


                <div class="card wizard-card" data-color="orange" id="wizardProfile">
                <div class="form">
                    <form action="insertar.php" method="POST">


                    	<div class="wizard-header">
                        	<h3>
                        	   <b>Reservas</b> y Recursos <br>
                        	   <small>Salud</small>
                        	</h3>
                    	</div>

						<div class="wizard-navigation">
							<ul>
	                            <li><a href="#account" data-toggle="tab">Reserva</a></li>
	                            <li><a href="#address" data-toggle="tab">Datos</a></li>
	                        </ul>

						</div>

                        <div class="tab-content">
                            <div class="tab-pane" id="account">
                                <h4 class="info-text"> ¿Cuando y cuánto tiempo va a durar tu reserva? </h4>
                                <div class="row">

                                    <div class="col-sm-10 col-sm-offset-1">
                                        <?php
                                            $tiempo = time();
                                            $fechaAc = date("Y-m-d", $tiempo);
                                            $fechahoraActual = date("Y-m-d\TH:i", $tiempo);
                                            $horaAc = date("H:i", $tiempo)
                                        ?>
                                        <!--  -->
                                        <div class="reservas">
                                        <div class="choice" data-toggle="wizard-checkbox">
                                        <label for="from">Fecha de la reserva</label><input onchange="minHora()" id="fechares" name="fecha_reserva" required styles type="date" min="<?php echo $fechaAc;?>"> 

                                        <div class="input-group date" id="from">
                                        </div>
                                        <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->

                                        <div class="reservas">
                                            <div class="choice" data-toggle="wizard-checkbox">
                                            
                                            <label for="from">Hora de inicio </label><input onchange="minRes()" id="horaini1" name="hora_inicio" readonly required styles type="time" min="<?php echo $horaAc;?>"> 
                                            
                                        <div class='input-group date' id='from'>
                            </div>
                            
<!--  -->
                            <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="reservas">
                                        <form action="insertar.php" method="post">
                                            <div class="choice" data-toggle="wizard-checkbox" id="horafin1">
                                            <label for="from">Hora de finalización</label><input id="horafin1" name='hora_final' readonly required styles type='time'>
                                <div class='input-group date' id='to'>
                                                <input type="checkbox" name="jobb" value="Code">
                                                <div>
                                </div>
                                            </div>
                                        </div>
                                            <div>
                            <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="address">
                                <div class="row">
                                    <?php 
                                    ?>
                                    </div>
                                    <div class="Evento">
                                         <div class="form-group" id="recursoIDres">
                                            <input type="hidden" id="IDres" required class="form-control" name='id_recurso' readonly>
                                          </div>
                                    </div>
                                    <?php 
                                    
                                    ?>
                                    <div class="Evento">
                                         <div class="form-group">
                                            <label>Título(max 20 caracteres)</label>
                                            <input type="text" required class="form-control" name='titulo'>
                                          </div>
                                    </div>
                                    <div class="Evento">
                                         <div class="form-group">
                                         <label for="body">Descripción(max 200 caracteres)</label>
                                        <textarea maxlength="200" id="body" name="descripcion" required class="form-control" rows="3"></textarea>
                                          </div>
                                    </div>
                                    <div class="Evento">
                                         <div class="form-group">
                                            <label>Clase de Evento</label>
                                             <select name="country" required class="form-control">
                                                <option value="Importante"> Público </option>
                                                <option value="Privado"> Privado </option>
                                            </select>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-footer height-wizard">
                            <div class="pull-right">
                                <input type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='next' value='Siguiente' />
                                <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd btn-sm' name='next' value='Reservar' />
                                
                            </div>

                            <div class="pull-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='Anterior' />
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </form>
                </div>
            </div> <!-- wizard container -->
        </div>
        </div><!-- end row -->
    </div> <!--  big container -->

    <div class="footer">

    </div>

</div>
<div id="id_res"></div>
</body>
<!--   Core JS Files   -->
    <script src="../CALENDARIO/assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="../CALENDARIO/assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../CALENDARIO/assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="../CALENDARIO/assets/js/gsdk-bootstrap-wizard.js"></script>
    <script src="../CALENDARIO/assets/js/script.js"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="../CALENDARIO/assets/js/jquery.validate.min.js"></script>
    <script src="<?=$base_url?>../CALENDARIO/assets/js/calendar.js"></script>
</html>
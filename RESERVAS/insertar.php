<?php
require '../CONEXIONES/conexionBD.php';
session_start();

// variables que reciben los datos introducidos en el formulario de reserva.
$nombre_completo  = $_SESSION['nombre'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_reserva = $_POST['fecha_reserva'];
$horafin1 = $_POST['hora_final'];
$horaini1 = $_POST['hora_inicio'];
$id_recurso = $_POST['id_recurso'];
$sentencia = "SELECT nombre, ubicacion FROM recursos WHERE id_recurso = $id_recurso";
$nombre_recurso = mysqli_query($conn, $sentencia);
while ($row = $nombre_recurso->fetch_assoc()) {
    $nombreREC = $row['nombre'];
    $ubicacionREC = $row['ubicacion'];
}
// Variables para contatenar la fecha con la hora de inicio y de fin de los datos obtenidos para adaptarlo al formato en el que recibe los datos el calendario.
$hora_final = $fecha_reserva."T".$horafin1;
$hora_inicio = $fecha_reserva."T".$horaini1;
// Se intoducen los datos en la base de datos.
$comparacion1 = "SELECT * FROM schedule_list WHERE id_recurso = $id_recurso AND '$hora_inicio' BETWEEN hora_inicio AND hora_final";
$c1 = mysqli_query($conn, $comparacion1);
$comparacion2 = "SELECT * FROM schedule_list WHERE id_recurso = $id_recurso AND '$hora_final' BETWEEN hora_inicio AND hora_final";
$c2 = mysqli_query($conn, $comparacion2);
$comparacion3 = "SELECT * FROM schedule_list WHERE id_recurso = $id_recurso AND '$hora_inicio' = hora_inicio";
$c3 = mysqli_query($conn, $comparacion3);
$comparacion4 = "SELECT * FROM schedule_list WHERE id_recurso = $id_recurso AND '$hora_final' = hora_final";
$c4 = mysqli_query($conn, $comparacion4);
$comparacion5 = "SELECT * FROM schedule_list WHERE id_recurso = $id_recurso AND '$hora_inicio' <= hora_inicio AND '$hora_final' >= hora_final";
$c5 = mysqli_query($conn, $comparacion5);


if($c1->num_rows>=1){
    header("location: ./falloreserva.php");
}elseif($c2->num_rows>=1){
    header("location: ./falloreserva.php");
}elseif($c3->num_rows>=1){
    header("location: ./falloreserva.php");
}elseif($c4->num_rows>=1){
    header("location: ./falloreserva.php");
}elseif($c5->num_rows>=1){
    header("location: ./falloreserva.php");
}else{
    $insertar = "INSERT INTO schedule_list(nombre_completo, titulo, descripcion, hora_final, hora_inicio, id_recurso, nombre_recurso)
    VALUES('$nombre_completo','$titulo','$descripcion','$hora_final','$hora_inicio','$id_recurso', '$nombreREC-$ubicacionREC')";

    // Arrays con los días de la semana y los meses en Español para poder mostrar en la confirmación de la reserva cuando se ha efectuado.
    $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $Finicio=$hora_inicio;
    $hfinal=$hora_final;

    // Aquí hace referencia a los arrays para sacar el día de la semana y los meses en Español.
    $sqldate=$diassemana[date('w',strtotime($Finicio))]." ".date('d',strtotime($Finicio))." de ".$meses[date('n',strtotime($Finicio))-1]. " del ".date('Y',strtotime($Finicio));
    $horaini=date('H:i',strtotime($Finicio));
    $horafin=date('H:i',strtotime($hfinal));
    $resultado = mysqli_query($conn, $insertar);

    // Una vez se haya efectuado la reserva y se hayan introducido los datos en la base de datos se mostrará un menú de confirmación con los datos de la reserva.
    if ($resultado) {
        ?>
        <script>document.write("<div style='position:absolute;left:0px;width:100%;top:0px;bottom:0px;display:flex;justify-content:center;align-items:center;background: #dda15e;'><div style='min-width:50%;height:500px;background:#fefae0;box-shadow: 2px 2px 5px 5px rgba(0, 0, 0, 0.15); border-radius:10px;'><p style='margin-left:20px;margin-right:20px;text-align:center;font-family:sans-serif;font-weight:bold;font-size:30px;'>Su reserva se ha <br> efectuado correctamente</p><p style='font-family:sans-serif;font-weight:bold;font-size:22px; margin-left:8%; margin-top:70px'>Detalles de la reserva:</p><p style='font-family:sans-serif;font-size:19px; margin-left:8%; margin-top:30px'><b>Fecha: </b><?php echo $sqldate; ?></p><p style='font-family:sans-serif;font-size:19px; margin-left:8%; margin-top:-5px;'><b>Desde las: </b><?php echo $horaini; ?></p><p style='font-family:sans-serif;font-size:19px; margin-left:8%;margin-top:-5px;'><b>Hasta las: </b><?php echo $horafin; ?></p><p style='font-family:sans-serif;font-size:19px; margin-left:8%;margin-top:-5px;'><b>Por: </b><?php echo $nombre_completo; ?></p><button style='margin-top:50px;margin-left:8%;margin-right:8%;width:84%;leftpadding: 10px 20px;font-size: 15px;font-weight: 600;color: #222;background: #bc6c25;color:black;border: none;outline: none;cursor: pointer;border-radius: 5px; height:50px' onclick='reloadpag()'>Aceptar</button></div></div>");
        function reloadpag(){ window.location='../../index.php'}</script>";
        <?php
    }
}
?>
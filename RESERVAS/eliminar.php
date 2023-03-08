<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="../CALENDARIO/js/jquery-3.6.0.min.js"></script>
  <title>Document</title>
  <style>
    body{
      background-color: #fefae0;
    }
    #mitad1{
      width: 30% !important;
    }
    #mitad2{
      width: 30% !important;
      height: 100px !important;
    }
    #peque{
      width: 15% !important;
    }

    .reducirCelda{
        word-break: break-all; 
        width: 200px;
    }

    #colorbotones{
        background-color: #606c38;
    }
  </style>
</head>
<body>
<form method="post">
    <div class="form-group">
        <h4>CAMBIAR Titulo</h4>
        <span class="input-icon"><i class="fa fa-user"></i></span>
        <input id="mitad1" name="titulo" type="text" class="form-control" >
    </div>
    <div class="form-group">
        <h4>CAMBIAR Descripcion</h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <textarea maxlength="200" rows="3" id="mitad2" name="descripcion" type="text" class="form-control"></textarea>
    </div>
    <br>
    <h3 style="text-decoration:underline;">Si desea modificar la fecha o la hora es necesario rellenar los 3 campos.</h3>
    <br>
    <div class="form-group">
        <h4>CAMBIAR Fecha</h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <input id="peque" name="fecha" type="date" class="form-control">
    </div>
    <div class="form-group">
        <h4>CAMBIAR Hora de inicio</h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <input id="peque" name="hora_inicio" type="time" class="form-control">
    </div>
    <div class="form-group">
        <h4>CAMBIAR Hora de finalizacion</h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <input id="peque" name="hora_final" type="time" class="form-control">
    </div>
    <button id="colorbotones"  onclick="location.href='../../index.php'" type="button" class="btn btn-info">VOLVER A CALENDARIO</button>
    <?php
            if(!empty($_SESSION['admin'])):
        ?>
            <button id="colorbotones"  onclick="location.href='../ADMINISTRADOR/controlADMIN.php'" type="button" class="btn btn-info">VOLVER A RESERVAS</button>
        <?php
            elseif(!empty($_SESSION['nombre'])):
        ?>
            <button id="colorbotones"  onclick="location.href='./misreservas.php'" type="button" class="btn btn-info">VOLVER A MIS RESERVAS</button>
        <?php
            else:
        ?>
          &nbsp   
        <?php
            endif;
        ?>
    <button name="confmod" class="btn btn-warning">CONFIRMAR MODIFICACION</button>
</form>
</body>
</html>
<?php
require('../CONEXIONES/conexionBD.php');

// recibimos el dato 
$id = $_GET['id'];
if(isset($_GET["eliminar"])){
  $resultados = mysqli_query($conn, "DELETE FROM schedule_list WHERE id=$id");
  if($resultados==TRUE){
    if ($_SESSION['nombre']){
  // redirigimos a la tabla
      header( 'Location: ./misreservas.php' );
    }elseif ($_SESSION['admin']){
      header( 'Location: ../ADMINISTRADOR/controlADMIN.php' );
    }
  }else{
    echo $id . 'ERROR';
  }
}
if(isset($_GET['editar'])){
    //$consulta = "SELECT titulo, descripcion, hora_inicio, hora_final FROM schedule_list WHERE id=$idreser";
    //$resultados = mysqli_query($con, $consulta);
    $idres = $id;
    $sql = "SELECT * FROM schedule_list WHERE id = $idres";
    $results=mysqli_query($conn,$sql);
    if( mysqli_num_rows( $results ) > 0){
      echo("
          <table class='table table-responsive table-bordered'>
              <tr>
                  <th>TITULO</th>
                  <th>DESCRIPCION</th>
                  <th>HORA DE INICIO</th>
                  <th>HORA DE FINAL</th>
              </tr>
      ");
      while($fila = $results->fetch_row()){
          $f0 = $fila[0];
          $f1 = $fila[1];
          $f2 = $fila[2];
          $f3 = $fila[3];
          $ReservaID = $fila[5];
          $IDRecu = $fila[6];
          echo   
              '<tr>
                      <td>'.$f0.'</td>
                      <td class="reducirCelda">'.$f1.'</td>
                      <td>'.$f2.'</td>
                      <td>'.$f3.'</td>
              </tr>
              ';
      }
    }
    if(isset($_POST['confmod'])){
      $titulo = $_POST['titulo'];
      $descripcion = $_POST['descripcion'];
      $fecha_reserva = $_POST['fecha'];
      $horaini = $_POST['hora_inicio'];
      $horafin = $_POST['hora_final'];
      $hora_final = $fecha_reserva."T".$horafin;
      $hora_inicio = $fecha_reserva."T".$horaini;
      if(empty($titulo) && empty($descripcion) && empty($fecha_reserva) && empty($horaini) && empty($horafin)){
        if ($_SESSION['nombre']){
          // redirigimos a la tabla
          header( 'Location: ./misreservas.php?fallo=true' );
        }elseif ($_SESSION['admin']){
          header( 'Location: ../ADMINISTRADOR/controlADMIN.php?fallo=true' );
        }
        exit;
      }elseif(empty($fecha_reserva) || empty($horaini) || empty($horafin)){
        $sql2 = "UPDATE schedule_list SET 
        titulo = COALESCE(NULLIF('$titulo',''),titulo),  
        descripcion = COALESCE(NULLIF('$descripcion',''),descripcion)
        WHERE id = $idres";
        $result = mysqli_query($conn, $sql2);
        if ($_SESSION['nombre']){
          // redirigimos a la tabla
          header( 'Location: ./misreservas.php' );
        }elseif ($_SESSION['admin']){
          header( 'Location: ../ADMINISTRADOR/controlADMIN.php' );
        }
        
      }else{
        $comparacion1 = "SELECT * FROM schedule_list WHERE id_recurso = $IDRecu AND id != $ReservaID AND '$hora_inicio' BETWEEN hora_inicio AND hora_final";
        $c1 = mysqli_query($conn, $comparacion1);
        $comparacion2 = "SELECT * FROM schedule_list WHERE id_recurso = $IDRecu AND id != $ReservaID AND '$hora_final' BETWEEN hora_inicio AND hora_final";
        $c2 = mysqli_query($conn, $comparacion2);
        $comparacion3 = "SELECT * FROM schedule_list WHERE id_recurso = $IDRecu AND id != $ReservaID AND '$hora_inicio' = hora_inicio";
        $c3 = mysqli_query($conn, $comparacion3);
        $comparacion4 = "SELECT * FROM schedule_list WHERE id_recurso = $IDRecu AND id != $ReservaID AND '$hora_final' = hora_final";
        $c4 = mysqli_query($conn, $comparacion4);
        $comparacion5 = "SELECT * FROM schedule_list WHERE id_recurso = $IDRecu AND id != $ReservaID AND '$hora_inicio' <= hora_inicio AND '$hora_final' >= hora_final";
        $c5 = mysqli_query($conn, $comparacion5);

        if($c1->num_rows>=1){
            echo('<p style="color:red;">Reserva ya relizada</p>');
        }elseif($c2->num_rows>=1){
            echo('<p style="color:red;">Reserva ya relizada</p>');
        }elseif($c3->num_rows>=1){
            echo('<p style="color:red;">Reserva ya relizada</p>');
        }elseif($c4->num_rows>=1){
            echo('<p style="color:red;">Reserva ya relizada</p>');
        }elseif($c5->num_rows>=1){
            echo('<p style="color:red;">Reserva ya relizada</p>');
        }else{
        $sql1 = "UPDATE schedule_list SET 
        titulo = COALESCE(NULLIF('$titulo',''),titulo),  
        descripcion = COALESCE(NULLIF('$descripcion',''),descripcion), 
        hora_inicio=COALESCE(NULLIF('$hora_inicio',''),hora_inicio), 
        hora_final=COALESCE(NULLIF('$hora_final',''),hora_final) 
        WHERE id = $idres";
        $result = mysqli_query($conn, $sql1);
        if ($_SESSION['nombre']){
          // redirigimos a la tabla
          header( 'Location: ./misreservas.php' );
        }elseif ($_SESSION['admin']){
          header( 'Location: ../ADMINISTRADOR/controlADMIN.php' );
        }
        }
    } 
  }
}
?>

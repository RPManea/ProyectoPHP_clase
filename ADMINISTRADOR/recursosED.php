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

    .reducirCelda{
        word-break: break-all; 
        width: 200px;
    }

    #colorbotones{
        background-color: #606c38;
    }

    #peque{
      width: 5% !important;
    }
  </style>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <h4><b>CAMBIAR Nombre del recurso</b></h4>
        <span class="input-icon"><i class="fa fa-user"></i></span>
        <input id="mitad1" name="nombre" type="text" class="form-control" >
    </div>
    <div class="form-group">
        <h4><b>CAMBIAR Ubicacion del recurso</b></h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <textarea id="mitad1" name= "ubicacion" type="text" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <h4><b>CAMBIAR Aforo del recurso</b></h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <input id="mitad1" name="aforo" type="text" class="form-control">
    </div>
    <div class="form-group">
        <h4><b>CAMBIAR Descripcion del recurso</b></h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <input id="mitad1" name="descripcion" type="text" class="form-control">
    </div>
    <div class="form-group">
        <h4><b>CAMBIAR Contenido del recurso</b></h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <input id="mitad1" name="contenido" type="text" class="form-control">
    </div>
    <div class="form-group">
        <h4><b>CAMBIAR foto del recurso</h4>
        <input type="file" name="foto">
        <!--<p>Para cambiar la foto del recurso es necesario convertir la imagen a "base64" puede hacerlo pinchando <a href="https://base64.guru/converter/encode/image/jpg" class="link-info">"aqui"</b></a>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <input id="mitad1" name="foto" id="foto" type="text" maxlenght="1000000" class="form-control">-->
    </div>
    <button id="colorbotones"  onclick="location.href='../../index.php'" type="button" class="btn btn-info">VOLVER A CALENDARIO</button>
    <button id="colorbotones"  onclick="location.href='./recursos.php'" type="button" class="btn btn-info">VOLVER A RECURSOS</button>
    <button name="confmod" class="btn btn-warning">CONFIRMAR MODIFICACION</button>
</form>
</body>
</html>
<?php
require('../CONEXIONES/conexionBD.php');

// recibimos el dato 
$id = $_GET['id'];
session_start();
if(isset($_GET["eliminar"])){
  $resultados = mysqli_query($conn, "DELETE FROM recursos WHERE id_recurso=$id");
  if($resultados==TRUE){
      header( 'Location: ./recursos.php' );
  }else{
    echo $id . 'ERROR';
  }
}
if(isset($_GET['editar'])){
    //$consulta = "SELECT titulo, descripcion, hora_inicio, hora_final FROM schedule_list WHERE id=$idreser";
    //$resultados = mysqli_query($con, $consulta);
    $idres = $id;
    $sql = "SELECT * FROM recursos WHERE id_recurso = $idres";
    $results=mysqli_query($conn,$sql);
    if( mysqli_num_rows( $results ) > 0){
      echo("
          <table class='table table-responsive table-bordered'>
              <tr>
                  <th>NOMBRE RECURSO</th>
                  <th>UBICACION RECURSO</th>
                  <th>AFORO RECURSO</th>
                  <th>DESCRIPCION RECURSO</th>
                  <th>CONTENIDO RECURSO</th>
              </tr>
      ");
      while($fila = $results->fetch_row()){
          $f1 = $fila[1];
          $f2 = $fila[2];
          $f3 = $fila[3];
          $f4 = $fila[4];
          $f5 = $fila[5];
          echo   
              '<tr>
                      <td>'.$f1.'</td>
                      <td class="reducirCelda">'.$f2.'</td>
                      <td>'.$f3.'</td>
                      <td>'.$f4.'</td>
                      <td>'.$f5.'</td>
              </tr>
              ';
      }
    }

    if(isset($_POST['confmod'])){
        $nombre = $_POST['nombre'];
        $ubicacion = $_POST['ubicacion'];
        $aforo = $_POST['aforo'];
        $descripcion = $_POST['descripcion'];
        $contenido = $_POST['contenido'];
        $tipoArchivo=$_FILES['foto']['type'];
        $tamañoArchivo=$_FILES['foto']['size'];
        $imagenSubida=fopen($_FILES['foto']['tmp_name'],'r');
        $binariosImagen=fread($imagenSubida,$tamañoArchivo);
        $binariosImagen=mysqli_real_escape_string($conn,$binariosImagen);
        //$foto = $_POST['foto'];
        if(empty($nombre) && empty($ubicacion) && empty($aforo) && empty($descripcion) && empty($contenido) && empty($binariosImagen)){
            header( 'Location: ./recursos.php?fallo=true' );
            exit;
        }else{
            $sql = "UPDATE recursos SET 
                nombre = COALESCE(NULLIF('$nombre',''),nombre),  
                ubicacion = COALESCE(NULLIF('$ubicacion',''),ubicacion), 
                aforo=COALESCE(NULLIF('$aforo',''),aforo), 
                descripcion=COALESCE(NULLIF('$descripcion',''),descripcion),
                contenido=COALESCE(NULLIF('$contenido',''),contenido),
                foto=COALESCE(NULLIF('$binariosImagen',''),foto),
                tipo=COALESCE(NULLIF('$tipoArchivo',''),tipo)
                WHERE id_recurso = $idres";
            $result = mysqli_query($conn, $sql);
            header( 'Location: ./recursos.php' );
        }
    }
}
?>
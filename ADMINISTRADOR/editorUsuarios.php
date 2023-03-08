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
<form method="post">
    <div class="form-group">
        <h4>CAMBIAR Nombre de usuario(sin espacios)</h4>
        <span class="input-icon"><i class="fa fa-user"></i></span>
        <input id="mitad1" name="usuario" type="text" class="form-control" >
    </div>
    <div class="form-group">
        <h4>CAMBIAR Nombre Completo</h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <textarea id="mitad1" name="nombre" type="text" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <h4>CAMBIAR Contraseña(sin espacios)</h4>
        <span class="input-icon"><i class="fas fa-key"></i></span>
        <input id="mitad1" name="pass" type="password" class="form-control">
    </div>
    <div class="form-group">
         <h4>CAMBIAR Nivel de acceso</h4>
        <p class="description"><strong>Introduce el nivel de acceso: 0=invalido, 1=usuario, 9=administrador</strong></p>
        <select id="peque" name="nivel_acceso" onKeyDown="return false" type="number" min="0" max="9" class="form-control">
            <option hidden disabled selected value></option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="9">9</option>
        </select>
    </div>
    <button id="colorbotones"  onclick="location.href='../../index.php'" type="button" class="btn btn-info">VOLVER A CALENDARIO</button>
    <button id="colorbotones"  onclick="location.href='./usuariosREG.php'" type="button" class="btn btn-info">VOLVER A USUARIOS</button>
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
  $resultados = mysqli_query($conn, "DELETE FROM usuarios WHERE id_usuario=$id");
  if($resultados==TRUE){
      header( 'Location: ./usuariosREG.php' );
  }else{
    echo $id . 'ERROR';
  }
}
if(isset($_GET['editar'])){
    //$consulta = "SELECT titulo, descripcion, hora_inicio, hora_final FROM schedule_list WHERE id=$idreser";
    //$resultados = mysqli_query($con, $consulta);
    $idres = $id;
    $sql = "SELECT * FROM usuarios WHERE id_usuario = $idres";
    $results=mysqli_query($conn,$sql);
    if( mysqli_num_rows( $results ) > 0){
      echo("
          <table class='table table-responsive table-bordered'>
              <tr>
                  <th>NOMBRE USUARIO</th>
                  <th>NOMBRE COMPLETO</th>
                  <th>CONTRASEÑA</th>
                  <th>NIVEL_ACCESO</th>
              </tr>
      ");
      while($fila = $results->fetch_row()){
          $f1 = $fila[1];
          $f2 = $fila[2];
          $f3 = $fila[3];
          $f4 = $fila[4];
          echo   
              '<tr>
                      <td>'.$f1.'</td>
                      <td class="reducirCelda">'.$f2.'</td>
                      <td>'.$f3.'</td>
                      <td>'.$f4.'</td>
              </tr>
              ';
      }
    }

    if(isset($_POST['confmod'])){
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $pass = $_POST['pass'];
        $nivel_acceso = $_POST['nivel_acceso'];
        $password = password_hash($pass, PASSWORD_DEFAULT);  
        if(empty($usuario) && empty($nombre) && empty($pass) && empty($nivel_acceso)){
            header( 'Location: ../ADMINISTRADOR/usuariosREG.php?fallo=true' );
            exit;
        }else{
            $sql = "UPDATE usuarios SET 
                usuario = COALESCE(NULLIF('$usuario',''),usuario),  
                nombreCompleto = COALESCE(NULLIF('$nombre',''),nombreCompleto), 
                pass=COALESCE(NULLIF('$password',''),pass), 
                nivel_acceso=COALESCE(NULLIF('$nivel_acceso',''),nivel_acceso) 
                WHERE id_usuario = $idres";
            $result = mysqli_query($conn, $sql);
            header( 'Location: ../ADMINISTRADOR/usuariosREG.php' );
        }
    }
}
?>
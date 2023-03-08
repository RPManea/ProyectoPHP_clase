<?php 
require('./conexionBD.php');

if(isset($_POST['submit'])){

	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	
  $sql = "SELECT usuario, nombreCompleto, pass, nivel_acceso FROM usuarios WHERE usuario = '$username'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $nomCOM = $row['nombreCompleto'];
  $nivel = $row['nivel_acceso'];
  $usuario = $row['usuario'];
if(empty($username) || empty($password))  
  header('location: ../LOGIN/login.php?vacio=true');
elseif ($result->num_rows == 1 && $username==$row['usuario'] && password_verify($password, $row['pass']) ) {
  session_destroy();
  session_start();
    if($nivel == '9'){
      $_SESSION['admin'] = $nomCOM;
      header('location: ../../index.php');
    }elseif($nivel == '1'){ 
      $_SESSION['nombre'] = $nomCOM;
      header('location: ../../index.php');}
    else{
      header("location: ../LOGIN/login.php?fallo=true");
    }
}else{
  header("location: ../LOGIN/login.php?fallo=true");
}
} // end of isset
$conn->close();
 
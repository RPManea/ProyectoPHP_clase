<?php
require("../CONEXIONES/conexionBD.php"); 
          if(isset($_POST["register"])){
               $_POST = array_map("trim", $_POST);
               $username = mysqli_real_escape_string($conn, $_POST["username"]);  
               $nombreCompleto = mysqli_real_escape_string($conn, ($_POST["nombreCompleto"]));  
               $password = mysqli_real_escape_string($conn, $_POST["password"]); 
               $nivel = mysqli_real_escape_string($conn, $_POST["nivelacceso"]); 
               $sql = "SELECT usuario FROM usuarios WHERE usuario = '$username'";
               $result = $conn->query($sql);
               $consulta = mysqli_fetch_assoc($result);
               if($consulta >= 1){
                    header("location: registro.php?user=true");

               }elseif(!empty($_POST["nombreCompleto"] && !empty($_POST["username"]) && !empty($_POST["password"]))){ 
                    $password = password_hash($password, PASSWORD_DEFAULT);  
                    $query = "INSERT INTO usuarios(usuario, nombreCompleto, pass, nivel_acceso) VALUES('$username', '$nombreCompleto', '$password', '$nivel')";  
                    if(mysqli_query($conn, $query)){  
                         header("location: registro.php?correcto=true");

                    }else{
                         header("location: registro.php?vacio=true");
                    }

               }else{
                    header("location: registro.php?vacio=true");
               }
          }    
?>
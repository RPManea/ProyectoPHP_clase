<?php
require("../CONEXIONES/conexionBD.php"); 
          if(isset($_POST["register"])){
               $_POST = array_map("trim", $_POST);
               $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);  
               $ubicacion = mysqli_real_escape_string($conn, ($_POST["ubicacion"]));  
               $aforo = mysqli_real_escape_string($conn, $_POST["aforo"]); 
               $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);
               $contenido = mysqli_real_escape_string($conn, $_POST["contenido"]);
               $tipoArchivo=$_FILES['foto']['type'];
               $tamañoArchivo=$_FILES['foto']['size'];
               $imagenSubida=fopen($_FILES['foto']['tmp_name'],'r');
               $binariosImagen=fread($imagenSubida,$tamañoArchivo);
               $binariosImagen=mysqli_real_escape_string($conn,$binariosImagen);
               //$foto = mysqli_real_escape_string($conn, $_POST["foto"]);
               $sql = "SELECT nombre, ubicacion FROM recursos WHERE nombre = '$nombre' AND ubicacion = '$ubicacion'";
               $result = $conn->query($sql);
               $consulta = mysqli_fetch_assoc($result);
               if($consulta >= 1){
                    header("location: ./crearRec.php?recurso=valido");

               }elseif(!empty($nombre) && !empty($ubicacion) && !empty($aforo) && !empty($descripcion) && !empty($contenido) && !empty($binariosImagen)){ 
                    $query = "INSERT INTO recursos(nombre, ubicacion, aforo, descripcion, contenido, foto, tipo) VALUES('$nombre', '$ubicacion', '$aforo', '$descripcion', '$contenido', '$binariosImagen','$tipoArchivo')";  
                    if(mysqli_query($conn, $query)){  
                         header("location: ./crearRec.php?correcto=true");

                    }
               }else{
                    header("location: ./crearRec.php?error=true");
               }
          }    
?>
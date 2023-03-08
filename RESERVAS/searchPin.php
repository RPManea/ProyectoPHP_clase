<?php
    // Funcion que muestra los recursos de la base de datos en el desplegable según el centro seleccionado.
    function findnombre(){
        require("../CONEXIONES/conexionBD.php");
        $k = $_POST['id'];
        $sql = ("SELECT nombre FROM recursos WHERE ubicacion= '{$k}' ");
        $result = mysqli_query($conn, $sql);

        echo '<select id="nombre" name="nombre" onchange="selectnombre()">';
        echo '<option style="color: gray">Selecciona un recurso</option>';
        while ($rows = mysqli_fetch_array($result)){
            echo '<option value='.$rows["nombre"].'>'.$rows["nombre"].'</option>';
        }

        echo "</select>";
    }

    // FUncion que retorna la consulta SQL con todos los resultados
	function returnID(){
        require("../CONEXIONES/conexionBD.php");
		$k = $_POST['id1'];
        $l = $_POST['id2'];
		$sql = ("SELECT * FROM recursos WHERE ubicacion= '{$k}' AND nombre='{$l}'");
        $id_rec = mysqli_query($conn, $sql);
		
		return $id_rec;
	}

    // Funcion que muestra la información de los recursos elegidos a través de los desplegables (imagen; datos de aforo, descropción, contenido...; nombre del centro y del recurso).
    function disptabla(){
        require("../CONEXIONES/conexionBD.php");
        $k = $_POST['id1'];
        $l = $_POST['id2'];
		$sql = ("SELECT * FROM recursos WHERE ubicacion= '{$k}' AND nombre='{$l}'");
        $result = mysqli_query($conn, $sql);
        
            while ($rows = mysqli_fetch_array($result)){
                echo '<div class="titulo-recurso">';
                /*echo $rows['nombre']; ?> - <?php echo $rows['ubicacion'];*/
                $nombre = $rows['nombre'];
                $ubicacion = $rows['ubicacion'];
                echo '<p id="NombreEnviar">'.$nombre.' - '.$ubicacion.'</p>';
                echo '</div>';

                echo '<div class="subtabla1">';
                echo '<table>';
                ?> 
                    <tr>   
                      <td class="contenido" style="margin-bottom:45px;"><img style="border-radius:15px; margin-bottom:30px; max-width: 80%; max-height: 400px;" src="data:<?php echo $rows['tipo']; ?>;base64,<?php echo base64_encode($rows["foto"]);?>"></td>
                    </tr>
                    
                <?php
                echo '</table>';
                echo '</div>';
                echo '<div class="subtabla2">';
                echo '<table>';
                ?>
                    <tr>
                        <td style="font-size:23px;font-weight:bolder;">Especificaciones:</td>
                        <td id="IDRecRes" style="font-size:0px;"><?php echo $rows['id_recurso']; ?></td>
                    </tr>
                    <tr>
                        <td class="contenido cabecera" style="margin-top:15px"><b style="margin-right:10px">Aforo:</b> <?php echo $rows['aforo']; ?></td>
                    </tr>
                    
                    <tr>
                        <td class="contenido cabecera"><b>Descripción:</b></td>
                        <td class="contenido"><?php echo $rows['descripcion']; ?></td>
                    </tr>
                    <tr><td style="height:20px;"></td></tr>
                    <tr>
                        <td class="contenido cabecera"><b>Contenido:</b></td>
                        <td class="contenido"><?php echo $rows['contenido']; ?></td>
                    </tr>
                    <tr><td style="height:50px;"></td></tr>
                     
                <?php         
            }             
        echo '</table>';
        echo '</div>';
    }
    
    // Función que muestra las reservas efectuadas en los proximos días de ese mismo recurso.
    function dispreservas(){
        $id_rec2 = 0;
        include("../CONEXIONES/conexionBD.php");
        $id_rec = returnID();
        while ($row = mysqli_fetch_array($id_rec)){
            $id_rec2 = $row['id_recurso'];
        }
        
        
        
        $time = time();
        $fechaActual = date("Y-m-d\TH:i", $time);
        $horaActual = date("H:i", $time);
        // AND hora_final>='$horaActual'
        
        $sql = ("SELECT * FROM schedule_list WHERE id_recurso= '{$id_rec2}' AND hora_final>='$fechaActual' ORDER BY hora_inicio");
        $result = mysqli_query($conn, $sql);
        
        echo '<div style="margin-top:150px" id="titulo-reservas">';
        echo '</div>';
        echo '<div style="margin-top:150px" id="subtabla3">';
        echo '<table>';
            while($rows=mysqli_fetch_assoc($result)) {

                $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

                $Finicio=$rows["hora_inicio"]; 
                $hfinal=$rows["hora_final"];
                $sqldate=$diassemana[date('w',strtotime($Finicio))]." ".date('d',strtotime($Finicio))." de ".$meses[date('n',strtotime($Finicio))-1]. " del ".date('Y',strtotime($Finicio))." desde las ".date('H:i',strtotime($Finicio))." hasta las ".date('H:i',strtotime($hfinal));                    
                    ?>
                    <tr>
                        <td class="contenido_tabla"><p>- Reservado el <?php echo $sqldate;?> por <?php echo $rows["nombre_completo"];?></p></td>
                    </tr>
                    <tr style="height:15px"></tr>
            
                    <?php
            }
            echo '</table>';
            echo '</div>';

    }
    
    // Condicional para llamar a las funciones desde el dynamicdrop.js
    $k = $_POST['key'];
    if ($k=='ubi'){
        findnombre();
    } 
    elseif ($k=='nom'){
        disptabla();
        dispreservas();
    }

?>
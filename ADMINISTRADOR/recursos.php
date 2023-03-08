<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../CALENDARIO/js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../CSS/login.css">
    <head>
    <button  onclick="location.href='../../index.php'" type="button" class="btn">VOLVER A CALENDARIO</button>
    <script language="JavaScript" type="text/javascript">
        function checkDelete(){
            return confirm('El recurso se va a eliminar, ¿Estas seguro?');
        }
    </script>
    </head>
    <style>
        button{
            display:flex;
            align-items: center;
            justify-content:center;
        }
        .btn-info {
            color: white;
            background-color: rgb(0, 94, 92);
            border-color: rgb(0, 94, 92);
        }
        .btn-info:hover {
            color: white;
            background-color: rgb(0, 94, 92);
            border-color: rgb(0, 94, 92);
        }
        .reducirCelda{
            word-break: break-all; 
            width: 200px;
        }

        th, td{
            text-align: center !important;
        }
    </style>
    <?php
      if(isset($_GET["fallo"]) && $_GET["fallo"] == 'true'){
          echo "<div style='color:red'>No has modificado ningun campo. </div>";
        }
    ?>
<body id="body">

    <?php
    include '../CONEXIONES/conexionBD.php';
    session_start();
    if (empty($_SESSION['admin'])) {
        header("Location: ../LOGIN/logout.php");
        exit();
    }
    if ($_SESSION['admin']){
        $sql = "SELECT * FROM recursos";
        $resultado=mysqli_query($conn,$sql);
        $a = 1;
        
        //Valida que la consulta esté bien hecha
        if( mysqli_num_rows( $resultado ) > 0){
            echo("
                <table class='table table-responsive table-bordered'>
                    <tr>
                        <th>ID DEL RECURSO</th>
                        <th>NOMBRE RECURSO</th>
                        <th>UBICACION RECURSO</th>
                        <th>AFORO RECURSO</th>
                        <th>DESCRIPCION RECURSO</th>
                        <th>CONTENIDO RECURSO</th>
                        <th>ACCIONES</th>
                    </tr>
            ");
            while($fila = $resultado->fetch_row()){
                $f0 = $fila[0];
                $f1 = $fila[1];
                $f2 = $fila[2];
                $f3 = $fila[3];
                $f4 = $fila[4];
                $f5 = $fila[5];
                echo   
                    '<tr>
                            <td class="reducirCelda">'.$f0.'</td>
                            <td>'.$f1.'</td>
                            <td>'.$f2.'</td>
                            <td class="reducirCelda">'.$f3.'</td>
                            <td>'.$f4.'</td>
                            <td>'.$f5.'</td>
                            <td>                           
                                <form method="get" action="recursosED.php">
                                    <input type="hidden" name="id" value='.$f0.'>
                                    <button name="eliminar" id="btnRES" onclick="return checkDelete()" class="btn-danger">Eliminar</button>
                                    <button name="editar" id="btnRES" class="btn-primary">Editar</button>
                                </form>
                            </td>
                    </tr>
                    ';
            }
            $resultado->close();
        }else{
            echo ("<h1>No hay ningun recurso</h1>");
        }
        mysqli_close( $conn );
    }
    ?>
</div>
</body>
</html>
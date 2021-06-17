<?php

// Carga configuracion
require("config.php");


if ((! isset ( $_POST['IdCaso'] )) || (! isset ( $_POST['Nombre'] )) || (! isset ( $_POST['Tipo'] )) || (! isset ( $_POST['Fecha'] )))  { echo "0"; return; }

$caso=$_POST['IdCaso'];
$name=$_POST['Nombre'];
$tipo=$_POST['Tipo'];
$date=$_POST['Fecha'];

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }



//echo json_encode(array('TRAZA' => 1));
//response= "TRAZA:".$_GET['Traza'].", FECHA:".$_GET['Fecha'];

$query = mysqli_query($db, "INSERT INTO modelos (ID_CASO, Nombre_del_modelo, Tipo, Fecha_hora_de_alta) VALUES (".$caso.", '".$name."','".$tipo."', '".$date."');");
$query = mysqli_query($db, "COMMIT;"); 

$resultado=array('Nombre' => $name, 'Tipo' => $tipo, 'Fecha' => $date);
$respuesta[0]=$resultado;

echo json_encode($respuesta);
mysqli_close($db);
?>
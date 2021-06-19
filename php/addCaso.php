<?php

// Carga configuracion
require("config.php");


if ((! isset ( $_POST['Traza'] )) || (! isset ( $_POST['Fecha'] )))  { echo "0"; return; }

$tra=$_POST['Traza'];
$date=$_POST['Fecha'];

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }


//Ejecuta la query
$query = mysqli_query($db, "INSERT INTO casos (Trazabilidad_hospital, Fecha_hora_de_alta) VALUES ('".$tra."', '".$date."');");
$query = mysqli_query($db, "COMMIT;"); 

//Generamos el Json de salida por mostrar algo
$resultado=array('Traza' => $tra, 'Fecha' => $date);
$respuesta[0]=$resultado;

echo json_encode($respuesta);
mysqli_close($db);
?>
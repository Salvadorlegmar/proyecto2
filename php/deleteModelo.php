<?php

// Carga configuracion
require("config.php");

$conn = mysqli_connect("localhost", $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conection="Connected successfully";


if ((! isset ( $_POST['IDModelo'] )))  { echo "0"; return; }

// Variables
$modelo=$_POST['IDModelo'];

//Borramos el Modelo en las dos tablas
$sql1=mysqli_query($conn, "DELETE FROM stls WHERE ID_MODELO=".$modelo);
$sql2=mysqli_query($conn, "DELETE FROM modelos WHERE ID_MODELO=".$modelo);


$resultado=array('ID' => $modelo);
$respuesta[0]=$resultado;

echo json_encode($respuesta);
mysqli_close($conn)
?>
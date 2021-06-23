<?php

// Carga configuracion
require("config.php");


$conn = mysqli_connect("localhost", $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conection="Connected successfully";


if ((! isset ( $_POST['IDCaso'] )))  { echo "0"; return; }

// Variables
$caso=$_POST['IDCaso'];

//Borramos el caso en las tres tablas
$sql1=mysqli_query($conn, "DELETE FROM stls WHERE ID_CASO=".$caso);
$sql2=mysqli_query($conn, "DELETE FROM modelos WHERE ID_CASO=".$caso);
$sql3=mysqli_query($conn, "DELETE FROM casos WHERE ID_CASO=".$caso);

$resultado=array('ID' => $caso);
$respuesta[0]=$resultado;

echo json_encode($respuesta);
mysqli_close($conn);
?>
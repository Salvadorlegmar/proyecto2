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

$sql1=mysqli_query($db, "DELETE FROM stls WHERE ID_MODELO=".$modelo);
$sql2=mysqli_query($db, "DELETE FROM modelos WHERE ID_MODELO=".$modelo);


$respuest="OK";

echo json_encode($respuesta);
mysqli_close($db)
?>
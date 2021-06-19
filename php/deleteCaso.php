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

$sql1=mysqli_query($db, "DELETE FROM stls WHERE ID_CASO=".$caso);
$sql2=mysqli_query($db, "DELETE FROM modelos WHERE ID_CASO=".$caso);
$sql3=mysqli_query($db, "DELETE FROM casos WHERE ID_CASO=".$caso);

$respuest="OK";

echo json_encode($respuesta);
mysqli_close($db);
?>
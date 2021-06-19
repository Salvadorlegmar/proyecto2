<?php

// Carga configuracion
require("config.php");

if ((! isset ( $_POST['IDStl'] )))  { echo "0"; return; }


$conn = mysqli_connect("localhost", $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conection="Connected successfully";


//echo $conection;
//echo "IDSTL=".$_GET['IDStl'];

// Variables
/*$stl=$_GET['IDStl'];

$sql1=mysqli_query($db, "DELETE FROM stls WHERE ID_STL=".$stl);


$resultado=array('ID' => $stl);*/
$resultado=$conection;
$respuesta[0]=$resultado;

echo json_encode($respuesta);
mysqli_close($db)
?>
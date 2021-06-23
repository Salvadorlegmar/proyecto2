<?php
// Carga configuracion
require("config.php");


$conn = mysqli_connect("localhost", $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conection="Connected successfully";


if ((! isset ( $_POST['IDSTL'] ))) { echo "0"; return; }
// Variables
$stl=$_POST['IDSTL'];



//Borramos el STL en la tabla stls
$sql1=mysqli_query($conn, "DELETE FROM stls WHERE ID_STL=".$stl);


$resultado=array('ID' => $stl);
$respuesta[0]=$resultado;

echo json_encode($respuesta);
mysqli_close($conn)

?>
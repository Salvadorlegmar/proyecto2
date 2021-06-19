<?php

// Carga configuracion
require("config.php");

if ((! isset ( $_POST['IDStl'] )) || (! isset ( $_POST['Nombre'] )) || (! isset ( $_POST['Color'] )) || (! isset ( $_POST['Visible'] )) || (! isset ( $_POST['Transp'] )) ||(! isset ( $_POST['Orden'] )))  { echo "0"; return; }

$idstl=$_POST['IDStl'];
$name=$_POST['Nombre'];
$color=$_POST['Color'];
$visible=$_POST['Visible'];
$transp=$_POST['Transp'];
$orden=$_POST['Orden'];

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }


//Elecutamos la query
$query = mysqli_query($db, "UPDATE stls SET Nombre_del_elemento='".$name."', Color='".$color."', Visible=".$visible.", Transparencia=".$transp.", Orden=".$orden." WHERE ID_STL=".$idstl.";");
$query = mysqli_query($db, "COMMIT;"); 

//Devolvemos algo en el JSON
$resultado=array('Nombre' => $name);
$respuesta[0]=$resultado;

echo json_encode($respuesta);
mysqli_close($db);
?>
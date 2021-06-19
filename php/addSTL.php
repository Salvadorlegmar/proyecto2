<?php

// Carga configuracion
require("config.php");

//if ((! isset ( $_POST['IdCaso'] )) || (! isset ( $_POST['IdModelo'] )) || (! isset ( $_POST['Nombre'] )) || (! isset ( $_POST['Color'] )) || (! isset ( $_POST['Visible'] )) || (! isset ( $_POST['Transp'] )) ||(! isset ( $_POST['Orden'] )))  { echo "0"; return; }

$caso=$_GET['IdCaso'];
$modelo=$_GET['IdModelo'];
$name=$_GET['Nombre'];
$color=$_GET['Color'];
$color=explode("#",$color)[1];
$visible=$_GET['Visible'];
if($visible=="si"){
    $visible=1;
}else{
    $visible=0;
}
$transp=$_GET['Transp'];
$orden=$_GET['Orden'];

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }


//$consulta= "INSERT INTO stls (ID_CASO, ID_MODELO, Nombre_del_elemento, Color, Visible , Transparencia, Orden) VALUES (".$caso.", ".$modelo.", '".$name."','".$color."', ".$visible.", ".$transp.", ".$orden.");";
//echo $consulta;
//echo json_encode(array('TRAZA' => 1));
//response= "TRAZA:".$_GET['Traza'].", FECHA:".$_GET['Fecha'];

$query = mysqli_query($db, "INSERT INTO stls (ID_CASO, ID_MODELO, Nombre_del_elemento, Color, Visible , Transparencia, Orden) VALUES (".$caso.", ".$modelo.", '".$name."','".$color."', ".$visible.", ".$transp.", ".$orden.");");
$query = mysqli_query($db, "COMMIT;"); 

$resultado=array('Nombre' => $name);
$respuesta[0]=$resultado;

echo json_encode($respuesta);
mysqli_close($db);
?>
<?php

// Carga configuracion
require("config.php");


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

//Ejecuta la query
$query = mysqli_query($db, "INSERT INTO stls (ID_CASO, ID_MODELO, Nombre_del_elemento, Color, Visible , Transparencia, Orden) VALUES (".$caso.", ".$modelo.", '".$name."','".$color."', ".$visible.", ".$transp.", ".$orden.");");
$query = mysqli_query($db, "COMMIT;"); 

//Generamos el Json de salida por mostrar algo
$resultado=array('Nombre' => $name);
$respuesta[0]=$resultado;

echo json_encode($respuesta);
mysqli_close($db);
?>
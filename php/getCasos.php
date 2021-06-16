<?php

// Carga configuracion
require("config.php");


// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }


// Variables
$IDs[] = array();
$Trazas[] = array(); 
$Fechas[] = array();
$i=0;


// Realiza la consulta - Obtenemos los ID de los streams que forman la tarifa correspondiente
$sql=mysqli_query($db, "SELECT DISTINCT ID_CASO, Trazabilidad_hospital, Fecha_hora_de_alta FROM casos;");

while($row = mysqli_fetch_array($sql)) {
    $IDs[$i] = $row[0];
    $Trazas[$i] = $row[1]; 
    $Fechas[$i] = $row[2];
    $i=$i+1;
}
$max=$i;

// Tranforma array de resultado en json
for($j=0; $j<$max; $j++) {

    $resultado=array('Id'=> $IDs[$j], 'Traza' => $Trazas[$j], 'Fecha' => $Fechas[$j]);
    $respuesta[$j]=$resultado;
}

echo json_encode($respuesta);
mysqli_close($db);
<?php

// Carga configuracion
$DB_LOCAL_SERVER = "Localhost";
$DB_USER= "root";
$DB_PASS = "anvimur2001lrvfg";
$DB_NAME = "Cella2";

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }


// Variables
$IDs[] = array();
$i=0;


// Realiza la consulta - Obtenemos los ID de los Casos
$sql=mysqli_query($db, "SELECT DISTINCT ID_CASO FROM casos;");

while($row = mysqli_fetch_array($sql)) {
    $IDs[$i] = $row[0];
    $i=$i+1;
}
$max=$i;

// Tranforma array de resultado en json
for($j=0; $j<$max; $j++) {

    $resultado=array('ID'=> $IDs[$j]);
    $respuesta[$j]=$resultado;
}

echo json_encode($respuesta);
mysqli_close($db);

?>
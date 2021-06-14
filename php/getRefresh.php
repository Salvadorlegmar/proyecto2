<?php

// Carga configuracion
require("../txt/config.php");

// Comprueba que se pasen los datos del dispositivo
if ( ! isset ($_GET ['Mac']) ){ echo "0" ; return ;  }

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }

// Realiza la consulta - Obtenemos el atributo NeedRefresh del dispositivo pasado por su MAC correspondiente.
$sql=mysqli_query($db, "SELECT DISTINCT NeedRefresh, TariffId FROM Device WHERE Mac='". $_GET ['Mac'] ."';");

$row = mysqli_fetch_array($sql);
$result=$row[0];
$tarif=$row[1];

// Reseteamos el valor de la variable NeedRefresh del dispositivo correspondiente.
if ($result == 1) {
	$query = mysqli_query($db, "UPDATE Device SET NeedRefresh=0 WHERE Mac='". $_GET ['Mac'] ."';");
}

$respuesta[] = array();
$resultado = array('isRefresh' => $result, 'tarifa' => $tarif);

$respuesta[0] = $resultado;

///////////////////////////////////////
echo json_encode($respuesta);
mysqli_close($db);
?>



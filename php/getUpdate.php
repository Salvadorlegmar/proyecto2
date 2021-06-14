<?php

// Carga configuracion
require("../txt/config.php");

// Comprueba que se pasen los datos del dispositivo
if ( ! isset ($_GET ['Mac']) ){ echo "0" ; return ;  }


// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }

// Realiza la consulta - Obtenemos el atributo NeedRefresh del dispositivo pasado por su MAC correspondiente.
$sql=mysqli_query($db, "SELECT DISTINCT Mac, Firmware, SerialNumber, NeedRefresh, UpdateFirm FROM Device WHERE Mac='". $_GET ['Mac'] ."';");


$row = mysqli_fetch_array($sql);
$verFirm="";
if ($row[4] == 1){
	//echo "PARA A350:". strpos($row[2],"A350") .", PARA A331:". strpos($row[2],"A331") .", PARA Z121:".strpos($row[2],"Z121 <br/>");
	$query = mysqli_query($db, "UPDATE Device SET UpdateFirm=0 WHERE Mac='". $_GET ['Mac'] ."';");
	if (strpos($row[2],"A350") === 0) {
		//echo "PASO1";
		$verFirm="http://tv.holafibra.com/firmware_hybroad/A350/A350_Anvimur_3.7.8614.zip";
	}else{
		if (strpos($row[2],"A331") === 0) {
			//echo "PASO2";
        		$verFirm="http://tv.holafibra.com/firmware_hybroad/A331/A331_Anvimur_3.7.8024.zip";
		}
	}
}


$respuesta[] = array();
$resultado = array('Newfirm' => $verFirm);

$respuesta[0] = $resultado;

///////////////////////////////////////
echo json_encode($respuesta);
mysqli_close($db);
?>



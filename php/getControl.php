<?php

// Carga configuracion
require("../txt/config.php");

// Comprueba que se pasen los datos del dispositivo
if ((! isset ( $_POST['Mac'] )) || (! isset ( $_POST['System'] )))  { echo "0"; return; }
//if ((! isset ( $_POST['Mac'] )) || (! isset ( $_POST['System'] )) || (! isset ( $_POST['Oper'] )))  { echo "0"; return; }

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }

// Realiza la consulta - Receptor que coincida la MAC y este activo
$sql=mysqli_query($db, "SELECT Mac, Enable, EndDate, StartDate, SerialNumber FROM Device where Mac='".$_POST['Mac']."' AND Enable='1';");
$res = 0;

#Función que comprueba si una IP pertenece a un rango
function ip_in_range($lower_range_ip_address, $upper_range_ip_address, $needle_ip_address)
{
        # ip2long traslada la ip a una representación númerica 
        $min    = ip2long($lower_range_ip_address);
        $max    = ip2long($upper_range_ip_address);
        $needle = ip2long($needle_ip_address);

return (($needle >= $min) AND ($needle <= $max));
}

// Trata la respuesta
while($row=mysqli_fetch_row($sql)) {
	// Obtiene IP
	$ip = get_real_ip();

//	if ((ip_in_range("85.217.132.2", "85.217.132.254",$ip) == 1) || (ip_in_range("85.217.133.2", "85.217.133.254",$ip) == 1)
//	||  (ip_in_range("185.251.212.2", "185.251.212.254",$ip) == 1) || (ip_in_range("154.61.225.2", "154.61.225.254",$ip) == 1)
//	||  (ip_in_range("195.82.124.2", "195.82.124.254",$ip) == 1) || (ip_in_range("185.251.214.2", "185.251.214.254",$ip) == 1)
//	||  (ip_in_range("185.251.215.2", "185.251.215.254",$ip) == 1) || (ip_in_range("185.251.213.2", "185.251.213.254",$ip) == 1)
//	||  (ip_in_range("185.246.12.2", "185.246.12.254",$ip) == 1) || (ip_in_range("185.246.14.2", "185.246.14.254",$ip) == 1)
//       ||  ($ip == "2.139.191.124") || ($ip == "149.14.241.242") || ($ip == "90.171.185.171" ) || ($ip == "149.62.176.5"))  { 
 
		// Actualiza datos del cliente
		$dateCurrent = date('Y-m-d H:i:s');
		if ( $row[2] != "0000-00-00 00:00:00" && $row[2] < $dateCurrent ) { break; }
		if ( $row[3] == "0000-00-00 00:00:00") { 
			$query = mysqli_query($db, "UPDATE Device SET StartDate='".$dateCurrent."' WHERE Mac='".$_POST['Mac']."';");
       		}
		$query = mysqli_query($db, "UPDATE Device SET LastConnect='".$dateCurrent."', IP='".$ip."', System='".$_POST['System']."', SerialNumber='".$_POST['SN']."', Firmware='".$_POST['CurrentFirm']."' WHERE Mac='" . $_POST['Mac'] . "';"); 
		$query = mysqli_query($db, "Commit;");

		// Abre la ip en el cortafuegos
		shell_exec('sudo /usr/sbin/./firewall -n ' . $ip);
		$res = 1;
//	}
}
// Comprobamos si existe Catch-up
if ( file_exists("../apps/catchup") ){
        $esCatchup = 1;
} else{
        $esCatchup = 0;
}

//Cargamos la version reciente del fichero "stbinfo.txt"
$fileName=file($_POST['Url']);
//echo $fileName;
//$num=count($fileName)-1;
//echo $num
$num= spliti("\\.",spliti("_",spliti("/",$fileName[count($fileName)-1])[5])[2])[2];


$respuesta[]=array();
$resultado = array('enable' => $res, 'existCatchup' => $esCatchup, 'numVersion' => $num);
//$resultado = array('enable' => $res, 'existCatchup' => $esCatchup);
$respuesta[0] = $resultado;

echo json_encode($respuesta);


//echo $res;

// Funcion que obtiene la ip del cliente
function get_real_ip() {
    if (isset($_SERVER["HTTP_CLIENT_IP"])) { return $_SERVER["HTTP_CLIENT_IP"];
	} elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) { return $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) { return $_SERVER["HTTP_X_FORWARDED"];
    } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) { return $_SERVER["HTTP_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_FORWARDED"])) { return $_SERVER["HTTP_FORWARDED"];
    } else { return $_SERVER["REMOTE_ADDR"]; }
}

?>

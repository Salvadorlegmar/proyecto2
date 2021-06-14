<?php

// Carga configuracion
require("../txt/config.php");

// Comprueba que se pasen los datos del dispositivo
if ( ! isset ($_GET ['Mac']) ){ echo "0" ; return ;  }

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }


// Variables
$Name[] = array(); $Address[] = array(); $Active[] = array(); $Private[] = array(); $Multicast[] = array(); $i=0;


// Realiza la consulta - Obtenemos los ID de los streams que forman la tarifa correspondiente
$sqlhls=mysqli_query($db, "SELECT DISTINCT StreamId FROM GenreByStream INNER JOIN TariffByGenre ON GenreByStream.GenreId=TariffByGenre.GenreId INNER JOIN Device ON TariffByGenre.TariffId=Device.TariffId WHERE Device.Mac='".$_GET['Mac']."' AND Device.Enable='1';");
$sqlmulticast =mysqli_query($db, "SELECT DISTINCT StreamId FROM GenreByStreamMulticast INNER JOIN TariffByGenre ON GenreByStreamMulticast.GenreId=TariffByGenre.GenreId INNER JOIN Device ON TariffByGenre.TariffId=Device.TariffId WHERE Device.Mac='".$_GET ['Mac']."' AND Device.Enable='1';");


// Trata la consulta
$pila = array();
while($row = mysqli_fetch_array($sqlhls)) { array_push($pila, $row[0]); }
//sort($pila);
foreach($pila as $v){
//while($row = mysqli_fetch_array($sql)) {
	//$streamID = $row[0];
	$streamID = $v;
	// Obtenemos nombre del canal, url del canal, y el campo Private de la table Stream
	//$sql2=mysqli_query($db, "SELECT Name, AddressOut, Enable, Private, StreamId, Multicast FROM Stream WHERE StreamId ='" .$streamID. "' AND Enable=1;");
	$sql2=mysqli_query($db, "SELECT Name, AddressOut, Enable, Private, StreamId FROM Stream WHERE StreamId ='" .$streamID. "' AND Enable=1;");
	while($row2 = mysqli_fetch_array($sql2)) {
		$Name[$i] = $row2[0]; $Address[$i] = $row2[1]; $Active[$i] = $row2[2]; $Private[$i] = $row2[3]; $StreamId[$i] = $row2[4]; $Multicast[$i] = 0;  $i = $i+1;
	}

}

// Trata la consulta multicast
$pila2 = array();
while($row1 = mysqli_fetch_array($sqlmulticast)) { array_push($pila2, $row1[0]); }
sort($pila2);
foreach($pila2 as $v){
//while($row = mysqli_fetch_array($sql)) {
        //$streamID = $row[0];
        $streamID = $v;
        // Obtenemos nombre del canal, url del canal, y el campo Private de la table Stream
        //$sql2=mysqli_query($db, "SELECT Name, AddressOut, Enable, Private, StreamId, Multicast FROM Stream WHERE StreamId ='" .$streamID. "' AND Enable=1;");
        $sql2=mysqli_query($db, "SELECT Name, AddressOut, Enable, Private, StreamId FROM Stream_Multicast WHERE StreamId ='" .$streamID. "' AND Enable=1;");
        while($row2 = mysqli_fetch_array($sql2)) {
                $Name[$i] = $row2[0]; $Address[$i] = $row2[1]; $Active[$i] = $row2[2]; $Private[$i] = $row2[3]; $StreamId[$i] = $row2[4]; $Multicast[$i] = 1;  $i = $i+1;
        }

}


$j = 0; $max = $i; // Canales Totales

// Obtiene ip del servidor
$command="/sbin/ifconfig eth1 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
//$command="/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
$localIP = exec ($command); 
$indexC=0;
$indexM=0;
//$respuestaCaceres="";
$respuestaCaceres=array();

//$respuestaMalaga="";
$respuestaMalaga=array();
//$respuesta="";
$respuesta=array();

$resultado=array();

// Tranforma array de resultado en json
for($i=0; $i<$max; $i++) {
	//if ($Active[$i] === "0") { continue; } // Canal parado
	$s = $StreamId[$i];
	$n = $Name[$i];
        $n2  = str_replace(" ", "_", $n);
	$p = $Private[$i];
	if(($s >= 500) && ($s < 807)){
		//echo "1.ENTRA EL CANAL:".$n2.", CON EL STREAM:".$s.", MULTICAST:".$Multicast[$i]."</br>";
		if($Multicast[$i]==1){
                	$a=$Address[$i];
                	$logo="multicast/".$StreamId[$i];
        	}else{
                	$a=$Address[$i];
			$logo="hls/".$StreamId[$i];

		}
		//echo "1.URL DEL CANAL:".$a."</br>";
		$resultado=array('Id' => $s, 'Name' => $n, 'Url' => $a, 'Private' => $p, 'Multicast' => $Multicast[$i], 'Logo' => $logo);

		//echo "RESULTADO:".$resultado[0];
		$respuestaCaceres[$indexC]=$resultado;

		$indexC++;
	}else{
		//echo "2.ENTRA EL CANAL:".$n2.", CON EL STREAM:".$s.", MULTICAST:".$Multicast[$i]."</br>";
		if($Multicast[$i]==1){
                	$a=$Address[$i];
                	$logo="multicast/".$StreamId[$i];
        	}else{
                        $a = "http://@".$localIP.":4420/m3u8/".$n2.".m3u8";
	                $logo="hls/".$StreamId[$i];
        	}
		//echo "2.URL DEL CANAL:".$a."</br>";

		$resultado=array('Id' => $s, 'Name' => $n, 'Url' => $a, 'Private' => $p, 'Multicast' => $Multicast[$i], 'Logo' => $logo);
		$respuestaMalaga[$indexM]=$resultado;
		$indexM++;
	}
}


$respuesta=array_merge($respuestaCaceres, $respuestaMalaga);


// Ordenación por Burbuja
/*for($i=1; $i<$max; $i++){
	for($r=0; $r<$max-$i; $r++){
		if(strnatcasecmp($respuesta[$r]['Id'], $respuesta[$r+1]['Id']) > 0){
			$k=$respuesta[$r+1];
			$respuesta[$r+1]=$respuesta[$r];
			$respuesta[$r]=$k;
		}
	}
}*/



///////////////////////////////////////
echo json_encode($respuesta);
mysqli_close($db);

?>

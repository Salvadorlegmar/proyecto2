<?php

header('Content-Type: text/html; charset=utf-8');

// Carga configuracion
require("../txt/config.php");

/****************  Connect to MySQL database  ***************************/
$db = mysqli_connect( "Localhost", "root", "anvimur2001lrvfg", "Epg" ) or die ( "Error " . mysqli_error ( $db ) );
$link = mysqli_connect ( "Localhost", "root", "anvimur2001lrvfg", "TRUE-IP2" ) or die ( "Error " . mysqli_error ( $link ) );
if (mysqli_connect_errno()) {echo "0" ; return ;}

$respuesta[]=array();


//Comprueba que exista el canal
if (!isset($_GET['Canal'])){ echo "0" ; return ;}

/* cambiar el conjunto de caracteres a utf8 */
if (!mysqli_set_charset($db, "utf8")) {
        error_log("Error cargando el conjunto de caracteres utf8: " . mysqli_error($db));
        return;
}

//Consultamos el EpgNum del canal
$id=1;
if($_GET['Multi'] == '0'){
        $queryID = mysqli_query($link, "SELECT EpgNum FROM Stream WHERE StreamId = '" .$_GET['Canal']. "';");
}else{
        $queryID = mysqli_query($link, "SELECT EpgNum FROM Stream_Multicast WHERE StreamId = '" .$_GET['Canal']. "';");
}

// Obtenemos el ID
while($column=mysqli_fetch_row($queryID)){
        $id = $column[0];
}


// Realiza la consulta - Obtenemos la programación de un canal pasado como parámetro

$resQuery=0;
if($_GET['Multi'] == '0'){
   if($_GET['Limite']=='2'){
	$sql1=mysqli_query($db, "SELECT DISTINCT Title, SUBSTRING(Start,12,5) AS Start, SUBSTRING(Stop,12,5) AS Stop, Descr FROM Epg WHERE Epg.Id='" . $id . "' AND ((Epg.Start <= NOW() AND Epg.Stop > NOW()) OR Epg.Start >= NOW()) ORDER BY Epg.Start LIMIT 2;");
   }else{
	//$sql1=mysqli_query($db, "SELECT DISTINCT Title, REPLACE(REPLACE(REPLACE(Start,' ',''),'-',''),':','') AS Start, REPLACE(REPLACE(REPLACE(Stop,' ',''),'-',''),':','') AS Stop, Descr FROM Epg WHERE Epg.Name='" . $_GET['Canal'] . "' AND Epg.Start >= '". $_GET['Limite'] ."' ORDER BY Epg.Start;");
	$sql1=mysqli_query($db, "SELECT DISTINCT Title, REPLACE(REPLACE(REPLACE(Start,' ',''),'-',''),':','') AS Start, REPLACE(REPLACE(REPLACE(Stop,' ',''),'-',''),':','') AS Stop, Descr FROM Epg WHERE (Epg.id='".$id."' AND Epg.Start >= '".$_GET['Limite']."') OR (Epg.id='".$id."' AND Epg.Start < '".$_GET['Limite']."' AND Epg.Stop > '".$_GET['Limite']."') ORDER BY Epg.Start LIMIT 20;");
   }
   $resQuery=$sql1->num_rows;
}

$i=0;

if($_GET['Limite']=='2' && $resQuery==0){
	for($i=0; $i<2; $i++){
		$resultado = array('Titulo' => "No Info", 'Inicio' => "No Info", 'Fin' => "No Info", 'Sinopsis' => "No Info");
                $respuesta[$i] = $resultado;
	}

}else{
	while($row1 = mysqli_fetch_array($sql1)) {

    		$resultado = array('Titulo' => $row1[0], 'Inicio' => $row1[1], 'Fin' => $row1[2], 'Sinopsis' => $row1[3]);
    		$respuesta[$i] = $resultado;

    		$i = $i+1;
	}
}


//echo json_encode($respuesta);
mysqli_close($db);
mysqli_close($link);
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

?>

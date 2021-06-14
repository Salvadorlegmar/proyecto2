<?php

// Carga configuracion
require("../txt/config.php");

// Comprueba que se pasen los datos del dispositivo
if (!isset( $_GET['Mac'])) { echo "0"; return; }

//echo "llega";

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }

//echo "llega";

// Realiza la consulta - Receptor que coincida la MAC y este activo
$sql=mysqli_query($db, "SELECT Login, Pass FROM User WHERE UserId=(SELECT UserId FROM Device WHERE Mac='".$_GET['Mac']."' AND Enable='1');");

$user="";
$pass="";

//echo "llega";
// Trata la respuesta
//while($row=mysqli_fetch_row($sql)) {
while($row = mysqli_fetch_array($sql)){
	$user=$row[0];
	$pass=$row[1];
}
//echo "U=".$user.", P=".$pass;


$respuesta[]=array();
$resultado = array('User' => $user, 'Pass' => $pass);
//$resultado = array('enable' => $res, 'existCatchup' => $esCatchup);
$respuesta[0] = $resultado;

//echo json_encode($resultado);
echo json_encode($respuesta);

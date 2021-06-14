<?php

// Carga configuracion
require("config.php");

if ((! isset ( $_GET['Traza'] )) || (! isset ( $_GET['Fecha'] )))  { echo "0"; return; }

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }

$query = mysqli_query($db, "INSERT INTO casos (Trazabilidad_hospital, Fecha_hora_de_alta) VALUES ('".$_GET['Traza']."', '".$_GET['Fecha']."');");      		


?>
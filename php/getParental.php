<?php

// Carga configuracion
require("../txt/config.php");

// Comprueba que se pasen los datos del dispositivo
if ( ! isset ($_GET ['Mac']) ){ echo "0" ; return ;  }

// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }

// Realiza la consulta - Control parental del usuario
$query=mysqli_query($db, "SELECT ParentPass FROM User WHERE User.UserId in (SELECT UserId from Device WHERE Mac='" .$_GET['Mac']. "')");

// Trata la consulta
while($column=mysqli_fetch_row($query)) { echo $column[0]; }
mysqli_close($db);

?>

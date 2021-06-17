<?php

// Carga configuracion
require("config.php");


// Conecta con la base de datos
$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
if (mysqli_connect_errno()) { echo "0" ; return ; }

// Variables
$caso=$_POST['IDCase'];
$IDs[] = array();
$Nombres[] = array(); 
$Tipos[] = array();
$Fechas[] = array();
$i=0;

//echo "HOLA CASE:".$caso;

// Realiza la consulta - Obtenemos los datos de los modelos
$sql=mysqli_query($db, "SELECT ID_MODELO, Nombre_del_modelo, Tipo, Fecha_hora_de_alta FROM modelos WHERE ID_CASO=".$caso.";");

while($row = mysqli_fetch_array($sql)) {
    $IDs[$i] = $row[0];
    $Nombres[$i] = $row[1]; 
    $Tipos[$i] = $row[2];
    $Fechas[$i] = $row[3];
    //echo "I:".$i.", ID:".$IDs[$i].", NA:".$Nombres[$i].", TIPO:".$Tipos[$i].", FECHA:".$Fechas[$i]."<br>";
    $i=$i+1;
}
$max=$i;

// Tranforma array de resultado en json
for($j=0; $j<$max; $j++) {
    //echo "ENTRO";
    //$resultado=array('Id'=> $IDs[$j], 'Nombre' => $Nombres[$j], 'Tipo' => $Tipos[$j] ,'Fecha' => $Fechas[$j]);
    $resultado=array('Id'=> $IDs[$j], 'Nombre' => $Nombres[$j], 'Tipo' => $Tipos[$j], 'Fecha' => $Fechas[$j]);
    //echo "INDICE:".$j." VALOR1:".$resultado['Id']." VALOR2:".$resultado['Nombre']." VALOR3:".$resultado['Fecha']."<br>";
    $respuesta[$j]=$resultado;
}

//$respuesta[]="HOLA";

echo json_encode($respuesta);
mysqli_close($db);
<?php

// Carga configuracion
$DB_LOCAL_SERVER = "Localhost";
$DB_USER= "root";
$DB_PASS = "anvimur2001lrvfg";
$DB_NAME = "Cella2";

if ((! isset ( $_POST['ID'] )) )  { echo "0"; return; }

// Conecta con la base de datos
//$db=mysqli_connect("Localhost", $DB_USER, $DB_PASS, $DB_NAME);
//if (mysqli_connect_errno()) { echo "0" ; return ; }

$conn = mysqli_connect("localhost", $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conection="Connected successfully";

// Variables
$caso=$_POST['ID'];
$IDsC[] = array();
$IDsM[] = array();
$Nombres[] = array(); 
$Tipos[] = array();
$Fechas[] = array();
$i=0;



// Realiza la consulta - Obtenemos los datos de los modelos
//$sql=mysqli_query($conn, "SELECT ID_MODELO, Nombre_del_modelo, Tipo, Fecha_hora_de_alta FROM modelos WHERE ID_CASO=".$caso.";");
$sql=mysqli_query($conn, "SELECT ID_CASO, ID_MODELO, Nombre_del_modelo, Tipo, Fecha_hora_de_alta FROM modelos WHERE ID_CASO=".$caso.";");

while($row = mysqli_fetch_array($sql)) {
    $IDsC[$i] = $row[0];
    $IDsM[$i] = $row[1];
    $Nombres[$i] = $row[2]; 
    $Tipos[$i] = $row[3];
    $Fechas[$i] = $row[4];
    $i=$i+1;
}
$max=$i;




// Tranforma array de resultado en json
for($j=0; $j<$max; $j++) {
    //$resultado=array('Id'=> $IDs[$j], 'Nombre' => $Nombres[$j], 'Tipo' => $Tipos[$j] ,'Fecha' => $Fechas[$j]);
    $resultado=array('ID' => $IDsM[$j], 'ID_caso' => $IDsC[$j], 'Nombre' => $Nombres[$j], 'Fecha' => $Fechas[$j], 'Tipo' => $Tipos[$j]);
    //echo "INDICE:".$j." VALOR1:".$resultado['ID_caso'].", VALOR 11:".$resultado['ID_modelo'].", VALOR2:".$resultado['Nombre'].", VALOR3:".$resultado['Fecha']."<br>";
    $respuesta[$j]=$resultado;
}
//$salida='modelos' => $respuesta;
//$salida['modelos']=$respuesta;


echo json_encode($respuesta);
mysqli_close($conn);

?>
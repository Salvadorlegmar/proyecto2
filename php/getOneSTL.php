<?php

// Carga configuracion
require("config.php");

$conn = mysqli_connect("localhost", $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conection="Connected successfully";


if ((! isset ( $_POST['IDSTL'] )))  { echo "0"; return; }

// Variables
$stl=$_POST['IDSTL'];

$Nombre[] = array();
$Color[] = array();
$Visible[] = array();
$Transparencia[] = array();
$Ordene[] = array();
$i=0;



// Realiza la consulta - Obtenemos los datos de los modelos
$sql=mysqli_query($conn, "SELECT Nombre_del_elemento, Color, Visible, Transparencia, Orden FROM stls WHERE ID_STL=".$stl.";");



while($row = mysqli_fetch_array($sql)) {
    $Nombre[$i] = $row[0]; 
    $Color[$i] = "#".$row[1];
    
    if($row[2] == 1){
        $Visible[$i]="si";
    }else{
        $Visible[$i]="no";
    }

    $Transparencia[$i] = $row[3];
    $Orden[$i] = $row[4];
    $i=$i+1;
}
$max=$i;




// Tranforma array de resultado en json
for($j=0; $j<$max; $j++) {
    $resultado=array('Nombre' => $Nombre[$j], 'Color'=> $Color[$j], 'Visible' => $Visible[$j], 'Transp' => $Transparencia[$j], 'Orden' => $Orden[$j]);
    $respuesta[$j]=$resultado;
}



echo json_encode($respuesta);
mysqli_close($conn);

?>
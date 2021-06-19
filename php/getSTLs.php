<?php

// Carga configuracion
require("config.php");

$conn = mysqli_connect("localhost", $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conection="Connected successfully";


// Variables
$IDsC[] = array();
$IDsM[] = array();
$IDsS[] = array();
$Nombres[] = array();
$Colores[] = array();
$Visibles[] = array();
$Transparencias[] = array();
$Ordenes[] = array();
$i=0;



// Realiza la consulta - Obtenemos los datos de los STLs
$sql=mysqli_query($conn, "SELECT ID_CASO, ID_MODELO, ID_STL, Nombre_del_elemento, Color, Visible, Transparencia, Orden FROM stls WHERE ID_CASO=".$_POST['IDCase']." AND ID_MODELO=".$_POST['IDModel'].";");



while($row = mysqli_fetch_array($sql)) {
    $IDsC[$i] = $row[0];
    $IDsM[$i] = $row[1];
    $IDsS[$i] = $row[2];
    $Nombres[$i] = $row[3]; 
    $Colores[$i] = "#".$row[4];
    
    if($row[5] == 1){
        $Visibles[$i]="SI";
    }else{
        $Visibles[$i]="NO";
    }

    $Transparencias[$i] = $row[6];
    $Ordenes[$i] = $row[7];
    $i=$i+1;
}
$max=$i;




// Tranforma array de resultado en json
for($j=0; $j<$max; $j++) {
    $resultado=array('ID_caso' => $IDsC[$j], 'ID_modelo'=> $IDsM[$j], 'ID_stl'=> $IDsS[$j], 'Nombre' => $Nombres[$j], 'Color'=> $Colores[$j], 'Visible' => $Visibles[$j], 'Transp' => $Transparencias[$j], 'Orden' => $Ordenes[$j]);
    $respuesta[$j]=$resultado;
}



echo json_encode($respuesta);
mysqli_close($conn);

?>
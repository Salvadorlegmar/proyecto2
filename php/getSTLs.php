<?php

// Carga configuracion
require("config.php");

$conn = mysqli_connect("localhost", $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conection="Connected successfully";

//echo "CASO:".$_GET['IDCase'];
//echo "MODELO:".$_GET['IDModel'];

//if ((! isset ( $_POST['IDCase'] )) || (! isset ( $_POST['IDModel'] )))  { echo "23"; return; }
//echo $conection;

// Variables
//$caso=$_GET['IDCase'];
$IDsC[] = array();
$IDsM[] = array();
$IDsS[] = array();
$Nombres[] = array();
$Colores[] = array();
$Visibles[] = array();
$Transparencias[] = array();
$Ordenes[] = array();
$i=0;



// Realiza la consulta - Obtenemos los datos de los modelos
//$sql=mysqli_query($conn, "SELECT ID_MODELO, Nombre_del_modelo, Tipo, Fecha_hora_de_alta FROM modelos WHERE ID_CASO=".$caso.";");
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
    //echo "<br>DATOS IDC:".$IDsC[$i].", IDM:".$IDsM[$i].", IDS:".$IDsS[$i].", NAME:".$Nombres[$i];
    //echo "<br>DATOS IDC:".$IDsC[$i].", IDM:".$IDsM[$i].", IDS:".$IDsS[$i].", NAME:".$Nombres[$i].", COL:".$Colores[$i];
    $i=$i+1;
}
$max=$i;




// Tranforma array de resultado en json
for($j=0; $j<$max; $j++) {
    //$resultado=array('Id'=> $IDs[$j], 'Nombre' => $Nombres[$j], 'Tipo' => $Tipos[$j] ,'Fecha' => $Fechas[$j]);
    $resultado=array('ID_caso' => $IDsC[$j], 'ID_modelo'=> $IDsM[$j], 'ID_stl'=> $IDsS[$j], 'Nombre' => $Nombres[$j], 'Color'=> $Colores[$j], 'Visible' => $Visibles[$j], 'Transp' => $Transparencias[$j], 'Orden' => $Ordenes[$j]);
    //echo "INDICE:".$j." VALOR1:".$resultado['ID_caso'].", VALOR 11:".$resultado['ID_modelo'].", VALOR2:".$resultado['Nombre'].", VALOR3:".$resultado['Fecha']."<br>";
    $respuesta[$j]=$resultado;
}



echo json_encode($respuesta);
mysqli_close($conn);

?>
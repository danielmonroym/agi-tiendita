#!/usr/bin/php -q
<?php
set_time_limit(30);
$param_error_log = '/tmp/notas.log';
$param_debug_on = 1;
require('phpagi.php');
require("definiciones.inc");
$link = mysql_connect(HOST, USUARIO,CLAVE);    
mysql_select_db(DB, $link);  

$agi = new AGI();
$agi->answer();
sleep(1);

$agi->exec_agi("googletts.agi,\"Bienvenido a la tiendita virtual \",es");
$agi->exec_agi("googletts.agi,\"A continuacion se lista los productos disponibles\",es");


$result = mysql_query("SELECT * FROM productos", $link); 

while ($row = mysql_fetch_array($result)){ 
    $agi->exec_agi("googletts.agi,\"El producto con nombre\",es");
	$agi->exec_agi("googletts.agi,\"".$row['nombre']."\",es");
	sleep(1);
	$agi->exec_agi("googletts.agi,\"Cuesta\",es");
	$agi->exec_agi("googletts.agi,\"".$row['precio']."\",es");
	$agi->exec_agi("googletts.agi,\"En el momento tenemos la cantidad de\",es");
    $agi->exec_agi("googletts.agi,\"".$row['cantidad']."\",es");
    $agi->exec_agi("googletts.agi,\" Su descripcion es\",es");
	$agi->exec_agi("googletts.agi,\"".$row['descripcion']."\",es");
    $agi->exec_agi("googletts.agi,\" Su codigo es\",es");
	$agi->exec_agi("googletts.agi,\"".$row['id_producto']."\",es");
} 

$agi->exec_agi("googletts.agi,\"Marque 1 para empezar la compra despues del tono\",es");
sleep(1);
$numero = $agi->get_data("beep", 5000, 1);
$resultado = $numero["result"];
if($resultado ==1){
    $agi->exec_agi("googletts.agi,\"Ingrese el codigo del producto despues del tono\",es");  
  $codigo = $agi->get_data("beep", 5000, 1);
  $valor = $codigo['result'];
  $result = mysql_query("SELECT * FROM productos WHERE id_producto =".$valor , $link); 
  $row = mysql_fetch_array($result);
  $opt = "0";

  if($row['id_producto']==$valor and $valor != null){
  $agi->exec_agi("googletts.agi,\" Acaba de comprar el producto con nombre\",es");
	$agi->exec_agi("googletts.agi,\"".$row['nombre']."\",es");
  $agi->exec_agi("googletts.agi,\"Con un valor de\",es");
	$agi->exec_agi("googletts.agi,\"".$row['precio']."\",es");
  $nombre = $row['nombre'];
  $precio = $row['precio'];
  $result = mysql_query("INSERT INTO venta_productos (nombre, cantidad, precio) VALUES ('$nombre', '1', '$precio');", $link);  
  sleep(1);
  $agi->exec_agi("googletts.agi,\"Que tenga un buen dia\",es");
  }else{
    $agi->exec_agi("googletts.agi,\"El producto con codigo\",es");
    $agi->exec_agi("googletts.agi,\"".$codigo['result']."\",es");
    $agi->exec_agi("googletts.agi,\"No se encuentra\",es");
    sleep(0,3);
	  
    $opt=null;
  }

    
} else{
    $agi->exec_agi("googletts.agi,\"Que tenga un buen dia\",es");
}
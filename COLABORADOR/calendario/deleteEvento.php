<?php
require_once('../../conexion.php');
$id    		= $_REQUEST['id']; 

$sqlDeleteEvento = ("DELETE FROM calendario WHERE  identificador='" .$id. "'");
$resultProd = mysqli_query($link, $sqlDeleteEvento);

?>
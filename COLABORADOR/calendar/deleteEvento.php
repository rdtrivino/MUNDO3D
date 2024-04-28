<?php
require_once('config.php');
$id    		= $_REQUEST['id']; 

$sqlDeleteEvento = ("DELETE FROM calendario WHERE  identificador='" .$id. "'");
$resultProd = mysqli_query($con, $sqlDeleteEvento);

?>
  
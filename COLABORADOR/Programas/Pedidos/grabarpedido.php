<?php



$codigo=$_POST['txtPe_Codigo'];
$estado=$_POST["txtPe_Estado"];
$producto=$_POST["txtPe_Producto"]; 
$cantidad=$_POST["txtPe_Cantidad"]; 
$precio=$_POST["txtPe_Precio"]; 
$fechaentrega=$_POST["txtPe_Fechaentrega"];
$fechapedido=$_POST["txtPe_Fechapedido"];  
$cliente=$_POST["txtPe_Cliente"]; 
$observacion=$_POST["txtPe_Observacion"]; 


include("..\..\conexion.php");

$query = "INSERT INTO pedido (Pe_Codigo, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Precio, Pe_Fechaentrega, Pe_Fechapedido, Pe_Cliente, Pe_Observacion)
VALUES ('$codigo','$estado', '$producto' , '$cantidad','$precio','$fechaentrega','$fechapedido','$cliente','$observacion')";

$cadena=mysqli_query($link,$query) or die ("Error en la insercion de datos");

echo "<script>

alert('Los datos se grabaron correctamente');

location.href='../index.html';

</script>";

?>
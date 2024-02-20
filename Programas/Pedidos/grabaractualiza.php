<?php
include("../../conexion.php");
$accion = $_POST["Accion"];

if (isset($accion)) {
    if ($accion == "Update") {
        $estado = $_POST['txtPe_Estado'];
        $producto = $_POST['txtPe_Producto'];
        $cantidad = $_POST['txtPe_Cantidad'];
        $precio = $_POST['txtPe_Precio'];
        $fechaentrega = $_POST['txtPe_Fechaentrega'];
        $fechapedido = $_POST['txtPe_Fechapedido'];
        $cliente = $_POST['txtPe_Cliente'];
        $observacion = $_POST['txtPe_Observacion'];
        $codigo = $_POST['txtPe_Codigo'];

        $query = "UPDATE pedido
                  SET Pe_Estado = '$estado',
                      Pe_Producto = '$producto',
                      Pe_Cantidad = '$cantidad',
                      Pe_Precio = '$precio',
                      Pe_Fechaentrega = '$fechaentrega',
                      Pe_Fechapedido = '$fechapedido',
                      Pe_Cliente = '$cliente',
                      Pe_Observacion = '$observacion'
                  WHERE Pe_Codigo = '$codigo'";

        $result = mysqli_query($link, $query) or die ("Error en la actualización de los datos. Error: " . mysqli_error($link));
        echo "<script>
                alert('Los datos fueron actualizados correctamente');
                location.href='../index.html';
                </script>";
    } else {
        $codigo = $_POST['txtPe_Codigo'];

        $query = "DELETE 
                  FROM pedido
                  WHERE Pe_Codigo = '$codigo'";

        $result = mysqli_query($link, $query) or die ("Error en el borrado de los datos. Error: " . mysqli_error($link));
        echo "<script>
                alert('Los datos fueron borrados correctamente');
                location.href='../index.html';
                </script>";
    }
}
?>

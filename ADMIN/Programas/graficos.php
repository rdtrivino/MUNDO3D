<?php
    include __DIR__ . '/../conexion.php';

    $nombreCompleto = $_SESSION['username'];
    $usuario_id = $_SESSION['user_id'];
    $sql = "SELECT Identificador, Pe_Estado, Pe_Producto, Pe_Cantidad,  Pe_Fechaentrega, Pe_Fechapedido, Pe_Cliente, Pe_Observacion FROM pedidos";
    $resultado = mysqli_query($link, $sql);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($link));
    }

function obtenerNombreProducto($codigoProducto, $tu_conexion) {
    // Realiza una consulta SQL para obtener el nombre del producto a partir del código
    $sql = "SELECT pro_nombre FROM productos
     WHERE Identificador = " . $codigoProducto;

    // Ejecuta la consulta
    $resultado = mysqli_query($tu_conexion, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['pro_nombre'];
    } else {
        return "Producto no encontrado";
    }
}
function obtenerNombreEstado($codigoEstado, $tu_conexion) {
    // Realiza una consulta SQL para obtener el nombre del estado a partir del código
    $sql = "SELECT Es_Nombre FROM pedido_estado WHERE Es_Codigo = " . $codigoEstado;

    // Ejecuta la consulta
    $resultado = mysqli_query($tu_conexion, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['Es_Nombre'];
    } else {
        return "Estado no encontrado";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_cambios'])) {
    // Verifica que los campos estén definidos en el formulario
    if (isset($_POST['Identificador'], $_POST['Pe_Estado'], $_POST['Pe_Producto'], $_POST['Pe_Cantidad'], $_POST['Pe_Observacion'], $_POST['Pe_Fechaentrega'], $_POST['cliente'])) {
        $Identificador = $_POST['Identificador'];
        $estado = $_POST['Pe_Estado'];
        $producto = $_POST['Pe_Producto'];
        $cantidad = $_POST['Pe_Cantidad'];
        $observacion = $_POST['Pe_Observacion'];
        $fecha_entrega = $_POST['Pe_Fechaentrega'];
        $cliente = $_POST['cliente'];

        // Validar y escapar los datos para evitar inyección SQL
        $identificador = intval($identificador);
        $estado = intval($estado);
        $cantidad = intval($cantidad);
        $precio = intval($precio);
        // Validar y escapar otros campos según el tipo de dato en la base de datos

        // Realiza una consulta SQL para actualizar los datos en la base de datos
        $sql_actualizar = "UPDATE pedidos
                          SET Identificaror = $identificador, 
                              Pe_Producto = '$producto', 
                              Pe_Cantidad = $cantidad, 
                              Pe_Observacion = '$observacion', 
                              Pe_Fechaentrega = '$fecha_entrega', 
                              Pe_Cliente = $cliente 
                          WHERE Pe_Codigo = $codigo";

        if (mysqli_query($link, $sql_actualizar)) {
            echo "Cambios guardados con éxito.";
        } else {
            echo "Error al guardar los cambios: " . mysqli_error($link);
        }

        // Cierra la conexión a la base de datos
        mysqli_close($link);
    } else {
        echo "Datos del formulario incompletos o incorrectos.";
    }
    }
    function obtenerNombreMes($numero_mes) {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        // Verificar si el índice existe en el array antes de acceder a él
        if (array_key_exists($numero_mes, $meses)) {
            return $meses[$numero_mes];
        } else {
            return 'Mes inválido';
        }
    }

    // Consulta para obtener la cantidad de pedidos por mes
    $sql_pedidos_por_mes = "SELECT MONTH(Pe_Fechapedido) AS Mes, COUNT(*) AS CantidadPedidos
                            FROM pedidos
                            WHERE Pe_Estado <> 'inactivo'
                            GROUP BY MONTH(Pe_Fechapedido)";

    // Ejecutar la consulta
    $resultado_pedidos_por_mes = mysqli_query($link, $sql_pedidos_por_mes);

    // Verificar si la consulta tuvo éxito y si hay al menos un resultado
    if ($resultado_pedidos_por_mes && mysqli_num_rows($resultado_pedidos_por_mes) > 0) {
        // Arreglo para almacenar los datos del primer gráfico (doughnut)
        $data1 = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Cantidad de Pedidos',
                    'data' => [],
                    'backgroundColor' => ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                    'hoverOffset' => 4
                ]
            ]
        ];

        // Arreglo para almacenar los datos del segundo gráfico (bar)
        $data2 = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Cantidad de Pedidos',
                    'data' => [],
                    'backgroundColor' => 'rgb(54, 162, 235)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 1
                ]
            ]
        ];

        // Procesar los resultados de la consulta y llenar los arreglos de datos
        while ($row = mysqli_fetch_assoc($resultado_pedidos_por_mes)) {
            // Agregar el mes y la cantidad de pedidos al arreglo de datos del primer gráfico (doughnut)
            $nombre_mes = obtenerNombreMes($row['Mes']); // Función para obtener el nombre del mes
            $data1['labels'][] = $nombre_mes;
            $data1['datasets'][0]['data'][] = $row['CantidadPedidos'];

            // Agregar el mes y la cantidad de pedidos al arreglo de datos del segundo gráfico (bar)
            $data2['labels'][] = $nombre_mes;
            $data2['datasets'][0]['data'][] = $row['CantidadPedidos'];
        }

        // Convertir los arreglos de datos a JSON para utilizarlos en el script de JavaScript
        $data1_json = json_encode($data1);
        $data2_json = json_encode($data2);
    } else {
        // Si no hay resultados en la consulta, asignar valores predeterminados
        $data1_json = json_encode(['labels' => [], 'datasets' => []]);
        $data2_json = json_encode(['labels' => [], 'datasets' => []]);
    }
?>
<?php
include __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tabla = $_POST['tabla'];
    $valores = array();

    foreach ($_POST as $clave => $valor) {
        if ($clave !== 'tabla') {
            // Escapa los valores para evitar inyección SQL
            $valores[$clave] = "'" . mysqli_real_escape_string($link, $valor) . "'";
        }
    }

    $columnas = implode(", ", array_keys($valores));
    $valores = implode(", ", $valores);

    $peticion = "INSERT INTO $tabla ($columnas) VALUES ($valores)";
    $resultado = mysqli_query($link, $peticion);

    if ($resultado) {
        echo "Los datos se han insertado correctamente en la base de datos.";
    } else {
        echo "Error al insertar datos: " . mysqli_error($link);
    }

    header("Location: index.php?tabla=" . $_POST['tabla']);
} else {
    echo "Acceso no permitido.";
}
?>


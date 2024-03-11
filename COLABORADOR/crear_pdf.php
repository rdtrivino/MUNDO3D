<?php
    // Incluir el archivo de conexión a la base de datos
    include __DIR__ . '/../conexion.php';
    // Incluir la librería PDF
    include_once('libs/fpdf.php');
    
    class PDF extends FPDF
    {
        // Función encargada de realizar el encabezado
        function Header()
        {
            // Logo
            $this->Image("../images/Logo Mundo 3d.png",5,5,20);
            $this->SetFont('Arial','B',13);
            // Mover a la derecha
            $this->Cell(80);
            // Título
            $this->Cell(95,10,'Lista de Pedidos',1,0,'C');
            // Salto de línea
            $this->Ln(20);
        }

        // Función pie de página
        function Footer()
        {
            // Posición a 1.5 cm desde abajo
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    // Crear una instancia de la conexión a la base de datos
    $link = mysqli_connect($host, $user, $password);

    if (!$link) {   die("Error al conectarse al servidor: " . mysqli_connect_error());
    }

    if (!mysqli_select_db($link, $dbname)) {
        die("Error al conectarse a la Base de Datos: " . mysqli_error($link));
    }

    // Consulta SQL para obtener los datos del personal
    $result = mysqli_query($link, "SELECT Identificador, Pe_Cliente, Pe_Estado, Pe_Producto, Pe_Cantidad, Pe_Fechapedido, Pe_Fechaentrega, Pe_Observacion FROM pedidos") or die("Error en la consulta: ".mysqli_error($link));

    // Crear una instancia del objeto PDF
    $pdf = new PDF();
    // Encabezado
    $pdf->AddPage();
    // Pie de página
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','B',12);
    // Declaramos el ancho de las columnas
    $w = array(10, 30, 20, 30, 30, 30, 30, 30);
    // Encabezado de la tabla
    $pdf->Cell(10,12,'Codigo',1);
    $pdf->Cell(30,12,'Cliente',1);
    $pdf->Cell(20,12,'Estado',1);
    $pdf->Cell(30,12,'Producto',1);
    $pdf->Cell(30,12,'Cantidad',1);
    $pdf->Cell(30,12,'Fecha de pedido',1);
    $pdf->Cell(30,12,'Fecha de entrega',1);
    $pdf->Cell(30,12,'Observación',1);
    $pdf->Ln();
    $pdf->SetFont('Arial','',12);
    // Mostrar el contenido de la tabla
    foreach($result as $row) {
        $pdf->Cell($w[0],6,$row['Identificador'],1);
        $pdf->Cell($w[1],6,$row['Pe_Cliente'],1);
        $pdf->Cell($w[2],6,$row['Pe_Estado'],1);
        $pdf->Cell($w[3],6,$row['Pe_Producto'],1);
        $pdf->Cell($w[4],6,$row['Pe_Cantidad'],1);
        $pdf->Cell($w[5],6,$row['Pe_Fechapedido'],1);
        $pdf->Cell($w[6],6,$row['Pe_Fechaentrega'],1);
        $pdf->Cell($w[7],6,$row['Pe_Observacion'],1);
        $pdf->Ln();
    }
    // Salida del PDF
    $pdf->Output();
?>

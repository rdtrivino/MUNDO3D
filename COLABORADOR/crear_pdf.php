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
            if ($_GET['tabla'] == 'pedidos') {
                $this->Cell(95,10,'Lista de Pedidos',1,0,'C');
            } elseif ($_GET['tabla'] == 'productos') {
                $this->Cell(95,10,'Lista de Productos',1,0,'C');
            }
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
            $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    // Crear una instancia de la conexión a la base de datos
    $link = mysqli_connect($host, $user, $password);

    if (!$link) {   
        die("Error al conectarse al servidor: " . mysqli_connect_error());
    }

    if (!mysqli_select_db($link, $dbname)) {
        die("Error al conectarse a la Base de Datos: " . mysqli_error($link));
    }

    // Definir juego de caracteres UTF-8 en la conexión
    mysqli_set_charset($link, "utf8");
    
    if ($_GET['tabla'] == 'pedidos') {
        // Consulta SQL para obtener los datos del pedido
        $result = mysqli_query($link, "SELECT pedidos.*, pedido_estado.Es_Nombre AS Pe_Estado, 
                    SUBSTRING(productos.Pro_Nombre, 1, 24) AS Pe_Producto_Corta 
                    FROM pedidos
                    INNER JOIN pedido_estado ON pedidos.Pe_Estado = pedido_estado.Es_Codigo
                    INNER JOIN productos ON pedidos.Pe_Producto = productos.Identificador") or die("Error en la consulta: ".mysqli_error($link));
    
        // Crear una instancia del objeto PDF
        $pdf = new PDF('L'); // Establecer orientación como landscape
        $pdf->SetAutoPageBreak(true, 15); // Habilitar el salto automático de página con margen de 15mm
        // Encabezado
        $pdf->AddPage();
        // Pie de página
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial','B',12);
    // Declaramos el ancho de las columnas
        $w = array(10, 28, 24, 50, 12, 29, 30, 22, 20, 55); // Anchos de las columnas ajustados para landscape
        // Encabezado de la tabla
        $pdf->Cell($w[0],12,'ID',1);
        $pdf->Cell($w[1],12,'Cliente',1);
        $pdf->Cell($w[2],12,'Estado',1);
        $pdf->Cell($w[3],12,'Producto',1);
        $pdf->Cell($w[4],12,'Cant',1);
        $pdf->Cell($w[5],12,'Fecha pedido',1);
        $pdf->Cell($w[6],12,'Fecha entrega',1);
        $pdf->Cell($w[7],12,'Tipo',1);
        $pdf->Cell($w[8],12,'Color',1);
        $pdf->Cell($w[9],12,'Observacion',1);
        $pdf->Ln();
        $pdf->SetFont('Arial','',12);
        // Mostrar el contenido de la tabla
        foreach($result as $row) {
            // Verificar si queda suficiente espacio para la fila
            if ($pdf->getPageHeight() - $pdf->GetY() < 12) {
                $pdf->AddPage(); // Agregar una nueva página si no hay suficiente espacio
                // Reconfigurar el encabezado de la tabla para la nueva página
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell($w[0],12,'ID',1);
                $pdf->Cell($w[1],12,'Cliente',1);
                $pdf->Cell($w[2],12,'Estado',1);
                $pdf->Cell($w[3],12,'Producto',1);
                $pdf->Cell($w[4],12,'Cant',1);
                $pdf->Cell($w[5],12,'Fecha pedido',1);
                $pdf->Cell($w[6],12,'Fecha entrega',1);
                $pdf->Cell($w[7],12,'Tipo',1);
                $pdf->Cell($w[8],12,'Color',1);
                $pdf->Cell($w[9],12,'Observacion',1);
                $pdf->Ln();
                $pdf->SetFont('Arial','',12);
            }
    
            // Imprimir las primeras celdas como de costumbre
            $pdf->Cell($w[0],6,$row['Identificador'],1);
            $pdf->Cell($w[1],6,$row['Pe_Cliente'],1);
            $pdf->Cell($w[2],6,$row['Pe_Estado'],1);
            $pdf->Cell($w[3],6,$row['Pe_Producto_Corta'],1);
            $pdf->Cell($w[4],6,$row['Pe_Cantidad'],1);
            $pdf->Cell($w[5],6,$row['Pe_Fechapedido'],1);
            $pdf->Cell($w[6],6,$row['Pe_Fechaentrega'],1);
            $pdf->Cell($w[7],6,$row['pe_tipo_impresion'],1);
            $pdf->Cell($w[8],6,$row['pe_color'],1);
            $pdf->Cell($w[9],6,$row['Pe_Observacion'],1);
    
            $pdf->Ln(); // Salto de línea después de cada fila
        }  
    
        // Salida del PDF
        $pdf->Output();
    } elseif ($_GET['tabla'] == 'productos') {
        // Consulta SQL para obtener los datos de los productos
        $result = mysqli_query($link, "SELECT productos.*, categoria.Cgo_Nombre AS Pro_Categoria, 
                    SUBSTRING(productos.Pro_Descripcion, 1, 42) AS Pro_Descripcion_Corta,
                    SUBSTRING(productos.Pro_Nombre, 1, 20) AS Pro_Nombre_Corto 
                    FROM productos
                    INNER JOIN categoria ON productos.Pro_Categoria = categoria.Cgo_Codigo") or die("Error en la consulta: ".mysqli_error($link));

        // Crear una instancia del objeto PDF
        $pdf = new PDF('L'); // Establecer orientación como landscape
        // Encabezado
        $pdf->SetAutoPageBreak(true, 15); // Habilitar el salto automático de página con margen de 15mm

        // Encabezado
        $pdf->AddPage();
        // Pie de página
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial','B',12);
        // Declaramos el ancho de las columnas
        $w = array(10, 56, 96, 30, 20, 28, 20, 18); // Anchos de las columnas ajustados para landscape
        // Encabezado de la tabla
        $pdf->Cell($w[0],12,'ID',1);
        $pdf->Cell($w[1],12,'Nombre',1);
        $pdf->Cell($w[2],12,'Descripcion',1);
        $pdf->Cell($w[3],12,'Categoria',1);
        $pdf->Cell($w[4],12,'Cantidad',1);
        $pdf->Cell($w[5],12,'Precio Venta',1);
        $pdf->Cell($w[6],12,'Costo',1);
        $pdf->Cell($w[7],12,'Estado',1);
        $pdf->Ln();
        $pdf->SetFont('Arial','',12);
        // Mostrar el contenido de la tabla
        foreach($result as $row) {
            // Verificar si queda suficiente espacio para la fila
            if ($pdf->getPageHeight() - $pdf->GetY() < 12) {
                $pdf->AddPage(); // Agregar una nueva página si no hay suficiente espacio
                // Reconfigurar el encabezado de la tabla para la nueva página
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell($w[0],12,'ID',1);
                $pdf->Cell($w[1],12,'Nombre',1);
                $pdf->Cell($w[2],12,'Descripcion',1);
                $pdf->Cell($w[3],12,'Categoria',1);
                $pdf->Cell($w[4],12,'Cantidad',1);
                $pdf->Cell($w[5],12,'Precio Venta',1);
                $pdf->Cell($w[6],12,'Costo',1);
                $pdf->Cell($w[7],12,'Estado',1);
                $pdf->Ln();
                $pdf->SetFont('Arial','',12);
            }

            // Imprimir las celdas de cada fila
            $pdf->Cell($w[0],6,$row['Identificador'],1);
            $pdf->Cell($w[1],6,$row['Pro_Nombre_Corto'],1); // Utilizar el campo limitado a 20 caracteres
            $pdf->Cell($w[2],6,$row['Pro_Descripcion_Corta'],1); // Utilizar el campo limitado a 30 caracteres
            $pdf->Cell($w[3],6,$row['Pro_Categoria'],1);
            $pdf->Cell($w[4],6,$row['Pro_Cantidad'],1);
            $pdf->Cell($w[5],6,$row['Pro_PrecioVenta'],1);
            $pdf->Cell($w[6],6,$row['Pro_Costo'],1);
            $pdf->Cell($w[7],6,$row['Pro_Estado'],1);
            
            // Ir a la siguiente fila
            $pdf->Ln(); // Salto de línea después de cada fila
        }  
        
        // Salida del PDF
        $pdf->Output();
    }


?>

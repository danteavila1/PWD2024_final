<?php
require('../../modelo/conector/BaseDatos.php');
require('../../modelo/Producto.php');
require('../../vendor/setasign/fpdf/fpdf.php');



class PDF extends FPDF {
    // Encabezado del PDF
    function Header() {
        // Configurar ancho de la tabla y calcular margen izquierdo
        $tableWidth = 90 + 50; 
        $pageWidth = 210; 
        $marginLeft = ($pageWidth - $tableWidth) / 2; 
        // Fuente para el encabezado
        $this->SetFont('Arial', 'B', 14);
        // Título del reporte
        $this->Cell(0, 10, 'Productos en stock', 0, 1, 'C');
        // Espacio después del encabezado
        $this->Ln(10);
        // Encabezados de la tabla
        $this->SetFont('Arial', 'B', 12);
        $this->SetX($marginLeft); 
        $this->Cell(90, 10, 'Nombre', 1, 0, 'C');
        $this->Cell(50, 10, 'Cantidad', 1, 1, 'C');
    }

    // Pie de página
    function Footer() {
        // Posición: 1.5 cm desde abajo
        $this->SetY(-15);
        // Fuente del pie de página
        $this->SetFont('Arial', 'I', 10);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear una instancia de PDF
$pdf = new PDF();
$pdf->AddPage(); // Añadir una página
$pdf->SetFont('Arial', '', 12); // Fuente para el contenido

$tableWidth = 90 + 50; // Suma de los anchos de las columnas
$pageWidth = 210; // Ancho de la página A4 en mm
$marginLeft = ($pageWidth - $tableWidth) / 2;


$producto = new Producto();
$productos = Producto::listar('procantstock > 0');


// Cargar datos en el PDF usando un foreach
foreach ($productos as $product) {
    $pdf->SetX($marginLeft); 
    $pdf->Cell(90, 10, $product->getProNombre(), 1, 0, 'L');
    $pdf->Cell(50, 10, $product->getProCantStock(), 1, 1, 'C');
}

// Salida del PDF
$pdf->Output('I', 'reporte_productos.pdf');
?>
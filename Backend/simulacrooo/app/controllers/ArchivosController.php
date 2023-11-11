<?php
use Fpdf\Fpdf;
require_once './models/Venta.php';

class ArchivosController extends Venta{
    
    public function CrearPdf($request, $response, $args) {
        
        $ventas = Venta::obtenerTodos();
        //var_dump($ventas);
        if ($ventas) {
            $pdf = new FPDF();
            $pdf->AddPage();

            $pdf->SetFont('Arial','B',16);
            //id, fecha, id_cripto, cantidad, cliente
            // Columnas de la clase venta
            $header = array('ID', 'FECHA', 'ID_CRIPTO', 'CANTIDAD', 'CLIENTE');
            
            $w = array(20, 30, 30, 30, 40, 30);
            for ($i = 0; $i < count($header); $i++) {
                $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            }
            $pdf->Ln();

            $fill = false;

            // Header
            foreach ($ventas as $Venta) { // cada una de las columnas de la clase venta
                var_dump($Venta);
                $pdf->Cell($w[0], 6, $Venta->id, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[1], 6, $Venta->fecha, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[2], 6, $Venta->id_cripto, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[3], 6, $Venta->cantidad, 'LR', 0, 'C', $fill);
                $pdf->Cell($w[4], 6, $Venta->cliente, 'LR', 0, 'C', $fill);
                
                $pdf->Ln();
                $fill = !$fill;
            }
            //$pdf->Cell(array_sum($w), 0, '', 'T');

            $destino = "PDFVentas.pdf";
            $pdf->Output('F',$destino,true);
    
            // ruta del pdf, hay que crear el directorio manualmente
            $payload = json_encode(array("message" => "PDF guardado!"));
        } else {
            $payload = json_encode(array("error" => 'No se pudo generar el PDF'));
        }
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    
}
?>

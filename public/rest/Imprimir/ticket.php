<?php
require __DIR__ . '/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

	/* A wrapper to do organise item names & prices into columns */
	class item
	{
		private $name;
		private $price;
		private $dollarSign;

		public function __construct($name = '', $price = '', $dollarSign = false)
		{
			$this -> name = $name;
			$this -> price = $price;
			$this -> dollarSign = $dollarSign;
		}
		
		public function __toString()
		{
			$rightCols = 10;
			$leftCols = 38;
			if ($this -> dollarSign) {
				$leftCols = $leftCols / 2 - $rightCols / 2;
			}
			$left = str_pad($this -> name, $leftCols) ;
			
			$sign = ($this -> dollarSign ? '$ ' : '');
			$right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
			return "$left$right\n";
		}
	}
	
try {

	// Enter the share name for your USB printer here
	$connector = new WindowsPrintConnector("smb://PC-Juan/XP-80C");

	$printer = new Printer($connector);

	/* Print a "Hello world" receipt" */
	$printer -> setTextSize(2,2);
	$printer -> text("PRE CUENTA\n");
	$printer -> feed();
	$printer -> selectPrintMode();
	$printer -> text(utf8_decode($data->nomb_c) . "\n");
	$printer -> text("Salón: " . utf8_decode($data->desc_m) . "\n");
	$printer -> text("Mesa: " . utf8_decode($data->nro_mesa) . "\n");
	$printer -> text("Fecha: " . date('d-m-Y h:i A',strtotime($data->fecha_p)) . "\n");
	$printer -> feed();
	$printer -> setEmphasis(true);
	$printer -> text("Detalle de consumo\n");
	$printer -> setEmphasis(false);
	/* Items */
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	$printer -> setEmphasis(true);
	$printer -> text(new item('Producto', 'S/'));
	$printer -> setEmphasis(false);
	$total = 0;
	foreach($data->Detalle as $d){
		$printer -> text(new item(utf8_decode($d->Producto->nombre_prod).' '.utf8_decode($d->Producto->pres_prod), number_format(($d->cantidad * $d->precio),2)));
		$total = ($d->cantidad * $d->precio) + $total;
	}
	$printer -> feed();
	/* Total */
	$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
	$printer -> text($total);
	$printer -> selectPrintMode();
	$printer -> cut();

	/* Close printer */
	$printer -> close();

} catch(Exception $e) {
	echo "No se pudo imprimir en esta impresora " . $e -> getMessage() . "\n";
}
?>
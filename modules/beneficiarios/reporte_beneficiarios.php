<?php
//Incluir archivos
include('../../bd/funciones_bd.inc');
require('../../libs/fpdf153/fpdf.php');  

//Para formto de fechas
include_once('../../core/formatearfechas.php');


//Se extiende la clase FPDF
class PDF extends FPDF
{
	var $title;
	var $title1;	
	var $SQL;
	var $idreg;

		//var $nombre_tipo_cotizacion;

	var $elaborado_por;
	var $revisado_por;
	var $autorizado_por;
	
	var $widths;
	var $aligns;
	var $borde;

	/************************************************************************
	* ENCABEZADO DE PAGINA
	************************************************************************/
	function Header()
	{
		
		$title  = $this->title;
		$title1 = $this->title1;
		
		//ENCABEZADO DEL DOCUMENTO
		$this->SetXY(10,13);

		//Formato de encabezado
		$this->SetFont('Arial','B',9);
		$this->SetFillColor(255);
		$this->SetTextColor(0);
	    
		$this->ln(10);   
	
		$this->Cell(260,4,"E.P.S. MADERAS DEL ORINOCO, CA",0,1,'C',1);
		$this->Cell(260,4,"GERENCIA DE PRODUCTOS ASERRADOS",0,1,'C',1);
		$this->Cell(260,4,"DEPARTAMENTOS DE AUTOGESTIONADO",0,1,'C',1);
		$this->ln(10);   
		$this->Cell(260,4,STRTOUPPER(utf8_decode("REPORTE DE BENEFICIARIOS ")),'0',1,'C',1);
		$this->Image('../../images/logocorporacion.jpg',10,10,40,40);
	    $this->Image('../../images/logoempresa.jpg',220,10,40,40); 
		$this->SetFont('Arial','B',11);
		
		
		
		

	}

	/************************************************************************
	* PIE DE PAGINA
	************************************************************************/
	function Footer()
	{
		//Formato de texto
		$this->SetFillColor(255);
		$this->SetFont('Arial','',8);
		$this->SetTextColor(0);

		//NUMERO DE PAGINA
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->SetXY(10,180);		
		$this->Cell(0,5,'Impreso el: '.date ("d/m/Y") ,'0',1,'L',1);
		$this->SetFont('Arial','',8);		
		$this->SetXY(10,200);
		$this->Cell(0,5,'Pagina '.$this->PageNo().'/{nb}','0',1,'C',1);
		
	}

	/************************************************************************
	* MEJORA DE LAS FUNCIONALIDAD MULTICELDA
	************************************************************************/
	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}
	
	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}
	
	function SetBorde($b)
	{
		//Set the array of column alignments
		$this->borde=$b;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			if($this->borde)
				$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}
	
	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
			$i++;
		}
		return $nl;
	}

	/************************************************************************
	* LINEA
	************************************************************************/
	function linea($x1,$y1,$x2,$y2, $ancho,$c1,$c2,$c3)
	{
		$this->SetDrawColor($c1,$c2,$c3);
		$this->SetLineWidth($ancho);
		$this->Line($x1,$y1,$x2,$y2);
	}

	/************************************************************************
	* MARCO
	************************************************************************/
	function marco()
	{
		//marco externo
		
		$this->linea(5,5,205,5,0.4,0,0,0);	
		$this->linea(5,5,5,292,0.4,0,0,0);	
		$this->linea(5,292,205,292,0.4,0,0,0);
		$this->linea(205,5,205,292,0.4,0,0,0);
		//lineas interna
		$this->linea(5,18,205,18,0.4,0,0,0);	
		$this->linea(5,288,205,288,0.4,0,0,0);
	}

	/************************************************************************
	* CARGAR DATA
	************************************************************************/
	function LoadData()
	{
		
		
		$SQL_1 = " 
				SELECT 
					t1.cedula,
					t1.nombres,
					t1.apellidos,
					t1.sexo,
					to_char(t1.fecha_nacimiento,'dd/mm/yyy') AS fecha_nacimiento,
					t1.direccion,
					t1.telefono,
					t1.estatus
				FROM 
					beneficiarios.beneficiario t1
				ORDER BY t1.cedula
				";
		
		
		$this->ln(10); 
		$this->SetFont('Arial','B',15);
		$this->SetFillColor(255,255,255);	
		$this->SetTextColor(255,20,20);
		$this->Cell(260,4,utf8_decode("Reporte de Benefiricarios"),0,1,'C',1);
		$resul = ejecutarPDO('conexion',$SQL_1);
		if($resul->RowCount()>0)
		{
			$this->ln(10);
			$this->SetFont('Arial','B',10);		
			$this->SetBorde(1);
			$this->SetFillColor(20,111,44);
			//$this->SetDrawColor(20,111,44);
			$this->SetTextColor(255,255,255);
			
			$this->Cell(30,5,utf8_decode("Cédula"),'1',0,'C',1);
			$this->Cell(50,5,utf8_decode("Nombre Completo"),'1',0,'C',1);
			$this->Cell(30,5,utf8_decode("Sexo"),'1',0,'C',1);
			$this->Cell(40,5,utf8_decode("Fecha de Nacimiento"),'1',0,'C',1);
			$this->Cell(50,5,utf8_decode("Dirección"),'1',0,'C',1);
			$this->Cell(30,5,utf8_decode("Teléfono"),'1',0,'C',1);
			$this->Cell(30,5,utf8_decode("Estatus"),'1',0,'C',1);		
			$this->ln(5);
			
			//echo $sql;
			$this->SetWidths(array(30,50,30,40,50,30,30));
			$this->SetAligns(array('C','C','C','C','C','C','C'));		
			/*******************************************************************************
			/* DETALLE DEL DOCUMENTO
			*******************************************************************************/
			
			foreach ($resul as $fila_det)
			{
				$this->SetX(10);							
				$this->SetDrawColor(0);				
				$this->SetFont('Arial','',8);
				$this->SetTextColor(0);
				$this->Row(
							array(
								$fila_det['cedula'],
								$fila_det['nombres'].' '.$fila_det['apellidos'],
								$fila_det['sexo'],
								$fila_det['fecha_nacimiento'],
								$fila_det['direccion'],
								$fila_det['telefono'],
								$fila_det['estatus'],
							)
						);
					
				}
			
		}
		else
		{
			//Formato de texto
			$this->ln(5);
			$this->SetFillColor(255);
			$this->SetFont('Arial','B',12);
			$this->SetTextColor(0);
			// Asi se hace de modo horizontal
			$this->Cell(260,20,'NO EXISTEN DATOS QUE MOSTRAR','0',0,'C',1);			
			
		}
		
	}
}


//Se crea el PDF
$pdf = new PDF('L','mm','Letter');
$title ='Reporte de Beneficiarios';

// if($_GET['reg'])
// {
	
	
	//Elaborado por
	$elaborado_por = 'Curso';

	//Revisado por
	$revisado_por = 'Nosotros';

	//Autorizado por
	$autorizado_por = 'Nosotros';


	$pdf->elaborado_por = $elaborado_por;
	$pdf->revisado_por = $revisado_por;
	$pdf->autorizado_por = $autorizado_por;
	
	$pdf->SetTitle(utf8_decode($title));
	$pdf->AliasNbPages();
	$pdf->AddPage('L');
	$pdf->SetFont('Times','',8);
	$data=$pdf->LoadData();
	$pdf->Output();
// }
// else
// 	echo "No se reconoce el registro a mostrar.";

?> 

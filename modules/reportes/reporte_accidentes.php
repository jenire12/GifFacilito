<?php
//Incluir archivos
include('../../bd/funciones_bd.inc');
require('../../libs/fpdf153/fpdf.php');  


//Se extiende la clase FPDF
class PDF extends FPDF
{
	var $title;
	var $title1;	
	var $SQL;
	var $idreg;
			
	var $fecha_inicial;
	var $fecha_final;
	var $criterio;
	var $campo_criterio;

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
	
		$this->Cell(260,4,utf8_decode("COMPLEJO SIDERURGICO NACIONAL"),0,1,'C',1);
		$this->Cell(260,4,utf8_decode("DEPARTAMENTO DE PROTECCIÓN INDUSTRIAL"),0,1,'C',1);
		$this->Cell(260,4,utf8_decode("SEGURIDAD Y AMBIENTE"),0,1,'C',1);
		$this->ln(10);
		$this->Image('../../imagenes/logo.jpg',10,10,50,30);	     
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
		//$this->Image('../../imagenes/logo.jpg',10,10,50,30);
		$this->Image('../../imagenes/cintillocsn.png',10,185,260,13);
		
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
		$aux="";
		if ($this->criterio == 'no_criterio'){
			$aux="";
		}else{
			$aux="AND ".$this->criterio." LIKE '%".$this->campo_criterio."%'";
		}			
		
		$SQL = " 
				SELECT 
					t1.id_reporte, fec_registro, 
					to_char(t1.fec_informe, 'DD/MM/YYYY') AS fec_informe, 
					t1.jefe_turno,
					t2.nombres||' '||t2.apellidos AS nombre_jefe,
					t8.descripcion AS desc_departamento, 
					to_char(t1.fec_ocurrencia, 'DD/YY/YYYY') AS fec_ocurrencia,
					t1.turno,
					t3.descripcion AS desc_turno,
					t1.trabajador_lesionado,
					t4.nombres||' '||t4.apellidos AS nombre_trabajador,
					t1.profesion_oficio,
					t1.lesion,
					t5.descripcion AS desc_lesion,					
					t1.descripcion_accidente, 
					t1.recomendaciones, 
					t1.perdida_tiempo, 
					t1.sobretiempo, 
					t1.medico_tratante,
					t6.nombres||' '||t6.apellidos AS nombre_medico,
					t1.enfermero_tratante,
					t7.nombres||' '||t7.apellidos AS nombre_enfermero,					
					t1.lugar_accidente,
					t9.descripcion AS desc_cargo
				FROM 
					tsca_accidente t1					
					LEFT JOIN tsca_mttrabajador t2 ON t1.jefe_turno = t2.id_ficha
					LEFT JOIN tsca_turnos t3 ON t1.turno = t3.id_turno					
					LEFT JOIN tsca_mttrabajador t4 ON t1.trabajador_lesionado = t4.id_ficha
					LEFT JOIN tsca_lesiones t5 ON t1.lesion = t5.cod_lesion
					LEFT JOIN tsca_mttrabajador t6 ON t1.trabajador_lesionado = t6.id_ficha
					LEFT JOIN tsca_mttrabajador t7 ON t1.trabajador_lesionado = t7.id_ficha					
					LEFT JOIN tsca_departamentos t8 ON t2.departamento = t8.cod_departamento
					LEFT JOIN tsca_mtcargo t9 ON t4.cargo = t9.id_cargo
				WHERE					
					t1.fec_informe::date BETWEEN '".$this->fecha_inicial."' AND '".$this->fecha_final."'
					$aux
				ORDER BY t1.id_reporte ASC
				";
		 
		 
		$this->SetFont('Arial','B',15);
		$this->SetFillColor(255,255,255);	
		$this->SetTextColor(255,20,20);
		$this->Cell(260,4,utf8_decode("Reporte de Investigación de Accidentes"),0,1,'C',1);
		$resul = ejecutarPDO("cnx_siceac", $SQL);
		if($resul->RowCount()>0)
		{
			$this->ln(10);
			$this->SetFont('Arial','B',8);		
			$this->SetBorde(1);
			$this->SetFillColor(20,111,44);
			//$this->SetDrawColor(20,111,44);
			$this->SetTextColor(255,255,255);
			
			$this->Cell(20,5,utf8_decode("Fec. Informe"),'1',0,'C',1);
			$this->Cell(30,5,utf8_decode("Supervisor"),'1',0,'C',1);
			$this->Cell(30,5,utf8_decode("Departamento"),'1',0,'C',1);
			$this->Cell(23,5,utf8_decode("Fec. Accidente"),'1',0,'C',1);
			$this->Cell(30,5,utf8_decode("Trabajador"),'1',0,'C',1);
			$this->Cell(15,5,utf8_decode("Ficha"),'1',0,'C',1);
			$this->Cell(20,5,utf8_decode("Cargo"),'1',0,'C',1);
			$this->Cell(30,5,utf8_decode("Lesión"),'1',0,'C',1);
			$this->Cell(30,5,utf8_decode("Médico"),'1',0,'C',1);
			$this->Cell(18,5,utf8_decode("Perdida de T"),'1',0,'C',1);
			$this->Cell(15,5,utf8_decode("Sobre T"),'1',0,'C',1);
			$this->ln(5);
			
			//echo $sql;
			$this->SetWidths(array(20,30,30,23,30,15,20,30,30,18,15));
			$this->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C'));
			/*******************************************************************************
			/* DETALLE DEL DOCUMENTO
			*******************************************************************************/
			
			foreach ($resul as $fila_det)
			{
				$this->SetX(10);							
				$this->SetDrawColor(0);				
				$this->SetFont('Arial','',7);
				$this->SetTextColor(0);
				$this->Row(
							array(
								$fila_det['fec_informe'],
								utf8_decode($fila_det['nombre_jefe']),
								utf8_decode($fila_det['desc_departamento']),
								$fila_det['fec_ocurrencia'],
								utf8_decode($fila_det['nombre_trabajador']),
								$fila_det['trabajador_lesionado'],
								utf8_decode($fila_det['desc_cargo']),
								utf8_decode($fila_det['desc_lesion']),
								utf8_decode($fila_det['nombre_medico']),
								$fila_det['perdida_tiempo'],
								$fila_det['sobretiempo']
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
$title ='Reporte de Accidentes';

// if($_GET['reg'])
// {
	//Recibir fecha inicial
	$fecha_inicial = $_GET['fecha_inicio'];

	//Recibir fecha final
	$fecha_final = $_GET['fecha_fin'];	
	
	$criterio = $_GET['criterio'];
	
	$campo_criterio = $_GET['campo_criterio'];
	
	//Elaborado por
	$elaborado_por = 'Seguridad y Ambiente';

	//Revisado por
	$revisado_por = 'Seguridad y Ambiente';

	//Autorizado por
	$autorizado_por = 'Seguridad y Ambiente';


	$pdf->elaborado_por = $elaborado_por;
	$pdf->revisado_por = $revisado_por;
	$pdf->autorizado_por = $autorizado_por;
	$pdf->fecha_inicial = $fecha_inicial;
	$pdf->fecha_final = $fecha_final;
	$pdf->criterio= $criterio;
	$pdf->campo_criterio = $campo_criterio;
	
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

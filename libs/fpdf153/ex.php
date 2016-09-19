<?php
define('FPDF_FONTPATH','font/');
require('mysql_table.php');

class PDF extends PDF_MySQL_Table
{
function Header()
{
	//Title
	$this->SetFont('Arial','',18);
	$this->Cell(0,6,'World populations',0,1,'C');
	$this->Ln(10);
	//Ensure table header is output
	parent::Header();
}
}

//Connect to database
mysql_connect('localhost','root','');
mysql_select_db('test');

$pdf=new PDF();
$pdf->Open();
$pdf->AddPage();
//First table: put all columns automatically
$pdf->Table('select * from menus');
$pdf->AddPage();
//Second table: specify 3 columns
$pdf->AddCol('id_menu',20,'','C');
$pdf->AddCol('menu',40,'menu');
$prop=array('HeaderColor'=>array(255,150,100),
			'color1'=>array(210,245,255),
			'color2'=>array(255,255,210),
			'padding'=>2);
$pdf->Table('select name,id_menu from menus order by id_menu  0,10',$prop);
$pdf->Output();
?>

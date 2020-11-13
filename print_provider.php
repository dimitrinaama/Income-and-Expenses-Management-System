<?php
require('vendor/fpdf/fpdf.php');
require('connection.php');

class PDF extends FPDF {
	function Header(){
		$connect = mysqli_connect('localhost','root','');
		mysqli_select_db($connect,'egm_income_and_expenses');

		$sql = "SELECT company_name,
						company_website,
						company_email
						FROM tbl_company
					WHERE company_id = '1'";

		$result = mysqli_query($connect, $sql);
		$row = mysqli_fetch_row($result);

		$this->SetFont('Arial','B',18);
		$this->Cell(180	,5,$row[0],0,1,'C');
		$this->SetFont('Arial','',12);
		$this->Cell(180	,5,$row[1],0,1,'C');
		$this->Cell(180	,5,$row[2],0,1,'C');

		$this->Cell(12);

		$this->SetFont('Arial', 'B', 14);
		$this->Ln(5);
		$this->Cell(180	,5,'Providers List',0,1,'C');

		$this->Ln(10);

	}
	function Footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
	}
}

$pdf = new PDF('P','mm','A4');

$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->SetTitle('Providers List');

$query = mysqli_query($conn,"SELECT * FROM tbl_providers");
while($data = mysqli_fetch_array($query)){

	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(190,5,'Provider information',0,1);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'ID',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_id'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Name',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_full_name'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Email',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_email'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Officer Name',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_officer_name'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Telephone',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_telephone'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Cellphone',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_cellphone'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Status',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_status'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Address',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_address'],0,1);		
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Bank Name',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_bank_name'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Bank Account',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_bank_account_number'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Account Type',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_bank_account_type'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Website',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_website'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Username',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_username'],0,1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(30,5,'Password',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(160,5,$data['provider_password'],0,1);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(190,5,'Notes',0,1);
	$pdf->SetFont('Arial','',12);

	$cellWidth = 190;
	$cellHeight = 5;

	if($pdf->GetStringWidth($data['provider_note']) < $cellWidth){
		$line = 1;
	}else{
		$textLength = strlen($data['provider_note']);
		$errMargin = 10;
		$startChar = 0;
		$maxChar = 0;
		$textArray = array();
		$tmpString = "";

		while($startChar < $textLength){
			while(
			$pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
			($startChar+$maxChar) < $textLength ) {
				$maxChar++;
				$tmpString = substr($data['provider_note'],$startChar,$maxChar);
			}
			$startChar = $startChar+$maxChar;
			array_push($textArray,$tmpString);
			$maxChar = 0;
			$tmpString = '';

		}
		$line = count($textArray);
	}

	$xPos = $pdf->GetX();
	$yPos = $pdf->GetY();
	$pdf->MultiCell($cellWidth,$cellHeight,$data['provider_note'],0);

	$pdf->SetXY($xPos + $cellWidth , $yPos);

	$pdf->Ln(150);
}

$pdf->Output('I','Provider Information.pdf');
?>
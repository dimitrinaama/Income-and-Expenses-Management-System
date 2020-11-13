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
		$this->Cell(155	,5,$row[0],0,1,'C');
		$this->SetFont('Arial','',12);
		$this->Cell(155	,5,$row[1],0,1,'C');
		$this->Cell(155	,5,$row[2],0,1,'C');

		$this->Cell(12);

		$this->SetFont('Arial', 'B', 14);
		$this->Ln(5);
		$this->Cell(155	,5,'Expense Categories List',0,1,'C');

		$this->Ln(1);

		$this->SetFont('Arial','B',12);
		$this->SetFillColor(115, 171, 255);
		$this->SetDrawColor(0,0,0);
		$this->SetFont('Arial', '', 12);
		$this->SetTextColor(0,0,0);
		$this->Cell(15,10,'ID',1,0,'',true);
		$this->Cell(80,10,'Expense Category',1,0,'',true);
		$this->Cell(60,10,'Status',1,1,'',true);

	}
	function Footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
	}
}

$pdf = new PDF('P','mm','A4');

$pdf->AliasNbPages('{pages}');
$pdf->SetMargins(25.4,25.4,25.4,25.4);
$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();
$pdf->SetTitle('Expense Categories List');

$pdf->SetFont('Arial','',10);
$pdf->SetDrawColor(0,0,0);

$query = mysqli_query($conn,"SELECT * FROM tbl_expense_categories");

while($data = mysqli_fetch_array($query)){
	$pdf->Cell(15,5,$data[0],1,0);
	$pdf->Cell(80,5,$data[3],1,0);
	$pdf->Cell(60,5,$data[4],1,1);
}

$pdf->Output('I','Expense Categories List.pdf');
?>
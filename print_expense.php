<?php
require('vendor/fpdf/fpdf.php');
require('connection.php');

class PDF extends FPDF {
	function Header(){
		$conn = mysqli_connect('localhost','root','');
		mysqli_select_db($conn,'egm_income_and_expenses');

        $sql = "SELECT company_name,
                        company_website,
                        company_email
                        FROM tbl_company
						WHERE company_id = '1'";

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_row($result);

		$this->SetFont('Arial','B',18);			
		$this->Cell(280	,5,$row[0],0,1,'C');
		$this->SetFont('Arial','',12);
		$this->Cell(280	,5,$row[1],0,1,'C');
		$this->Cell(280	,5,$row[2],0,1,'C');

		$this->Cell(12);

		$this->SetY(15);
		$this->SetFont('Arial', 'B', 18);
		$this->Ln(24);
		$this->SetX(123);
		$this->Write(5, 'Expenses Report');

		$this->SetY(10);
		$this->SetFont('Arial', '', 12);
		$this->Ln(22);
		$this->SetX(240);
		$this->Write(5, 'From '.$_GET["from_date"]);

		$this->SetY(10);
		$this->SetFont('Arial', '', 12);
		$this->Ln(28);
		$this->SetX(240);
		$this->Write(5, 'To '.$_GET["to_date"]);

		$this->Ln(10);

		$this->SetFont('Arial','B',12);
		$this->SetFillColor(115, 171, 255);
		$this->SetDrawColor(0,0,0);
		$this->SetFont('Arial', '', 12);
		$this->SetTextColor(0,0,0);
		$this->Cell(10,10,'ID',1,0,'',true);
		$this->Cell(25,10,'Date',1,0,'',true);
		$this->Cell(65,10,'Description',1,0,'',true);
		$this->Cell(30,10,'Total',1,0,'',true);
		$this->Cell(40,10,'Category',1,0,'',true);
		$this->Cell(60,10,'Provider',1,0,'',true);
		$this->Cell(40,10,'Payment Method',1,1,'',true);
	}
	function Footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
	}
}

$pdf = new PDF('P','mm','A4');

$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage('L');
$pdf->SetTitle('Expenses Report');

$pdf->SetFont('Arial','',10);
$pdf->SetDrawColor(0,0,0);

$expense_query="SELECT expe.expense_date,
			expe.expense_description,
			expe.expense_amount,
			category.expense_category_name,
			prov.provider_full_name,
			paym.payment_name
		FROM tbl_expenses AS expe
		INNER JOIN tbl_expense_categories AS category
		ON expe.expense_category_id = category.expense_category_id 
		INNER JOIN tbl_providers AS prov
		ON expe.provider_id = prov.provider_id 	 	 		
		INNER JOIN tbl_payments AS paym
		ON expe.payment_id = paym.payment_id WHERE 
		(expe.expense_date BETWEEN '".$_GET["from_date"]."' 
		AND '".$_GET["to_date"]."') ORDER BY expe.expense_date ASC";

$expense_records = mysqli_query($conn, $expense_query);

$counter=0;
$expense_total = 0;
while($data = mysqli_fetch_array($expense_records)){
	$counter++;
	$expense_description = $data[1];
	$expense_total = $expense_total+$data[2];
	$expense_category = $data[3];
	$provider = $data[4];
	$payment_method = $data[5];

	if(strlen($expense_description) > 30){
		$expense_description = substr($data[1],0,30).'...';
	}

	if(strlen($expense_category) > 20){
		$expense_category = substr($data[3],0,20).'...';
	}

	if(strlen($provider) > 20){
		$provider = substr($data[4],0,20).'...';
	}

	if(strlen($payment_method) > 17){
		$payment_method = substr($data[5],0,17).'...';
	}

	$pdf->Cell(10,5,$counter,1,0);
	$pdf->Cell(25,5,$data[0],1,0);
	$pdf->Cell(65,5,$expense_description,1,0);
	$pdf->Cell(30,5,'$'.number_format($data[2]),1,0);
	$pdf->Cell(40,5,$expense_category,1,0);
	$pdf->Cell(60,5,$provider,1,0);
	$pdf->Cell(40,5,$payment_method,1,1);

}
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,7,'Total',1,0);
$pdf->Cell(170,7,'$'.number_format($expense_total,2),1,1);

$pdf->Output('I','Expense Report - From '.$_GET["from_date"].' to '.$_GET["to_date"].'.pdf');
?>
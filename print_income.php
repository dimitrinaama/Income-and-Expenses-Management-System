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
		$this->Write(5, 'Income Report');

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
		$this->Cell(60,10,'Customer',1,0,'',true);
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
$pdf->SetTitle('Income Report');

$pdf->SetFont('Arial','',10);
$pdf->SetDrawColor(0,0,0);

$income_query="SELECT inco.income_date,
			inco.income_description,
			inco.income_amount,
			category.income_category_name,
			cust.customer_full_name,
			paym.payment_name
		FROM tbl_income AS inco
		INNER JOIN tbl_income_categories AS category
		ON inco.income_category_id = category.income_category_id 
		INNER JOIN tbl_customers AS cust
		ON inco.customer_id = cust.customer_id 	 	 		
		INNER JOIN tbl_payments AS paym
		ON inco.payment_id = paym.payment_id WHERE 
		(inco.income_date BETWEEN '".$_GET["from_date"]."' 
		AND '".$_GET["to_date"]."') ORDER BY inco.income_date ASC";

$income_records = mysqli_query($conn, $income_query);

$counter=0;
$income_total = 0;
while($data = mysqli_fetch_array($income_records)){
	$counter++;
	$income_description = $data[1];
	$income_total = $income_total+$data[2];
	$income_category = $data[3];
	$customer = $data[4];
	$payment_method = $data[5];

	if(strlen($income_description) > 30){
		$income_description = substr($data[1],0,30).'...';
	}

	if(strlen($income_category) > 20){
		$income_category = substr($data[3],0,20).'...';
	}

	if(strlen($customer) > 20){
		$customer = substr($data[4],0,20).'...';
	}

	if(strlen($payment_method) > 17){
		$payment_method = substr($data[5],0,17).'...';
	}

	$pdf->Cell(10,5,$counter,1,0);
	$pdf->Cell(25,5,$data[0],1,0);
	$pdf->Cell(65,5,$income_description,1,0);
	$pdf->Cell(30,5,'$'.number_format($data[2]),1,0);
	$pdf->Cell(40,5,$income_category,1,0);
	$pdf->Cell(60,5,$customer,1,0);
	$pdf->Cell(40,5,$payment_method,1,1);

}
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,7,'Total',1,0);
$pdf->Cell(170,7,'$'.number_format($income_total,2),1,1);

$pdf->Output('I','Income Report - From '.$_GET["from_date"].' to '.$_GET["to_date"].'.pdf');
?>
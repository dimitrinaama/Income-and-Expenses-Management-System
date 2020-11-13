<?php
// Company action.
require_once "connection.php";
session_start();
$output = '';

if(isset($_POST["action"])){

    // Get company information.
    if($_POST["action"] == "profile_fetch"){
        $sql = "SELECT company_name,
                        company_website,
                        company_email,
                        company_address,
                        company_city,
                        company_country,
                        company_zip_code,
                        company_phone,
                        company_fax
                        FROM tbl_company
                        WHERE company_id = '1'";

        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);

        $output = array(
            'company_name'             =>    $row[0],
            'company_website'          =>    $row[1],
            'company_email'            =>    $row[2],
            'company_address'          =>    $row[3],
            'company_city'             =>    $row[4],
            'company_country'          =>    $row[5],
            'company_zip_code'         =>    $row[6],
            'company_phone'            =>    $row[7],
            'company_fax'              =>    $row[8]
        );
        echo json_encode($output);
    }

    // Update company information.
    if($_POST["action"] == "update_company"){    
        $sql = "UPDATE tbl_company SET company_last_update_by = '".$_SESSION["user_id"]."',
                                company_name = '".$_POST["company_name"]."',
                                company_website = '".$_POST["website"]."',
                                company_email = '".$_POST["email"]."',
                                company_address = '".$_POST["address"]."',
                                company_city = '".$_POST["city"]."',
                                company_country = '".$_POST["country"]."',
                                company_zip_code = '".$_POST["zip_code"]."',
                                company_phone = '".$_POST["phone"]."',
                                company_fax = '".$_POST["fax"]."',
                                company_updated_at = NOW()
                                WHERE company_id = '1'";
        if(mysqli_query($conn, $sql)){    
            $output = array(
                'status'        => 'success',
                'message'       => ' Company information has been updated successfully.',
            );    
        }
        echo json_encode($output);
    }
}
?>

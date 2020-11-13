<?php

//customer_action.php

include "connection.php";
session_start();

$output = '';
if(isset($_POST["action"])){

  // Fetch all customers
  if($_POST["action"] == "customer_fetch"){

    // Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $row_per_page = $_POST['length'];
    $column_index = $_POST['order'][0]['column'];
    $column_name = $_POST['columns'][$column_index]['data'];
    $column_sort_order = $_POST['order'][0]['dir'];
    $search_value = $_POST['search']['value'];

    // Search
    $search_query = " ";
    if($search_value != ''){
      $search_query = " and (customer_id LIKE '%".$search_value."%'
                            OR customer_full_name LIKE '%".$search_value."%'
                            OR customer_email LIKE '%".$search_value."%'
                            OR customer_officer_name LIKE '%".$search_value."%'
                            OR customer_telephone LIKE '%".$search_value."%'
                            OR customer_status LIKE '%".$search_value."%' ) ";
    }

    // Total number of records without filtering
    $sql_customer = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_customers");
    $records = mysqli_fetch_assoc($sql_customer);
    $total_records = $records['allcount'];

    // Total number of records with filtering
    $sql_customer = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_customers WHERE 1 ".$search_query);
    $records = mysqli_fetch_assoc($sql_customer);
    $total_record_with_filter = $records['allcount'];

    // Fetch records
    $customer_query = "SELECT * FROM tbl_customers WHERE 1 ".$search_query." ORDER BY ".$column_name." ".$column_sort_order." LIMIT ".$row.",".$row_per_page;

    $customer_records = mysqli_query($conn, $customer_query);
    $data = array();

    while ($row = mysqli_fetch_assoc($customer_records)){

      $status = '';
      if ($row["customer_status"] == "Active"){
        $status = '<label class="badge badge-success">Active</label>';
      } else if ($row["customer_status"] == "Inactive"){
        $status = '<label class="badge badge-danger">Inactive</label>';
      }

      $data[] = array(
        "customer_id"              =>  $row['customer_id'],
        "customer_full_name"       =>  $row['customer_full_name'],
        "customer_email"           =>  $row['customer_email'],
        "customer_officer_name"    =>  $row['customer_officer_name'],
        "customer_telephone"       =>  $row['customer_telephone'],
        "customer_status"          =>  $status,
        "action"                   =>  '<button type="button" class="btn btn-secondary view_customer btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['customer_id'].'"><i class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-success update_customer btn-sm" id="'.$row['customer_id'].'"><i class="fas fa-edit"></i></button>'
      );
    }

    $response = array(
      "draw"                  => intval($draw),
      "iTotalRecords"         => $total_records,
      "iTotalDisplayRecords"  => $total_record_with_filter,
      "aaData"                => $data
    );

    echo json_encode($response);

  }

  // Add customer
  if($_POST["action"] == "add_customer"){

    $sql = "INSERT INTO tbl_customers (customer_created_by,
                                  customer_full_name,
                                  customer_email,
                                  customer_officer_name,
                                  customer_telephone,
                                  customer_cellphone,
                                  customer_status,
                                  customer_address,
                                  customer_bank_name,
                                  customer_bank_account_number,
                                  customer_bank_account_type,
                                  customer_website,
                                  customer_username,
                                  customer_password,
                                  customer_note,
                                  customer_created_at)
                          VALUES('".$_SESSION["user_id"]."',
                                '".$_POST["full_name"]."',
                                '".$_POST["email"]."',
                                '".$_POST["officer_name"]."',
                                '".$_POST["telephone"]."',
                                '".$_POST["cellphone"]."',
                                '".$_POST["status"]."',
                                '".$_POST["address"]."',
                                '".$_POST["bank_name"]."',
                                '".$_POST["bank_account"]."',
                                '".$_POST["account_type"]."',
                                '".$_POST["website"]."',
                                '".$_POST["username"]."',
                                '".$_POST["password"]."',
                                '".$_POST["notes"]."',
                                NOW())";

    if(mysqli_query($conn, $sql)){
      $output = array(
        'status'          => 'success',
        'message'         => ' New customer has been successfully added.'
      );
    }  

    echo json_encode($output);

  }

  // Single fetch
  if($_POST["action"] == "single_fetch"){

    $sql = "SELECT cust.customer_id,
              cust.customer_full_name,
              cust.customer_email,
              cust.customer_officer_name,
              cust.customer_telephone,
              cust.customer_cellphone,
              cust.customer_address,
              cust.customer_bank_name,
              cust.customer_bank_account_number,
              cust.customer_bank_account_type,
              cust.customer_website,
              cust.customer_username,
              cust.customer_password,
              cust.customer_status,
              cust.customer_note,
              user_1.user_full_name,
              cust.customer_created_at,
              cust.customer_updated_at,
              user_2.user_full_name
            FROM tbl_customers AS cust
            INNER JOIN tbl_users AS user_1
            ON cust.customer_created_by = user_1.user_id 
            LEFT JOIN tbl_users AS user_2
            ON cust.customer_last_update_by = user_2.user_id
            WHERE cust.customer_id = '".$_POST["customer_id"]."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    $output = array(
          "customer_id"		                 =>	$row[0],
          "customer_full_name"		         =>	$row[1],
          "customer_email"		             => $row[2],
          "customer_officer_name"		       => $row[3],
          "customer_telephone"		         => $row[4],
          "customer_cellphone"		         => $row[5],
          "customer_address"		           => $row[6],
          "customer_bank_name"		         => $row[7],
          "customer_bank_account_number"   => $row[8],
          "customer_bank_account_type"	   => $row[9],
          "customer_website"		           => $row[10],
          "customer_username"		           => $row[11],
          "customer_password"		           => $row[12],
          "customer_status"		             => $row[13],
          "customer_note"		               => $row[14],
          "customer_created_by"            => $row[15],
          "customer_created_at"            => $row[16],
          "customer_updated_at"            => $row[17],
          "customer_last_update_by"        => $row[18]
    );

    echo json_encode($output);

  }

  // Update customer information
  if($_POST["action"] == "update_customer"){

    $sql = "UPDATE tbl_customers SET customer_last_update_by = '".$_SESSION["user_id"]."',
                                  customer_full_name = '".$_POST["full_name"]."',
                                  customer_email = '".$_POST["email"]."',
                                  customer_officer_name = '".$_POST["officer_name"]."',
                                  customer_telephone = '".$_POST["telephone"]."',
                                  customer_cellphone = '".$_POST["cellphone"]."',
                                  customer_status = '".$_POST["status"]."',
                                  customer_address = '".$_POST["address"]."',
                                  customer_bank_name = '".$_POST["bank_name"]."',
                                  customer_bank_account_number = '".$_POST["bank_account"]."',
                                  customer_bank_account_type = '".$_POST["account_type"]."',
                                  customer_website = '".$_POST["website"]."',
                                  customer_username = '".$_POST["username"]."',
                                  customer_password = '".$_POST["password"]."',
                                  customer_note = '".$_POST["notes"]."',
                                  customer_updated_at = NOW()
                                WHERE customer_id = '".$_POST["customer_id"]."'";

    if(mysqli_query($conn, $sql)){
      $output = array(
        'status'          => 'success',
        'message'         => ' Customer information has been successfully updated.'
      );
    }

    echo json_encode($output);

  }
}
?>
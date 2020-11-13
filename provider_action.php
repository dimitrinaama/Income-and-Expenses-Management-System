<?php

//provider_action.php

include "connection.php";
session_start();

$output = '';
if(isset($_POST["action"])){

  // Fetch all providers
  if($_POST["action"] == "provider_fetch"){

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
      $search_query = " and (provider_id LIKE '%".$search_value."%'
                            OR provider_full_name LIKE '%".$search_value."%'
                            OR provider_email LIKE '%".$search_value."%'
                            OR provider_officer_name LIKE '%".$search_value."%'
                            OR provider_telephone LIKE '%".$search_value."%'
                            OR provider_status LIKE '%".$search_value."%' ) ";
    }

    // Total number of records without filtering
    $sql_provider = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_providers");
    $records = mysqli_fetch_assoc($sql_provider);
    $total_records = $records['allcount'];

    // Total number of records with filtering
    $sql_provider = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_providers WHERE 1 ".$search_query);
    $records = mysqli_fetch_assoc($sql_provider);
    $total_record_with_filter = $records['allcount'];

    // Fetch records
    $provider_query = "SELECT * FROM tbl_providers WHERE 1 ".$search_query." ORDER BY ".$column_name." ".$column_sort_order." LIMIT ".$row.",".$row_per_page;

    $provider_records = mysqli_query($conn, $provider_query);
    $data = array();

    while ($row = mysqli_fetch_assoc($provider_records)){

      $status = '';
      if ($row["provider_status"] == "Active"){
        $status = '<label class="badge badge-success">Active</label>';
      } else if ($row["provider_status"] == "Inactive"){
        $status = '<label class="badge badge-danger">Inactive</label>';
      }

      $data[] = array(
        "provider_id"              =>  $row['provider_id'],
        "provider_full_name"       =>  $row['provider_full_name'],
        "provider_email"           =>  $row['provider_email'],
        "provider_officer_name"    =>  $row['provider_officer_name'],
        "provider_telephone"       =>  $row['provider_telephone'],
        "provider_status"          =>  $status,
        "action"                   =>  '<button type="button" class="btn btn-secondary view_provider btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['provider_id'].'"><i class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-success update_provider btn-sm" id="'.$row['provider_id'].'"><i class="fas fa-edit"></i></button>'
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

  // Add provider
  if($_POST["action"] == "add_provider"){

    $sql = "INSERT INTO tbl_providers (provider_created_by,
                                  provider_full_name,
                                  provider_email,
                                  provider_officer_name,
                                  provider_telephone,
                                  provider_cellphone,
                                  provider_status,
                                  provider_address,
                                  provider_bank_name,
                                  provider_bank_account_number,
                                  provider_bank_account_type,
                                  provider_website,
                                  provider_username,
                                  provider_password,
                                  provider_note,
                                  provider_created_at)
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
        'message'         => ' New provider has been successfully added.'
      );
    }  

    echo json_encode($output);

  }

  // Single fetch
  if($_POST["action"] == "single_fetch"){

    $sql = "SELECT prov.provider_id,
              prov.provider_full_name,
              prov.provider_email,
              prov.provider_officer_name,
              prov.provider_telephone,
              prov.provider_cellphone,
              prov.provider_address,
              prov.provider_bank_name,
              prov.provider_bank_account_number,
              prov.provider_bank_account_type,
              prov.provider_website,
              prov.provider_username,
              prov.provider_password,
              prov.provider_status,
              prov.provider_note,
              user_1.user_full_name,
              prov.provider_created_at,
              prov.provider_updated_at,
              user_2.user_full_name
            FROM tbl_providers AS prov 
            INNER JOIN tbl_users AS user_1
            ON prov.provider_created_by = user_1.user_id 
            LEFT JOIN tbl_users AS user_2
            ON prov.provider_last_update_by = user_2.user_id
            WHERE prov.provider_id = '".$_POST["provider_id"]."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    $output = array(
          "provider_id"		                 =>	$row[0],
          "provider_full_name"		         =>	$row[1],
          "provider_email"		             => $row[2],
          "provider_officer_name"		       => $row[3],
          "provider_telephone"		         => $row[4],
          "provider_cellphone"		         => $row[5],
          "provider_address"		           => $row[6],
          "provider_bank_name"		         => $row[7],
          "provider_bank_account_number"   => $row[8],
          "provider_bank_account_type"	   => $row[9],
          "provider_website"		           => $row[10],
          "provider_username"		           => $row[11],
          "provider_password"		           => $row[12],
          "provider_status"		             => $row[13],
          "provider_note"		               => $row[14],
          "provider_created_by"            => $row[15],
          "provider_created_at"            => $row[16],
          "provider_updated_at"            => $row[17],
          "provider_last_update_by"        => $row[18]
    );

    echo json_encode($output);

  }

  // Update provider information
  if($_POST["action"] == "update_provider"){

    $sql = "UPDATE tbl_providers SET provider_last_update_by = '".$_SESSION["user_id"]."',
                                  provider_full_name = '".$_POST["full_name"]."',
                                  provider_email = '".$_POST["email"]."',
                                  provider_officer_name = '".$_POST["officer_name"]."',
                                  provider_telephone = '".$_POST["telephone"]."',
                                  provider_cellphone = '".$_POST["cellphone"]."',
                                  provider_status = '".$_POST["status"]."',
                                  provider_address = '".$_POST["address"]."',
                                  provider_bank_name = '".$_POST["bank_name"]."',
                                  provider_bank_account_number = '".$_POST["bank_account"]."',
                                  provider_bank_account_type = '".$_POST["account_type"]."',
                                  provider_website = '".$_POST["website"]."',
                                  provider_username = '".$_POST["username"]."',
                                  provider_password = '".$_POST["password"]."',
                                  provider_note = '".$_POST["notes"]."',
                                  provider_updated_at = NOW()
                                WHERE provider_id = '".$_POST["provider_id"]."'";

    if(mysqli_query($conn, $sql)){
      $output = array(
        'status'          => 'success',
        'message'         => ' Provider information has been successfully updated.'
      );
    }

    echo json_encode($output);

  }
}
?>
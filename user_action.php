<?php

//user_action.php
include "connection.php";
session_start();

$output = '';
if(isset($_POST["action"])){

  // Fetch all users
  if($_POST["action"] == "user_fetch"){
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
      $search_query = " and (user_id LIKE '%".$search_value."%'
                            OR user_full_name LIKE '%".$search_value."%'
                            OR user_email LIKE '%".$search_value."%'
                            OR user_gender LIKE '%".$search_value."%'
                            OR user_status LIKE '%".$search_value."%'
                            OR user_role LIKE '%".$search_value."%' ) ";
    }

    // Total number of records without filtering
    $sql_user = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_users");
    $records = mysqli_fetch_assoc($sql_user);
    $total_records = $records['allcount'];

    // Total number of records with filtering
    $sql_user = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_users WHERE 1 ".$search_query);
    $records = mysqli_fetch_assoc($sql_user);
    $total_record_with_filter = $records['allcount'];

    // Fetch records
    $user_query = "SELECT * FROM tbl_users WHERE 1 ".$search_query." ORDER BY ".$column_name." ".$column_sort_order." LIMIT ".$row.",".$row_per_page;

    $user_records = mysqli_query($conn, $user_query);
    $data = array();

    while ($row = mysqli_fetch_assoc($user_records)){
      $status = '';
      if ($row["user_status"] == "Active"){
        $status = '<label class="badge badge-success">Active</label>';
      } else if ($row["user_status"] == "Inactive"){
        $status = '<label class="badge badge-danger">Inactive</label>';
      }

      $data[] = array(
        "user_id"              =>  $row['user_id'],
        "user_full_name"       =>  $row['user_full_name'],
        "user_email"           =>  $row['user_email'],
        "user_gender"          =>  $row['user_gender'],
        "user_role"            =>  $row['user_role'],
        "user_status"          =>  $status,
        "action"               =>  '<button type="button" class="btn btn-secondary view_user btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['user_id'].'"><i class="fas fa-eye"></i></button>
                                    <button type="button" class="btn btn-success update_user btn-sm" id="'.$row['user_id'].'"><i class="fas fa-edit"></i></button>'
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

  // Add user
  if($_POST["action"] == "add_user"){
    // Check if email already exists.
    $sql = "SELECT * FROM tbl_users WHERE user_email = '".$_POST["email"]."'";
    $result = mysqli_query($conn, $sql);
    $check_rows = mysqli_num_rows($result);

    if($check_rows > 0) {
      $output = array(
        'status'          =>	'error',
      );
    } else {
      $sql = "INSERT INTO tbl_users (user_created_by, 
                                    user_full_name, 
                                    user_email,
                                    user_gender,
                                    user_status,
                                    user_role,
                                    user_password,
                                    user_created_at) 
                            VALUES('".$_SESSION["user_id"]."',
                                  '".$_POST["full_name"]."',
                                  '".$_POST["email"]."',
                                  '".$_POST["gender"]."',
                                  '".$_POST["status"]."',
                                  '".$_POST["role"]."',
                                  '".sha1($_POST['password'])."',
                                  NOW())";

      if(mysqli_query($conn, $sql)){
        $output = array(
          'status'          => 'success',
          'message'         => ' New user has been successfully added.'
        );
      }
    }
    echo json_encode($output);
  }

  // Single fetch
  if($_POST["action"] == "single_fetch"){
    $sql = "SELECT u1.user_id,
                    u1.user_full_name,
                    u1.user_email,
                    u1.user_gender,
                    u1.user_status,
                    u1.user_role,
                    u2.user_full_name,
                    u1.user_created_at,
                    u1.user_updated_at,
                    u3.user_full_name
                  FROM tbl_users AS u1 
                  INNER JOIN tbl_users AS u2
                  ON u1.user_created_by=u2.user_id 
                  LEFT JOIN tbl_users AS u3
                  ON u1.user_last_update_by=u3.user_id 
                  WHERE u1.user_id = '".$_POST["user_id"]."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    $output = array(
        "user_id"                  =>  $row[0],
        "user_full_name"           =>  $row[1],
        "user_email"               =>  $row[2],
        "user_gender"              =>  $row[3],
        "user_status"              =>  $row[4],
        "user_role"                =>  $row[5],
        "user_created_by"          =>  $row[6],
        "user_created_at"          =>  $row[7],
        "user_updated_at"          =>  $row[8],
        "user_last_update_by"      =>  $row[9]
    );
    echo json_encode($output);
  }

  // Update User Profile
  if($_POST["action"] == "update_user_profile"){
    // Check if email already exists.
    $sql = "SELECT * FROM tbl_users WHERE user_email = '".$_POST["update_email"]."' AND user_id != '".$_POST["update_profile_id"]."'";
    $result = mysqli_query($conn, $sql);
    $check_rows = mysqli_num_rows($result);

    if($check_rows > 0) {
      $output = array(
        'status'      =>	'error',
      );
    } else {
      $sql = "UPDATE tbl_users SET user_last_update_by = '".$_SESSION["user_id"]."',
                                    user_full_name = '".$_POST["update_full_name"]."',
                                    user_email = '".$_POST["update_email"]."',
                                    user_gender = '".$_POST["update_gender"]."',
                                    user_role = '".$_POST["update_role"]."',
                                    user_status = '".$_POST["update_status"]."',
                                    user_updated_at = NOW()
                                  WHERE user_id = '".$_POST["update_profile_id"]."'";

      if(mysqli_query($conn, $sql)){
        $output = array(
          'status'          => 'success',
          'message'         => ' User profile has been successfully updated.'
        );
      }
    }
    echo json_encode($output);
  }

  // Update User Password
  if($_POST["action"] == "update_user_password"){
    $sql = "UPDATE tbl_users SET user_last_update_by = '".$_SESSION["user_id"]."',
                                    user_password = '".sha1($_POST['update_password'])."',
                                    user_updated_at = NOW()
                                  WHERE user_id = '".$_POST["update_password_id"]."'";

    if(mysqli_query($conn, $sql)){
      $output = array(
        'status'          => 'success',
        'message'         => ' User password has been successfully updated.'
      );
    }
    echo json_encode($output);
  }
}
?>
<?php
include "connection.php";

  $output = '';
  if(isset($_POST["action"])){

    if($_POST["action"] == "add_info"){
      $sql_total_income = "SELECT sum(income_amount) FROM tbl_income";
      $sql_total_expenses = "SELECT sum(expense_amount) FROM tbl_expenses";
      $sql_total_income_this_month = "SELECT sum(income_amount) FROM tbl_income WHERE MONTH(`income_date`)=MONTH(CURRENT_DATE) AND YEAR(`income_date`)=YEAR(CURRENT_DATE)";
      $sql_total_expenses_this_month = "SELECT sum(expense_amount) FROM tbl_expenses WHERE MONTH(`expense_date`)=MONTH(CURRENT_DATE) AND YEAR(`expense_date`)=YEAR(CURRENT_DATE)";

      $total_income_result = mysqli_query($conn, $sql_total_income);
      $total_expense_result = mysqli_query($conn, $sql_total_expenses);
      $total_income_this_month_result = mysqli_query($conn, $sql_total_income_this_month);
      $total_expenses_this_month_result = mysqli_query($conn, $sql_total_expenses_this_month);

      $row1 = mysqli_fetch_row($total_income_result);
      $row2 = mysqli_fetch_row($total_expense_result);
      $row3 = mysqli_fetch_row($total_income_this_month_result);
      $row4 = mysqli_fetch_row($total_expenses_this_month_result);

      $output=array(
        'total_income'               => '$'.number_format($row1[0]),
        'total_expenses'             => '$'.number_format($row2[0]),
        'total_income_this_month'    => '$'.number_format($row3[0]),
        'total_expenses_this_month'  => '$'.number_format($row4[0])
      );

      echo json_encode($output);

    }

    // Get total monthly amount of income and expenses of the months that have passed on the current year.
    if($_POST["action"] == "income_vs_expense_info"){

      $sql_income = "SELECT MONTHNAME(income_date), SUM(income_amount) 
      FROM tbl_income WHERE YEAR(`income_date`)=YEAR(CURRENT_DATE) GROUP BY YEAR(income_date), MONTH(income_date)";
  
      $sql_expense = "SELECT MONTHNAME(expense_date), SUM(expense_amount) 
      FROM tbl_expenses WHERE YEAR(`expense_date`)=YEAR(CURRENT_DATE) GROUP BY YEAR(expense_date), MONTH(expense_date)";
  
      $income_result = mysqli_query($conn, $sql_income);
  
      $expenses_result = mysqli_query($conn, $sql_expense);
  
      $monthly_income = array();
      while ($row = mysqli_fetch_row($income_result)){
        $monthly_income[] = $row[0];
        $total_month_income[] = $row[1];
      }

      $monthly_expenses = array();
      while ($row = mysqli_fetch_row($expenses_result)){
        $monthly_expenses[] = $row[0];        
        $total_month_expense[] = $row[1];      
      }

      $months_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      $monthly_default_income_values = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      $monthly_default_expenses_values = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

      $count = 0;
      foreach($months_list as $month){
        $income_array_length = count($monthly_income);
        for($i=0; $i < $income_array_length; $i++){
          if($month == $monthly_income[$i]){
            $monthly_default_income_values[$count]=$total_month_income[$i]; 
          }
        }
        $count++;
      }

      $count = 0;
      foreach($months_list as $month){
        $expenses_array_length = count($monthly_expenses);
        for($i=0; $i < $expenses_array_length; $i++){
          if($month == $monthly_expenses[$i]){
            $monthly_default_expenses_values[$count]=$total_month_expense[$i]; 
          }
        }
        $count++;
      }

      $output=array(
        'total_month_income'     => $monthly_default_income_values,
        'total_month_expense'    => $monthly_default_expenses_values,
      );

      echo json_encode($output);

    }

    // Get Income by Category
    if($_POST["action"] == "income_category_info"){

      $sql_income_category="SELECT exp_cat.income_category_name, count(exp.income_id)
                  FROM tbl_income_categories exp_cat
                  LEFT JOIN tbl_income exp ON exp_cat.income_category_id=exp.income_category_id
                  GROUP BY exp_cat.income_category_id
                  ORDER BY count(exp.income_id)DESC,
                  exp_cat.income_category_name ASC";

      $income_category_result=mysqli_query($conn,$sql_income_category);

      $i=105;
      while ($row = mysqli_fetch_row($income_category_result)){
        $income_category[] = $row[0];
        $total_income[] = $row[1];
        $colors[] = '#'.substr(md5($i=$i+5), 0, 6);
      }

      $output=array(
        'income_category'   => $income_category,
        'total_income'      => $total_income,
        'colors'            => $colors,
      );

      echo json_encode($output);

    }

    // Get Expenses by Category
    if($_POST["action"] == "expense_category_info"){

      $sql_expenses_category="SELECT exp_cat.expense_category_name, count(exp.expense_id)
                  FROM tbl_expense_categories exp_cat
                  LEFT JOIN tbl_expenses exp ON exp_cat.expense_category_id=exp.expense_category_id
                  GROUP BY exp_cat.expense_category_id
                  ORDER BY count(exp.expense_id)DESC,
                  exp_cat.expense_category_name ASC";

      $expenses_result_category=mysqli_query($conn,$sql_expenses_category);
      $i=135;
      while ($row = mysqli_fetch_row($expenses_result_category)){
        $expense_category[] = $row[0];
        $total_expenses[] = $row[1];
        $colors[] = '#'.substr(md5($i=$i+5), 0, 6);
      }

      $output=array(
        'expense_category'  => $expense_category,
        'total_expenses'    => $total_expenses,
        'colors'            => $colors,
      );

      echo json_encode($output);

    }
  }
?>
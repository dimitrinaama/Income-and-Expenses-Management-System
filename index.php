<?php include('include/header.php'); ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <div>
        <a href="income.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-dollar-sign fa-sm text-white-50"></i> Manage Income</a>
        <a href="expense.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-credit-card fa-sm text-white-50"></i> Manage Expenses</a>
      </div>
    </div>

    <!-- Content Row -->
    <div class="row">

      <!-- Total Income -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Income This Year</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="view_total_income"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Total Income -->

      <!-- Total Expenses -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success  text-uppercase mb-1">Total Expenses This Year</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="view_total_expenses"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-credit-card fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Total Expenses -->

      <!-- Income This Month -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Income This Month</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="view_total_income_this_month"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Income This Month -->

      <!-- Expense This Month -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Expenses This Month</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="view_total_expenses_this_month"></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-credit-card fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.Expense This Month -->

    <!-- Content Row -->

    <div class="row">

      <!-- Income vs Expenses Report -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Income vs Expenses Report</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <canvas id="expenses_category_distribution" width="100%" height="30"></canvas>
          </div>
        </div>
      </div>
      <!-- /.Income vs Expenses Report -->

    </div>
    <!-- Content Row -->

    <div class="row">

      <!-- Income by Category Chart -->
      <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Income by Category</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <canvas id="income_category_distribution" width="200%" height="120"></canvas>
          </div>
        </div>
      </div>
      <!-- /.Income by Category Chart -->

      <!-- Expenses by Category -->
      <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Expenses by Category</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <canvas id="expense_category_distribution" width="200%" height="120"></canvas>
          </div>
        </div>
      </div>
      <!-- /.Expenses by Category -->

    </div>

  </div>
  <!-- /.container-fluid -->

<?php include('include/footer.php'); ?>

<script>
  $.ajax({
    url:"admin_action.php",
    method:"POST",
    data:{action:'add_info'},
    dataType: "json",
    success:function(data){
      $('#view_total_income').text(data['total_income']);
      $('#view_total_expenses').text(data['total_expenses']);
      $('#view_total_income_this_month').text(data['total_income_this_month']);
      $('#view_total_expenses_this_month').text(data['total_expenses_this_month']);
    }
  });

  $.ajax({
    url:"admin_action.php",
    method:"POST",
    data:{action:'income_vs_expense_info'},
    dataType: "json",
    success:function(data){

      var maximum = 5000;
      var largest_income = 1000;
      var largest_expense = 1000;

      // Get largest value from total month income and total month expense to set the maximum value on the line Chart.
      var largest_income = Math.max.apply(0, data.total_month_income);
      var largest_expense = Math.max.apply(0, data.total_month_expense);

      if(largest_income >= largest_expense){
        maximum = (Math.floor((largest_income) * 1.10));
      } else {
        maximum = (Math.floor((largest_expense) * 1.10));
      }

      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';

      // Line Chart Created Expenses
      var expenses_category_distribution = document.getElementById("expenses_category_distribution");
      var myLineChart = new Chart(expenses_category_distribution, {
        type: 'line',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          datasets: [{
            label: "Month total expenses",
            lineTension: 0.3,
            backgroundColor: "rgba(216,2,2,0.2)",
            borderColor: "rgba(216,2,2,1)",
            pointRadius: 5,
            pointBackgroundColor: "rgba(216,2,2,1)",
            pointBorderColor: "rgba(255,255,255,0.8)",
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(216,2,2,1)",
            pointHitRadius: 50,
            pointBorderWidth: 2,
            data: data.total_month_expense,
          },
          {
            label: "Month total income",
            lineTension: 0.3,
            backgroundColor: "rgba(2,117,216,0.2)",
            borderColor: "rgba(2,117,216,1)",
            pointRadius: 5,
            pointBackgroundColor: "rgba(2,117,216,1)",
            pointBorderColor: "rgba(255,255,255,0.8)",
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(2,117,216,1)",
            pointHitRadius: 50,
            pointBorderWidth: 2,
            data: data.total_month_income,
          }            
        ],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: true
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: maximum,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              }
            }],
          },
          legend: {
            display: true
          }
        }
      });
    }
  });

  $.ajax({
    url:"admin_action.php",
    method:"POST",
    data:{action:'income_category_info'},
    dataType: "json",
    success:function(data){
      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';

      // Pie Chart of Expense Category Distribution
      var income_category_distribution = document.getElementById("income_category_distribution");
      var income_category_distribution = new Chart(income_category_distribution, {
        type: 'doughnut',
        data: {
          labels: data.income_category,
          datasets: [{
            data: data.total_income,
            backgroundColor: data.colors,
          }],
        },
      });
    }
  });

  $.ajax({
    url:"admin_action.php",
    method:"POST",
    data:{action:'expense_category_info'},
    dataType: "json",
    success:function(data){
      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';

      // Pie Chart of Expense Category Distribution
      var expense_category_distribution = document.getElementById("expense_category_distribution");
      var expense_category_distribution = new Chart(expense_category_distribution, {
        type: 'doughnut',
        data: {
          labels: data.expense_category,
          datasets: [{
            data: data.total_expenses,
            backgroundColor: data.colors,
          }],
        },
      });
    }
  });
</script>
<?php
//header.php  
session_start();
if(!isset($_SESSION["user_email"])){
  header('location: login.html');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Income and Expenses Management System</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.jpg">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <i class="fas fa-search-dollar"></i>
        </div>
        <div class="sidebar-brand-text mx-3">I&EMS</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Income -->
      <li class="nav-item">
        <a class="nav-link" href="income.php">
          <i class="fas fa-dollar-sign fa-fw"></i>
          <span> Income</span></a>
      </li>

      <!-- Nav Item - Expenses -->
      <li class="nav-item">
        <a class="nav-link" href="expense.php">
          <i class="fas fa-credit-card fa-fw"></i>          
          <span>Expenses</span></a>
      </li>

      <!-- Nav Item - Expense Category -->
      <li class="nav-item">
        <a class="nav-link" href="expense_category.php">
          <i class="fas fa-list-ul fa-fw"></i>
          <span> Expense Category</span></a>
      </li>

      <!-- Nav Item - Income Category -->
      <li class="nav-item">
        <a class="nav-link" href="income_category.php">
          <i class="fas fa-list-ul fa-fw"></i>
          <span> Income Category</span></a>
      </li>

      <!-- Nav Item - Payments -->
      <li class="nav-item">
        <a class="nav-link" href="payment.php">
          <i class="fas fa-money-bill-alt fa-fw"></i>
          <span>Payments</span></a>
      </li>

      <!-- Nav Item - Customers -->
      <li class="nav-item">
        <a class="nav-link" href="customer.php">
          <i class="fas fa-users fa-fw"></i>
          <span>Customers</span></a>
      </li>

      <!-- Nav Item - Providers -->
      <li class="nav-item">
        <a class="nav-link" href="provider.php">
          <i class="fas fa-truck fa-fw"></i>
          <span>Providers</span></a>
      </li>

      <?php if($_SESSION['user_role']=="Admin"): ?>
      <!-- Nav Item - Users -->
      <li class="nav-item">
        <a class="nav-link" href="user.php">
          <i class="fas fa-users fa-fw"></i>
          <span>Users</span></a>
      </li>
      <?php endif; ?>

      <!-- Nav Item - Profile -->
      <li class="nav-item">
        <a class="nav-link" href="profile.php">
          <i class="fas fa-user-cog fa-fw"></i>
          <span>Profile</span></a>
      </li>

      <?php if($_SESSION['user_role']=="Admin"): ?>
      <!-- Nav Item - Profile -->
      <li class="nav-item">
        <a class="nav-link" href="company.php">
          <i class="fas fa-sliders-h"></i>
          <span>Settings</span></a>
      </li>
      <?php endif; ?>
      
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user_full_name']; ?></span>
                <i class="fas fa-user-circle fa-sm fa-fw mr-2 text-gray-400"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                  <i class="fas fa-user-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
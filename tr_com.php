<?php
session_start();

if (!isset($_SESSION['admin'])){
  header('location:login.php');
}

include("dbcon.php");
date_default_timezone_set("Asia/Manila");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="900; url=logout.php">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.4/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
    <title>Transactions</title>
    <link rel="icon" href="logo/logo2.png" type="image/x-icon" />
</head>
<body style="background-color:#f0f0f0;">

<!-- NAVBAR -->
<nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #043047;">
  <div class="container">
    <h2 style="color: white;"><i class="bi bi-tools me-2"></i>FixitFinder</h2>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
          <ul class="navbar-nav nav-fill nav-pills nav-tabs">
            <li class="nav-item">
              <a class="nav-link" href="index.php" style="color: white;"><i class="bi bi-pie-chart me-2"></i>Dashboard</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;"><i class="bi bi-house me-2"></i>Homeowners</a>  
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="ho_pen.php">Pending</a></li>
                  <li><a class="dropdown-item" href="ho_ver.php">Verified</a></li>
                  <li><a class="dropdown-item" href="ho_sus.php">Suspended</a></li>
                  <li><a class="dropdown-item" href="ho_ter.php">Terminated</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;"><i class="bi bi-wrench-adjustable me-2"></i>Workers</a>    
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="wk_pen.php">Pending</a></li>
                  <li><a class="dropdown-item" href="wk_ver.php">Verified</a></li>
                  <li><a class="dropdown-item" href="wk_sus.php">Suspended</a></li>
                  <li><a class="dropdown-item" href="wk_ter.php">Terminated</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;"><i class="bi bi-envelope-paper me-2"></i>Transactions</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="tr_pen.php">Pending</a></li>
                  <li><a class="dropdown-item" href="tr_ong.php">Ongoing</a></li>
                  <li><a class="dropdown-item" href="tr_com.php">Completed</a></li>
                  <li><a class="dropdown-item" href="tr_dec.php">Declined</a></li>
                </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="reports.php" style="color: white;"><i class="bi bi-flag me-2"></i>Reports</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php" style="color: red;"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
            </li>
          </ul>
        </div>
  </div>
</nav>
<br>

<!-- HEADER -->
<div class="container justify-content-center rounded">
<p class="fs-2 text-center">COMPLETED TRANSACTIONS</p><hr>

<div class="container text-center">
  <div class="row align-items-center">
    <div class="col">
    <div class="form-group mb-3">
      <label for="">From</label>
      <input type="text" name="min" id="min"  class="form-control">
    </div>
    </div>
    <div class="col">
    <div class="form-group mb-3">
      <label for="">To</label>
      <input type="text" name="max" id="max"  class="form-control">
    </div>
    </div>
  </div>
</div>
<hr>

<!-- TABLE -->
<table id="myTable" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Homeowner</th>
        <th scope="col" class="text-center">Worker</th>
        <th scope="col" class="text-center">Job</th>
        <th scope="col" class="text-center">Status</th>
        <th scope="col" class="text-center">Date</th> 
      </tr>
    </thead>

    <tbody>
        <?php
        $count = 0;
        $fetchdata = $database->getReference('TransactionCompleted')->getValue();
        if(is_array($fetchdata)){
          foreach($fetchdata as $key => $row){
            $fetchdata2 = $database->getReference('TransactionCompleted/'.$key)->getValue();
            if(is_array($fetchdata2)){
              foreach($fetchdata2 as $key2 => $row2){
                $fetchdata3 = $database->getReference('TransactionCompleted/'.$key.'/'.$key2)->getValue();
                if(is_array($fetchdata3)){
                  foreach($fetchdata3 as $key3 => $row3){
                    $count += 1;
        ?>
               <tr>
                    <td scope="col" class="text-center"><?= $row3['homeownername']; ?></td>
                    <td scope="col" class="text-center"><?= $row3['workername']; ?></td>
                    <td scope="col" class="text-center"><?= $row3['job']; ?></td>
                    <td scope="col" class="text-center"><?= $row3['status']; ?></td>
                    <td scope="col" class="text-center"><?= $row3['completeddate']; ?></td>
               </tr> 
        <?php
                  }
                }
              }
            }
          }
        }
        ?>
    </tbody>
</table>
<hr>
<div class="text-center">
    <h6>Total: <?= $count ?></h4>
</div>
</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.4/js/dataTables.dateTime.min.js"></script>

<!-- TABLE -->
<script>
  new DataTable('#myTable', {
    order: [[4, 'desc']],
    scrollCollapse: true,
    scrollY: '50vh',
    info: false,
    "language": {
            "lengthMenu": "Show _MENU_ Entries",
        }
  });
</script>

<!-- DATE RANGE FILTER -->
<script>
let minDate, maxDate;
 
 DataTable.ext.search.push(function (settings, data, dataIndex) {
     let min = minDate.val();
     let max = maxDate.val();
     let date = new Date(data[4]);
  
     if (
         (min === null && max === null) ||
         (min === null && date <= max) ||
         (min <= date && max === null) ||
         (min <= date && date <= max)
     ) {
         return true;
     }
     return false;
 });
  
 minDate = new DateTime('#min', {
     format: 'MMMM Do YYYY'
 });
 maxDate = new DateTime('#max', {
     format: 'MMMM Do YYYY'
 });
  
 let table = new DataTable('#myTable');
  
 document.querySelectorAll('#min, #max').forEach((el) => {
     el.addEventListener('change', () => table.draw());
 });
</script>

<!-- REFRESH -->
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

</body>
</html>
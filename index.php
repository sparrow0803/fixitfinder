<?php
session_start();

if (!isset($_SESSION['admin'])){
  header('location:login.php');
}

include("dbcon.php");
date_default_timezone_set("Asia/Manila");
use PHPMAILER\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$fetchdata7 = $database->getReference('users')->getValue();
  if(is_array($fetchdata7)){
    foreach($fetchdata7 as $key7 => $row7){
      if(isset($row7['lift_suspension']) && $row7['lift_suspension'] == date('Y-m-d')){
        $updateData = [
          'verification'=>'Verified',
          'ver_last_update'=>date('Y-m-d'),
          'lift_suspension'=>"N/A"
        ];
        $database->getReference('users/'.$key7)->update($updateData);

        $body='';
        $body.= '
        <html>
        <body style="color: #000; font-size: 16px; text-decoration: none; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;">

        <div id="wrapper" style="max-width: 600px; margin: auto auto; padding: 20px;">

        <div id="content" style="font-size: 16px; padding: 25px; background-color: #fff;
        moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px; -khtml-border-radius: 10px;
        border-color: #043047; border-width: 4px 1px; border-style: solid;">
        <center>
        <img src="cid:logo" width="100" height="50">
        </center>
        <h2 style="font-size: 18px;">ACCOUNT REACTIVATION! </h2>
        <p style="font-size: 15px;">Your homeowner account has been lifted on its suspension. You can now use your account again.</p><br>
        <p style="font-size: 13px">© FixitFinder</p>
        </div>
  
        </div>

        </body></html> ';

        $email = $row7['email'];
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'officialfixitfinder@gmail.com';
        $mail->Password = 'sdjxnpjfinsbtzoy';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->AddEmbeddedImage(dirname(__FILE__) . '/logo/logo.png', 'logo');

        $mail->setFrom('officialfixitfinder@gmail.com','FixitFinder');
        $mail->addAddress($email);
        $mail->addReplyTo('officialfixitfinder@gmail.com','FixitFinder');

        $mail->isHTML(true);
        $mail->Subject = 'Account Reactivation';
        $mail->Body = $body;
        $mail->send();
      }
    }
  }

  $fetchdata8 = $database->getReference('worker_users')->getValue();
  if(is_array($fetchdata7) && is_array($fetchdata8)){
    foreach($fetchdata7 as $key7 => $row7){
      foreach($fetchdata8 as $key8 => $row8){
      if(isset($row8['lift_suspension']) && $row8['lift_suspension'] == date('Y-m-d') && $key7 == $key8){
        $updateData = [
          'worker_verification'=>'Verified',
          'worker_last_update'=>date('Y-m-d'),
          'lift_suspension'=>"N/A"
        ];
        $database->getReference('worker_users/'.$key8)->update($updateData);

        $body='';
        $body.= '
        <html>
        <body style="color: #000; font-size: 16px; text-decoration: none; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;">

        <div id="wrapper" style="max-width: 600px; margin: auto auto; padding: 20px;">

        <div id="content" style="font-size: 16px; padding: 25px; background-color: #fff;
        moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px; -khtml-border-radius: 10px;
        border-color: #043047; border-width: 4px 1px; border-style: solid;">
        <center>
        <img src="cid:logo" width="100" height="50">
        </center>
        <h2 style="font-size: 18px;"> ACCOUNT REACTIVATION! </h2>
        <p style="font-size: 15px;">Your worker account has been lifted on its suspension. You can now use your account again.</p><br>
        <p style="font-size: 13px">© FixitFinder</p>
        </div>
  
        </div>

        </body></html> ';

        $email = $row7['email'];
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'officialfixitfinder@gmail.com';
        $mail->Password = 'sdjxnpjfinsbtzoy';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->AddEmbeddedImage(dirname(__FILE__) . '/logo/logo.png', 'logo');

        $mail->setFrom('officialfixitfinder@gmail.com','FixitFinder');
        $mail->addAddress($email);
        $mail->addReplyTo('officialfixitfinder@gmail.com','FixitFinder');

        $mail->isHTML(true);
        $mail->Subject = 'Account Reactivation';
        $mail->Body = $body;
        $mail->send();
      }
    }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="900; url=logout.php">
  <title>Dashboard</title>
  <link rel="icon" href="logo/logo2.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
              <a class="nav-link active" href="index.php" style="color: white;"><i class="bi bi-pie-chart me-2"></i>Dashboard</a>
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
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;"><i class="bi bi-envelope-paper me-2"></i>Transactions</a>
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

<!-- HOMEOWNER CHART -->
<?php
$ho_ver = 0;
$ho_pen = 0;
$ho_sus = 0;
$ho_ter = 0;

$fetchdata = $database->getReference('users')->getValue();
if(is_array($fetchdata)){
    foreach($fetchdata as $key => $row){
      if( $row['verification'] == 'Verified'){
        $ho_ver++;
      }
      elseif( $row['verification'] == 'Pending'){
        $ho_pen++;
      }
      elseif( $row['verification'] == 'Suspended'){
        $ho_sus++;
      }
      elseif( $row['verification'] == 'Terminated'){
        $ho_ter++;
      }
      else{
        continue;
      }
    }
}
else{
  $ho_ver = 0;
  $ho_pen = 0;
  $ho_sus = 0;
  $ho_ter = 0;
}

$ho_total = array($ho_ver, $ho_pen, $ho_sus, $ho_ter);
?>

<!-- WORKER CHART -->
<?php
$wk_ver = 0;
$wk_pen = 0;
$wk_sus = 0;
$wk_ter = 0;

$fetchdata = $database->getReference('users')->getValue();
$fetchdata2 = $database->getReference('worker_users')->getValue();
if(is_array($fetchdata) && is_array($fetchdata2)){
  foreach($fetchdata as $key => $row){
    foreach($fetchdata2 as $key2 => $row2){
      if($row2['worker_verification'] == 'Verified' && $key2 == $key){
        $wk_ver++;
      }
      elseif( $row2['worker_verification'] == 'Pending' && $key2 == $key){
        $wk_pen++;
      }
      elseif( $row2['worker_verification'] == 'Suspended' && $key2 == $key){
        $wk_sus++;
      }
      elseif( $row2['worker_verification'] == 'Terminated' && $key2 == $key){
        $wk_ter++;
      }
      else{
        continue;
      }
    }
  }
}
else{
  $wk_ver = 0;
  $wk_pen = 0;
  $wk_sus = 0;
  $wk_ter = 0;
}

$wk_total = array($wk_ver, $wk_pen, $wk_sus, $wk_ter);
?>

<!-- INFO FETCH -->
<?php
$total_ho = 0;
$fetchdata = $database->getReference('users')->getValue();
if(is_array($fetchdata)){
foreach($fetchdata as $key => $row){
    $total_ho += 1;
}
}

$total_wk = 0;
$fetchdata = $database->getReference('users')->getValue();
$fetchdata2 = $database->getReference('worker_users')->getValue();
if(is_array($fetchdata) && is_array($fetchdata2)){
  foreach($fetchdata as $key => $row){
    foreach($fetchdata2 as $key2 => $row2){
      if($row2['worker_verification'] == 'In Process' || $key2 != $key){
        continue ;
      }
      else{
      $total_wk += 1;
      }
    }
  }
}

$total_tr = 0;
$fetchdata = $database->getReference('TransactionCompleted')->getValue();
if(is_array($fetchdata)){
foreach($fetchdata as $key => $row){
  $fetchdata2 = $database->getReference('TransactionCompleted/'.$key)->getValue();
  if(is_array($fetchdata2)){
  foreach($fetchdata2 as $key2 => $row2){
    $fetchdata3 = $database->getReference('TransactionCompleted/'.$key.'/'.$key2)->getValue();
    if(is_array($fetchdata3)){
    foreach($fetchdata3 as $key3 => $row3){
      $total_tr += 1;
    }
    }
  }
  }
}
}

$total_rep = 0;
$fetchdata = $database->getReference('Reports')->getValue();
if(is_array($fetchdata)){
foreach($fetchdata as $key => $row){
  if($row['status'] == "Pending"){
    $total_rep += 1;
  }
  else{
    continue ;
  }
}
}
?>

<!-- INFO -->
<div class="container">

  <div class="row g-3 m-1">
  <h1>DASHBOARD</h1><br>
  </div>

  <div class="row g-3 m-1">
    <div class="col-md-3">
      <div class="p-3 rounded" style="background-color:#043047; color:#f0f0f0;">
        <h3><i class="bi bi-house me-2"></i><?= $total_ho ?></h3>
        <p class="fs-5">Total Homeowners</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="p-3 rounded" style="background-color:#FFD041;">
        <h3><i class="bi bi-wrench-adjustable me-2"></i><?= $total_wk ?></h3>
        <p class="fs-5">Total Workers</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="p-3 rounded" style="background-color:#043047; color:#f0f0f0;">
        <h3><i class="bi bi-envelope-paper me-2"></i><?= $total_tr ?></h3>
        <p class="fs-5">Successful Transactions</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="p-3 rounded" style="background-color:#FFD041;">
        <h3><i class="bi bi-flag me-2"></i><?= $total_rep ?></h3>
        <p class="fs-5">Pending Reports</p>
      </div>
    </div>
  </div>



  <div class="row g-3 m-1">
  <div class="col">
    <canvas class="p-3 rounded bg-white" id="myChart"></canvas>
  </div>
  <div class="col">
    <canvas class="p-3 rounded bg-white" id="myChart2"><canvas>
  </div>
  </div>

</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- HOMEOWNER CHART -->
<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Verified', 'Pending', 'Suspended', 'Terminated'],
      datasets: [{
        label: 'Homeowners',
        data: <?php echo json_encode($ho_total) ?>,
        borderWidth: 1,
        backgroundColor: '#043047'
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<!-- WORKER CHART -->
<script>
  const ctx2 = document.getElementById('myChart2');

  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Verified', 'Pending', 'Suspended', 'Terminated'],
      datasets: [{
        label: 'Workers',
        data: <?php echo json_encode($wk_total) ?>,
        borderWidth: 1,
        backgroundColor: '#FFD041'
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
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
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

if(isset($_POST['verify'])){


    $updatedata = [
        'verification'=>'Verified',
        'ver_last_update'=>date('Y-m-d')
    ];

    $houpdate = $database->getReference('users/'.$_POST['verify'])->update($updatedata);

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
    <h2 style="font-size: 18px;"> WELCOME! </h2>
    <p style="font-size: 15px;">Your FixitFinder homeowner account is now verified!</p>
    <p style="font-size: 15px;">You can now access the full features of the application.</p><br>
    <p style="font-size: 13px">© FixitFinder</p>
    </div>
    

    </div>
  
    </body></html> ';
  
    $email = $_POST['email'];
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
    $mail->Subject = 'Account Verification';
    $mail->Body = $body;
  
    if($mail->send() && $houpdate){
      $_SESSION['verify_success'] = "Successful Verification!";
    }
    else{
      $_SESSION['verify_failed'] = "Verification Failed!";
    }
}

if(isset($_POST['send'])){

    $op = '';
    $qry = $_POST['qry'];
    foreach($qry as $rsn){
      $op .= "<h5> - ".$rsn."</h5>";
    }

    
    $deletequery_result = $database->getReference('users/'.$_POST['hid'])->remove();
    $deletequery_result2 = $database->getReference('worker_users/'.$_POST['hid'])->remove();
    
    $uid = $_POST['hid'];
    $auth->deleteUser($uid);

    $fetch1 = $database->getReference('users_selfie/'.$_POST['hid'])->getValue();
    if (is_array($fetch1)){
      $database->getReference('users_selfie/'.$_POST['hid'])->remove();
    }

    $fetch2 = $database->getReference('users_image/'.$_POST['hid'])->getValue();
    if (is_array($fetch2)){
      $database->getReference('users_image/'.$_POST['hid'])->remove();
    }
  
  
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
    <h2 style="font-size: 18px;"> NOTICE! </h2>
    <p style="font-size: 15px;">Good day! We regret to inform you that your homeowner account did not meet the requirements for validation due to the following:</p>
    '.$op.'
    <p style="font-size: 15px;">Please comply all the following queries by registering again in the application.</p><br>
    <p style="font-size: 13px">© FixitFinder</p>
    </div>
    

    </div>
  
    </body></html> ';
  
    $email = $_POST['send'];
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
    $mail->Subject = 'Account Validation';
    $mail->Body = $body;
  
    if($mail->send() && $deletequery_result && $deletequery_result2){
      $_SESSION['email_success'] = "DONE";
    }
    else{
      $_SESSION['email_fail'] = "FAIL";
    }
}

if(isset($_POST['detect'])){

    $deletequery_result = $database->getReference('users/'.$_POST['id'])->remove();
    $deletequery_result2 = $database->getReference('worker_users/'.$_POST['id'])->remove();
    
    $uid = $_POST['id'];
    $auth->deleteUser($uid);

    $fetch1 = $database->getReference('users_selfie/'.$_POST['id'])->getValue();
    if (is_array($fetch1)){
      $database->getReference('users_selfie/'.$_POST['id'])->remove();
    }

    $fetch2 = $database->getReference('users_image/'.$_POST['id'])->getValue();
    if (is_array($fetch2)){
      $database->getReference('users_image/'.$_POST['id'])->remove();
    }

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
    <h2 style="font-size: 18px;"> NOTICE! </h2>
    <p style="font-size: 15px;">Our system detected that your account has matched one of our existing suspended or terminated accounts. We regret to inform you that this account will be deleted under the suspicion of abusing the registration within the application.</p>
    <p style="font-size: 15px;">If your account is currently in suspension, please wait for the reactivation date.</p><br>
    <p style="font-size: 13px">© FixitFinder</p>
    </div>
    

    </div>
  
    </body></html> ';
  
    $email = $_POST['detect'];
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
    $mail->Subject = 'Account Review';
    $mail->Body = $body;
  
    if($mail->send() && $deletequery_result && $deletequery_result2){
      $_SESSION['email_success'] = "DONE";
    }
    else{
      $_SESSION['email_fail'] = "FAIL";
    }

}

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
    <title>Homeowners Pending Verification</title>
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
              <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;"><i class="bi bi-house me-2"></i>Homeowners</a>  
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

<!-- VERIFY MODAL -->
<div class="modal fade" id="verifymodal" tabindex="-1" aria-labelledby="verifymodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="verifymodalLabel">Homeowner Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      </div>

    </div>
</div>
</div>

<!-- HEADER -->
<div class="container justify-content-center rounded">
<p class="fs-2 text-center">HOMEOWNERS PENDING VERIFICATION</p><hr>

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
        <th scope="col" class="text-center">Name</th>
        <th scope="col" class="text-center">Email</th>
        <th scope="col" class="text-center">Last Updated</th>
        <th scope="col" class="text-center">Status</th>
        <th scope="col" class="text-center">Action</th> 
      </tr>
    </thead>

    <tbody>
        <?php
        $count = 0;
        $fetchdata = $database->getReference('users')->getValue();
        if(is_array($fetchdata)){
            foreach($fetchdata as $key => $row){
                if($row['verification'] != 'Pending'){
                    continue ;
                }
                else{
                    $count += 1;
        ?>
               <tr>
                    <td scope="col" class="text-center"><?= $row['fullname']; ?></td>
                    <td scope="col" class="text-center"><?= $row['email']; ?></td>
                    <td scope="col" class="text-center"><?= $row['ver_last_update']; ?></td>
                    <td scope="col" class="text-center"><?= $row['verification']; ?></td>
                    <td scope="col" class="text-center">
                        <div class='btn-group' role='group' aria-label='Basic mixed styles example'>
                            <button type='button' id='<?php echo $key; ?>' class='btn btn-outline-success verifybtn' value='<?php echo $key; ?>'><i class="bi bi-check-lg"></i></button>
                        </div>
                    </td>
               </tr> 
        <?php
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
    order: [[2, 'desc']],
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
     let date = new Date(data[2]);
  
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

<!-- MODAL -->
<script>
  $(document).ready(function () {
    $('#myTable').on('click', '.verifybtn', function() {
        var id = $(this).val();

      $.ajax({url: "ho_info.php",
        method:"POST",
        data:{hopen:id},
        success: function(result){
          $(".modal-body").html(result);
        }

      });

      $('#verifymodal').modal('show');
    });
  });
</script>

<!-- SWEETALERT SUCCESS -->
<?php
if(isset($_SESSION['verify_success']))
{
?>
<script>
    Swal.fire({
    title: "<?php echo $_SESSION['verify_success']; ?>",
    text: "User has been verified!",
    icon: "success",
    confirmButtonText: 'OK',
    confirmButtonColor: "#043047",
    });
</script>
<?php unset($_SESSION['verify_success']); } ?>

<?php
if(isset($_SESSION['email_success']))
{
?>
<script>
    Swal.fire({
    title: "<?php echo $_SESSION['email_success']; ?>",
    text: "Accound Deleted & Email Sent Succesfully!",
    icon: "success",
    confirmButtonText: 'OK',
    confirmButtonColor: "#043047",
    });
</script>
<?php unset($_SESSION['email_success']); } ?>

<!-- SWEETALERT FAIL -->
<?php
if(isset($_SESSION['verify_failed']))
{
?>
<script>
    Swal.fire({
    title: "<?php echo $_SESSION['verify_failed']; ?>",
    text: "Error!",
    icon: "error",
    confirmButtonText: 'OK',
    confirmButtonColor: "#043047",
    });
</script>
<?php unset($_SESSION['verify_failed']); } ?>

<?php
if(isset($_SESSION['email_fail']))
{
?>
<script>
    Swal.fire({
    title: "<?php echo $_SESSION['email_fail']; ?>",
    text: "Failed To Send Email!",
    icon: "error",
    confirmButtonText: 'OK',
    confirmButtonColor: "#043047",
    });
</script>
<?php unset($_SESSION['email_fail']); } ?>

<!-- CHECKBOX VALIDATION -->
<script>
  function checkFormData(){
    if ($('input:checkbox').filter(':checked').length < 1){
      alert("Please Check At Least One Reason");
      return false;
    }
  }
 </script>

<!-- REFRESH -->
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

</body>
</html>
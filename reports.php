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

if(isset($_POST['send'])){
$reason = '';
$description = '';

$updateData = [
  'status'=>'Resolved',
  'action_taken'=>$_POST['reason'],
  'date_updated'=>date('Y-m-d')
];

$updatequery = $database->getReference('Reports/'.$_POST['id'])->update($updateData);

if($_POST['reason'] == 'Warning Sent'){
  $reason = $_POST['reason'];
  $description = 'We already sent a warning to the user you reported. After three consecutive warnings, that account will be up for either suspension or termination.';
}

  if($_POST['reason'] == 'Account Suspended'){
    $reason = $_POST['reason'];
    $description = 'The account you reported has already been suspended and currently in suspension state.';
  }

  else if($_POST['reason'] == 'Account Terminated'){
    $reason = $_POST['reason'];
    $description = 'The account you reported has already been terminated. They can no longer use their account';
  }

  else if($_POST['reason'] == 'Invalid Report: Not Enough Evidence'){
    $reason = $_POST['reason'];
    $description = 'Your report does not have enough evidence. Please submit another report through the application.';
  }

  else if($_POST['reason'] == 'Invalid Report: Not Enough Information'){
    $reason = $_POST['reason'];
    $description = 'Your report lacks enough information to be processed. Please submit another report and add more subject, description or evidence on your ticket.';
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
    <p style="font-size: 16px;">The report you submitted has been processed by our admin. Below are the details:</p>
    <p style="font-size: 15px;">Issued By: '.$_POST['reporter_name'].'</p>
    <p style="font-size: 15px;">User Reported: '.$_POST['reported_name'].'</p>
    <p style="font-size: 15px;">Issue Status: Resolved</p>
    <p style="font-size: 15px;">Date Submitted: '.$_POST['date_submitted'].'</p>
    <p style="font-size: 15px;">Date Resolved: '.$_POST['date_updated'].'</p>
    <p style="font-size: 15px;">Action Taken: '.$reason.'</p>
    <p style="font-size: 15px;">Description: '.$description.'</p><br>
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
    $mail->Subject = 'Ticket Information';
    $mail->Body = $body;
  
    if($mail->send() && $updatequery){
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
    <title>REPORTS</title>
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
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;"><i class="bi bi-envelope-paper me-2"></i>Transactions</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="tr_pen.php">Pending</a></li>
                  <li><a class="dropdown-item" href="tr_ong.php">Ongoing</a></li>
                  <li><a class="dropdown-item" href="tr_com.php">Completed</a></li>
                  <li><a class="dropdown-item" href="tr_dec.php">Declined</a></li>
                </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="reports.php" style="color: white;"><i class="bi bi-flag me-2"></i>Reports</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php" style="color: red;"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
            </li>
          </ul>
        </div>
  </div>
</nav>
<br>

<!-- INFO MODAL -->
<div class="modal fade" id="infomodal" tabindex="-1" aria-labelledby="infomodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="infomodalLabel">Report Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      </div>

    </div>
</div>
</div>

<!-- HEADER -->
<div class="container justify-content-center rounded">
<p class="fs-2 text-center">REPORTS</p><hr>

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
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Issued By</th>
        <th scope="col" class="text-center">Reported</th>
        <th scope="col" class="text-center">Status</th>
        <th scope="col" class="text-center">Action</th> 
      </tr>
    </thead>

    <tbody>
        <?php
        $count = 0;
        $status = '';
        $fetchdata = $database->getReference('Reports')->getValue();
        if(is_array($fetchdata)){
            foreach($fetchdata as $key => $row){
              $count += 1;
                if($row['status'] == 'Pending'){
                  $status = "<td scope='col' class='table-danger text-center'>" .$row['status']. "</td>";
                }
                else{
                  $status = "<td scope='col' class='table-success text-center'>" .$row['status']. "</td>";
                }
                    
        ?>
               <tr>
                    <td scope="col" class="text-center"><?= $row['date_updated']; ?></td>
                    <td scope="col" class="text-center"><?= $row['reporter_name']; ?></td>
                    <td scope="col" class="text-center"><?= $row['reported_name']; ?></td>
                    <?= $status; ?>
                    <td scope="col" class="text-center">
                        <div class='btn-group' role='group' aria-label='Basic mixed styles example'>
                            <button type='button' id='<?php echo $key; ?>' class='btn btn-outline-dark infobtn' value='<?php echo $key; ?>'><i class="bi bi-info-circle"></i></button>
                        </div>
                    </td>
               </tr> 
        <?php
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
    order: [[0, 'desc']],
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
     let date = new Date(data[0]);
  
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
    $('#myTable').on('click', '.infobtn', function() {
        var id = $(this).val();

      $.ajax({url: "rep_info.php",
        method:"POST",
        data:{rep:id},
        success: function(result){
          $(".modal-body").html(result);
        }

      });

      $('#infomodal').modal('show');
    });
  });
</script>

<!-- SWEETALERT SUCCESS -->
<?php
if(isset($_SESSION['email_success']))
{
?>
<script>
    Swal.fire({
    title: "<?php echo $_SESSION['email_success']; ?>",
    text: "Email Sent Succesfully!",
    icon: "success",
    confirmButtonText: 'OK',
    confirmButtonColor: "#043047",
    });
</script>
<?php unset($_SESSION['email_success']); } ?>

<!-- SWEETALERT FAIL -->

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
    if ($('input:radio').filter(':checked').length < 1){
      alert("Please Choose One");
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
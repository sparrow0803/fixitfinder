<?php
session_start();

if (!isset($_SESSION['admin'])){
  header('location:login.php');
}

include("dbcon.php");
date_default_timezone_set("Asia/Manila");

if(isset($_POST['rep'])){
$output = '';

$fetchdata = $database->getReference('Reports')->getValue();
if(is_array($fetchdata)){
    foreach($fetchdata as $key => $row){
        if($key == $_POST['rep'] && $row['status'] == 'Pending'){

$output .= 

'<form method="POST" action="reports.php" onsubmit="return checkFormData()">

<input type="hidden" name="id" value='.$key.'>

<div class="row">    
<div class="col"> 
<div class="form-group mb-3">
<label for="">Issued By</label>
<input type="text" name="reporter_name" id="reporter_name" value="'.$row["reporter_name"].' ('.$row["reporter_type"].')" class="form-control" readonly>
</div>
</div>
    
<div class="col"> 
<div class="form-group mb-3">
<label for="">Reported</label>
<input type="text" name="reported_name" id="reported_name" value="'.$row["reported_name"].' ('.$row["reported_type"].')" class="form-control" readonly>
</div>
</div>
</div>

<div class="row">    
<div class="col"> 
<div class="form-group mb-3">
<label for="">Reporter ID</label>
<input type="text" name="reporter_id" id="reporter_id" value="'.$row["reporter_id"].'" class="form-control" readonly>
</div>
</div>
    
<div class="col"> 
<div class="form-group mb-3">
<label for="">Reported ID</label>
<input type="text" name="reported_id" id="reported_id" value="'.$row["reported_id"].'" class="form-control" readonly>
</div>
</div>
</div>

<div class="row">    
<div class="col"> 
<div class="form-group mb-3">
<label for="">Reporter Email</label>
<input type="text" name="reporter_email" id="reporter_email" value="'.$row["reporter_email"].'" class="form-control" readonly>
</div>
</div>
    
<div class="col"> 
<div class="form-group mb-3">
<label for="">Reported Email</label>
<input type="text" name="reported_email" id="reported_email" value="'.$row["reported_email"].'" class="form-control" readonly>
</div>
</div>
</div>

<div class="row">    
<div class="col"> 
<div class="form-group mb-3">
<label for="">Date Submitted</label>
<input type="text" name="date_submitted" id="date_submitted" value="'.$row["date_submitted"].'" class="form-control" readonly>
</div>
</div>
    
<div class="col"> 
<div class="form-group mb-3">
<label for="">Date Updated</label>
<input type="text" name="date_updated" id="date_updated" value="'.$row["date_updated"].'" class="form-control" readonly>
</div>
</div>
</div>

<div class="form-group mb-3">
<label for="" style="color: red">Report Subject</label>
<textarea name="report_subject" id="report_subject" class="form-control" readonly>'.$row["report_subject"].'</textarea>
</div>

<div class="form-group mb-3">
<label for="" style="color: red">Description</label>
<textarea name="report_desc" id="report_desc" class="form-control" readonly>'.$row["report_desc"].'</textarea>
</div>

<div class="row">
<div class="col">
<label for="">Evidence 1</label><br>
<a href="'.$row['report_evi_pic1'].'" target="_blank">
<img src="'.$row['report_evi_pic1'].'" style="width: 250px;"><br>
</a>
</div>

<div class="col">
<label for="">Evidence 2</label><br>
<a href="'.$row['report_evi_pic2'].'" target="_blank">
<img src="'.$row['report_evi_pic2'].'" style="width: 250px;"><br>
</a>
</div>
</div>

<hr>

<div class="form-group mb-3">

<label for="">ACTION TAKEN</label>

<div class="form-check">
<input class="form-check-input" name="reason" type="radio" value="Warning Sent" id="chk1">
<label class="form-check-label" for="flexCheckDefault">
Warning Sent
</label>
</div>

<div class="form-check">
<input class="form-check-input" name="reason" type="radio" value="Account Suspended" id="chk1">
<label class="form-check-label" for="flexCheckDefault">
Account Suspended
</label>
</div>

<div class="form-check">
<input class="form-check-input" name="reason" type="radio" value="Account Terminated" id="chk1">
<label class="form-check-label" for="flexCheckDefault">
Account Terminated
</label>
</div>

<div class="form-check">
<input class="form-check-input" name="reason" type="radio" value="Invalid Report: Not Enough Evidence" id="chk1">
<label class="form-check-label" for="flexCheckDefault">
Invalid Report: Not Enough Evidence
</label>
</div>

<div class="form-check">
<input class="form-check-input" name="reason" type="radio" value="Invalid Report: Not Enough Information" id="chk1">
<label class="form-check-label" for="flexCheckDefault">
Invalid Report: Not Enough Information
</label>
</div>

</div>
<button type="submit" name="send" value="'.$row["reporter_email"].'" class="btn btn-dark">Send</button>
</form>';

        }

else if ($key == $_POST['rep'] && $row['status'] == 'Resolved'){
  
  $output .= 

  '
  <div class="row">    
  <div class="col"> 
  <div class="form-group mb-3">
  <label for="">Issued By</label>
  <input type="text" name="reporter_name" id="reporter_name" value="'.$row["reporter_name"].' ('.$row["reporter_type"].')" class="form-control" readonly>
  </div>
  </div>
      
  <div class="col"> 
  <div class="form-group mb-3">
  <label for="">Reported</label>
  <input type="text" name="reported_name" id="reported_name" value="'.$row["reported_name"].' ('.$row["reported_type"].')" class="form-control" readonly>
  </div>
  </div>
  </div>
  
  <div class="row">    
  <div class="col"> 
  <div class="form-group mb-3">
  <label for="">Reporter ID</label>
  <input type="text" name="reporter_id" id="reporter_id" value="'.$row["reporter_id"].'" class="form-control" readonly>
  </div>
  </div>
      
  <div class="col"> 
  <div class="form-group mb-3">
  <label for="">Reported ID</label>
  <input type="text" name="reported_id" id="reported_id" value="'.$row["reported_id"].'" class="form-control" readonly>
  </div>
  </div>
  </div>
  
  <div class="row">    
  <div class="col"> 
  <div class="form-group mb-3">
  <label for="">Reporter Email</label>
  <input type="text" name="reporter_email" id="reporter_email" value="'.$row["reporter_email"].'" class="form-control" readonly>
  </div>
  </div>
      
  <div class="col"> 
  <div class="form-group mb-3">
  <label for="">Reported Email</label>
  <input type="text" name="reported_email" id="reported_email" value="'.$row["reported_email"].'" class="form-control" readonly>
  </div>
  </div>
  </div>
  
  <div class="row">    
  <div class="col"> 
  <div class="form-group mb-3">
  <label for="">Date Submitted</label>
  <input type="text" name="date_submitted" id="date_submitted" value="'.$row["date_submitted"].'" class="form-control" readonly>
  </div>
  </div>
      
  <div class="col"> 
  <div class="form-group mb-3">
  <label for="">Date Updated</label>
  <input type="text" name="date_updated" id="date_updated" value="'.$row["date_updated"].'" class="form-control" readonly>
  </div>
  </div>
  </div>
  
  <div class="form-group mb-3">
  <label for="" style="color: red">Report Subject</label>
  <textarea name="report_subject" id="report_subject" class="form-control" readonly>'.$row["report_subject"].'</textarea>
  </div>
  
  <div class="form-group mb-3">
  <label for="" style="color: red">Description</label>
  <textarea name="report_desc" id="report_desc" class="form-control" readonly>'.$row["report_desc"].'</textarea>
  </div>

  <div class="form-group mb-3">
  <label for="" style="color: green">Action Taken</label>
  <input type="text" name="action_taken" id="action_taken" value="'.$row["action_taken"].'" class="form-control" readonly>
  </div>
  
  <div class="form-group mb-3">
  <label for="">Evidence</label><br>
  <a href="'.$row['report_evi_pic1'].'" target="_blank">
  <img src="'.$row['report_evi_pic1'].'" style="width: 250px;"><br>
  </a>
  </div>';

}
    }
}
echo $output;
}

?>
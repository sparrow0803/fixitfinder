<?php
session_start();

if (!isset($_SESSION['admin'])){
  header('location:login.php');
}

include("dbcon.php");
date_default_timezone_set("Asia/Manila");

if(isset($_POST['hopen'])){
    $output = '';
    $selfie = '';
    $valid_id = '';
    $type_id = 'N/A';

    $fetchselfie = $database->getReference('users_selfie')->getValue();
    if(is_array($fetchselfie)){
        foreach($fetchselfie as $key2 => $row2){
            if($key2 == $_POST['hopen']){
            $selfie = $row2['picture'];
            }
        }
    }

    $fetchvalidid = $database->getReference('users_image')->getValue();
    if(is_array($fetchvalidid)){
        foreach($fetchvalidid as $key3 => $row3){
            if($key3 == $_POST['hopen']){
            $valid_id = $row3['picture'];
            $type_id = $row3['type_of_id'];
            }
        }
    }

    $detect = '';
    $fetchdata = $database->getReference('users')->getValue();
    if(is_array($fetchdata)){
        foreach($fetchdata as $key => $row){
            if($key == $_POST['hopen']){

                  $fetchdata7 = $database->getReference('users')->getValue();
                  $fetchdata8 = $database->getReference('worker_users')->getValue();
                  if(is_array($fetchdata7) || is_array($fetchdata8)){
                  foreach($fetchdata7 as $key7 => $row7){
                    foreach($fetchdata8 as $key8 => $row8){
                      if (strtolower($row['fullname']) == strtolower($row7['fullname']) && $row['dateofbirth'] == $row7['dateofbirth'] && ($row7['verification'] == 'Suspended' || $row7['verification'] == 'Terminated' || $row8['worker_verification'] == 'Suspended')){
                        $detect = "<div class='form-group mb-3'>
                        <label for='' style='color: red;'>The system detected that this account matched the credentials of an existing suspended or terminated account. Would you like to delete this account?</label>
                        <input type='hidden' name='id' value='".$key."'>
                        <button type='submit' name='detect' class='btn btn-danger' value='".$row['email']."'>YES</button>
                        </div><hr>";
                      }
                    }
                  }
                  }

    $output .= 
    
    '<form method="POST" action="ho_pen.php">
    
    '.$detect.'

    <div class="row">    
    <div class="col"> 
    <div class="form-group mb-3">
      <label for="">Fullname</label>
      <input type="text" name="fullname" id="fullname" value="'.$row["fullname"].'" class="form-control" readonly>
    </div>
    </div>
    
    <div class="col"> 
    <div class="form-group mb-3">
      <label for="">ID</label>
      <input type="text" name="id" id="id" value="'.$key.'" class="form-control" readonly>
    </div>
    </div>
    </div>

    <div class="row">    
    <div class="col">
    <div class="form-group mb-3">
      <label for="">Email</label>
      <input type="text" name="email" id="email" value="'.$row["email"].'" class="form-control" readonly>
    </div>
    </div>

    <div class="col">
    <div class="form-group mb-3">
      <label for="">Contact #</label>
      <input type="text" name="number" id="number" value="'.$row["number"].'" class="form-control" readonly>
    </div>
    </div>
    </div>

    <div class="form-group mb-3">
      <label for="">Address</label>
      <input type="text" name="address" id="address" value="'.$row["fulladdress"].' ('.$row["zipcode"].')" class="form-control" readonly>
    </div>

    <div class="row">
    <div class="col">
    <div class="form-group mb-3">
      <label for="">Submitted Date</label>
      <input type="text" name="ver_submit_date" id="ver_submit_date" value="'.$row["ver_submit_date"].'" class="form-control" readonly>
    </div>
    </div>

    <div class="col">
    <div class="form-group mb-3">
      <label for="">Last Updated</label>
      <input type="text" name="ver_last_update" id="ver_last_update" value="'.$row["ver_last_update"].'" class="form-control" readonly>
    </div>
    </div>
    </div>

    <div class="row">
    <div class="col">
    <label for="">Picture</label><br>
    <a href="'.$selfie.'" target="_blank">
    <img src="'.$selfie.'" style="width: 250px;"><br>
    </a>
    </div>

    <div class="col">
    <label for="">Valid ID ('.$type_id.')</label><br>
    <a href="'.$valid_id.'" target="_blank">
    <img src="'.$valid_id.'" style="width: 300px;">
    </a>
    </div>
    </div>

    <br>
    <div class="form-group mb-3">
    <button type="submit" name="verify" value="'.$key.'" class="btn btn-success">Verify</button>
    </div>
    </form>

    <hr>

    <form method="POST" action="ho_pen.php" onsubmit="return checkFormData()">
    <input type="hidden" name="hid" id="'.$key.'" value="'.$key.'">

      <div class="row">
      <div class="col">
      <div class="form-group mb-3">
      <label for="">DELETE ACCOUNT</label>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Invalid Selfie" id="chk1">
        <label class="form-check-label" for="flexCheckDefault">
        Invalid Selfie
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Invalid ID" id="chk2">
        <label class="form-check-label" for="flexCheckDefault">
        Invalid ID
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="ID taken does not match the selected ID" id="chk3">
        <label class="form-check-label" for="flexCheckDefault">
        ID taken does not match the selected ID
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Selfie does not match the ID picture" id="chk5">
        <label class="form-check-label" for="flexCheckDefault">
        Selfie does not match the ID picture
        </label>
      </div>
       <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Registered information does not match ID information" id="chk10">
        <label class="form-check-label" for="flexCheckDefault">
        Registered information does not match ID information
        </label>
      </div>
      </div>
      </div>

      <div class="col">
      <div class="form-group mb-3">
      <label for=""></label>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Expired ID" id="chk4">
        <label class="form-check-label" for="flexCheckDefault">
        Expired ID
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Empty ID" id="chk6">
        <label class="form-check-label" for="flexCheckDefault">
        Empty ID
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Empty Selfie" id="chk7">
        <label class="form-check-label" for="flexCheckDefault">
        Empty Selfie
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Underage" id="chk7">
        <label class="form-check-label" for="flexCheckDefault">
        Underage
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Blurry / Not Visible ID" id="chk8">
        <label class="form-check-label" for="flexCheckDefault">
        Blurry / Not Visible ID
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Blurry / Not Visible Selfie" id="chk9">
        <label class="form-check-label" for="flexCheckDefault">
        Blurry / Not Visible Selfie
        </label>
      </div>
      </div>
      </div>
      </div>
    <button type="submit" name="send" value="'.$row["email"].'" class="btn btn-dark">Continue</button>
    </form>'
    ;
                }
        }
    }
    echo $output;
}

if(isset($_POST['hover3'])){
  $output = '';
  $selfie = '';
  $valid_id = '';
  $type_id = 'N/A';

  $fetchselfie = $database->getReference('users_selfie')->getValue();
  if(is_array($fetchselfie)){
      foreach($fetchselfie as $key2 => $row2){
          if($key2 == $_POST['hover3']){
          $selfie = $row2['picture'];
          }
      }
  }

  $fetchvalidid = $database->getReference('users_image')->getValue();
  if(is_array($fetchvalidid)){
      foreach($fetchvalidid as $key3 => $row3){
          if($key3 == $_POST['hover3']){
          $valid_id = $row3['picture'];
          $type_id = $row3['type_of_id'];
          }
      }
  }

  $fetchdata = $database->getReference('users')->getValue();
  if(is_array($fetchdata)){
      foreach($fetchdata as $key => $row){
          if($key == $_POST['hover3']){

  $output .= 
  
  '
  <div class="row">    
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">Fullname</label>
    <input type="text" name="fullname" id="fullname" value="'.$row["fullname"].'" class="form-control" readonly>
  </div>
  </div>
  
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">ID</label>
    <input type="text" name="id" id="id" value="'.$key.'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <div class="row">    
  <div class="col">
  <div class="form-group mb-3">
    <label for="">Email</label>
    <input type="text" name="email" id="email" value="'.$row["email"].'" class="form-control" readonly>
  </div>
  </div>

  <div class="col">
  <div class="form-group mb-3">
    <label for="">Contact #</label>
    <input type="text" name="number" id="number" value="'.$row["number"].'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <div class="form-group mb-3">
    <label for="">Address</label>
    <input type="text" name="address" id="address" value="'.$row["fulladdress"].' ('.$row["zipcode"].')" class="form-control" readonly>
  </div>

  <div class="row">
  <div class="col">
  <div class="form-group mb-3">
    <label for="">Submitted Date</label>
    <input type="text" name="ver_submit_date" id="ver_submit_date" value="'.$row["ver_submit_date"].'" class="form-control" readonly>
  </div>
  </div>

  <div class="col">
  <div class="form-group mb-3">
    <label for="">Last Updated</label>
    <input type="text" name="ver_last_update" id="ver_last_update" value="'.$row["ver_last_update"].'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <div class="row">
  <div class="col">
  <label for="">Picture</label><br>
  <a href="'.$selfie.'" target="_blank">
  <img src="'.$selfie.'" style="width: 250px;"><br>
  </a>
  </div>

  <div class="col">
  <label for="">Valid ID ('.$type_id.')</label><br>
  <a href="'.$valid_id.'" target="_blank">
  <img src="'.$valid_id.'" style="width: 300px;">
  </a>
  </div>
  </div><hr>';
              }
      }
  }
  echo $output;

  $output2 = '';
  $warn = '';
  $sus = '';
  $rep = '';

  $fetchdata = $database->getReference('HO_Warning/'.$_POST['hover3'])->getValue();
  if(is_array($fetchdata)){
    foreach($fetchdata as $key => $row){
      $warn .= '
      <tr>
      <td scope="col" class="text-center">'.$row['date'].'</td>
      <td scope="col" class="text-center">'.$row['reason'].'</td>
      </tr>';
    }
  }
  $fetchdata2 = $database->getReference('HO_Suspension/'.$_POST['hover3'])->getValue();
  if(is_array($fetchdata2)){
    foreach($fetchdata2 as $key2 => $row2){
      $sus .= '
      <tr>
      <td scope="col" class="text-center">'.$row2['date'].'</td>
      <td scope="col" class="text-center">'.$row2['reason'].'</td>
      </tr>';
    }
  }
  $fetchdata3 = $database->getReference('Reports')->getValue();
  if(is_array($fetchdata3)){
    foreach($fetchdata3 as $key3 => $row3){
      if ($row3['reported_id'] == $_POST['hover3'] && $row3['reported_type'] == 'Home Owner'){
      $rep .= '
      <tr>
      <td scope="col" class="text-center">'.$row3['date_updated'].'</td>
      <td scope="col" class="text-center">'.$row3['report_subject'].'</td>
      <td scope="col" class="text-center">'.$row3['report_desc'].'</td>
      </tr>';
      }
    }
  }

  $output2 .= '

  <label for="" style="color: red;">Suspension</label>
  <table id="myTable4" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Violations</th>
      </tr>
    </thead>

    <tbody>'
      .$sus.
    '</tbody>

  </table><hr>
  <label for="" style="color: red;">Warning</label>
  <table id="myTable2" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Violations</th>
      </tr>
    </thead>

    <tbody>'
      .$warn.
    '</tbody>

  </table><hr>

  <label for="" style="color: red;">Report Log</label>
  <table id="myTable3" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Subject</th>
        <th scope="col" class="text-center">Description</th>
      </tr>
    </thead>

    <tbody>'
      .$rep.
    '</tbody>

  </table>

  <script>
  new DataTable("#myTable2", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });

  new DataTable("#myTable3", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });

  new DataTable("#myTable4", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });
  </script>';
  echo $output2;
}

if(isset($_POST['hover'])){
  $output = '';

  $total_warning = $database->getReference('HO_Warning/'.$_POST['hover'])->getSnapshot()->numChildren();
  $total_suspend = $database->getReference('HO_Suspension/'.$_POST['hover'])->getSnapshot()->numChildren();

  $fetchdata = $database->getReference('users')->getValue();
  if(is_array($fetchdata)){
      foreach($fetchdata as $key => $row){
          if($key == $_POST['hover']){

  $output .= 
  
  '<form method="POST" action="ho_ver.php" onsubmit="return checkFormData()">
  
  <div class="row">    
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">Fullname</label>
    <input type="text" name="fullname" id="fullname" value="'.$row["fullname"].'" class="form-control" readonly>
  </div>
  </div>
  
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">ID</label>
    <input type="text" name="id" id="id" value="'.$key.'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <div class="row"> 
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="" style="color: red;">Total Warning</label>
    <input type="text" name="totalw" id="totalw" value="'.$total_warning.'" class="form-control" readonly>
  </div>
  </div>

  <div class="col"> 
  <div class="form-group mb-3">
    <label for="" style="color: red;">Total Suspension</label>
    <input type="text" name="totals" id="totals" value="'.$total_suspend.'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <hr>

  <div class="form-group mb-3">
    <label for="">SEND WARNING</label>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Uploading blurry or unrelated content" id="chk1">
      <label class="form-check-label" for="flexCheckDefault">
      Uploading blurry or unrelated content
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Using slightly harmful and inappropriate language" id="chk3">
      <label class="form-check-label" for="flexCheckDefault">
      Using slightly harmful and inappropriate language
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Not showing up on appointment" id="chk5">
      <label class="form-check-label" for="flexCheckDefault">
      Not showing up on appointment
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Late pay or underpaid" id="chk7">
      <label class="form-check-label" for="flexCheckDefault">
      Late pay or underpaid
      </label>
    </div>
  </div>
  <button type="submit" name="send" value="'.$row["email"].'" class="btn btn-dark">Send</button>
  </form>'
  ;
              }
      }
  }
  echo $output;
}

if(isset($_POST['hover2'])){
  $output = '';

  $total_warning = $database->getReference('HO_Warning/'.$_POST['hover2'])->getSnapshot()->numChildren();
  $total_suspend = $database->getReference('HO_Suspension/'.$_POST['hover2'])->getSnapshot()->numChildren();

  $fetchdata = $database->getReference('users')->getValue();
  if(is_array($fetchdata)){
      foreach($fetchdata as $key => $row){
          if($key == $_POST['hover2']){

  $output .= 
  
  '<form method="POST" action="ho_ver.php" onsubmit="return checkFormData()">
  
  <div class="row">    
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">Fullname</label>
    <input type="text" name="fullname" id="fullname" value="'.$row["fullname"].'" class="form-control" readonly>
  </div>
  </div>
  
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">ID</label>
    <input type="text" name="id" id="id" value="'.$key.'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <div class="row"> 
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="" style="color: red;">Total Warning</label>
    <input type="text" name="totalw" id="totalw" value="'.$total_warning.'" class="form-control" readonly>
  </div>
  </div>

  <div class="col"> 
  <div class="form-group mb-3">
    <label for="" style="color: red;">Total Suspension</label>
    <input type="text" name="totals" id="totals" value="'.$total_suspend.'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <hr>

  <div class="row">
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">TERMINATION</label>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Scamming" id="chk1">
      <label class="form-check-label" for="flexCheckDefault">
      Scamming
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Griefing" id="chk2">
      <label class="form-check-label" for="flexCheckDefault">
      Griefing
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Misinformation" id="chk3">
      <label class="form-check-label" for="flexCheckDefault">
      Misinformation
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Hate Speech" id="chk4">
      <label class="form-check-label" for="flexCheckDefault">
      Hate Speech
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Any forms of violence/threats" id="chk5">
      <label class="form-check-label" for="flexCheckDefault">
      Any forms of violence/threats
      </label>
    </div>
  </div>
  </div>

  <div class="col"> 
  <div class="form-group mb-3">
  <label for="">   </label>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Discrimination" id="chk6">
      <label class="form-check-label" for="flexCheckDefault">
      Discrimination
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Robbery" id="chk7">
      <label class="form-check-label" for="flexCheckDefault">
      Robbery
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Unsettled payment" id="chk8">
      <label class="form-check-label" for="flexCheckDefault">
      Unsettled payment
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="qry[]" type="checkbox" value="Selling Substances" id="chk10">
      <label class="form-check-label" for="flexCheckDefault">
      Selling Substances
      </label>
    </div>
    </div>
  </div>
  </div>
  <button type="submit" name="terminate" value="'.$row["email"].'" class="btn btn-danger">TERMINATE</button>
  </form>'
  ;
              }
      }
  }
  echo $output;
}

if(isset($_POST['hosus'])){
  $output = '';
  $selfie = '';
  $valid_id = '';
  $type_id = 'N/A';

    $fetchselfie = $database->getReference('users_selfie')->getValue();
    if(is_array($fetchselfie)){
        foreach($fetchselfie as $key2 => $row2){
            if($key2 == $_POST['hosus']){
            $selfie = $row2['picture'];
            }
        }
    }

    $fetchvalidid = $database->getReference('users_image')->getValue();
    if(is_array($fetchvalidid)){
        foreach($fetchvalidid as $key3 => $row3){
            if($key3 == $_POST['hosus']){
            $valid_id = $row3['picture'];
            $type_id = $row3['type_of_id'];
            }
        }
    }

  $fetchdata = $database->getReference('users')->getValue();
  if(is_array($fetchdata)){
      foreach($fetchdata as $key => $row){
          if($key == $_POST['hosus']){

  $output .= 
  
  '<div class="row">    
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">Fullname</label>
    <input type="text" name="fullname" id="fullname" value="'.$row["fullname"].'" class="form-control" readonly>
  </div>
  </div>
  
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">ID</label>
    <input type="text" name="id" id="id" value="'.$key.'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <div class="row"> 
  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">Email</label>
    <input type="text" name="email" id="email" value="'.$row["email"].'" class="form-control" readonly>
  </div>
  </div>

  <div class="col">
    <div class="form-group mb-3">
      <label for="">Contact #</label>
      <input type="text" name="number" id="number" value="'.$row["number"].'" class="form-control" readonly>
    </div>
  </div>

  <div class="col"> 
  <div class="form-group mb-3">
    <label for="">Reactivation</label>
    <input type="text" name="reac" id="reac" value="'.$row["lift_suspension"].'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <div class="form-group mb-3">
    <label for="">Address</label>
    <input type="text" name="address" id="address" value="'.$row["fulladdress"].' ('.$row["zipcode"].')" class="form-control" readonly>
  </div>

  <div class="row">
    <div class="col">
    <label for="">Picture</label><br>
    <a href="'.$selfie.'" target="_blank">
    <img src="'.$selfie.'" style="width: 250px;"><br>
    </a>
    </div>

    <div class="col">
    <label for="">Valid ID ('.$type_id.')</label><br>
    <a href="'.$valid_id.'" target="_blank">
    <img src="'.$valid_id.'" style="width: 300px;">
    </a>
    </div>
  </div>

  <hr>';
        }
      }
  }
      echo $output;

  $output2 = '';
  $warn = '';
  $sus = '';
  $rep = '';

  $fetchdata = $database->getReference('HO_Warning/'.$_POST['hosus'])->getValue();
  if(is_array($fetchdata)){
    foreach($fetchdata as $key => $row){
      $warn .= '
      <tr>
      <td scope="col" class="text-center">'.$row['date'].'</td>
      <td scope="col" class="text-center">'.$row['reason'].'</td>
      </tr>';
    }
  }
  $fetchdata2 = $database->getReference('HO_Suspension/'.$_POST['hosus'])->getValue();
  if(is_array($fetchdata2)){
    foreach($fetchdata2 as $key2 => $row2){
      $sus .= '
      <tr>
      <td scope="col" class="text-center">'.$row2['date'].'</td>
      <td scope="col" class="text-center">'.$row2['reason'].'</td>
      </tr>';
    }
  }

  $fetchdata3 = $database->getReference('Reports')->getValue();
  if(is_array($fetchdata3)){
    foreach($fetchdata3 as $key3 => $row3){
      if ($row3['reported_id'] == $_POST['hosus'] && $row3['reported_type'] == 'Home Owner'){
      $rep .= '
      <tr>
      <td scope="col" class="text-center">'.$row3['date_updated'].'</td>
      <td scope="col" class="text-center">'.$row3['report_subject'].'</td>
      <td scope="col" class="text-center">'.$row3['report_desc'].'</td>
      </tr>';
      }
    }
  }

  $output2 .= '
  <label for="" style="color: red;">Suspension</label>
  <table id="myTable2" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Violations</th>
      </tr>
    </thead>

    <tbody>'
      .$sus.
    '</tbody>

  </table><hr>

  <label for="" style="color: red;">Warning</label>
  <table id="myTable3" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Violations</th>
      </tr>
    </thead>

    <tbody>'
      .$warn.
    '</tbody>

  </table><hr>

  <label for="" style="color: red;">Report Log</label>
  <table id="myTable4" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Subject</th>
        <th scope="col" class="text-center">Description</th>
      </tr>
    </thead>

    <tbody>'
      .$rep.
    '</tbody>

  </table>

  <script>
  new DataTable("#myTable2", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });

  new DataTable("#myTable3", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });

  new DataTable("#myTable4", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });
  </script>';
  echo $output2;
}

if(isset($_POST['hoter'])){
  $output = '';
  $selfie = '';
  $valid_id = '';
  $type_id = 'N/A';

    $fetchselfie = $database->getReference('users_selfie')->getValue();
    if(is_array($fetchselfie)){
        foreach($fetchselfie as $key2 => $row2){
            if($key2 == $_POST['hoter']){
            $selfie = $row2['picture'];
            }
        }
    }

    $fetchvalidid = $database->getReference('users_image')->getValue();
    if(is_array($fetchvalidid)){
        foreach($fetchvalidid as $key3 => $row3){
            if($key3 == $_POST['hoter']){
            $valid_id = $row3['picture'];
            $type_id = $row3['type_of_id'];
            }
        }
    }

  $fetchdata = $database->getReference('users')->getValue();
  if(is_array($fetchdata)){
      foreach($fetchdata as $key => $row){
          if($key == $_POST['hoter']){

            $output .= 
  
            '<div class="row">    
            <div class="col"> 
            <div class="form-group mb-3">
              <label for="">Fullname</label>
              <input type="text" name="fullname" id="fullname" value="'.$row["fullname"].'" class="form-control" readonly>
            </div>
            </div>
            
            <div class="col"> 
            <div class="form-group mb-3">
              <label for="">ID</label>
              <input type="text" name="id" id="id" value="'.$key.'" class="form-control" readonly>
            </div>
            </div>
            </div>
          
            <div class="row"> 
            <div class="col"> 
            <div class="form-group mb-3">
              <label for="">Email</label>
              <input type="text" name="email" id="email" value="'.$row["email"].'" class="form-control" readonly>
            </div>
            </div>
          
            <div class="col">
              <div class="form-group mb-3">
                <label for="">Contact #</label>
                <input type="text" name="number" id="number" value="'.$row["number"].'" class="form-control" readonly>
              </div>
            </div>
          
            <div class="col"> 
            <div class="form-group mb-3">
              <label for="">Terminated</label>
              <input type="text" name="reac" id="reac" value="'.$row["ver_last_update"].'" class="form-control" readonly>
            </div>
            </div>
            </div>
          
            <div class="form-group mb-3">
              <label for="">Address</label>
              <input type="text" name="address" id="address" value="'.$row["fulladdress"].' ('.$row["zipcode"].')" class="form-control" readonly>
            </div>
          
            <div class="row">
              <div class="col">
              <label for="">Picture</label><br>
              <a href="'.$selfie.'" target="_blank">
              <img src="'.$selfie.'" style="width: 250px;"><br>
              </a>
              </div>
          
              <div class="col">
              <label for="">Valid ID ('.$type_id.')</label><br>
              <a href="'.$valid_id.'" target="_blank">
              <img src="'.$valid_id.'" style="width: 300px;">
              </a>
              </div>
            </div>
          
            <hr>';
        }
      }
  }
      echo $output;

  $output2 = '';
  $warn = '';
  $sus = '';
  $ter = '';
  $rep = '';

  $fetchdata = $database->getReference('HO_Warning/'.$_POST['hoter'])->getValue();
  if(is_array($fetchdata)){
    foreach($fetchdata as $key => $row){
      $warn .= '
      <tr>
      <td scope="col" class="text-center">'.$row['date'].'</td>
      <td scope="col" class="text-center">'.$row['reason'].'</td>
      </tr>';
    }
  }
  $fetchdata2 = $database->getReference('HO_Suspension/'.$_POST['hoter'])->getValue();
  if(is_array($fetchdata2)){
    foreach($fetchdata2 as $key2 => $row2){
      $sus .= '
      <tr>
      <td scope="col" class="text-center">'.$row2['date'].'</td>
      <td scope="col" class="text-center">'.$row2['reason'].'</td>
      </tr>';
    }
  }
  $fetchdata3 = $database->getReference('Termination/'.$_POST['hoter'])->getValue();
  if(is_array($fetchdata3)){
    foreach($fetchdata3 as $key3 => $row3){
      $ter .= '
      <tr>
      <td scope="col" class="text-center">'.$row3['date'].'</td>
      <td scope="col" class="text-center">'.$row3['reason'].'</td>
      </tr>';
    }
  }

  $fetchdata4 = $database->getReference('Reports')->getValue();
  if(is_array($fetchdata4)){
    foreach($fetchdata4 as $key4 => $row4){
      if ($row4['reported_id'] == $_POST['hoter']){
      $rep .= '
      <tr>
      <td scope="col" class="text-center">'.$row4['date_updated'].'</td>
      <td scope="col" class="text-center">'.$row4['report_subject'].'</td>
      <td scope="col" class="text-center">'.$row4['report_desc'].'</td>
      </tr>';
      }
    }
  }

  $output2 .= '

  <label for="" style="color: red;">Termination</label>
  <table id="myTable4" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Violations</th>
      </tr>
    </thead>

    <tbody>'
      .$ter.
    '</tbody>

  </table><hr>
  <label for="" style="color: red;">Suspension</label>
  <table id="myTable2" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Violations</th>
      </tr>
    </thead>

    <tbody>'
      .$sus.
    '</tbody>

  </table><hr>

  <label for="" style="color: red;">Warning</label>
  <table id="myTable3" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Violations</th>
      </tr>
    </thead>

    <tbody>'
      .$warn.
    '</tbody>

  </table><hr>

  <label for="" style="color: red;">Report Log</label>
  <table id="myTable5" class="table table-responsive table-hover table-bordered" style="border-color:#043047;">

    <thead>
      <tr>
        <th scope="col" class="text-center">Date</th>
        <th scope="col" class="text-center">Subject</th>
        <th scope="col" class="text-center">Description</th>
      </tr>
    </thead>

    <tbody>'
      .$rep.
    '</tbody>

  </table>

  <script>
  new DataTable("#myTable2", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });

  new DataTable("#myTable3", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });

  new DataTable("#myTable4", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });

  new DataTable("#myTable5", {
    order: [[0, "desc"]],
    info: false,
    paging: false,
    searching: false,
    scrollCollapse: true,
    scrollY: "50vh"
  });
  </script>';
  echo $output2;
}

?>
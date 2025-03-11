<?php
session_start();

if (!isset($_SESSION['admin'])){
  header('location:login.php');
}

include("dbcon.php");
date_default_timezone_set("Asia/Manila");

if(isset($_POST['wkpen'])){
    $output = '';
    $selfie = '';
    $valid_id = '';
    $pol_cle = '';

    $fetchselfie = $database->getReference('workers_selfie')->getValue();
    if(is_array($fetchselfie)){
        foreach($fetchselfie as $key2 => $row2){
            if($key2 == $_POST['wkpen']){
            $selfie = $row2['picture'];
            }
        }
    }

    $fetchvalidid = $database->getReference('workers_id')->getValue();
    if(is_array($fetchvalidid)){
        foreach($fetchvalidid as $key3 => $row3){
            if($key3 == $_POST['wkpen']){
            $valid_id = $row3['picture'];
            }
        }
    }

    $fetchpol = $database->getReference('workers_police_clearance')->getValue();
    if(is_array($fetchpol)){
        foreach($fetchpol as $key4 => $row4){
            if($key4 == $_POST['wkpen']){
            $pol_cle = $row4['picture'];
            }
        }
    }

    $fetchdata = $database->getReference('users')->getValue();
    $fetchdata5 = $database->getReference('worker_users')->getValue();
    if(is_array($fetchdata) && is_array($fetchdata)){
        foreach($fetchdata as $key => $row){
          foreach($fetchdata5 as $key5 => $row5){
            if($key == $_POST['wkpen'] && $key5 == $_POST['wkpen']){

              $occ = '';

        if(isset($row5['ACRepair'])){
          $occ .= $row5['ACRepair'].' | ';
        }

        if(isset($row5['Carpentry'])){
          $occ .= $row5['Carpentry'].' | ';}

        if(isset($row5['CleanServices'])){
          $occ .= $row5['CleanServices'].' | ';}

        if(isset($row5['Electric'])){
          $occ .= $row5['Electric'].' | ';}

        if(isset($row5['GateRepair'])){
          $occ .= $row5['GateRepair'].' | ';}
        
        if(isset($row5['Painting'])){
          $occ .= $row5['Painting'].' | ';}

        if(isset($row5['PestControl'])){
          $occ .= $row5['PestControl'].' | ';}

        if(isset($row5['Plumbing'])){
          $occ .= $row5['Plumbing'].' | ';}

        if(isset($row5['RoofRepair'])){
          $occ .= $row5['RoofRepair'].' | ';}

        if(isset($row5['Tiling'])){
          $occ .= $row5['Tiling'].' | ';}

    $output .= 
    
    '<form method="POST" action="wk_pen.php">
    
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
      <input type="text" name="id" id="id" value="'.$key5.'" class="form-control" readonly>
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
      <input type="text" name="ver_submit_date" id="ver_submit_date" value="'.$row5["worker_submit_date"].'" class="form-control" readonly>
    </div>
    </div>

    <div class="col">
    <div class="form-group mb-3">
      <label for="">Last Updated</label>
      <input type="text" name="ver_last_update" id="ver_last_update" value="'.$row5["worker_last_update"].'" class="form-control" readonly>
    </div>
    </div>
    </div>

    <div class="row">
    <div class="col">
      <div class="form-group mb-3">
        <label for="">Occupation</label>
        <textarea name="occupation" id="occupation" class="form-control" readonly>'.$occ.'</textarea>
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
    <label for="">Barangay Certificate</label><br>
    <a href="'.$valid_id.'" target="_blank">
    <img src="'.$valid_id.'" style="width: 300px;">
    </a>
    </div>

    <div class="col">
    <label for="">NBI Clearance</label><br>
    <a href="'.$pol_cle.'" target="_blank">
    <img src="'.$pol_cle.'" style="width: 300px;">
    </a>
    </div>
    </div>

    <br>
    <div class="form-group mb-3">
    <button type="submit" name="verify" value="'.$key5.'" class="btn btn-success">Verify</button>
    </div>
    </form>

    <hr>

    <form method="POST" action="wk_pen.php" onsubmit="return checkFormData()">
    <input type="hidden" name="wid" id="'.$key5.'" value="'.$key5.'">

    <div class="row">
    <div class="col">
    <div class="form-group mb-3">
    <label for="">DELETE ENRTY</label>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Invalid Selfie" id="chk1">
        <label class="form-check-label" for="flexCheckDefault">
        Invalid Selfie
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Invalid Brgy. Certificate" id="chk2">
        <label class="form-check-label" for="flexCheckDefault">
        Invalid Brgy. Certificate
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Invalid NBI Clearance" id="chk8">
        <label class="form-check-label" for="flexCheckDefault">
        Invalid NBI Clearance
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Selfie does not match the brgy. certificate picture" id="chk3">
        <label class="form-check-label" for="flexCheckDefault">
        Selfie does not match the brgy. certificate picture
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Selfie does not match the NBI clearance picture" id="chk5">
        <label class="form-check-label" for="flexCheckDefault">
        Selfie does not match the NBI clearance picture
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Registered information does not match credentials" id="chk9">
        <label class="form-check-label" for="flexCheckDefault">
        Registered information does not match credentials
        </label>
      </div>
      </div>
      </div>

      <div class="col">
      <div class="form-group mb-3">
      <label for=""></label>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Expired Brgy. Certificate" id="chk4">
        <label class="form-check-label" for="flexCheckDefault">
        Expired Brgy. Certificate
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Expired NBI Clearance" id="chk6">
        <label class="form-check-label" for="flexCheckDefault">
        Expired NBI Clearance
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Empty Selfie" id="chk7">
        <label class="form-check-label" for="flexCheckDefault">
        Empty Selfie
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Empty Brgy. Certificate" id="chk9">
        <label class="form-check-label" for="flexCheckDefault">
        Empty Brgy. Certificate
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Empty NBI Clearance" id="chk9">
        <label class="form-check-label" for="flexCheckDefault">
        Empty NBI Clearance
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Blurry / Not Visible Selfie" id="chk11">
        <label class="form-check-label" for="flexCheckDefault">
        Blurry / Not Visible Selfie
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Blurry / Not Visible Brgy. Certificate" id="chk12">
        <label class="form-check-label" for="flexCheckDefault">
        Blurry / Not Visible Brgy. Certificate
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="qry[]" type="checkbox" value="Blurry / Not Visible NBI Clearance" id="chk13">
        <label class="form-check-label" for="flexCheckDefault">
        Blurry / Not Visible NBI Clearance
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
    }
    echo $output;
}

if(isset($_POST['wkver3'])){
  $output = '';
  $selfie = '';
  $valid_id = '';
  $pol_cle = '';

  $fetchselfie = $database->getReference('workers_selfie')->getValue();
  if(is_array($fetchselfie)){
      foreach($fetchselfie as $key2 => $row2){
          if($key2 == $_POST['wkver3']){
          $selfie = $row2['picture'];
          }
      }
  }

  $fetchvalidid = $database->getReference('workers_id')->getValue();
  if(is_array($fetchvalidid)){
      foreach($fetchvalidid as $key3 => $row3){
          if($key3 == $_POST['wkver3']){
          $valid_id = $row3['picture'];
          }
      }
  }

  $fetchpol = $database->getReference('workers_police_clearance')->getValue();
  if(is_array($fetchpol)){
      foreach($fetchpol as $key4 => $row4){
          if($key4 == $_POST['wkver3']){
          $pol_cle = $row4['picture'];
          }
      }
  }

  $fetchdata = $database->getReference('users')->getValue();
  $fetchdata5 = $database->getReference('worker_users')->getValue();
  if(is_array($fetchdata) && is_array($fetchdata)){
      foreach($fetchdata as $key => $row){
        foreach($fetchdata5 as $key5 => $row5){
          if($key == $_POST['wkver3'] && $key5 == $_POST['wkver3']){

            $occ = '';

      if(isset($row5['ACRepair'])){
        $occ .= $row5['ACRepair'].' | ';
      }

      if(isset($row5['Carpentry'])){
        $occ .= $row5['Carpentry'].' | ';}

      if(isset($row5['CleanServices'])){
        $occ .= $row5['CleanServices'].' | ';}

      if(isset($row5['Electric'])){
        $occ .= $row5['Electric'].' | ';}

      if(isset($row5['GateRepair'])){
        $occ .= $row5['GateRepair'].' | ';}
      
      if(isset($row5['Painting'])){
        $occ .= $row5['Painting'].' | ';}

      if(isset($row5['PestControl'])){
        $occ .= $row5['PestControl'].' | ';}

      if(isset($row5['Plumbing'])){
        $occ .= $row5['Plumbing'].' | ';}

      if(isset($row5['RoofRepair'])){
        $occ .= $row5['RoofRepair'].' | ';}

      if(isset($row5['Tiling'])){
        $occ .= $row5['Tiling'].' | ';}

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
    <input type="text" name="id" id="id" value="'.$key5.'" class="form-control" readonly>
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
    <input type="text" name="ver_submit_date" id="ver_submit_date" value="'.$row5["worker_submit_date"].'" class="form-control" readonly>
  </div>
  </div>

  <div class="col">
  <div class="form-group mb-3">
    <label for="">Last Updated</label>
    <input type="text" name="ver_last_update" id="ver_last_update" value="'.$row5["worker_last_update"].'" class="form-control" readonly>
  </div>
  </div>
  </div>

  <div class="row">
  <div class="col">
    <div class="form-group mb-3">
      <label for="">Occupation</label>
      <textarea name="occupation" id="occupation" class="form-control" readonly>'.$occ.'</textarea>
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
  <label for="">Barangay Certificate</label><br>
  <a href="'.$valid_id.'" target="_blank">
  <img src="'.$valid_id.'" style="width: 300px;">
  </a>
  </div>

  <div class="col">
  <label for="">NBI Clearance</label><br>
  <a href="'.$pol_cle.'" target="_blank">
  <img src="'.$pol_cle.'" style="width: 300px;">
  </a>
  </div>
  </div><hr>';
              }
            }
      }
  }
  echo $output;

  $output2 = '';
  $warn = '';
  $sus = '';
  $rep = '';

  $fetchdata = $database->getReference('WK_Warning/'.$_POST['wkver3'])->getValue();
  if(is_array($fetchdata)){
    foreach($fetchdata as $key => $row){
      $warn .= '
      <tr>
      <td scope="col" class="text-center">'.$row['date'].'</td>
      <td scope="col" class="text-center">'.$row['reason'].'</td>
      </tr>';
    }
  }
  $fetchdata2 = $database->getReference('WK_Suspension/'.$_POST['wkver3'])->getValue();
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
      if ($row3['reported_id'] == $_POST['wkver3'] && $row3['reported_type'] == 'Worker'){
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

if(isset($_POST['wkver'])){
  $output = '';

  $total_warning = $database->getReference('WK_Warning/'.$_POST['wkver'])->getSnapshot()->numChildren();
  $total_suspend = $database->getReference('WK_Suspension/'.$_POST['wkver'])->getSnapshot()->numChildren();

  $fetchdata = $database->getReference('users')->getValue();
  $fetchdata2 = $database->getReference('worker_users')->getValue();
  if(is_array($fetchdata) && is_array($fetchdata2)){
      foreach($fetchdata as $key => $row){
        foreach($fetchdata2 as $key2 => $row2){
          if($key == $_POST['wkver'] && $key2 == $_POST['wkver']){

  $output .= 
  
  '<form method="POST" action="wk_ver.php" onsubmit="return checkFormData()">
  
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
    <input type="text" name="id" id="id" value="'.$key2.'" class="form-control" readonly>
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
      <input class="form-check-input" name="qry[]" type="checkbox" value="Job is not done properly" id="chk7">
      <label class="form-check-label" for="flexCheckDefault">
      Job is not done properly
      </label>
    </div>
  </div>
  <button type="submit" name="send" value="'.$row["email"].'" class="btn btn-dark">Send</button>
  </form>'
  ;
              }
            }
      }
  }
  echo $output;
}

if(isset($_POST['wkver2'])){
  $output = '';

  $total_warning = $database->getReference('WK_Warning/'.$_POST['wkver2'])->getSnapshot()->numChildren();
  $total_suspend = $database->getReference('WK_Suspension/'.$_POST['wkver2'])->getSnapshot()->numChildren();

  $fetchdata = $database->getReference('users')->getValue();
  $fetchdata2 = $database->getReference('worker_users')->getValue();
  if(is_array($fetchdata) && is_array($fetchdata2)){
      foreach($fetchdata as $key => $row){
        foreach($fetchdata2 as $key2 => $row2){
          if($key == $_POST['wkver2'] && $key2 == $_POST['wkver2']){

  $output .= 
  
  '<form method="POST" action="wk_ver.php" onsubmit="return checkFormData()">
  
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
    <input type="text" name="id" id="id" value="'.$key2.'" class="form-control" readonly>
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
      <input class="form-check-input" name="qry[]" type="checkbox" value="Unsettled Job" id="chk8">
      <label class="form-check-label" for="flexCheckDefault">
      Unsettled Job
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
  }
  echo $output;
}

if(isset($_POST['wksus'])){
  $output = '';
  $selfie = '';
  $valid_id = '';
  $pol_cle = '';

    $fetchselfie = $database->getReference('workers_selfie')->getValue();
    if(is_array($fetchselfie)){
        foreach($fetchselfie as $key2 => $row2){
            if($key2 == $_POST['wksus']){
            $selfie = $row2['picture'];
            }
        }
    }

    $fetchvalidid = $database->getReference('workers_id')->getValue();
    if(is_array($fetchvalidid)){
        foreach($fetchvalidid as $key3 => $row3){
            if($key3 == $_POST['wksus']){
            $valid_id = $row3['picture'];
            }
        }
    }

    $fetchpol = $database->getReference('workers_police_clearance')->getValue();
    if(is_array($fetchpol)){
        foreach($fetchpol as $key4 => $row4){
            if($key4 == $_POST['wksus']){
            $pol_cle = $row4['picture'];
            }
        }
    }

  $fetchdata = $database->getReference('users')->getValue();
  $fetchdata2 = $database->getReference('worker_users')->getValue();
  if(is_array($fetchdata) && is_array($fetchdata2)){
      foreach($fetchdata as $key => $row){
        foreach($fetchdata2 as $key2 => $row2){
          if($key == $_POST['wksus'] && $key2 == $_POST['wksus']){

      $occ = '';

      if(isset($row2['ACRepair'])){
        $occ .= $row2['ACRepair'].' | ';
      }

      if(isset($row2['Carpentry'])){
        $occ .= $row2['Carpentry'].' | ';}

      if(isset($row2['CleanServices'])){
        $occ .= $row2['CleanServices'].' | ';}

      if(isset($row2['Electric'])){
        $occ .= $row2['Electric'].' | ';}

      if(isset($row2['GateRepair'])){
        $occ .= $row2['GateRepair'].' | ';}
      
      if(isset($row2['Painting'])){
        $occ .= $row2['Painting'].' | ';}

      if(isset($row2['PestControl'])){
        $occ .= $row2['PestControl'].' | ';}

      if(isset($row2['Plumbing'])){
        $occ .= $row2['Plumbing'].' | ';}

      if(isset($row2['RoofRepair'])){
        $occ .= $row2['RoofRepair'].' | ';}

      if(isset($row2['Tiling'])){
        $occ .= $row2['Tiling'].' | ';}

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
    <input type="text" name="id" id="id" value="'.$key2.'" class="form-control" readonly>
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
    <input type="text" name="reac" id="reac" value="'.$row2["lift_suspension"].'" class="form-control" readonly>
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
        <label for="">Occupation</label>
        <textarea name="occupation" id="occupation" class="form-control" readonly>'.$occ.'</textarea>
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
    <label for="">Barangay Certificate</label><br>
    <a href="'.$valid_id.'" target="_blank">
    <img src="'.$valid_id.'" style="width: 300px;">
    </a>
    </div>

    <div class="col">
    <label for="">NBI Clearance</label><br>
    <a href="'.$pol_cle.'" target="_blank">
    <img src="'.$pol_cle.'" style="width: 300px;">
    </a>
    </div>
    </div>

  <hr>';
        }
      }
      }
  }
      echo $output;

  $output2 = '';
  $warn = '';
  $sus = '';
  $rep = '';

  $fetchdata = $database->getReference('WK_Warning/'.$_POST['wksus'])->getValue();
  if(is_array($fetchdata)){
    foreach($fetchdata as $key => $row){
      $warn .= '
      <tr>
      <td scope="col" class="text-center">'.$row['date'].'</td>
      <td scope="col" class="text-center">'.$row['reason'].'</td>
      </tr>';
    }
  }
  $fetchdata2 = $database->getReference('WK_Suspension/'.$_POST['wksus'])->getValue();
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
      if ($row3['reported_id'] == $_POST['wksus'] && $row3['reported_type'] == 'Worker'){
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

if(isset($_POST['wkter'])){
  $output = '';
  $selfie = '';
  $valid_id = '';
  $pol_cle = '';

    $fetchselfie = $database->getReference('workers_selfie')->getValue();
    if(is_array($fetchselfie)){
        foreach($fetchselfie as $key2 => $row2){
            if($key2 == $_POST['wkter']){
            $selfie = $row2['picture'];
            }
        }
    }

    $fetchvalidid = $database->getReference('workers_id')->getValue();
    if(is_array($fetchvalidid)){
        foreach($fetchvalidid as $key3 => $row3){
            if($key3 == $_POST['wkter']){
            $valid_id = $row3['picture'];
            }
        }
    }

    $fetchpol = $database->getReference('workers_police_clearance')->getValue();
    if(is_array($fetchpol)){
        foreach($fetchpol as $key4 => $row4){
            if($key4 == $_POST['wkter']){
            $pol_cle = $row4['picture'];
            }
        }
    }

  $fetchdata = $database->getReference('users')->getValue();
  $fetchdata2 = $database->getReference('worker_users')->getValue();
  if(is_array($fetchdata) && is_array($fetchdata2)){
      foreach($fetchdata as $key => $row){
        foreach($fetchdata2 as $key2 => $row2){
          if($key == $_POST['wkter'] && $key2 == $_POST['wkter']){

      $occ = '';

      if(isset($row2['ACRepair'])){
        $occ .= $row2['ACRepair'].' | ';
      }

      if(isset($row2['Carpentry'])){
        $occ .= $row2['Carpentry'].' | ';}

      if(isset($row2['CleanServices'])){
        $occ .= $row2['CleanServices'].' | ';}

      if(isset($row2['Electric'])){
        $occ .= $row2['Electric'].' | ';}

      if(isset($row2['GateRepair'])){
        $occ .= $row2['GateRepair'].' | ';}
      
      if(isset($row2['Painting'])){
        $occ .= $row2['Painting'].' | ';}

      if(isset($row2['PestControl'])){
        $occ .= $row2['PestControl'].' | ';}

      if(isset($row2['Plumbing'])){
        $occ .= $row2['Plumbing'].' | ';}

      if(isset($row2['RoofRepair'])){
        $occ .= $row2['RoofRepair'].' | ';}

      if(isset($row2['Tiling'])){
        $occ .= $row2['Tiling'].' | ';}

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
    <input type="text" name="id" id="id" value="'.$key2.'" class="form-control" readonly>
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
    <input type="text" name="reac" id="reac" value="'.$row2["worker_last_update"].'" class="form-control" readonly>
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
        <label for="">Occupation</label>
        <textarea name="occupation" id="occupation" class="form-control" readonly>'.$occ.'</textarea>
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
    <label for="">Barangay Certificate</label><br>
    <a href="'.$valid_id.'" target="_blank">
    <img src="'.$valid_id.'" style="width: 300px;">
    </a>
    </div>

    <div class="col">
    <label for="">NBI Clearance</label><br>
    <a href="'.$pol_cle.'" target="_blank">
    <img src="'.$pol_cle.'" style="width: 300px;">
    </a>
    </div>
    </div>

  <hr>';
        }
      }
      }
  }
      echo $output;

  $output2 = '';
  $warn = '';
  $sus = '';
  $ter = '';
  $rep = '';

  $fetchdata = $database->getReference('WK_Warning/'.$_POST['wkter'])->getValue();
  if(is_array($fetchdata)){
    foreach($fetchdata as $key => $row){
      $warn .= '
      <tr>
      <td scope="col" class="text-center">'.$row['date'].'</td>
      <td scope="col" class="text-center">'.$row['reason'].'</td>
      </tr>';
    }
  }
  $fetchdata2 = $database->getReference('WK_Suspension/'.$_POST['wkter'])->getValue();
  if(is_array($fetchdata2)){
    foreach($fetchdata2 as $key2 => $row2){
      $sus .= '
      <tr>
      <td scope="col" class="text-center">'.$row2['date'].'</td>
      <td scope="col" class="text-center">'.$row2['reason'].'</td>
      </tr>';
    }
  }
  $fetchdata3 = $database->getReference('Termination/'.$_POST['wkter'])->getValue();
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
      if ($row4['reported_id'] == $_POST['wkter']){
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
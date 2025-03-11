<?php
session_start();

if (isset($_SESSION['admin'])){
  header('location:index.php');
}

if(isset($_POST['login']))
    {
      if($_POST['username'] != 'adminFF' && $_POST['password'] != 'FFDev2024'){
        $_SESSION['error'] = 'Invalid Username & Password!';
      }
      elseif($_POST['username'] != 'adminFF'){
        $_SESSION['error'] = 'Invalid Username!';
      }
      elseif($_POST['password'] != 'FFDev2024'){
        $_SESSION['error'] = 'Invalid Password!';
      }
      else{
        $_SESSION['admin'] = $_POST['username'];
        header('location:index.php');
      }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>FixitFinder</title>
    <link rel="icon" href="logo/logo2.png" type="image/x-icon" />
</head>
<body style="background-color:#043047;">

  <div class="container position-absolute top-50 start-50 translate-middle" style="width: 20rem;">

    <div class="card" style="background-color: #fff;">
      <div class="card-header">
        <img src="logo/logo.png" class="card-img-top">
      </div>


      <div class="card-body">

      <form action="login.php" method="POST">
        <div class="mb-3">
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" required>
        </div>

        <div class="mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>

        <div class="text-center"> 
        <button type="submit" class="btn" name="login" style="background-color: #043047; color: white;">Log In</button>
        </div>
      </form>

      </div>
    </div>
</div>

<!-- SCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ERROR MESSAGE -->
<?php
  if(isset($_SESSION['error'])) { ?>
  <script>
    Swal.fire({
    title: "<?php echo $_SESSION['error']; ?>",
    icon: "error",
    confirmButtonText: 'OK',
    confirmButtonColor: "#043047",
    });
  </script>
<?php unset($_SESSION['error']); } ?>

<!-- REFRESH -->
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

</body>
</html>
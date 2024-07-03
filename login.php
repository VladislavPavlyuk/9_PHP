<?php
// (A) LOAD LIBRARY
require "adminLib.php";

if(isset($_Post['Registration'])){
    header("Location: registration.php");
    exit();
}


// (B) CHECK LOGIN CREDENTIALS
if (count($_POST)!=0) {
  $_ADM->verify($_POST["email"], $_POST["password"]);
}

// (C) REDIRECT IF SIGNED IN
if (isset($_SESSION["admin"])) {
  header("Location: adminProtected.php");
  exit();
} ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <!-- (D) LOGIN FORM -->
    <?php
    if ($_ADM->error!="") { echo "<div class='error'>".$_ADM->error."</div>"; }
    ?>
    <form action="login.php" method="post">
      <h1>LOGIN</h1>
      <label>Email</label>
      <input type="email" name="email" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <input type="submit" value="Login">
        <br><a href="#Reg" id="myBtn" >Registration</a>
    </form>
    <script>
        var btn = document.getElementById('myBtn');
        btn.addEventListener('click', function() {
            document.location.href = '<?php echo 'Registration.php'; ?>'; // Replace with your PHP variable or expression
        });
    </script>
  </body>
</html>


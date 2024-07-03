<?php
// (A) LOAD LIBRARY
require "adminLib.php";


function gotoRegistrationPage()
{
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
    <form method="post">
      <h1>LOGIN</h1>
      <label>Email</label>
      <input type="email" name="email" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <input type="submit" value="Login">


        <br><a type="submit"  href="#Reg" value="Registration">Registration</a>

    </form>

  </body>
</html>


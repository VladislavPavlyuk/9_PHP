<?php
// (A) PROCESS LOGIN ON SUBMIT
session_start();
if (isset($_POST["email"])) {
  require "2-user-lib.php";
  $USR->login($_POST["email"], $_POST["password"]);
}

// (B) REDIRECT USER IF SIGNED IN
if (isset($_SESSION["user"])) {
	header("Location: 4-index.php");
	exit();
}

// (C) LOGIN FORM ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <link rel="stylesheet" href="3-login.css">
  </head>
  <body>
    <!-- (C1) ERROR MESSAGES (IF ANY) -->
    <?php
    if (isset($_POST["email"])) { echo "<div id='notify'>Invalid user/password</div>"; }
    ?>

    <!-- (C2) LOGIN FORM -->
    <form id="login" method="post">
      <h2>MEMBER LOGIN</h2>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Sign In">
    </form>
  </body>
</html>
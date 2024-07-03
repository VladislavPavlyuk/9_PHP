<!DOCTYPE html>
<html>
  <head>
    <title>Registration Page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/registration.css">
  </head>
  <body>
    <!-- (A) REGISTRATION FORM -->
    <form method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="pass" placeholder="Password" required>
      <input type="submit" value="Register!">
    </form>

    <?php
    // (B) PROCESS SUBMITTED FORM
    if (isset($_POST["email"])) {
      require "registrationLib.php";
      echo "<div class='note'>";
      echo $USR->register($_POST["email"], $_POST["pass"])
        ? "Check your email and click on the activation link"
        : $USR->error ;
      echo "</div>";
    }
    ?>
  </body>
</html>
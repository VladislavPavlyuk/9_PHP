<!DOCTYPE html>
<html>
  <head>
    <title>Resend Page Demo</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/registration.css">
  </head>
  <body>
    <!-- (A) RESEND FORM -->
    <form method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="submit" value="Resend!">
    </form>

    <?php
    // (B) PROCESS SUBMITTED FORM
    if (isset($_POST["email"])) {
      require "registrationLib.php";
      echo "<div class='note'>";
      echo $USR->activation($_POST["email"])
        ? "Check your email and click on the activation link"
        : $USR->error ;
      echo "</div>";
    }
    ?>
  </body>
</html>
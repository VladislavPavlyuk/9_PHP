<!DOCTYPE html>
<html>
  <head>
    <title>Confirmation Page Demo</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/registration.css">
  </head>
  <body>
    <div class="note"><?php
    require "registrationLib.php";
    echo $USR->verify($_GET["i"], $_GET["h"])
      ? "Thank you! Account has been activated."
      : $USR->error ;
    ?></div>
  </body>
</html>
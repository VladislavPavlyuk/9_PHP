<?php
// (A) "LISTEN" FOR LOGOUT
session_start();
if (isset($_POST["logout"])) { unset($_SESSION["user"]); }

// (B) REDIRECT TO LOGIN PAGE IF NOT SIGNED IN
if (!isset($_SESSION["user"])) {
  header("Location: 3-login.php");
	exit();
}
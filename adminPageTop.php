<?php
// (A) LOAD LIBRARY
require "adminLib.php";

// (B) LOGOUT
if (isset($_POST["logout"])) { unset($_SESSION["admin"]); }

// (C) REDIRECT IF NOT SIGNED IN
if (!isset($_SESSION["admin"])) {
  header("Location: login.php");
  exit();
} ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Pure HTML CSS Admin Template</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <link rel="stylesheet" href="css/admin.css">
  </head>
  <body>
    <!-- (D) SIDEBAR -->
    <div id="pgside">
      <!-- (D1) BRANDING OR USER -->
      <form id="pguser" method="post" onclick="if(confirm('Sign Off?')){this.submit();}">
        <input type="hidden" name="logout" value="1">
        <img src="pic.png" id="pguserimg">
        <div class="txt">
          <div id="pgusername"><?=$_SESSION["admin"]["username"]?></div>
          <div id="pguseracct">account | logoff</div>
        </div>
      </form>

      <!-- (D2) MENU ITEMS -->
      <a href="#" class="current">
        <i class="ico">&#9733;</i>
        <i class="txt">Section A</i>
      </a>
      <a href="#">
        <i class="ico">&#9728;</i>
        <i class="txt">Section B</i>
      </a>
      <a href="#">
        <i class="ico">&#9737;</i>
        <i class="txt">Section C</i>
      </a>
    </div>

    <!-- (E) MAIN -->
    <main id="pgmain">
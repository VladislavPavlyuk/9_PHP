<?php
class Users {
  // (A) CONSTRUCTOR - CONNECT TO DATABASE
  private $pdo = null;
  private $stmt = null;
  public $error = null;
  function __construct () {
    $this->pdo = new PDO(
        'mysql:host=localhost;dbname=feedbacks', $user="root", $pass="");
  }

  // (B) DESTRUCTOR - CLOSE DATABASE CONNECTION
  function __destruct () {
    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }

  // (C) RUN SQL QUERY
  function query ($sql, $data=null) : void {
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($data);
  }

  // (D) GET USER
  function get ($id) {
    $this->query(sprintf("SELECT * FROM `users` WHERE `user_%s`=?", is_numeric($id) ? "id" : "email"), [$id]);
    return $this->stmt->fetch();
  }

  // (E) VERIFY EMAIL PASSWORD - SESSION MUST BE STARTED!
  function login ($email, $password) {
    // (E1) ALREADY SIGNED IN
    if (isset($_SESSION["user"])) { return true; }

    // (E2) GET USER
    $user = $this->get($email);
    if (!is_array($user)) { return false; }

    // (E3) VERIFY PASSWORD + REGISTER SESSION
    if (password_verify($password, $user["user_password"])) {
      $_SESSION["user"] = [];
      foreach ($user as $k=>$v) { if ($k!="user_password") { $_SESSION["user"][$k] = $v; }}
      return true;
    }
    return false;
  }

  // (F) SAVE USER
  function save ($name, $email, $pass, $id=null) {
    // (F1) ADD/UPDATE SQL
    if ($id===null) {
      $sql = "INSERT INTO `users` (`user_name`, `user_email`, `user_password`) VALUES (?,?,?)";
      $data = [$name, $email, password_hash($pass, PASSWORD_DEFAULT)];
    } else {
      $sql = "UPDATE `users` SET `user_name`=?, `user_email`=?, `user_password`=? WHERE `user_id`=?";
      $data = [$name, $email, password_hash($pass, PASSWORD_DEFAULT), $id];
    }

    // (F2) PROCESS SAVE
    $this->query($sql, $data);
    return true;
  }
}

// (G) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "users");
//define("DB_CHARSET", "utf8mb4");
define("DB_USER", "root");
define("DB_PASSWORD", "");

// (H) CREATE USER OBJECT
$USR = new Users();
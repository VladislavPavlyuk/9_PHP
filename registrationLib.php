<?php
class Users {
  // (A) CONSTRUCTOR - CONNECT TO DATABASE
  private $pdo = null;
  private $stmt = null;
  private $lastID = null;
  public $error = null;
  function __construct () {
    $this->pdo = new PDO('mysql:host=localhost;dbname=feedbacks', $user="root", $pass="");
  }

  // (B) DESTRUCTOR - CLOSE DATABASE CONNECTION
  function __destruct () {
    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }

  // (C) HELPER - RUN SQL QUERY
  function query ($sql, $data=null) : void {
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($data);
  }

  // (D) HELPER - GET USER BY ID OR EMAIL
  function get ($id) {
    $this->query(sprintf(
      "SELECT * FROM `users`
      LEFT JOIN `users_hash` USING (`id`)
      WHERE users.`%s`=?",
      is_numeric($id) ? "id" : "email"
    ), [$id]);
    return $this->stmt->fetch();
  }

  // (E) REGISTER NEW USER
  function register ($email, $pass) {
    // (E1) CHECK IF USER REGISTERED
    $user = $this->get($email);
    if (is_array($user)) {
      $this->error = "Already registered.";
      return false;
    }

    // (E2) CREATE ACCOUNT
    $this->query(
      "INSERT INTO `users` (`email`, `username`,`password`,`role_id`) VALUES (?,?,?,?)",
      [$email,$email, password_hash($pass, PASSWORD_DEFAULT),2]
    );
    $this->lastID = $this->pdo->lastInsertId();

    // (E3) ACTIVATION EMAIL
    return $this->activation($email, $this->lastID);
  }

  // (F) SEND ACTIVATION EMAIL
  // * register pass in both email and id
  // * resend pass in email only
  function activation ($email, $id=null) {
    // (F1) RESEND ONLY - CHECKS
    if ($id === null) {
      $user = $this->get($email);
      if (!is_array($user)) {
        $this->error = "Invalid user.";
        return false;
      }
      if (!isset($user["hash"])) {
        $this->error = "Already registered.";
        return false;
      }
      $remain = (strtotime($user["time"]) + HASH_VALID) - strtotime("now");
      if ($remain > 0) {
        $this->error = "Please wait another $remain seconds.";
        return false;
      }
      $id = $user["id"];
    }

    // (F2) CREATE HASH
    $hash = md5(date("YmdHis") . $email);
    $this->query(
      "REPLACE INTO `users_hash` (`id`, `hash`) VALUES (?,?)",
      [$id, $hash]
    );

    // (F3) SEND LINK TO USER
    if (@mail(
      $email, "Confirm your email",
      sprintf(
        "<a href='http://localhost/confirmation.php?i=%u&h=%s'>Click here</a> to complete the registration.",
        $id, $hash
      ),
      implode("\r\n", ["MIME-Version: 1.0", "Content-type: text/html; charset=utf-8"])
    )) { return true; }
    $this->error = "Error sending out email";
    return false;
  }

  // (G) VERIFY REGISTRATION
  function verify ($id, $hash) {
    // (G1) GET + CHECK THE USER
    $user = $this->get($id);
    if ($user === false) {
      $this->error = "Invalid acivation link.";
      return false;
    }
    if (!isset($user["hash"])) {
      $this->error = "Already activated.";
      return false;
    }
    if (strtotime("now") > strtotime($user["time"]) + HASH_VALID) {
      $this->error = "Activation link expired.";
      return false;
    }
    if ($user["hash"] != $hash) {
      $this->error = "Invalid activation link.";
      return false;
    }

    // (G2) ACTIVATE ACCOUNT IF OK
    $this->query(
      "DELETE FROM `users_hash` WHERE `id`=?",
      [$id]
    );
    return true;
  }
}

// (H) DATABASE + VALIDATION SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "feedbacks");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("HASH_VALID", 600); // 10 mins = 600 seconds

// (I) NEW USER OBJECT
$USR = new Users();
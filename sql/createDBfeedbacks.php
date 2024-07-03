<?php
try
{

    $user = "root";
    $pass = "";
    $db = new PDO('mysql:host=localhost;dbname=feedbacks', $user, $pass);

    // (A) ROLES TABLE
    $db->exec("
CREATE TABLE `roles` (
  `id` int(2) NOT NULL,
  `role` varchar(255) NOT NULL);
               ");
    $db->exec("
ALTER TABLE `roles`
          ADD PRIMARY KEY (`id`);
 ");
    $db->exec("
ALTER TABLE `roles`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;
 ");
      $db->exec("
INSERT INTO `roles` (`role`) VALUES ('Admin');
INSERT INTO `roles` (`role`) VALUES ('User');
 ");
    $db->exec("
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(2) NOT NULL);
 ");
      $db->exec("
ALTER TABLE `users`
	  ADD PRIMARY KEY (`id`),
	  ADD UNIQUE KEY `email` (`email`);
 ");
      $db->exec("
  ALTER TABLE `users`
		MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
 ");
       $db->exec("
   ALTER TABLE `users`
		ADD CONSTRAINT FK_RolesUser 
        FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) 
        ON UPDATE CASCADE  ON DELETE RESTRICT;
 ");
    // (B) ACCOUNT ACTIVATION
    $db->exec("
    CREATE TABLE `users_hash` (
      `id` bigint(20) NOT NULL,
      `time` datetime NOT NULL DEFAULT current_timestamp(),
      `hash` varchar(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
    $db->exec("
    ALTER TABLE `users_hash`
      ADD PRIMARY KEY (`id`);
");
      $db->exec("
  CREATE TABLE `feedback` (
	  `id` bigint(20) NOT NULL,
	  `title` varchar(255) NOT NULL,
	  `desc` text DEFAULT NULL);
 ");
          $db->exec("
  ALTER TABLE `feedback`
          ADD PRIMARY KEY (`id`);
 ");
              $db->exec("
  ALTER TABLE `feedback`
          MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
 ");
              $db->exec("
  CREATE TABLE `questions` (
		  `feedback_id` bigint(20) NOT NULL,
		  `id` bigint(20) NOT NULL,
		  `text` text NOT NULL,
		  `type` varchar(1) NOT NULL DEFAULT 'R');
 ");
              $db->exec("
  ALTER TABLE `questions`
          ADD PRIMARY KEY (`id`);        
 ");
              $db->exec("
	ALTER TABLE `questions`
          MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
 ");
              $db->exec("
   ALTER TABLE `questions`
		ADD CONSTRAINT FK_QuestionsFeedback
        FOREIGN KEY (`feedback_id`) REFERENCES `feedback`(`id`) 
        ON UPDATE CASCADE ON DELETE RESTRICT;
 ");
    $db->exec("
  CREATE TABLE `values` (
          `user_id` bigint(20) NOT NULL,
          `feedback_id` bigint(20) NOT NULL,
          `question_id` bigint(20) NOT NULL,
          `value` text NOT NULL);
 ");
              $db->exec("
  ALTER TABLE `values`
          ADD PRIMARY KEY (`user_id`,`feedback_id`,`question_id`);
 ");
        $db->exec("      
 ALTER TABLE `values`
		ADD CONSTRAINT FK_ValuesUser 
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) 
        ON UPDATE CASCADE ON DELETE RESTRICT;
 ");
         $db->exec("   
 ALTER TABLE `values`
		ADD CONSTRAINT FK_ValuesFeedback
        FOREIGN KEY (`feedback_id`) REFERENCES `feedback`(`id`) 
        ON UPDATE CASCADE ON DELETE RESTRICT;
 ");
          $db->exec("
 ALTER TABLE `values`
		ADD CONSTRAINT FK_ValuesQuestions
        FOREIGN KEY (`question_id`) REFERENCES `questions`(`id`) 
        ON UPDATE CASCADE ON DELETE RESTRICT;  
         ");

    //ADMIN ADD
    //$id=1;
    $name='Admin';
    $email='admin@admin.com';
    $password =  password_hash('123456', PASSWORD_DEFAULT);
    $role = 1; //Admin
    // Prepare the query
    $sql = "INSERT INTO `users` (`id`, `username`, `email`, `password`,`role_id`) VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->bindParam(2, $name);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $password);
    $stmt->bindParam(5, $role);
    $stmt->execute();
    $sql=$stmt=null;

    echo "Всё готово!";
}
catch(PDOException $e)
{
    //Вывести сообщение и прекратить выполнение текущего скрипта
    die("Error: ".$e->getMessage());
}
?>

        
<?php
    try
    {

        $user = "root";
        $pass = "";
        $db = new PDO('mysql:host=localhost;dbname=feedbacks', $user, $pass);

        // (A) ROLES TABLE
        $db->exec("
        CREATE TABLE `roles` (
          `id` bigint(20) NOT NULL,
          `role` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $db->exec("ALTER TABLE `roles`
          ADD PRIMARY KEY (`id`);
        ");

        $db->exec("
        ALTER TABLE `roles`
          MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;
        ");

        //ROLES ADD
        $db->exec("
        INSERT INTO `roles` (`role`) VALUES ('Admin');
        INSERT INTO `roles` (`role`) VALUES ('User');
        ");

        // (B) USERS TABLE
        $db->exec("
        CREATE TABLE `users` (
          `id` bigint(20) NOT NULL,
          `email` varchar(255) NOT NULL,
          `username` varchar(255) NOT NULL,
          `password` varchar(255) NOT NULL,
          `role_id` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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

        /*$role = 'User';
        $sql = "INSERT INTO `roles` (`id`, `role`) VALUES (?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(2, $role);
        $stmt->execute();*/

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

//USER ADD
        //$id=1;
       /* $name='Vlad';
        $email='vlad@vlad.com';
        $password =  password_hash('123456', PASSWORD_DEFAULT);
        $role = 2;
        // Prepare the query
        $sql = "INSERT INTO `users` (`id`, `name`, `email`, `password`,`role_id`) VALUES (?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $password);
        $stmt->bindParam(5, $role);
        $stmt->execute();
        $sql=$stmt=null;*/

        // (A) FEEDBACK TABLE
        $db->exec("CREATE TABLE `feedback` (
          `feedback_id` bigint(20) NOT NULL,
          `feedback_title` varchar(255) NOT NULL,
          `feedback_desc` text DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
        );

        $db->exec("ALTER TABLE `feedback`
          ADD PRIMARY KEY (`feedback_id`);");

        $db->exec("ALTER TABLE `feedback`
          MODIFY `feedback_id` bigint(20) NOT NULL AUTO_INCREMENT;");

        // (B) FEEDBACK QUESTIONS
        $db->exec("CREATE TABLE `feedback_questions` (
                  `feedback_id` bigint(20) NOT NULL,
                  `question_id` bigint(20) NOT NULL,
                  `question_text` text NOT NULL,
                  `question_type` varchar(1) NOT NULL DEFAULT 'R'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $db->exec("ALTER TABLE `feedback_questions`
          ADD PRIMARY KEY (`feedback_id`,`question_id`);");

                // (C) FEEDBACK FROM USERS
        $db->exec("CREATE TABLE `feedback_users` (
          `user_id` bigint(20) NOT NULL,
          `feedback_id` bigint(20) NOT NULL,
          `question_id` bigint(20) NOT NULL,
          `feedback_value` text NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");


        $db->exec("ALTER TABLE `feedback_users`
          ADD PRIMARY KEY (`user_id`,`feedback_id`,`question_id`);");

        echo "Всё готово!";
    }
catch(PDOException $e)
    {
        //Вывести сообщение и прекратить выполнение текущего скрипта
        die("Error: ".$e->getMessage());
    }
?>
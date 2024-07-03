
<?php
try
{
    $user = "root";
    $pass = "";
    $db = new PDO('mysql:host=localhost;dbname=users', $user, $pass);
// (A) USERS
    $db->exec("
    CREATE TABLE `users` (
      `id` bigint(20) NOT NULL,
      `email` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 ");
    $db->exec("
    ALTER TABLE `users`
      ADD PRIMARY KEY (`id`),
      ADD UNIQUE KEY `email` (`email`);
");
    $db->exec("
    ALTER TABLE `users` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
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
    echo "Всё готово!";
}
catch(PDOException $e)
{
//Вывести сообщение и прекратить выполнение текущего скрипта
    die("Error: ".$e->getMessage());
}
?>
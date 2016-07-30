<?php
    $dsn = 'mysql:host=localhost;dbname=FCCpolls';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/databaseError.php');
        exit();
    }
?>

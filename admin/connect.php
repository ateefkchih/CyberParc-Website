<?php
$user = 'root';
$pass = '';
$dsn = 'mysql:host=localhost;dbname=app-form';

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection Failed" . $e->getMessage();
}
?>

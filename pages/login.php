<?php
session_start();
require '../controller/controller.php';

// cek login
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}

$row = $_SESSION['login'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Home</title>
</head>

<body>
    <div class="container">
        <h1>Data</h1>
        <div class="content">
            <div class="label">
                <p>Username : </p>
                <p>Email : </p>
            </div>
            <div class="isi">
                <p><?= $row['username']; ?></p>
                <p><?= $row['email']; ?></p>
            </div>
        </div>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>

</html>
<?php
session_start();
require 'controller/controller.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

    // cek email
    if (mysqli_num_rows($result) > 0) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if ($password == $row["password"]) {
            $_SESSION['login'] = $row;
            header("Location: pages/login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login Page</title>
</head>

<body>
    <div class="container">
        <main class="main">
            <h1>Login Page</h1>
            <form action="" method="post" class="form">
                <div class="form-group">
                    <label for="email">Email : </label>
                    <input type="email" class="email" name="email" id="email" autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="button-group">
                    <button type="submit" name="login">Login</button>
                </div>
                <div class="text">
                    <a href="" class="daftar">Belum punya akun?</a>
                    <a href="" class="lupa">Lupa password?</a>
                </div>
            </form>
        </main>
    </div>
</body>

</html>
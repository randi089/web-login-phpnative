<?php
session_start();
require 'controller/controller.php';

// jika sudah login
if (isset($_SESSION['login'])) {
    header('Location: pages/login.php');
    exit;
}

// jika ada yang login maka verifikasi login
if (isset($_POST['login'])) {
    $emailI = $_POST['email'];
    $passwordI = $_POST['password'];

    if ($emailI == '' || $passwordI == '') {
        $eKosong = true;
    } else {
        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
        if ($stmt = $conn->prepare('SELECT * FROM user WHERE email = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the email is a string so we use "s".
            $stmt->bind_param('s', $emailI);
            $stmt->execute();

            // Store the result so we can check if the account exists in the database.
            $stmt->store_result();

            if ($stmt->num_rows() > 0) {
                $stmt->bind_result($id, $username, $email, $password);
                $stmt->fetch();

                // Account exists, now we verify the password.
                // Note: remember to use password_hash in your registration file to store the hashed passwords.

                if ($passwordI == $password) {
                    // Verification success! User has logged in.
                    // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                    $_SESSION['login'] = [
                        'id' => $id,
                        'username' => $username,
                        'email' => $email,
                        'password' => $password
                    ];

                    header('Location: pages/login.php');
                    exit;
                } else {
                    $pSalah = true;
                }
            } else {
                $nDaftar = true;
            }

            $stmt->close();
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
                    <?php
                    $salah = 'Passoword atau Email salah!';
                    $kosong = 'Passoword atau Email tidak boleh kosong!';
                    $notDaftar = 'Email belum terdaftar!';
                    if (isset($nDaftar)) :
                    ?>
                        <p><?= $notDaftar; ?></p>
                    <?php elseif (isset($pSalah)) : ?>
                        <p><?= $salah; ?></p>
                    <?php elseif (isset($eKosong)) : ?>
                        <p><?= $kosong; ?></p>
                    <?php endif; ?>
                </div>
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
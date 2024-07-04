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
    $data = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];

    $cekLogin = login($data);

    // Cek login
    if ($cekLogin == 'ok') {
        header('Location: pages/login.php');
        exit;
    } elseif ($cekLogin == 'kosong') {
        $eKosong = true;
    } elseif ($cekLogin == 'salah') {
        $pSalah = true;
    } elseif ($cekLogin == '!daftar') {
        $nDaftar = true;
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
            <?php
            $salah = 'Passoword atau Email salah!';
            $kosong = 'Passoword atau Email tidak boleh kosong!';
            $notDaftar = 'Email belum terdaftar!';
            $daftar = 'Akun berhasil dibuat! Silahkan Login.';
            $reset = 'Password berhasil direset! Silahkan Login.';
            if (isset($nDaftar)) :
            ?>
                <p><?= $notDaftar; ?></p>
            <?php elseif (isset($pSalah)) : ?>
                <p><?= $salah; ?></p>
            <?php elseif (isset($eKosong)) : ?>
                <p><?= $kosong; ?></p>
                <?php elseif (isset($_SESSION['message'])) :
                if ($_SESSION['message'] == 'daftar') : ?>
                    <p class="sukses"><?= $daftar; ?></p>
                <?php
                    unset($_SESSION['message']);
                elseif ($_SESSION['message'] == 'reset') : ?>
                    <p class="sukses"><?= $reset; ?></p>
            <?php
                    unset($_SESSION['message']);
                endif;
            endif; ?>
            <form action="" method="post" class="form">
                <div class="form-group">
                    <label for="email">Email : </label>
                    <input type="email" name="email" id="email" autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="button-group">
                    <button type="submit" name="login">Login</button>
                </div>
                <div class="text">
                    <a href="pages/daftar.php" class="daftar">Belum punya akun?</a>
                    <a href="pages/lupa.php" class="lupa">Lupa password?</a>
                </div>
            </form>
        </main>
    </div>
</body>

</html>
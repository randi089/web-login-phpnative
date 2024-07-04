<?php
session_start();
require '../controller/controller.php';

// cek apakah sudah login?
if (isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

// cek apakah form daftar sudah disubmit?
if (isset($_POST['daftar'])) {
    $daftar = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'password1' => $_POST['password1']
    ];

    $cekDaftar = daftar($daftar);

    // apakah daftar berhasil
    if ($cekDaftar == 'ok') {
        $_SESSION['message'] = true;
        header('Location: ../index.php');
        exit;
    } elseif ($cekDaftar == 'kosong') {
        $eKosong = true;
    } elseif ($cekDaftar == 'pass') {
        $nPass = true;
    } elseif ($cekDaftar == 'daftar') {
        $nDaftar = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/daftar.css">
    <title>Daftar Akun</title>
</head>

<body>
    <div class="container">
        <h1>Daftar Akun</h1>
        <?php
        $kosong = 'Input tidak boleh ada yang kosong!';
        $notPass = 'Password tidak sama!';
        $tDaftar = 'Email sudah terdaftar!';
        if (isset($nDaftar)) :
        ?>
            <p><?= $tDaftar; ?></p>
        <?php elseif (isset($eKosong)) : ?>
            <p><?= $kosong; ?></p>
        <?php elseif (isset($nPass)) : ?>
            <p><?= $notPass; ?></p>
        <?php endif; ?>
        <form action="" method="post" class="form">
            <div class="form-group">
                <label for="username">Username : </label>
                <input type="text" name="username" id="username" autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email : </label>
                <input type="email" class="email" name="email" id="email" autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password : </label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="password1">Ulangi Password : </label>
                <input type="password" name="password1" id="password1">
            </div>
            <div class="button-group">
                <button type="submit" name="daftar">Daftar</button>
                <a href="../index.php">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>
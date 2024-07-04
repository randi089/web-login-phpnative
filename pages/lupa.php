<?php
session_start();
require '../controller/controller.php';

if (isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['reset'])) {
    // kirim ke controller email
    $cekReset = cekReset($_POST['email']);

    // cek reset
    if ($cekReset == 'ok') {
        header('Location: reset.php');
        exit;
    } elseif ($cekReset == 'salah') {
        $invalid = true;
    } else {
        $kosong = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/lupa.css">
    <title>Lupa Password</title>
</head>

<body>
    <div class="container">
        <h1>Lupa Password</h1>
        <?php
        $tInvalid = 'Email salah!';
        $tKosong = 'Email harus di isi!';
        if (isset($invalid)) : ?>
            <p><?= $tInvalid; ?></p>
        <?php elseif (isset($kosong)) : ?>
            <p><?= $tKosong; ?></p>
        <?php endif; ?>
        <form action="" method="post" class="form">
            <div class="form-group">
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" autofocus>
            </div>
            <div class="button-group">
                <button type="submit" name="reset">Reset Password</button>
                <a href="../index.php">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>
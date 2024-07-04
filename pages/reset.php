<?php
session_start();
require '../controller/controller.php';

// cek session login
if (isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

// cek session reset
if (!isset($_SESSION['reset'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['ubah'])) {
    $data = [
        'password' => $_POST['password'],
        'password1' => $_POST['password1']
    ];
    $reset = resetP($_SESSION['reset'], $data);

    // cek kondisi reset
    if ($reset == 'ok') {
        unset($_SESSION['reset']);
        $_SESSION['message'] = 'reset';
        header('Location: ../index.php');
        exit;
    } elseif ($reset == 'kosong') {
        $eKosong = true;
    } else {
        $nPass = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/daftar.css">
    <title>Reset Password</title>
</head>

<body>
    <div class="container">
        <h1>Reset Password</h1>
        <?php
        $kosong = 'Input tidak boleh ada yang kosong!';
        $notPass = 'Password tidak sama!';
        if (isset($eKosong)) :
        ?>
            <p><?= $kosong; ?></p>
        <?php elseif (isset($nPass)) : ?>
            <p><?= $notPass; ?></p>
        <?php endif; ?>
        <form action="" method="post" class="form">
            <div class="form-group">
                <label for="password">Password Baru : </label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="password1">Ulangi Password : </label>
                <input type="password" name="password1" id="password1">
            </div>
            <div class="button-group">
                <button type="submit" name="ubah">Ubah Password</button>
            </div>
        </form>
    </div>
</body>

</html>
<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "weblogin");

// Mendaftarkan akun
function daftar($data)
{
    global $conn;
    $username = strtolower(stripslashes($data['username']));
    $email = strtolower($data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password1 = mysqli_real_escape_string($conn, $data['password1']);

    // cek apakah input dari form ada yang kosong
    if (empty($username) || empty($email) || empty($password) || empty($password1)) {
        return 'kosong';
    } elseif ($password != $password1) {
        return 'pass';
    } else {
        $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

        // cek apakah email sudah terdaftar
        if (mysqli_num_rows($result) > 0) {
            return 'daftar';
        } else {
            // enkripsi password
            $password = password_hash($password, PASSWORD_DEFAULT);

            // tambahkan akun baru ke database
            mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$email', '$password')");
            return 'ok';
        }
    }
}

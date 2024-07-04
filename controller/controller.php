<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "weblogin");

// Login
function login($data)
{
    global $conn;

    $emailI = $data['email'];
    $passwordI = $data['password'];

    if ($emailI == '' || $passwordI == '') {
        return 'kosong';
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

                if (password_verify($passwordI, $password)) {
                    // Verification success! User has logged in.
                    // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                    $_SESSION['login'] = [
                        'id' => $id,
                        'username' => $username,
                        'email' => $email,
                        'password' => $password
                    ];
                    return 'ok';
                } else {
                    return 'salah';
                }
            } else {
                return '!daftar';
            }

            $stmt->close();
        }
    }
}

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

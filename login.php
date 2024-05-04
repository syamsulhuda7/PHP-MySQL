<?php
session_start();
require 'functions.php';

// cek cookie dulu sebelum login
if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];

    // ambil username berdasarkan id
    $result = mysqli_query($db, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row["username"])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION{
    "login"})) {
    header("Location: index.php");
    exit;
}


if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($db, "SELECT * FROM user WHERE username = '$username'");

    // Cek username di dalam database apa sama dengan input
    if (mysqli_num_rows($result) === 1) {
        // Cek password
        $rowPassword = mysqli_fetch_assoc($result);
        if (password_verify($password, $rowPassword["password"])) {

            // Set session
            $_SESSION["login"] = true;

            // Cek remember me
            if (isset($_POST["remember"])) {
                // buat cookie

                setcookie('id', $rowPassword['id'], time() + 60);
                setcookie('key', hash('sha256', $rowPassword["username"]), time() + 60);
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
        ul {
            list-style: none;
        }

        p {
            color: red;
            font-weight: bold;
            font-style: italic;
        }
    </style>
</head>

<body>

    <h1>Halaman Login</h1>

    <?php if (isset($error)) : ?>
        <p>username / password salah!</p>
    <?php endif; ?>

    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username :</label>
                <input type="text" id="username" name="username">
            </li>
            <li>
                <label for="password">Password :</label>
                <input type="password" id="password" name="password">
            </li>
            <li>
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">remember me</label>
            </li>
            <li>
                <button type="submit" name="login">Login</button>
            </li>
        </ul>
    </form>

</body>

</html>
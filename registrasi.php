<?php 
require 'functions.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "
        <script>
        alert('User baru berhasil ditambahkan!')
        </script>
        ";
    } else {
        echo mysqli_error($db);
    };
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>
        label {
            display: block;
        }
        ul {
            list-style: none;
        }
    </style>
</head>
<body>
    <h1>Halaman Registrasi</h1>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username">username :</label>
                <input autocomplete="off" type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">password :</label>
                <input autocomplete="off" type="password" name="password" id="password">
            </li>
            <li>
                <label for="konfirmasiPassword">konfirmasi password :</label>
                <input autocomplete="off" type="password" name="konfirmasiPassword" id="konfirmasiPassword">
            </li>
            <li>
                <button type="submit" name="register">submit</button>
            </li>
        </ul>
    </form>
</body>
</html>
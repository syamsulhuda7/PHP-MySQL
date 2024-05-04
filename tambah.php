<?php
session_start();

if (!isset($_SESSION{"login"})) {
    header("Location: login.php");
}

// Koneksi
require 'functions.php';

// Cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

    // Cek apakah data berhasil ditambahkan
    if (tambah($_POST) > 0) {
        echo "
        <script>
        alert('Data berhasil ditambahkan!')
        document.location.href = 'index.php'
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Data gagal ditambahkan!')
        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
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
    <h1>Tambah Data Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nrp">NRP : </label>
                <input required type="text" id="nrp" name="nrp">
            </li>
            <li>
                <label for="nama">NAMA : </label>
                <input required type="text" id="nama" name="nama">
            </li>
            <li>
                <label for="email">EMAIL : </label>
                <input required type="email" id="email" name="email">
            </li>
            <li>
                <label for="jurusan">JURUSAN : </label>
                <input required type="text" id="jurusan" name="jurusan">
            </li>
            <li>
                <label for="gambar">GAMBAR : </label>
                <input required type="file" id="gambar" name="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Submit</button>
            </li>
        </ul>
    </form>
</body>

</html>
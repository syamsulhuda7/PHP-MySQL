<?php
session_start();

if (!isset($_SESSION{"login"})) {
    header("Location: login.php");
}

// Koneksi
require 'functions.php';

// Ambil data di URL
$id = $_GET["id"];
// Query data mahasiswa berdasarkan ID
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

// Cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

    // Cek apakah data berhasil diedit
    if (edit($_POST) > 0) {
        echo "
        <script>
        alert('Data berhasil diedit!')
        document.location.href = 'index.php'
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Data gagal diedit!')
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
    <title>Edit Data Mahasiswa</title>
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
    <h1>Edit Data Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input value="<?= $mhs["id"]; ?>" type="hidden" name="id">
        <input value="<?= $mhs["gambar"]; ?>" type="hidden" name="gambarLama">
        <ul>
            <li>
                <label for="nrp">NRP : </label>
                <input value="<?= $mhs["nrp"]; ?>" required type="text" id="nrp" name="nrp">
            </li>
            <li>
                <label for="nama">NAMA : </label>
                <input value="<?= $mhs["nama"]; ?>" required type="text" id="nama" name="nama">
            </li>
            <li>
                <label for="email">EMAIL : </label>
                <input value="<?= $mhs["email"]; ?>" required type="email" id="email" name="email">
            </li>
            <li>
                <label for="jurusan">JURUSAN : </label>
                <input value="<?= $mhs["jurusan"]; ?>" required type="text" id="jurusan" name="jurusan">
            </li>
            <li>
                <label for="gambar">GAMBAR : </label>
                <img width="50" src="img/<?= $mhs['gambar'] ?>" alt="">
                <br>
                <input type="file" id="gambar" name="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Submit</button>
            </li>
        </ul>
    </form>
</body>

</html>
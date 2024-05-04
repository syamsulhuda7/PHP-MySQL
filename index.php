<?php
session_start();

if (!isset($_SESSION{
"login"})) {
    header("Location: login.php");
}

require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id DESC");

// tombol cari di klik
if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        .loader {
            width: 80px;
            position: absolute;
            top: 125px;
            left: 290px;
            z-index: -1;
            display: none;
        }

        @media print {
            .logout, .tambah, .cari, .aksi, .aksi2 {
                display: none;
            }
        }
    </style>
</head>

<body>

    <a class="logout" href="logout.php">Logout</a>

    <h1>Daftar Mahasiswa</h1>

    <a class="tambah" href="tambah.php">Tambah Data Mahasiswa</a>
    <br><br>

    <!-- Pencarian -->
    <form class="cari" action="" method="post">
        <input id="keyword" autocomplete="off" type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword yang ingin dicari . . .">
        <buttoni id="tombolCari" type="submit" name="cari">Cari</buttoni>
    </form>
    <br>
    <!-- End Pencarian -->

    <img src="img/loader.gif" class="loader" alt="">

    <div id="container">
        <table border='1' cellpadding='10' cellspacing='0'>
            <tr>
                <th>No.</th>
                <th class="aksi">Aksi</th>
                <th>Gambar</th>
                <th>NRP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>
            <?php $i = 1 ?>
            <?php foreach ($mahasiswa as $row) : ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td class="aksi2">
                        <a href="edit.php?id=<?php echo $row['id'] ?>">edit</a> |
                        <a href="delete.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">delete</a>
                    </td>
                    <td><img src="img/<?php echo $row['gambar'] ?>" alt="" width='50'></td>
                    <td><?php echo $row['nrp'] ?></td>
                    <td><?php echo $row['nama'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['jurusan'] ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>

        </table>
    </div>
    <script src="js/jquery-3.7.1.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
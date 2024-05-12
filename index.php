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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .logout, .tambah {
            padding: 8px 16px;
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout {
            background-color: #dc3545;
            position: absolute;
            top: 50px;
            right: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: darkblue;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        img {
            width: 50px;
            height: auto;
            border-radius: 50%;
        }

        input[type="text"] {
            padding: 10px;
            margin-right: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            width: 300px; /* Adjust as needed */
        }

        button {
            padding: 10px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .loader {
            width: 50px; /* Adjust size as necessary */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }
        .top {
            display: flex;
            justify-content: space-between;
        }
        .edit {
            text-decoration: none;
            padding: 5px 10px;
            background-color: green;
            color: white;
            border-radius: 10px;
        }
        .delete {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border-radius: 10px;
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

    <div class="top">
        
        <!-- Pencarian -->
        <form class="cari" action="" method="post">
            <input id="keyword" autocomplete="off" type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword yang ingin dicari . . .">
            <buttoni id="tombolCari" type="submit" name="cari">Cari</buttoni>
        </form>
        <!-- End Pencarian -->

        <a class="tambah" href="tambah.php">Tambah Data Mahasiswa</a>
        
    </div>

    <img src="img/loader.gif" class="loader" alt="">

    <div id="container">
        <table border='1' cellpadding='10' cellspacing='0'>
            <tr>
                <th>No.</th>
                <th class="aksi">Aksi</th>
                <th>Gambar</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>
            <?php $i = 1 ?>
            <?php foreach ($mahasiswa as $row) : ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td class="aksi2">
                        <a class="edit" href="edit.php?id=<?php echo $row['id'] ?>">edit</a> |
                        <a class="delete" href="delete.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">delete</a>
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
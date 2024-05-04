<?php 
// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "phpdasar2");

function query($query) {
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $db;
    // Ambil data dari tiap elemen form
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // Upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // Query insert data
    $query = "INSERT INTO mahasiswa VALUES('', '$nama', '$nrp', '$email', '$jurusan', '$gambar')";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function upload () {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apa tidak ada gambar diupload
    if ($error === 4) {
        echo "<script>
        alert('Pilih gambar terlebih dahulu!')
        </script>
        ";
        return false;
    }

    // Cek apakah yang diupload gambar atau bukan (cek extensi file)
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
        alert('yang anda upload bukan gambar')
        </script>
        ";
        return false;
    }

    // Cek jika ukuran terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
        alert('Ukuran gambar terlalu besar!')
        </script>
        ";
        return false;
    }

    // Lolos pengecekan, gambar siap diupload
    // Generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function hapus ($id) {
    global $db;
    mysqli_query($db, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($db);
}

function edit ($data) {
    global $db;
    // Ambil data dari tiap elemen form
    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = $data["gambarLama"];

    // Cek apakah user pilih gambar baru atau tidak
    if ( $_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    // $gambar = htmlspecialchars($data["gambar"]);

    // Query update data
    $query = "UPDATE mahasiswa SET
                nrp = '$nrp',
                nama = '$nama',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
                WHERE id = $id 
            ";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function cari ($keyword) {
    $query = "SELECT * FROM mahasiswa WHERE 
                nama LIKE '%$keyword%' OR
                nrp LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%'
                ORDER BY id DESC
                ";
    return query($query);
}

function registrasi ($data) {
    global $db;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($db, $data["password"]);
    $konfirmasiPassword = mysqli_real_escape_string($db, $data["konfirmasiPassword"]);

    // Cek username sudah ada apa belum
    $result = mysqli_query($db, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
        alert('Username sudah terdaftar!')
        </script>
        ";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $konfirmasiPassword) {
        echo "
        <script>
        alert('Konfirmasi password tidak sesuai!')
        </script>
        ";
        return false;
    }
    
    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    mysqli_query($db, "INSERT INTO user VALUES ('', '$username', '$password')");
    return mysqli_affected_rows($db);
    
}

?>
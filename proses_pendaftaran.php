<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama       = htmlspecialchars($_POST['nama']);
    $email      = htmlspecialchars($_POST['email']);
    $nomor_hp   = htmlspecialchars($_POST['nomor_hp']);
    $judul_foto = htmlspecialchars($_POST['judul_foto']);
    $deskripsi  = htmlspecialchars($_POST['deskripsi']);

    // Upload foto
    $foto = $_FILES['foto'];
    $nama_file = basename($foto['name']);
    $lokasi_tmp = $foto['tmp_name'];
    $target = "uploads/" . $nama_file;

    // Cek dan buat folder uploads jika belum ada
    if (!is_dir("uploads")) {
        mkdir("uploads");
    }

    if (move_uploaded_file($lokasi_tmp, $target)) {
        $sql = "INSERT INTO peserta_foto (nama, email, nomor_hp, judul_foto, deskripsi, nama_file)
                VALUES ('$nama', '$email', '$nomor_hp', '$judul_foto', '$deskripsi', '$nama_file')";

        if (mysqli_query($conn, $sql)) {
            echo "<h2>Pendaftaran Berhasil!</h2>";
            echo "Nama: $nama<br>";
            echo "Email: $email<br>";
            echo "Nomor HP: $nomor_hp<br>";
            echo "Judul Foto: $judul_foto<br>";
            echo "Deskripsi: $deskripsi<br>";
            echo "<img src='uploads/$nama_file' style='max-width:300px;margin-top:10px;'><br>";
        } else {
            echo "Gagal menyimpan ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Upload foto gagal.";
    }
} else {
    echo "Akses tidak sah.";
}
?>

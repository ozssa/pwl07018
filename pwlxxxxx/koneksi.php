<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pwlgenap2019-akademik";  // Pakai nama database yang benar

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
<?php
$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'perusahaan'; // Nama database
$username = 'root'; // Username MySQL Anda
$password = ''; // Password MySQL Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

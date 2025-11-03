<?php
// --- INI ADALAH PERUBAHAN DARI BRANCH KONEKSIDATABASE ---
// --- Konfigurasi Database ---
$server   = "localhost"; // Nama server database (biasanya "localhost")
$user     = "root";      // Username database (default XAMPP/Laragon)
$pass     = "";          // Password database (default XAMPP/Laragon kosong)
$database = "data_mahasiswa"; // Nama database Anda
// -----------------------------

// Membuat koneksi
$koneksi = new mysqli($server, $user, $pass, $database);

// Cek koneksi
if ($koneksi->connect_error) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan script
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Jika Anda ingin mengetes file ini secara langsung, 
// hapus tanda komentar (//) di baris bawah ini.
// echo "Koneksi ke database berhasil!"; 

?>
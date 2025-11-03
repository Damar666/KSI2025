<?php
// Sertakan file koneksi (karena branch ini adalah salinan dari main, 
// file koneksi.php sudah ada di sini)
include 'koneksi.php';

// 1. Ambil data dari form (method POST)
$nim     = $_POST['nim'];
$nama    = $_POST['nama'];
$jurusan = $_POST['jurusan'];

// 2. Buat query INSERT
$sql = "INSERT INTO mahasiswa (nim, nama, jurusan) VALUES (?, ?, ?)";

// 3. Persiapkan statement (untuk keamanan dari SQL Injection)
$stmt = $koneksi->prepare($sql);

// 4. Bind parameter
// "sss" berarti 3 variabel berikutnya adalah string
$stmt->bind_param("sss", $nim, $nama, $jurusan);

// 5. Eksekusi query
if ($stmt->execute()) {
    echo "Data mahasiswa berhasil ditambahkan!";
    // Arahkan kembali ke halaman utama setelah 2 detik
    header("refresh:2;url=index.php");
} else {
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}

// 6. Tutup statement dan koneksi
$stmt->close();
$koneksi->close();

?>
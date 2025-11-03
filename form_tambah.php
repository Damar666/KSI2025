<?php
// --- BAGIAN LOGIKA PROSES ---
$pesan = "";
$pesan_tipe = "";

// Cek apakah form disubmit (apakah methodnya POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 1. Sertakan koneksi HANYA saat form disubmit
    include 'koneksi.php'; 

    // 2. Ambil data dari form
    $nim     = $_POST['nim'];
    $nama    = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $semester = $_POST['semester'];
    $ipk      = $_POST['ipk'];

    // 3. Buat query INSERT
    $sql = "INSERT INTO mahasiswa (nim, nama, jurusan, semester, ipk) VALUES (?, ?, ?, ?, ?)";

    // 4. Persiapkan statement
    $stmt = $koneksi->prepare($sql);

    // 5. Bind parameter ("sssid" = String, String, String, Integer, Double)
    $stmt->bind_param("sssid", $nim, $nama, $jurusan, $semester, $ipk);

    // 6. Eksekusi query
    if ($stmt->execute()) {
        $pesan = "Data mahasiswa berhasil ditambahkan! Mengalihkan ke halaman utama...";
        $pesan_tipe = "success";
        
        // Arahkan kembali ke halaman utama setelah 2 detik
        header("refresh:2;url=index.php");
    } else {
        // Cek apakah error karena duplicate entry (NIM sudah ada)
        if ($koneksi->errno == 1062) { 
            $pesan = "Error: NIM '$nim' sudah terdaftar. Gunakan NIM lain.";
        } else {
            $pesan = "Error: " . $stmt->error;
        }
        $pesan_tipe = "danger";
    }

    // 7. Tutup statement dan koneksi
    $stmt->close();
    $koneksi->close();
}
// --- AKHIR BAGIAN LOGIKA ---
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 600px;">
        <h1 class="mb-4 text-center">Form Tambah Mahasiswa</h1>
        <div class="card">
            <div class="card-body">

                <?php 
                // Tampilkan pesan sukses atau error di sini
                if (!empty($pesan)) : 
                ?>
                    <div class="alert alert-<?= htmlspecialchars($pesan_tipe); ?>" role="alert">
                        <?= htmlspecialchars($pesan); ?>
                    </div>
                <?php endif; ?>

                <form action="form_tambah.php" method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="number" class="form-control" id="semester" name="semester" required>
                    </div>
                    <div class="mb-3">
                        <label for="ipk" class="form-label">IPK</label>
                        <input type="text" class="form-control" id="ipk" name="ipk" placeholder="Contoh: 3.75" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
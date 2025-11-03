<?php
// 1. Sertakan file koneksi Anda
include 'koneksi.php';

// 2. Buat query untuk mengambil data mahasiswa DARI DATABASE
$sql = "SELECT * FROM mahasiswa";
$hasil_query = $koneksi->query($sql);

// --- Fungsi untuk menentukan status IPK ---
// (Fungsi ini Anda biarkan saja, sudah benar)
function getStatusIPK($ipk)
{
    if ($ipk >= 3.75) {
        return ['status' => 'Cumlaude', 'class' => 'success'];
    } elseif ($ipk >= 3.50) {
        return ['status' => 'Sangat Memuaskan', 'class' => 'info'];
    } elseif ($ipk >= 3.00) {
        return ['status' => 'Memuaskan', 'class' => 'warning'];
    } else {
        return ['status' => 'Cukup', 'class' => 'secondary'];
    }
}

// --- Logika untuk menghitung statistik ---
// Kita perlu mengambil data ke array dulu untuk menghitung statistik
$mahasiswa_dari_db = [];
if ($hasil_query && $hasil_query->num_rows > 0) {
    while ($row = $hasil_query->fetch_assoc()) {
        $mahasiswa_dari_db[] = $row;
    }
}
// Setel ulang pointer hasil query untuk looping di tabel nanti
if ($hasil_query) {
    $hasil_query->data_seek(0); // Kembali ke awal data
}

// Gunakan data dari DB untuk statistik
$total_mahasiswa = count($mahasiswa_dari_db);
$total_ipk = ($total_mahasiswa > 0) ? array_sum(array_column($mahasiswa_dari_db, 'ipk')) : 0;
$rata_rata_ipk = ($total_mahasiswa > 0) ? $total_ipk / $total_mahasiswa : 0;
$total_cumlaude = count(array_filter($mahasiswa_dari_db, fn ($m) => $m['ipk'] >= 3.75));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - KSI 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }

        .main-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .table-container {
            overflow-x: auto;
        }

        .custom-table {
            border-radius: 10px;
            overflow: hidden;
        }

        .custom-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
            transition: all 0.3s;
        }

        .badge-custom {
            padding: 8px 15px;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-container">
            <div class="header-section">
                <h1 class="display-4 fw-bold">
                    <i class="bi bi-mortarboard-fill text-primary"></i>
                    Data Mahasiswa
                </h1>
                <p class="lead text-muted">Sistem Informasi Akademik - KSI 2025</p>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <a href="form_tambah.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Data Mahasiswa
                </a>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="display-6"><?= $total_mahasiswa ?></h3>
                        <p class="mb-0"><i class="bi bi-people-fill"></i> Total Mahasiswa</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="display-6"><?= number_format($rata_rata_ipk, 2) ?></h3>
                        <p class="mb-0"><i class="bi bi-graph-up"></i> Rata-rata IPK</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="display-6"><?= $total_cumlaude ?></h3>
                        <p class="mb-0"><i class="bi bi-trophy-fill"></i> Cumlaude</p>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover custom-table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama Mahasiswa</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col" class="text-center">Semester</th>
                            <th scope="col" class="text-center">IPK</th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php
                        // Ganti loop foreach menjadi loop while dari hasil query
                        if ($hasil_query && $hasil_query->num_rows > 0) :
                            while ($mhs = $hasil_query->fetch_assoc()) :
                        ?>
                                <?php $status = getStatusIPK($mhs['ipk']); ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($mhs['nim']) ?></td>
                                    <td>
                                        <i class="bi bi-person-circle text-primary"></i>
                                        <strong><?= htmlspecialchars($mhs['nama']) ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($mhs['jurusan']) ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary"><?= htmlspecialchars($mhs['semester']) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-<?= $status['class'] ?>"><?= number_format($mhs['ipk'], 2) ?></strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $status['class'] ?> badge-custom">
                                            <?= $status['status'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php
                            endwhile;
                        else :
                            ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data mahasiswa di database.</td>
                            </tr>
                        <?php
                        endif;
                        // Tutup koneksi
                        $koneksi->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4 pt-3 border-top">
                <p class="text-muted mb-0">
                    <i class="bi bi-code-slash"></i>
                    Dibuat dengan PHP Native + Bootstrap 5
                </p>
                <p class="text-muted small">© 2025 KSI - Keamanan Sistem Informasi</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

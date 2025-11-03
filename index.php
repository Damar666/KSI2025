<?php
// Data mahasiswa (simulasi database)
$mahasiswa = [
    [
        'nim' => '2211040001',
        'nama' => 'Zakkya Nurhadi',
        'jurusan' => 'Manajemen Informatika',
        'semester' => 5,
        'ipk' => 3.75
    ],
    [
        'nim' => '2211040002',
        'nama' => 'Siti Nurhaliza',
        'jurusan' => 'Sistem Informasi',
        'semester' => 5,
        'ipk' => 3.85
    ],
    [
        'nim' => '2211040003',
        'nama' => 'Budi Santoso',
        'jurusan' => 'Teknik Informatika',
        'semester' => 5,
        'ipk' => 3.60
    ],
    [
        'nim' => '2211040004',
        'nama' => 'Dewi Lestari',
        'jurusan' => 'Sistem Informasi',
        'semester' => 5,
        'ipk' => 3.90
    ],
    [
        'nim' => '2211040005',
        'nama' => 'Eko Prasetyo',
        'jurusan' => 'Teknik Informatika',
        'semester' => 5,
        'ipk' => 3.55
    ]
]

// Fungsi untuk menentukan status IPK
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
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - KSI 2025</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
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
            <!-- Header -->
            <div class="header-section">
                <h1 class="display-4 fw-bold">
                    <i class="bi bi-mortarboard-fill text-primary"></i>
                    Data Mahasiswa
                </h1>
                <p class="lead text-muted">Sistem Informasi Akademik - KSI 2025</p>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="display-6"><?= count($mahasiswa) ?></h3>
                        <p class="mb-0"><i class="bi bi-people-fill"></i> Total Mahasiswa</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="display-6"><?= number_format(array_sum(array_column($mahasiswa, 'ipk')) / count($mahasiswa), 2) ?></h3>
                        <p class="mb-0"><i class="bi bi-graph-up"></i> Rata-rata IPK</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="display-6"><?= count(array_filter($mahasiswa, fn($m) => $m['ipk'] >= 3.75)) ?></h3>
                        <p class="mb-0"><i class="bi bi-trophy-fill"></i> Cumlaude</p>
                    </div>
                </div>
            </div>

            <!-- Table -->
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
                        <?php foreach ($mahasiswa as $mhs): ?>
                            <?php $status = getStatusIPK($mhs['ipk']); ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $no++ ?></td>
                                <td><?= $mhs['nim'] ?></td>
                                <td>
                                    <i class="bi bi-person-circle text-primary"></i>
                                    <strong><?= $mhs['nama'] ?></strong>
                                </td>
                                <td><?= $mhs['jurusan'] ?></td>
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?= $mhs['semester'] ?></span>
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
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4 pt-3 border-top">
                <p class="text-muted mb-0">
                    <i class="bi bi-code-slash"></i>
                    Dibuat dengan PHP Native + Bootstrap 5
                </p>
                <p class="text-muted small">© 2025 KSI - Keamanan Sistem Informasi</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
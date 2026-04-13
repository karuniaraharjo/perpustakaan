<?php
require_once 'functions_anggota.php';

// Data anggota
$anggota_list = [
    [
        'id' => 1,
        'nama' => 'Budi Santoso',
        'email' => 'budi@email.com',
        'status' => 'Aktif',
        'tanggal_daftar' => '2024-01-15',
        'total_pinjaman' => 5
    ],
    [
        'id' => 2,
        'nama' => 'Siti Nurhaliza',
        'email' => 'siti@email.com',
        'status' => 'Aktif',
        'tanggal_daftar' => '2024-02-10',
        'total_pinjaman' => 8
    ],
    [
        'id' => 3,
        'nama' => 'Ahmad Wijaya',
        'email' => 'ahmad@email.com',
        'status' => 'Non-Aktif',
        'tanggal_daftar' => '2023-12-05',
        'total_pinjaman' => 2
    ],
    [
        'id' => 4,
        'nama' => 'Dewi Lestari',
        'email' => 'dewi@email.com',
        'status' => 'Aktif',
        'tanggal_daftar' => '2024-03-20',
        'total_pinjaman' => 12
    ],
    [
        'id' => 5,
        'nama' => 'Rina Kusuma',
        'email' => 'rina@email.com',
        'status' => 'Aktif',
        'tanggal_daftar' => '2024-01-25',
        'total_pinjaman' => 6
    ]
];

// Handle search
$search_query = $_GET['search'] ?? '';
$filtered_list = $search_query ? search_anggota_by_nama($anggota_list, $search_query) : $anggota_list;
$filtered_list = sort_anggota_by_nama($filtered_list);

// Handle status filter
$status_filter = $_GET['status'] ?? '';
if ($status_filter) {
    $filtered_list = filter_by_status($filtered_list, $status_filter);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand mb-0 h1"><i class="bi bi-library"></i> Perpustakaan</span>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota Perpustakaan</h1>
        
        <!-- Dashboard Statistik -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h6 class="card-title">Total Anggota</h6>
                        <h2><?php echo hitung_total_anggota($anggota_list); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h6 class="card-title">Anggota Aktif</h6>
                        <h2><?php echo hitung_anggota_aktif($anggota_list); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h6 class="card-title">Rata-rata Pinjaman</h6>
                        <h2><?php echo number_format(hitung_rata_rata_pinjaman($anggota_list), 1); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h6 class="card-title">Non-Aktif</h6>
                        <h2><?php echo hitung_total_anggota($anggota_list) - hitung_anggota_aktif($anggota_list); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anggota Teraktif -->
        <?php $teraktif = cari_anggota_teraktif($anggota_list); ?>
        <?php if ($teraktif): ?>
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-star-fill"></i> Anggota Teraktif</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5><?php echo $teraktif['nama']; ?></h5>
                        <p class="text-muted"><?php echo $teraktif['email']; ?></p>
                        <p><strong>Total Pinjaman:</strong> <?php echo $teraktif['total_pinjaman']; ?> buku</p>
                        <p><strong>Terdaftar:</strong> <?php echo format_tanggal_indo($teraktif['tanggal_daftar']); ?></p>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="badge bg-success">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Search dan Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama anggota..." value="<?php echo htmlspecialchars($search_query); ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Aktif" <?php echo $status_filter === 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="Non-Aktif" <?php echo $status_filter === 'Non-Aktif' ? 'selected' : ''; ?>>Non-Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Anggota -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Anggota (<?php echo count($filtered_list); ?>)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tgl Daftar</th>
                                <th>Pinjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filtered_list as $anggota): ?>
                            <tr>
                                <td><?php echo $anggota['id']; ?></td>
                                <td><?php echo htmlspecialchars($anggota['nama']); ?></td>
                                <td><?php echo htmlspecialchars($anggota['email']); ?></td>
                                <td>
                                    <span class="badge <?php echo $anggota['status'] === 'Aktif' ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $anggota['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo format_tanggal_indo($anggota['tanggal_daftar']); ?></td>
                                <td><?php echo $anggota['total_pinjaman']; ?> buku</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center py-4 mt-5">
        <p class="text-muted mb-0">&copy; 2024 Sistem Anggota Perpustakaan</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
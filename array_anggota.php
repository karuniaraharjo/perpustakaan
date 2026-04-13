<?php
$anggota_list = [
    [
        "id" => "AGT-001",
        "nama" => "Budi Santoso",
        "email" => "budi@email.com",
        "telepon" => "081234567890",
        "alamat" => "Jakarta",
        "tanggal_daftar" => "2024-01-15",
        "status" => "Aktif",
        "total_pinjaman" => 5
    ],
    [
        "id" => "AGT-002",
        "nama" => "Siti Nurhaliza",
        "email" => "siti@email.com",
        "telepon" => "082345678901",
        "alamat" => "Bandung",
        "tanggal_daftar" => "2024-02-10",
        "status" => "Aktif",
        "total_pinjaman" => 8
    ],
    [
        "id" => "AGT-003",
        "nama" => "Ahmad Hidayat",
        "email" => "ahmad@email.com",
        "telepon" => "083456789012",
        "alamat" => "Surabaya",
        "tanggal_daftar" => "2024-01-20",
        "status" => "Non-Aktif",
        "total_pinjaman" => 2
    ],
    [
        "id" => "AGT-004",
        "nama" => "Rina Kusuma",
        "email" => "rina@email.com",
        "telepon" => "084567890123",
        "alamat" => "Yogyakarta",
        "tanggal_daftar" => "2024-03-05",
        "status" => "Aktif",
        "total_pinjaman" => 12
    ],
    [
        "id" => "AGT-005",
        "nama" => "Bambang Irawan",
        "email" => "bambang@email.com",
        "telepon" => "085678901234",
        "alamat" => "Medan",
        "tanggal_daftar" => "2024-02-28",
        "status" => "Aktif",
        "total_pinjaman" => 6
    ]
];

// Fungsi untuk menghitung total anggota
function hitungTotalAnggota($data)
{
    return count($data);
}

// Fungsi untuk menghitung anggota aktif
function hitungAnggotaAktif($data)
{
    $aktif = 0;
    foreach ($data as $anggota) {
        if ($anggota['status'] === 'Aktif') $aktif++;
    }
    return $aktif;
}

// Fungsi untuk mencari anggota dengan pinjaman terbanyak
function cariAnggotaTerbanyakPinjam($data)
{
    $max = 0;
    $anggota_terbanyak = null;
    foreach ($data as $anggota) {
        if ($anggota['total_pinjaman'] > $max) {
            $max = $anggota['total_pinjaman'];
            $anggota_terbanyak = $anggota;
        }
    }
    return $anggota_terbanyak;
}

// Fungsi untuk menghitung rata-rata pinjaman
function hitungRataRataPinjaman($data)
{
    $total = 0;
    foreach ($data as $anggota) {
        $total += $anggota['total_pinjaman'];
    }
    return count($data) > 0 ? $total / count($data) : 0;
}

// Fungsi untuk filter anggota berdasarkan status
function filterAnggotaByStatus($data, $status)
{
    $filtered = [];
    foreach ($data as $anggota) {
        if ($anggota['status'] === $status) {
            $filtered[] = $anggota;
        }
    }
    return $filtered;
}

// Hitung statistik
$total_anggota = hitungTotalAnggota($anggota_list);
$anggota_aktif = hitungAnggotaAktif($anggota_list);
$anggota_non_aktif = $total_anggota - $anggota_aktif;
$persen_aktif = ($anggota_aktif / $total_anggota) * 100;
$persen_non_aktif = ($anggota_non_aktif / $total_anggota) * 100;
$rata_rata_pinjaman = hitungRataRataPinjaman($anggota_list);
$anggota_terbanyak = cariAnggotaTerbanyakPinjam($anggota_list);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Anggota Perpustakaan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid py-4">
        <h1 class="mb-4">Sistem Manajemen Anggota Perpustakaan</h1>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Anggota</h5>
                        <h2><?php echo $total_anggota; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Anggota Aktif</h5>
                        <h2><?php echo $anggota_aktif; ?> (<?php echo round($persen_aktif, 1); ?>%)</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Anggota Non-Aktif</h5>
                        <h2><?php echo $anggota_non_aktif; ?> (<?php echo round($persen_non_aktif, 1); ?>%)</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Rata-rata Pinjaman</h5>
                        <h2><?php echo round($rata_rata_pinjaman, 2); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anggota Teraktif -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">Anggota Teraktif (Paling Banyak Pinjam)</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama:</strong> <?php echo $anggota_terbanyak['nama']; ?></p>
                        <p><strong>ID:</strong> <?php echo $anggota_terbanyak['id']; ?></p>
                        <p><strong>Total Pinjaman:</strong> <?php echo $anggota_terbanyak['total_pinjaman']; ?> buku</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Anggota Table -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Daftar Semua Anggota</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Total Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($anggota_list as $anggota): ?>
                            <tr>
                                <td><?php echo $anggota['id']; ?></td>
                                <td><?php echo $anggota['nama']; ?></td>
                                <td><?php echo $anggota['email']; ?></td>
                                <td><?php echo $anggota['telepon']; ?></td>
                                <td><?php echo $anggota['alamat']; ?></td>
                                <td><?php echo $anggota['tanggal_daftar']; ?></td>
                                <td>
                                    <span class="badge <?php echo ($anggota['status'] === 'Aktif') ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo $anggota['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo $anggota['total_pinjaman']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Filter Anggota Aktif -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Anggota Aktif</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (filterAnggotaByStatus($anggota_list, 'Aktif') as $anggota): ?>
                            <tr>
                                <td><?php echo $anggota['id']; ?></td>
                                <td><?php echo $anggota['nama']; ?></td>
                                <td><?php echo $anggota['email']; ?></td>
                                <td><?php echo $anggota['telepon']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
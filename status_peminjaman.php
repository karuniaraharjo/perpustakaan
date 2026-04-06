<?php
$nama_anggota = "Budi Santoso";
$total_pinjaman = 2;
$buku_terlambat = 1;
$hari_keterlambatan = 5; // hari
?>
<!DOCTYPE html>
<html>

<head>
    <title>Status Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Status Peminjaman Perpustakaan</h2>

        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Informasi Anggota</h3>
                <p><strong>Nama:</strong> <?php echo $nama_anggota; ?></p>
                <p><strong>Total Peminjaman:</strong> <?php echo $total_pinjaman; ?> buku</p>
                <p><strong>Buku Terlambat:</strong> <?php echo $buku_terlambat; ?> buku</p>
                <?php if ($buku_terlambat > 0): ?>
                    <p><strong>Hari Keterlambatan:</strong> <?php echo $hari_keterlambatan; ?> hari</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Status Peminjaman</h3>
                <?php
                $bisa_pinjam = true;
                $pesan = "";
                $total_denda = 0;

                if ($buku_terlambat > 0) {
                    $total_denda = $hari_keterlambatan * 1000 * $buku_terlambat;
                    if ($total_denda > 50000) {
                        $total_denda = 50000;
                    }
                    $bisa_pinjam = false;
                    $pesan .= "<p class='alert alert-danger'>⚠️ Ada buku yang terlambat!</p>";
                    $pesan .= "<p><strong>Total Denda:</strong> Rp " . number_format($total_denda, 0, ',', '.') . "</p>";
                } elseif ($total_pinjaman >= 3) {
                    $bisa_pinjam = false;
                    $pesan .= "<p class='alert alert-warning'>⚠️ Batas pinjaman maksimal sudah tercapai (3 buku)</p>";
                } else {
                    $bisa_pinjam = true;
                    $sisa_pinjaman = 3 - $total_pinjaman;
                    $pesan .= "<p class='alert alert-success'>✓ Anda masih bisa meminjam <strong>" . $sisa_pinjaman . "</strong> buku</p>";
                }

                echo $pesan;
                echo "<p><strong>Status:</strong> ";
                if ($bisa_pinjam) {
                    echo "<span class='badge bg-success'>Boleh Pinjam</span>";
                } else {
                    echo "<span class='badge bg-danger'>Tidak Boleh Pinjam</span>";
                }
                echo "</p>";
                ?>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Level Member</h3>
                <?php
                switch (true) {
                    case $total_pinjaman <= 5:
                        echo "<p><strong>Level:</strong> <span class='badge bg-warning'>Bronze</span></p>";
                        break;
                    case $total_pinjaman <= 15:
                        echo "<p><strong>Level:</strong> <span class='badge bg-secondary'>Silver</span></p>";
                        break;
                    default:
                        echo "<p><strong>Level:</strong> <span class='badge bg-info'>Gold</span></p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
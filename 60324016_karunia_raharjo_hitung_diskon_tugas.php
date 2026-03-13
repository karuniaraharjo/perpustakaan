<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>

        <?php
        $nama_pembeli = "Budi Santoso";
        $judul_buku = "Laravel Advanced";
        $harga_satuan = 150000;
        $jumlah_beli = 4;
        $is_member = true; // true atau false

        // Hitung subtotal
        $subtotal = $harga_satuan * $jumlah_beli;

        // Tentukan persentase diskon berdasarkan jumlah
        if ($jumlah_beli >= 1 && $jumlah_beli <= 2) {
            $persentase_diskon = 0;
        } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
            $persentase_diskon = 0.10;
        } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
            $persentase_diskon = 0.15;
        } else {
            $persentase_diskon = 0.20;
        }

        // Hitung diskon
        $diskon = $subtotal * $persentase_diskon;

        // Total setelah diskon pertama
        $total_setelah_diskon1 = $subtotal - $diskon;

        // Hitung diskon member jika member
        $diskon_member = 0;
        if ($is_member) {
            $diskon_member = $total_setelah_diskon1 * 0.05;
        }

        // Total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;

        // Hitung PPN
        $ppn = $total_setelah_diskon * 0.11;

        // Total akhir
        $total_akhir = $total_setelah_diskon + $ppn;

        // Total penghematan
        $total_hemat = $diskon + $diskon_member;
        ?>

        <div class="card">
            <div class="card-body">
            <h5 class="card-title">Detail Pembelian</h5>
            <table class="table">
                <tbody>
                <tr>
                    <td>Nama Pembeli</td>
                    <td><?php echo $nama_pembeli; ?></td>
                </tr>
                <tr>
                    <td>Judul Buku</td>
                    <td><?php echo $judul_buku; ?></td>
                </tr>
                <tr>
                    <td>Harga Satuan</td>
                    <td>Rp <?php echo number_format($harga_satuan, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td><?php echo $jumlah_beli; ?> buku</td>
                </tr>
                <tr>
                    <td>Status Member</td>
                    <td><?php echo $is_member ? 'Member' : 'Non-Member'; ?></td>
                </tr>
                <tr>
                    <td>Subtotal</td>
                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Diskon (<?php echo $persentase_diskon * 100; ?>%)</td>
                    <td>Rp <?php echo number_format($diskon, 0, ',', '.'); ?></td>
                </tr>
                <?php if ($is_member): ?>
                <tr>
                    <td>Diskon Member (5%)</td>
                    <td>Rp <?php echo number_format($diskon_member, 0, ',', '.'); ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td>Total setelah diskon</td>
                    <td>Rp <?php echo number_format($total_setelah_diskon, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>PPN (11%)</td>
                    <td>Rp <?php echo number_format($ppn, 0, ',', '.'); ?></td>
                </tr>
                </tbody>
            </table>
            <h5 class="mt-3">Total Akhir: <span class="badge bg-success">Rp <?php echo number_format($total_akhir, 0, ',', '.'); ?></span></h5>
            <p>Total Hemat: <span class="badge bg-warning">Rp <?php echo number_format($total_hemat, 0, ',', '.'); ?></span></p>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
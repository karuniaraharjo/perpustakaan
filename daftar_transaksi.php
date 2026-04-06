<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Transaksi Peminjaman</h1>

        <?php
        // Array untuk menyimpan data transaksi
        $transaksi_data = [];
        $total_transaksi = 0;
        $total_dipinjam = 0;
        $total_dikembalikan = 0;

        // Loop pertama untuk generate data dan hitung statistik
        for ($i = 1; $i <= 10; $i++) {
            $id_transaksi = "TRX-" . str_pad($i, 4, "0", STR_PAD_LEFT);
            $nama_peminjam = "Anggota " . $i;
            $judul_buku = "Buku Teknologi Vol. " . $i;
            $tanggal_pinjam = date('Y-m-d', strtotime("-$i days"));
            $tanggal_kembali = date('Y-m-d', strtotime("+7 days", strtotime($tanggal_pinjam)));
            $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";

            $transaksi_data[] = [
                'no' => $i,
                'id' => $id_transaksi,
                'peminjam' => $nama_peminjam,
                'buku' => $judul_buku,
                'tgl_pinjam' => $tanggal_pinjam,
                'tgl_kembali' => $tanggal_kembali,
                'status' => $status
            ];

            $total_transaksi++;
            if ($status == "Dipinjam") {
                $total_dipinjam++;
            } else {
                $total_dikembalikan++;
            }
        }
        ?>

        <!-- Tampilkan statistik dalam cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaksi</h5>
                        <h3><?php echo $total_transaksi; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Masih Dipinjam</h5>
                        <h3><?php echo $total_dipinjam; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Sudah Dikembalikan</h5>
                        <h3><?php echo $total_dikembalikan; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tampilkan tabel transaksi -->
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Hari</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no_urut = 0;
                // Loop untuk tampilkan data
                foreach ($transaksi_data as $data) {
                    // Skip transaksi genap dengan continue
                    if ($data['no'] % 2 == 0) {
                        continue;
                    }

                    // Break di transaksi ke-8
                    if ($data['no'] > 8) {
                        break;
                    }

                    $no_urut++;
                    $hari = (strtotime(date('Y-m-d')) - strtotime($data['tgl_pinjam'])) / 86400; // 86400 detik dalam sehari
                    $badge_class = ($data['status'] == "Dipinjam") ? "bg-warning" : "bg-success";
                ?>
                    <tr>
                        <td><?php echo $no_urut; ?></td>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['peminjam']; ?></td>
                        <td><?php echo $data['buku']; ?></td>
                        <td><?php echo $data['tgl_pinjam']; ?></td>
                        <td><?php echo $data['tgl_kembali']; ?></td>
                        <td><?php echo $hari; ?> hari</td>
                        <td><span class="badge <?php echo $badge_class; ?>"><?php echo $data['status']; ?></span></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
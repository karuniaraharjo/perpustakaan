<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Informasi Buku</h1>

        <?php
        // Data buku
        $data_buku = [
            [
                "pengarang" => "Karunia Raharjo",
                "penerbit" => "Informatika",
                "tahun_terbit" => 2023,
                "judul" => "Laravel: From Beginner to Advanced",
                "harga" => 125000,
                "stok" => 8,
                "isbn" => "978-602-1234-56-7",
                "kategori" => "Pemrograman",
                "bahasa" => "Indonesia",
                "jumlah_halaman" => 350,
                "berat" => "500 gram"
            ],
            [
                "pengarang" => "John Doe",
                "penerbit" => "Tech Press",
                "tahun_terbit" => 2022,
                "judul" => "Understanding PHP",
                "harga" => 95000,
                "stok" => 5,
                "isbn" => "978-602-1234-57-4",
                "kategori" => "Pemrograman",
                "bahasa" => "Inggris",
                "jumlah_halaman" => 400,
                "berat" => "600 gram"
            ],
            [
                "pengarang" => "Jane Smith",
                "penerbit" => "Database World",
                "tahun_terbit" => 2021,
                "judul" => "Mastering MySQL",
                "harga" => 85000,
                "stok" => 10,
                "isbn" => "978-602-1234-58-1",
                "kategori" => "Database",
                "bahasa" => "Indonesia",
                "jumlah_halaman" => 300,
                "berat" => "450 gram"
            ],
            [
                "pengarang" => "Alice Johnson",
                "penerbit" => "Web Design Co.",
                "tahun_terbit" => 2023,
                "judul" => "Web Design Essentials",
                "harga" => 110000,
                "stok" => 7,
                "isbn" => "978-602-1234-59-8",
                "kategori" => "Web Design",
                "bahasa" => "Inggris",
                "jumlah_halaman" => 250,
                "berat" => "300 gram"
            ],
        ];
        ?>

        <?php
        for ($i = 0; $i < count($data_buku); $i++) { ?>
            <div class="card mb-3">
                <div class="card-header <?php 
                    if ($data_buku[$i]["kategori"] == "Pemrograman") {
                        echo "bg-primary";
                    } elseif ($data_buku[$i]["kategori"] == "Database") {
                        echo "bg-success";
                    } elseif ($data_buku[$i]["kategori"] == "Web Design") {
                        echo "bg-warning";
                    } else {
                        echo "bg-secondary";
                    }
                ?> text-white">
                    <h5 class="mb-0"><?php echo $data_buku[$i]["judul"]; ?></h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Pengarang</th>
                            <td>: <?php echo $data_buku[$i]["pengarang"]; ?></td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td>: <?php echo $data_buku[$i]["penerbit"]; ?></td>
                        </tr>
                        <tr>
                            <th>Tahun Terbit</th>
                            <td>: <?php echo $data_buku[$i]["tahun_terbit"]; ?></td>
                        </tr>
                        <tr>
                            <th>ISBN</th>
                            <td>: <?php echo $data_buku[$i]["isbn"]; ?></td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>: Rp <?php echo number_format($data_buku[$i]["harga"], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>: <?php echo $data_buku[$i]["stok"]; ?> buku</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>: <?php echo $data_buku[$i]["kategori"]; ?></td>
                        </tr>
                        <tr>
                            <th>Bahasa</th>
                            <td>: <?php echo $data_buku[$i]["bahasa"]; ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Halaman</th>
                            <td>: <?php echo $data_buku[$i]["jumlah_halaman"]; ?> halaman</td>
                        </tr>
                        <tr>
                            <th>Berat</th>
                            <td>: <?php echo $data_buku[$i]["berat"]; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
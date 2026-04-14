<?php
session_start();

function h($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

function highlight_keyword($text, $keyword)
{
    $text = (string) $text;
    $keyword = trim((string) $keyword);

    if ($keyword === '') {
        return h($text);
    }

    $pattern = '/(' . preg_quote($keyword, '/') . ')/i';
    $parts = preg_split($pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE);

    if ($parts === false) {
        return h($text);
    }

    $output = '';
    foreach ($parts as $index => $part) {
        if ($index % 2 === 1) {
            $output .= '<mark>' . h($part) . '</mark>';
        } else {
            $output .= h($part);
        }
    }

    return $output;
}

function build_query($current, $overrides = [])
{
    $params = $current;
    unset($params['export']);

    foreach ($overrides as $key => $value) {
        if ($value === null || $value === '') {
            unset($params[$key]);
        } else {
            $params[$key] = $value;
        }
    }

    return http_build_query($params);
}

$buku_list = [
    ['kode' => 'BK-001', 'judul' => 'Pemrograman PHP untuk Pemula', 'kategori' => 'Programming', 'pengarang' => 'Budi Raharjo', 'penerbit' => 'Informatika', 'tahun' => 2023, 'harga' => 75000, 'stok' => 10],
    ['kode' => 'BK-002', 'judul' => 'Mastering MySQL Database', 'kategori' => 'Database', 'pengarang' => 'Andi Nugroho', 'penerbit' => 'Graha Ilmu', 'tahun' => 2022, 'harga' => 95000, 'stok' => 5],
    ['kode' => 'BK-003', 'judul' => 'Laravel Framework Advanced', 'kategori' => 'Programming', 'pengarang' => 'Siti Aminah', 'penerbit' => 'Informatika', 'tahun' => 2024, 'harga' => 125000, 'stok' => 8],
    ['kode' => 'BK-004', 'judul' => 'Web Design Principles', 'kategori' => 'Web Design', 'pengarang' => 'Dedi Santoso', 'penerbit' => 'Andi', 'tahun' => 2023, 'harga' => 85000, 'stok' => 15],
    ['kode' => 'BK-005', 'judul' => 'Network Security Fundamentals', 'kategori' => 'Networking', 'pengarang' => 'Rina Wijaya', 'penerbit' => 'Erlangga', 'tahun' => 2021, 'harga' => 110000, 'stok' => 0],
    ['kode' => 'BK-006', 'judul' => 'PHP Web Services', 'kategori' => 'Programming', 'pengarang' => 'Budi Raharjo', 'penerbit' => 'Informatika', 'tahun' => 2024, 'harga' => 90000, 'stok' => 12],
    ['kode' => 'BK-007', 'judul' => 'PostgreSQL Advanced', 'kategori' => 'Database', 'pengarang' => 'Ahmad Yani', 'penerbit' => 'Graha Ilmu', 'tahun' => 2024, 'harga' => 115000, 'stok' => 7],
    ['kode' => 'BK-008', 'judul' => 'JavaScript Modern', 'kategori' => 'Programming', 'pengarang' => 'Siti Aminah', 'penerbit' => 'Informatika', 'tahun' => 2023, 'harga' => 80000, 'stok' => 0],
    ['kode' => 'BK-009', 'judul' => 'Data Science Dasar', 'kategori' => 'Data Science', 'pengarang' => 'Maya Putri', 'penerbit' => 'Deepublish', 'tahun' => 2020, 'harga' => 130000, 'stok' => 4],
    ['kode' => 'BK-010', 'judul' => 'Algoritma dan Struktur Data', 'kategori' => 'Programming', 'pengarang' => 'Eko Kurniawan', 'penerbit' => 'Andi', 'tahun' => 2019, 'harga' => 98000, 'stok' => 2],
    ['kode' => 'BK-011', 'judul' => 'UI UX untuk Pemula', 'kategori' => 'Web Design', 'pengarang' => 'Nadia Lestari', 'penerbit' => 'Informatika', 'tahun' => 2025, 'harga' => 89000, 'stok' => 6],
    ['kode' => 'BK-012', 'judul' => 'Administrasi Jaringan Linux', 'kategori' => 'Networking', 'pengarang' => 'Rudi Hartono', 'penerbit' => 'Elex Media', 'tahun' => 2022, 'harga' => 105000, 'stok' => 9],
];

$kategori_options = array_values(array_unique(array_map(function ($item) {
    return $item['kategori'];
}, $buku_list)));
sort($kategori_options);

$keyword = trim($_GET['keyword'] ?? '');
$kategori = trim($_GET['kategori'] ?? '');
$min_harga = trim($_GET['min_harga'] ?? '');
$max_harga = trim($_GET['max_harga'] ?? '');
$tahun = trim($_GET['tahun'] ?? '');
$status = trim($_GET['status'] ?? 'semua');
$sort = trim($_GET['sort'] ?? 'judul');
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$export = trim($_GET['export'] ?? '');

$errors = [];
$status_valid = ['semua', 'tersedia', 'habis'];
$sort_valid = ['judul', 'harga', 'tahun'];
$current_year = (int) date('Y');

if ($kategori !== '' && !in_array($kategori, $kategori_options, true)) {
    $errors[] = 'Kategori yang dipilih tidak valid.';
}

if ($status !== '' && !in_array($status, $status_valid, true)) {
    $status = 'semua';
}

if (!in_array($sort, $sort_valid, true)) {
    $sort = 'judul';
}

if ($min_harga !== '' && (!is_numeric($min_harga) || (int) $min_harga < 0)) {
    $errors[] = 'Harga minimum harus berupa angka positif.';
}

if ($max_harga !== '' && (!is_numeric($max_harga) || (int) $max_harga < 0)) {
    $errors[] = 'Harga maksimum harus berupa angka positif.';
}

if ($min_harga !== '' && $max_harga !== '' && is_numeric($min_harga) && is_numeric($max_harga)) {
    if ((int) $min_harga > (int) $max_harga) {
        $errors[] = 'Harga minimum tidak boleh lebih besar dari harga maksimum.';
    }
}

if ($tahun !== '') {
    if (!ctype_digit($tahun)) {
        $errors[] = 'Tahun terbit harus berupa angka bulat.';
    } else {
        $tahun_int = (int) $tahun;
        if ($tahun_int < 1900 || $tahun_int > $current_year) {
            $errors[] = 'Tahun terbit harus berada pada rentang 1900 sampai tahun sekarang.';
        }
    }
}

$hasil = [];

if (count($errors) === 0) {
    $hasil = array_filter($buku_list, function ($buku) use ($keyword, $kategori, $min_harga, $max_harga, $tahun, $status) {
        if ($keyword !== '') {
            $in_judul = stripos($buku['judul'], $keyword) !== false;
            $in_pengarang = stripos($buku['pengarang'], $keyword) !== false;
            if (!$in_judul && !$in_pengarang) {
                return false;
            }
        }

        if ($kategori !== '' && $buku['kategori'] !== $kategori) {
            return false;
        }

        if ($min_harga !== '' && $buku['harga'] < (int) $min_harga) {
            return false;
        }

        if ($max_harga !== '' && $buku['harga'] > (int) $max_harga) {
            return false;
        }

        if ($tahun !== '' && $buku['tahun'] !== (int) $tahun) {
            return false;
        }

        if ($status === 'tersedia' && $buku['stok'] <= 0) {
            return false;
        }

        if ($status === 'habis' && $buku['stok'] > 0) {
            return false;
        }

        return true;
    });

    $hasil = array_values($hasil);

    usort($hasil, function ($a, $b) use ($sort) {
        if ($sort === 'harga') {
            return $a['harga'] <=> $b['harga'];
        }

        if ($sort === 'tahun') {
            return $a['tahun'] <=> $b['tahun'];
        }

        return strcasecmp($a['judul'], $b['judul']);
    });

    $is_search = ($keyword !== '' || $kategori !== '' || $min_harga !== '' || $max_harga !== '' || $tahun !== '' || $status !== 'semua');
    if ($is_search) {
        $search_snapshot = [
            'waktu' => date('d-m-Y H:i:s'),
            'keyword' => $keyword,
            'kategori' => $kategori,
            'min_harga' => $min_harga,
            'max_harga' => $max_harga,
            'tahun' => $tahun,
            'status' => $status,
            'sort' => $sort,
        ];

        $signature_payload = [
            'keyword' => $keyword,
            'kategori' => $kategori,
            'min_harga' => $min_harga,
            'max_harga' => $max_harga,
            'tahun' => $tahun,
            'status' => $status,
            'sort' => $sort,
        ];
        $current_signature = md5(json_encode($signature_payload));
        $recent_searches = $_SESSION['recent_searches'] ?? [];

        $filtered_recent = [];
        foreach ($recent_searches as $item) {
            $item_signature = md5(json_encode([
                'keyword' => $item['keyword'] ?? '',
                'kategori' => $item['kategori'] ?? '',
                'min_harga' => $item['min_harga'] ?? '',
                'max_harga' => $item['max_harga'] ?? '',
                'tahun' => $item['tahun'] ?? '',
                'status' => $item['status'] ?? 'semua',
                'sort' => $item['sort'] ?? 'judul',
            ]));

            if ($item_signature !== $current_signature) {
                $filtered_recent[] = $item;
            }
        }

        array_unshift($filtered_recent, $search_snapshot);
        $_SESSION['recent_searches'] = array_slice($filtered_recent, 0, 5);
    }
}

if ($export === 'csv' && count($errors) === 0) {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="hasil_pencarian_buku.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Kode', 'Judul', 'Kategori', 'Pengarang', 'Penerbit', 'Tahun', 'Harga', 'Stok']);

    foreach ($hasil as $row) {
        fputcsv($output, [
            $row['kode'],
            $row['judul'],
            $row['kategori'],
            $row['pengarang'],
            $row['penerbit'],
            $row['tahun'],
            $row['harga'],
            $row['stok'],
        ]);
    }

    fclose($output);
    exit;
}

$per_page = 10;
$total_hasil = count($hasil);
$total_pages = max(1, (int) ceil($total_hasil / $per_page));
$page = max(1, min($page, $total_pages));
$offset = ($page - 1) * $per_page;
$hasil_page = array_slice($hasil, $offset, $per_page);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Buku Lanjutan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="container py-5">
        <h1 class="mb-4"><i class="bi bi-search"></i> Sistem Pencarian Buku Lanjutan</h1>

        <?php if (count($errors) > 0): ?>
            <div class="alert alert-danger">
                <h6 class="mb-2"><i class="bi bi-exclamation-triangle-fill"></i> Validasi gagal:</h6>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo h($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-funnel"></i> Form Pencarian</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="keyword" class="form-label">Keyword (Judul/Pengarang)</label>
                            <input type="text" id="keyword" name="keyword" class="form-control" value="<?php echo h($keyword); ?>" placeholder="contoh: PHP atau Budi Raharjo">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select id="kategori" name="kategori" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                <?php foreach ($kategori_options as $item): ?>
                                    <option value="<?php echo h($item); ?>" <?php echo $kategori === $item ? 'selected' : ''; ?>>
                                        <?php echo h($item); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tahun" class="form-label">Tahun Terbit</label>
                            <input type="number" id="tahun" name="tahun" class="form-control" value="<?php echo h($tahun); ?>" min="1900" max="<?php echo $current_year; ?>" placeholder="<?php echo $current_year; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="min_harga" class="form-label">Harga Min (Rp)</label>
                            <input type="number" id="min_harga" name="min_harga" class="form-control" value="<?php echo h($min_harga); ?>" min="0" step="1000">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="max_harga" class="form-label">Harga Max (Rp)</label>
                            <input type="number" id="max_harga" name="max_harga" class="form-control" value="<?php echo h($max_harga); ?>" min="0" step="1000">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="sort" class="form-label">Sorting</label>
                            <select id="sort" name="sort" class="form-select">
                                <option value="judul" <?php echo $sort === 'judul' ? 'selected' : ''; ?>>Judul</option>
                                <option value="harga" <?php echo $sort === 'harga' ? 'selected' : ''; ?>>Harga</option>
                                <option value="tahun" <?php echo $sort === 'tahun' ? 'selected' : ''; ?>>Tahun</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label d-block">Status Ketersediaan</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="st_semua" value="semua" <?php echo $status === 'semua' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="st_semua">Semua</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="st_tersedia" value="tersedia" <?php echo $status === 'tersedia' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="st_tersedia">Tersedia</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="st_habis" value="habis" <?php echo $status === 'habis' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="st_habis">Habis</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        <a href="search_advanced.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                        <?php if (count($errors) === 0 && $total_hasil > 0): ?>
                            <a href="?<?php echo h(build_query($_GET, ['export' => 'csv', 'page' => null])); ?>" class="btn btn-success">
                                <i class="bi bi-download"></i> Export CSV
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-table"></i> Hasil Pencarian</h5>
                <span class="badge bg-light text-dark"><?php echo $total_hasil; ?> hasil ditemukan</span>
            </div>
            <div class="card-body">
                <?php if (count($errors) === 0 && $total_hasil > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Tahun</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hasil_page as $index => $buku): ?>
                                    <tr>
                                        <td><?php echo $offset + $index + 1; ?></td>
                                        <td><span class="badge bg-secondary"><?php echo h($buku['kode']); ?></span></td>
                                        <td><?php echo highlight_keyword($buku['judul'], $keyword); ?></td>
                                        <td><?php echo h($buku['kategori']); ?></td>
                                        <td><?php echo highlight_keyword($buku['pengarang'], $keyword); ?></td>
                                        <td><?php echo h($buku['penerbit']); ?></td>
                                        <td><?php echo h($buku['tahun']); ?></td>
                                        <td>Rp <?php echo number_format($buku['harga'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php if ($buku['stok'] > 0): ?>
                                                <span class="badge bg-success"><?php echo h($buku['stok']); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Habis</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($total_pages > 1): ?>
                        <nav>
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?<?php echo h(build_query($_GET, ['page' => $page - 1])); ?>">Sebelumnya</a>
                                </li>

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="?<?php echo h(build_query($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?<?php echo h(build_query($_GET, ['page' => $page + 1])); ?>">Berikutnya</a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php elseif (count($errors) === 0): ?>
                    <div class="alert alert-warning mb-0">Tidak ada buku yang cocok dengan kriteria pencarian.</div>
                <?php else: ?>
                    <div class="alert alert-light mb-0">Perbaiki validasi terlebih dahulu untuk menampilkan hasil.</div>
                <?php endif; ?>
            </div>
        </div>

        <?php $recent_searches = $_SESSION['recent_searches'] ?? []; ?>
        <?php if (count($recent_searches) > 0): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-clock-history"></i> Recent Searches</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recent_searches as $item): ?>
                            <?php
                            $query = build_query([], [
                                'keyword' => $item['keyword'] ?? '',
                                'kategori' => $item['kategori'] ?? '',
                                'min_harga' => $item['min_harga'] ?? '',
                                'max_harga' => $item['max_harga'] ?? '',
                                'tahun' => $item['tahun'] ?? '',
                                'status' => $item['status'] ?? 'semua',
                                'sort' => $item['sort'] ?? 'judul',
                            ]);
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo h($item['waktu'] ?? '-'); ?></strong>
                                    <div class="small text-muted">
                                        keyword: <?php echo h($item['keyword'] ?? '-'); ?>,
                                        kategori: <?php echo h($item['kategori'] ?? 'semua'); ?>,
                                        tahun: <?php echo h($item['tahun'] ?? 'semua'); ?>,
                                        status: <?php echo h($item['status'] ?? 'semua'); ?>
                                    </div>
                                </div>
                                <a class="btn btn-sm btn-outline-primary" href="?<?php echo h($query); ?>">Gunakan Lagi</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
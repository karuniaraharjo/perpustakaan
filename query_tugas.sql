-- ============================================
-- QUERY TUGAS: DATABASE PERPUSTAKAAN
-- ============================================

-- ============================================
-- 1) STATISTIK BUKU (5 QUERY)
-- ============================================

-- 1.1 Menampilkan total jumlah buku (baris data) yang aktif.
SELECT COUNT(*) AS total_buku
FROM buku
WHERE is_deleted = 0;

-- 1.2 Menampilkan total nilai inventaris: SUM(harga x stok) untuk buku aktif.
SELECT SUM(harga * stok) AS total_nilai_inventaris
FROM buku
WHERE is_deleted = 0;

-- 1.3 Menampilkan rata-rata harga buku aktif.
SELECT AVG(harga) AS rata_rata_harga
FROM buku
WHERE is_deleted = 0;

-- 1.4 Menampilkan buku termahal (judul dan harga) dari buku aktif.
SELECT judul, harga
FROM buku
WHERE is_deleted = 0
ORDER BY harga DESC
LIMIT 1;

-- 1.5 Menampilkan buku dengan stok terbanyak dari buku aktif.
SELECT judul, stok
FROM buku
WHERE is_deleted = 0
ORDER BY stok DESC
LIMIT 1;


-- ============================================
-- 2) FILTER DAN PENCARIAN (5 QUERY)
-- ============================================

-- 2.1 Menampilkan semua buku kategori Programming dengan harga di bawah 100000.
SELECT *
FROM buku
WHERE is_deleted = 0
	AND kategori = 'Programming'
	AND harga < 100000;

-- 2.2 Menampilkan buku dengan judul yang mengandung kata PHP atau MySQL.
SELECT *
FROM buku
WHERE is_deleted = 0
	AND (judul LIKE '%PHP%' OR judul LIKE '%MySQL%');

-- 2.3 Menampilkan buku yang terbit pada tahun 2024.
SELECT *
FROM buku
WHERE is_deleted = 0
	AND tahun_terbit = 2024;

-- 2.4 Menampilkan buku yang memiliki stok antara 5 sampai 10.
SELECT *
FROM buku
WHERE is_deleted = 0
	AND stok BETWEEN 5 AND 10;

-- 2.5 Menampilkan buku yang ditulis oleh pengarang Budi Raharjo.
SELECT *
FROM buku
WHERE is_deleted = 0
	AND pengarang = 'Budi Raharjo';


-- ============================================
-- 3) GROUPING DAN AGREGASI (3 QUERY)
-- ============================================

-- 3.1 Menampilkan jumlah judul buku dan total stok untuk setiap kategori.
SELECT
	kategori,
	COUNT(*) AS jumlah_buku,
	SUM(stok) AS total_stok
FROM buku
WHERE is_deleted = 0
GROUP BY kategori;

-- 3.2 Menampilkan rata-rata harga buku untuk setiap kategori.
SELECT
	kategori,
	AVG(harga) AS rata_rata_harga
FROM buku
WHERE is_deleted = 0
GROUP BY kategori;

-- 3.3 Menampilkan kategori dengan total nilai inventaris terbesar.
SELECT
	kategori,
	SUM(harga * stok) AS total_nilai_inventaris
FROM buku
WHERE is_deleted = 0
GROUP BY kategori
ORDER BY total_nilai_inventaris DESC
LIMIT 1;


-- ============================================
-- 4) UPDATE DATA (2 QUERY)
-- ============================================

-- 4.1 Menaikkan harga semua buku kategori Programming sebesar 5%.
UPDATE buku
SET harga = harga * 1.05
WHERE is_deleted = 0
	AND kategori = 'Programming';

-- 4.2 Menambahkan stok 10 untuk semua buku dengan stok kurang dari 5.
UPDATE buku
SET stok = stok + 10
WHERE is_deleted = 0
	AND stok < 5;


-- ============================================
-- 5) LAPORAN KHUSUS (2 QUERY)
-- ============================================

-- 5.1 Menampilkan daftar buku yang perlu restocking (stok < 5).
SELECT *
FROM buku
WHERE is_deleted = 0
	AND stok < 5;

-- 5.2 Menampilkan 5 buku termahal dari buku aktif.
SELECT judul, harga
FROM buku
WHERE is_deleted = 0
ORDER BY harga DESC
LIMIT 5;

<?php
// 1. Function untuk hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

// 2. Function untuk hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $count = 0;
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] === 'Aktif') {
            $count++;
        }
    }
    return $count;
}

// 3. Function untuk hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    if (empty($anggota_list)) return 0;
    $total = array_sum(array_column($anggota_list, 'total_pinjaman'));
    return round($total / count($anggota_list), 2);
}

// 4. Function untuk cari anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $anggota) {
        if ($anggota['id'] == $id) {
            return $anggota;
        }
    }
    return null;
}

// 5. Function untuk cari anggota teraktif
function cari_anggota_teraktif($anggota_list) {
    $teraktif = null;
    $max_pinjaman = 0;
    foreach ($anggota_list as $anggota) {
        if ($anggota['total_pinjaman'] > $max_pinjaman) {
            $max_pinjaman = $anggota['total_pinjaman'];
            $teraktif = $anggota;
        }
    }
    return $teraktif;
}

// 6. Function untuk filter by status
function filter_by_status($anggota_list, $status) {
    $filtered = [];
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] === $status) {
            $filtered[] = $anggota;
        }
    }
    return $filtered;
}

// 7. Function untuk validasi email
function validasi_email($email) {
    if (empty($email)) return false;
    if (strpos($email, '@') === false) return false;
    if (strpos($email, '.') === false) return false;
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// 8. Function untuk format tanggal Indonesia
function format_tanggal_indo($tanggal) {
    $bulan = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    
    $parts = explode('-', $tanggal);
    if (count($parts) !== 3) return $tanggal;
    
    $hari = (int)$parts[2];
    $bulan_num = $parts[1];
    $tahun = $parts[0];
    
    return $hari . ' ' . ($bulan[$bulan_num] ?? $bulan_num) . ' ' . $tahun;
}

// BONUS: Function untuk sort anggota by nama
function sort_anggota_by_nama($anggota_list, $order = 'ASC') {
    usort($anggota_list, function($a, $b) use ($order) {
        $compare = strcmp($a['nama'], $b['nama']);
        return $order === 'ASC' ? $compare : -$compare;
    });
    return $anggota_list;
}

// BONUS: Function untuk search anggota by nama
function search_anggota_by_nama($anggota_list, $keyword) {
    $keyword = strtolower($keyword);
    $hasil = [];
    foreach ($anggota_list as $anggota) {
        if (strpos(strtolower($anggota['nama']), $keyword) !== false) {
            $hasil[] = $anggota;
        }
    }
    return $hasil;
}
?>
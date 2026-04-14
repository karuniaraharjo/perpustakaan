<?php
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

$errors = [];
$success = false;

$nama = '';
$email = '';
$telepon = '';
$alamat = '';
$jenis_kelamin = '';
$tanggal_lahir = '';
$pekerjaan = '';

$opsi_pekerjaan = ['Pelajar', 'Mahasiswa', 'Pegawai', 'Lainnya'];
$opsi_kelamin = ['Laki-laki', 'Perempuan'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = sanitize_input($_POST['nama'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $telepon = sanitize_input($_POST['telepon'] ?? '');
    $alamat = sanitize_input($_POST['alamat'] ?? '');
    $jenis_kelamin = sanitize_input($_POST['jenis_kelamin'] ?? '');
    $tanggal_lahir = sanitize_input($_POST['tanggal_lahir'] ?? '');
    $pekerjaan = sanitize_input($_POST['pekerjaan'] ?? '');

    if ($nama === '') {
        $errors['nama'] = 'Nama lengkap wajib diisi.';
    } elseif (strlen($nama) < 3) {
        $errors['nama'] = 'Nama lengkap minimal 3 karakter.';
    }

    if ($email === '') {
        $errors['email'] = 'Email wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid.';
    }

    if ($telepon === '') {
        $errors['telepon'] = 'Nomor telepon wajib diisi.';
    } elseif (!preg_match('/^08\d{8,11}$/', $telepon)) {
        $errors['telepon'] = 'Format telepon harus 08xxxxxxxxxx dengan panjang 10-13 digit.';
    }

    if ($alamat === '') {
        $errors['alamat'] = 'Alamat wajib diisi.';
    } elseif (strlen($alamat) < 10) {
        $errors['alamat'] = 'Alamat minimal 10 karakter.';
    }

    if ($jenis_kelamin === '') {
        $errors['jenis_kelamin'] = 'Jenis kelamin wajib dipilih.';
    } elseif (!in_array($jenis_kelamin, $opsi_kelamin, true)) {
        $errors['jenis_kelamin'] = 'Pilihan jenis kelamin tidak valid.';
    }

    if ($tanggal_lahir === '') {
        $errors['tanggal_lahir'] = 'Tanggal lahir wajib diisi.';
    } else {
        $tgl_obj = DateTime::createFromFormat('Y-m-d', $tanggal_lahir);
        $format_valid = $tgl_obj && $tgl_obj->format('Y-m-d') === $tanggal_lahir;

        if (!$format_valid) {
            $errors['tanggal_lahir'] = 'Format tanggal lahir tidak valid.';
        } else {
            $hari_ini = new DateTime();
            $umur = $tgl_obj->diff($hari_ini)->y;
            if ($umur < 10) {
                $errors['tanggal_lahir'] = 'Umur minimal 10 tahun.';
            }
        }
    }

    if ($pekerjaan === '') {
        $errors['pekerjaan'] = 'Pekerjaan wajib dipilih.';
    } elseif (!in_array($pekerjaan, $opsi_pekerjaan, true)) {
        $errors['pekerjaan'] = 'Pilihan pekerjaan tidak valid.';
    }

    if (count($errors) === 0) {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Form Registrasi Anggota</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill"></i> Registrasi anggota berhasil disimpan.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (count($errors) > 0): ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Terdapat kesalahan pada input.</strong> Silakan periksa setiap field.
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="" novalidate>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="nama"
                                    name="nama"
                                    class="form-control <?php echo isset($errors['nama']) ? 'is-invalid' : ''; ?>"
                                    value="<?php echo $nama; ?>"
                                    placeholder="Masukkan nama lengkap">
                                <div class="invalid-feedback"><?php echo $errors['nama'] ?? ''; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo $email; ?>"
                                        placeholder="contoh@email.com">
                                    <div class="invalid-feedback"><?php echo $errors['email'] ?? ''; ?></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="telepon"
                                        name="telepon"
                                        class="form-control <?php echo isset($errors['telepon']) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo $telepon; ?>"
                                        placeholder="08xxxxxxxxxx">
                                    <div class="invalid-feedback"><?php echo $errors['telepon'] ?? ''; ?></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea
                                    id="alamat"
                                    name="alamat"
                                    rows="3"
                                    class="form-control <?php echo isset($errors['alamat']) ? 'is-invalid' : ''; ?>"
                                    placeholder="Masukkan alamat lengkap"><?php echo $alamat; ?></textarea>
                                <div class="invalid-feedback"><?php echo $errors['alamat'] ?? ''; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php echo isset($errors['jenis_kelamin']) ? 'is-invalid' : ''; ?>"
                                            type="radio"
                                            name="jenis_kelamin"
                                            id="jk_laki"
                                            value="Laki-laki"
                                            <?php echo $jenis_kelamin === 'Laki-laki' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="jk_laki">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input <?php echo isset($errors['jenis_kelamin']) ? 'is-invalid' : ''; ?>"
                                            type="radio"
                                            name="jenis_kelamin"
                                            id="jk_perempuan"
                                            value="Perempuan"
                                            <?php echo $jenis_kelamin === 'Perempuan' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="jk_perempuan">Perempuan</label>
                                    </div>
                                    <?php if (isset($errors['jenis_kelamin'])): ?>
                                        <div class="invalid-feedback d-block"><?php echo $errors['jenis_kelamin']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input
                                        type="date"
                                        id="tanggal_lahir"
                                        name="tanggal_lahir"
                                        class="form-control <?php echo isset($errors['tanggal_lahir']) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo $tanggal_lahir; ?>"
                                        max="<?php echo date('Y-m-d'); ?>">
                                    <div class="invalid-feedback"><?php echo $errors['tanggal_lahir'] ?? ''; ?></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                <select
                                    id="pekerjaan"
                                    name="pekerjaan"
                                    class="form-select <?php echo isset($errors['pekerjaan']) ? 'is-invalid' : ''; ?>">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <?php foreach ($opsi_pekerjaan as $opsi): ?>
                                        <option value="<?php echo $opsi; ?>" <?php echo $pekerjaan === $opsi ? 'selected' : ''; ?>>
                                            <?php echo $opsi; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"><?php echo $errors['pekerjaan'] ?? ''; ?></div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Daftar Anggota
                                </button>
                                <a href="form_anggota.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if ($success): ?>
                    <div class="card border-success shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-person-vcard-fill"></i> Data Anggota Tersimpan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2"><strong>Nama Lengkap:</strong> <?php echo $nama; ?></div>
                                <div class="col-md-6 mb-2"><strong>Email:</strong> <?php echo $email; ?></div>
                                <div class="col-md-6 mb-2"><strong>Telepon:</strong> <?php echo $telepon; ?></div>
                                <div class="col-md-6 mb-2"><strong>Jenis Kelamin:</strong> <?php echo $jenis_kelamin; ?></div>
                                <div class="col-md-6 mb-2"><strong>Tanggal Lahir:</strong> <?php echo $tanggal_lahir; ?></div>
                                <div class="col-md-6 mb-2"><strong>Pekerjaan:</strong> <?php echo $pekerjaan; ?></div>
                                <div class="col-12 mb-2"><strong>Alamat:</strong> <?php echo nl2br($alamat); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
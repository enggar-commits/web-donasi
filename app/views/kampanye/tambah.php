<?php $baseUrl = ($_SERVER['HTTP_HOST'] == 'localhost') ? '/donasi' : ''; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kampanye - Web Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4 py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?= $baseUrl ?>/">Web Donasi</a>
            <div class="d-flex align-items-center ms-auto">
                <span class="me-3 text-muted">Halo, <b><?= htmlspecialchars($_SESSION['nama']) ?></b></span>
                <a href="<?= $baseUrl ?>/auth/logout" class="btn btn-sm btn-outline-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 800px;">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header text-white py-3" style="background-color: #00aeef;">
                <h5 class="mb-0 fw-bold">Formulir Tambah Kampanye Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= $baseUrl ?>/kampanye/store" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Judul Kampanye *</label>
                        <input type="text" name="judul_kampanye" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Foto / Gambar Thumbnail (Opsional)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Target Dana (Rp) *</label>
                        <input type="number" name="target_dana" class="form-control" min="10000" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small">Deskripsi Program *</label>
                        <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= $baseUrl ?>/kampanye" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn text-white px-4 fw-bold" style="background-color: #00aeef;">Simpan Kampanye</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
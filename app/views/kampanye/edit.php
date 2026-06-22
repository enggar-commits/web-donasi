<?php $baseUrl = ($_SERVER['HTTP_HOST'] == 'localhost') ? '/donasi' : ''; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kampanye - Web Donasi</title>
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
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="mb-0 fw-bold">Formulir Edit Kampanye</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= $baseUrl ?>/kampanye/update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_kampanye" value="<?= htmlspecialchars($data['id_kampanye']) ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Judul Kampanye *</label>
                        <input type="text" name="judul_kampanye" class="form-control" value="<?= htmlspecialchars($data['judul_kampanye']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Ubah Foto / Gambar Thumbnail (Biarkan kosong jika tidak diubah)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        <?php if($data['gambar']): ?>
                            <small class="text-success mt-1 d-block">Gambar saat ini: <?= htmlspecialchars($data['gambar']) ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Target Dana (Rp) *</label>
                            <input type="number" name="target_dana" class="form-control" value="<?= htmlspecialchars($data['target_dana']) ?>" min="10000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Status Program *</label>
                            <select name="status" class="form-select" required>
                                <option value="aktif" <?= ($data['status'] == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                <option value="selesai" <?= ($data['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small">Deskripsi Program *</label>
                        <textarea name="deskripsi" class="form-control" rows="5" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= $baseUrl ?>/kampanye" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Update Kampanye</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
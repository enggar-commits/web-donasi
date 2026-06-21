<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Donasi - Web Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header text-white py-3" style="background-color: #4f46e5;">
                <h5 class="mb-0 fw-bold">Catat Transaksi Donasi Manual</h5>
            </div>
            <div class="card-body p-4">
                <form action="/donasi/transaksi/store" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Pilih Kampanye Tujuan *</label>
                        <select name="id_kampanye" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Kampanye --</option>
                            <?php foreach($kampanye as $k): ?>
                                <option value="<?= $k['id_kampanye'] ?>"><?= htmlspecialchars($k['judul_kampanye']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Nominal Donasi Masuk (Rp) *</label>
                        <input type="number" name="nominal" class="form-control" min="1000" placeholder="Contoh: 50000" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small">Tanggal Transaksi *</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/donasi/transaksi" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn text-white px-4 fw-bold" style="background-color: #4f46e5;">Simpan Transaksi</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php $baseUrl = ($_SERVER['HTTP_HOST'] == 'localhost') ? '/donasi' : ''; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Donasi - Web Donasi</title>
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

    <div class="container mt-4 mb-5" style="max-width: 600px;">
        <div class="card shadow border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                <h6 class="text-muted text-center mb-1">Anda akan berdonasi untuk program:</h6>
                <h5 class="fw-bold text-center text-primary mb-4">"<?= htmlspecialchars($kampanye['judul_kampanye']) ?>"</h5>
                
                <form action="<?= $baseUrl ?>/transaksi/store" method="POST">
                    <input type="hidden" name="id_kampanye" value="<?= $kampanye['id_kampanye'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Nominal Donasi (Rp) *</label>
                        <input type="number" name="nominal" class="form-control form-control-lg text-success fw-bold text-center" min="10000" placeholder="Minimal Rp 10.000" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Pilih Metode Pembayaran *</label>
                        <select name="metode_pembayaran" class="form-select form-select-lg" required>
                            <option value="BCA Virtual Account">BCA Virtual Account</option>
                            <option value="Mandiri Virtual Account">Mandiri Virtual Account</option>
                            <option value="BRI Virtual Account">BRI Virtual Account</option>
                            <option value="GoPay / QRIS">GoPay / QRIS</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">Dukungan / Doa Singkat (Opsional)</label>
                        <textarea name="pesan" class="form-control" rows="3" placeholder="Tuliskan doa atau pesan semangat..."></textarea>
                    </div>

                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_anonim" id="anonimSwitch" value="1">
                        <label class="form-check-label text-muted small fw-bold" for="anonimSwitch">Sembunyikan nama saya (Hamba Allah)</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Lanjutkan Pembayaran</button>
                        <a href="<?= $baseUrl ?>/kampanye" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>

        <h5 class="fw-bold mb-3 text-dark">Doa-Doa Donatur (<?= count($list_doa) ?>)</h5>
        <?php if(!empty($list_doa)): foreach($list_doa as $doa): ?>
            <div class="card border-0 shadow-sm mb-2 rounded-3">
                <div class="card-body p-3">
                    <div class="fw-bold text-primary small mb-1"><?= $doa['is_anonim'] == 1 ? 'Hamba Allah' : htmlspecialchars($doa['nama']) ?></div>
                    <p class="mb-0 text-muted small fst-italic">" <?= htmlspecialchars($doa['pesan']) ?> "</p>
                </div>
            </div>
        <?php endforeach; else: ?>
            <p class="text-muted small">Belum ada doa tertulis. Jadilah yang pertama memberikan dukungan!</p>
        <?php endif; ?>
    </div>
</body>
</html>
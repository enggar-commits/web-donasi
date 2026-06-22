<?php $baseUrl = ($_SERVER['HTTP_HOST'] == 'localhost') ? '/donasi' : ''; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Donasi - Web Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> .navbar-brand { font-weight: bold; color: #00aeef !important; } .bg-custom { background-color: #00aeef; color: white; } </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4 py-3">
        <div class="container">
            <a class="navbar-brand" href="<?= $baseUrl ?>/">Web Donasi</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/kampanye">Kampanye</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold text-primary" href="<?= $baseUrl ?>/transaksi">Data Donasi</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="me-3 text-muted">Halo, <b><?= htmlspecialchars($_SESSION['nama']) ?></b> <span class="badge bg-secondary ms-1"><?= strtoupper($_SESSION['role']) ?></span></span>
                    <a href="<?= $baseUrl ?>/auth/logout" class="btn btn-sm btn-outline-danger">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Riwayat Donasi Masuk</h3>
            </div>
            <a href="<?= $baseUrl ?>/transaksi/tambah" class="btn bg-custom fw-bold">+ Catat Donasi Baru</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4">No</th>
                                <th class="py-3">Tanggal</th>
                                <th class="py-3">Tujuan Kampanye</th>
                                <th class="py-3">Nama Donatur</th>
                                <th class="py-3">Metode</th>
                                <th class="py-3 text-end px-4">Nominal Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($data)): ?>
                                <?php $no = 1; foreach($data as $row): ?>
                                <tr>
                                    <td class="py-3 px-4 fw-bold text-muted"><?= $no++ ?></td>
                                    <td class="py-3"><?= htmlspecialchars($row['tanggal']) ?></td>
                                    <td class="py-3 fw-bold text-primary"><?= htmlspecialchars($row['judul_kampanye']) ?></td>
                                    
                                    <td class="py-3 text-muted">
                                        <?php if(isset($row['is_anonim']) && $row['is_anonim'] == 1): ?>
                                            <i class="fw-bold">Hamba Allah</i> <span class="badge bg-secondary" style="font-size: 10px;">Anonim</span>
                                        <?php else: ?>
                                            <?= htmlspecialchars($row['pencatat']) ?>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="py-3 text-muted small"><?= htmlspecialchars($row['metode_pembayaran'] ?? 'Manual') ?></td>
                                    <td class="py-3 text-end px-4 fw-bold text-success">+ Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada donasi yang masuk.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
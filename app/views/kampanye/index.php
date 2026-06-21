<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; color: #00aeef !important; }
        .bg-custom { background-color: #00aeef; color: white; }
        .btn-custom { background-color: #00aeef; color: white; font-weight: bold; }
        .btn-custom:hover { background-color: #008ec4; color: white; }
        .card-img-top { height: 200px; object-fit: cover; background-color: #e9ecef; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4 py-3">
        <div class="container">
            <a class="navbar-brand" href="/donasi/">Web Donasi</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active fw-bold text-primary" href="/donasi/kampanye">Kampanye</a></li>
                    <?php if($_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link text-muted" href="/donasi/transaksi">Data Donasi</a></li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="me-3 text-muted">Halo, <b><?= htmlspecialchars($_SESSION['nama']) ?></b> <span class="badge bg-secondary ms-1"><?= strtoupper($_SESSION['role']) ?></span></span>
                    <a href="/donasi/auth/logout" class="btn btn-sm btn-outline-danger">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Program Penggalangan Dana</h3>
                <p class="text-muted small">Bantu sesama mewujudkan harapan mereka.</p>
            </div>
            <?php if($_SESSION['role'] === 'admin'): ?>
                <a href="/donasi/kampanye/tambah" class="btn btn-custom">+ Tambah Kampanye</a>
            <?php endif; ?>
        </div>

        <?php if($_SESSION['role'] === 'admin'): ?>
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4">No</th>
                                <th class="py-3">Judul Kampanye</th>
                                <th class="py-3">Target Dana</th>
                                <th class="py-3">Terkumpul</th>
                                <th class="py-3 text-center">Status</th>
                                <th class="py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($data)): $no = 1; foreach($data as $row): 
                                $persentase = ($row['target_dana'] > 0) ? round(($row['dana_terkumpul'] / $row['target_dana']) * 100) : 0;
                            ?>
                            <tr>
                                <td class="py-3 px-4 fw-bold text-muted"><?= $no++ ?></td>
                                <td class="py-3 fw-bold text-primary"><?= htmlspecialchars($row['judul_kampanye']) ?></td>
                                <td class="py-3 text-muted">Rp <?= number_format($row['target_dana'], 0, ',', '.') ?></td>
                                <td class="py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-bold text-success">Rp <?= number_format($row['dana_terkumpul'], 0, ',', '.') ?></span>
                                        <span class="badge bg-light text-primary border"><?= $persentase ?>%</span>
                                    </div>
                                    <div class="progress" style="height: 6px;"><div class="progress-bar bg-success" style="width: <?= $persentase > 100 ? 100 : $persentase ?>%"></div></div>
                                </td>
                                <td class="py-3 text-center"><span class="badge bg-<?= $row['status']=='aktif'?'success':'secondary' ?>"><?= ucfirst($row['status']) ?></span></td>
                                <td class="py-3 text-center">
                                    <a href="/donasi/kampanye/edit/<?= $row['id_kampanye'] ?>" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <a href="/donasi/kampanye/hapus/<?= $row['id_kampanye'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?');">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada kampanye.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <?php if(!empty($data)): foreach($data as $row): 
                    $persentase = ($row['target_dana'] > 0) ? round(($row['dana_terkumpul'] / $row['target_dana']) * 100) : 0;
                    
                    // --- LOGIKA THUMBNAIL OTOMATIS BERDASARKAN KATA KUNCI JUDUL ---
                    $judul_lower = strtolower($row['judul_kampanye']);
                    $default_img = 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb0?w=500&q=80'; // Default: Tangan Peduli
                    
                    if (strpos($judul_lower, 'bencana') !== false || strpos($judul_lower, 'banjir') !== false || strpos($judul_lower, 'gempa') !== false) {
                        $default_img = 'https://images.unsplash.com/photo-1528323273322-d81458248d40?w=500&q=80'; // Gambar Bencana/Banjir
                    } elseif (strpos($judul_lower, 'sakit') !== false || strpos($judul_lower, 'medis') !== false || strpos($judul_lower, 'operasi') !== false) {
                        $default_img = 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=500&q=80'; // Gambar Rumah Sakit/Medis
                    } elseif (strpos($judul_lower, 'sekolah') !== false || strpos($judul_lower, 'pendidikan') !== false || strpos($judul_lower, 'guru') !== false) {
                        $default_img = 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=500&q=80'; // Gambar Pendidikan/Anak
                    } elseif (strpos($judul_lower, 'masjid') !== false || strpos($judul_lower, 'panti') !== false || strpos($judul_lower, 'yatim') !== false) {
                        $default_img = 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?w=500&q=80'; // Gambar Masjid/Religi
                    }

                    // Prioritaskan gambar dari database jika admin upload, jika kosong gunakan default image di atas
                    $img_src = $row['gambar'] ? '/donasi/uploads/' . $row['gambar'] : $default_img;
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                        <img src="<?= $img_src ?>" class="card-img-top" alt="Thumbnail">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 48px;"><?= htmlspecialchars($row['judul_kampanye']) ?></h5>
                            <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 60px;"><?= htmlspecialchars($row['deskripsi']) ?></p>
                            
                            <div class="mt-auto">
                                <div class="progress mb-2" style="height: 6px;"><div class="progress-bar bg-info" role="progressbar" style="width: <?= $persentase > 100 ? 100 : $persentase ?>%;"></div></div>
                                <div class="d-flex justify-content-between small text-muted mb-3">
                                    <span>Terkumpul:<br><b class="text-success text-dark">Rp <?= number_format($row['dana_terkumpul'], 0, ',', '.') ?></b></span>
                                    <span class="text-end">Target:<br><b>Rp <?= number_format($row['target_dana'], 0, ',', '.') ?></b></span>
                                </div>
                                <?php if($row['status'] == 'aktif'): ?>
                                    <a href="/donasi/transaksi/bayar/<?= $row['id_kampanye'] ?>" class="btn btn-custom w-100 py-2">Donasi Sekarang</a>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100 py-2" disabled>Program Selesai</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                    <div class="col-12 text-center py-5 text-muted">Belum ada program donasi aktif saat ini.</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
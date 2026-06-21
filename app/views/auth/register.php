<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Web Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4 shadow-sm border-0" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">Daftar Akun</h3>
            <p class="text-muted small">Buat akun untuk mulai berdonasi</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger py-2 text-center small"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/donasi/auth/storeUser" method="POST" autocomplete="off">
            <div class="mb-3">
                <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold small text-muted">Username Baru</label>
                <input type="text" name="username" class="form-control" placeholder="Buat username tanpa spasi" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold small text-muted">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Buat kata sandi" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 fw-bold">Daftar Sekarang</button>
            
            <div class="mt-3 text-center">
                <span class="small text-muted">Sudah punya akun? <a href="/donasi/auth/login" class="text-primary fw-bold text-decoration-none">Login di sini</a></span>
            </div>
        </form>
    </div>
</body>
</html>
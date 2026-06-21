<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran - Web Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow border-0 rounded-3 text-center mb-4">
            <div class="card-header bg-success text-white py-3 fw-bold">
                Transaksi Donasi Berhasil Dibuat
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-1">Metode Pembayaran:</p>
                <h6 class="fw-bold text-dark mb-4"><?= htmlspecialchars($metode) ?></h6>
                
                <?php 
                // Cek apakah kata "QRIS" atau "GoPay" ada di dalam variabel metode
                $is_qris = (strpos(strtolower($metode), 'qris') !== false || strpos(strtolower($metode), 'gopay') !== false); 
                
                if($is_qris): 
                ?>
                    <p class="text-muted small mb-2">Scan QR Code di bawah ini:</p>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=DonasiWeb" alt="QR Code QRIS" class="img-fluid border p-2 rounded mb-4">
                <?php else: ?>
                    <p class="text-muted small mb-1">Nomor Virtual Account / Kode Bayar:</p>
                    <h3 class="fw-bold text-primary mb-4" style="font-family: monospace; letter-spacing: 2px;"><?= $va_number ?></h3>
                <?php endif; ?>
                
                <p class="text-muted small mb-1">Total Nominal yang Harus Dibayar:</p>
                <h2 class="fw-bold text-success mb-4">Rp <?= number_format($nominal, 0, ',', '.') ?></h2>
                
                <div class="text-start alert alert-warning small rounded-3 p-3">
                    <h6 class="fw-bold mb-1">Panduan Transfer:</h6>
                    <?php if($is_qris): ?>
                        <ol class="mb-0 ps-3 text-muted">
                            <li>Buka aplikasi Gojek, OVO, Dana, atau m-Banking Anda.</li>
                            <li>Pilih menu <b>Scan QRIS</b>.</li>
                            <li>Arahkan kamera ke QR Code di atas.</li>
                            <li>Konfirmasi nominal dana dan masukkan PIN Anda.</li>
                        </ol>
                    <?php else: ?>
                        <ol class="mb-0 ps-3 text-muted">
                            <li>Salin nomor Virtual Account di atas.</li>
                            <li>Buka aplikasi m-Banking atau pergi ke ATM terdekat.</li>
                            <li>Pilih menu Transfer, lalu pilih opsi <b>Virtual Account</b>.</li>
                            <li>Masukkan nomor kode bayar dan konfirmasi nominal dana.</li>
                        </ol>
                    <?php endif; ?>
                </div>
                
                <a href="/donasi/kampanye" class="btn btn-primary w-100 py-2 fw-bold mt-2">Selesai & Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
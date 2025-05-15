<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran - Happy Paws</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-header {
            background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);
            padding: 20px;
            color: white;
            margin-bottom: 30px;
        }
        .logo-img {
            max-height: 80px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .detail-item {
            margin-bottom: 10px;
        }
        .detail-label {
            color: #7B1FA2;
            font-weight: 500;
        }
        @media print {
            .no-print {
                display: none;
            }
            .invoice-header {
                background: #7B1FA2 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="invoice-header rounded">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="<?php echo base_url('assets/images/logooo.png'); ?>" alt="Happy Paws" class="logo-img">
                </div>
                <div class="col">
                    <h4 class="mb-1">Happy Paws</h4>
                    <p class="mb-0">Jl. Contoh No. 123, Kota</p>
                    <p class="mb-0">Telp: +62 123 4567 890</p>
                </div>
            </div>
        </div>

        <div class="row invoice-details">
            <div class="col-md-6">
                <h5 class="text-purple mb-3">Detail Pelanggan</h5>
                <div class="detail-item">
                    <span class="detail-label">Nama:</span>
                    <span><?php echo $booking->nama_pemilik; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">No. Telepon:</span>
                    <span><?php echo $booking->no_hp; ?></span>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <h5 class="text-purple mb-3">Detail Transaksi</h5>
                <div class="detail-item">
                    <span class="detail-label">No. Transaksi:</span>
                    <span>#<?php echo $booking->id; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Metode Pembayaran:</span>
                    <span><?php echo ucfirst($booking->metode_pembayaran); ?></span>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header text-black" style="background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);">
                <h5 class="mb-0">Detail Layanan</h5>
            </div>
            <div class="card-body">
                <?php if($type == 'grooming'): ?>
                    <div class="detail-item">
                        <span class="detail-label">Jenis Layanan:</span>
                        <span>Grooming</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Paket:</span>
                        <span><?php echo ucfirst($booking->paket_grooming); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Jenis Hewan:</span>
                        <span><?php echo $booking->jenis_hewan; ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tanggal:</span>
                        <span><?php echo date('d M Y', strtotime($booking->tanggal_grooming)); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Waktu:</span>
                        <span><?php echo $booking->waktu_booking; ?></span>
                    </div>
                    <?php if($booking->pengantaran == 'antar'): ?>
                    <div class="detail-item">
                        <span class="detail-label">Alamat:</span>
                        <span><?php echo $booking->detail_alamat . ', ' . $booking->desa . ', ' . $booking->kecamatan; ?></span>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="detail-item">
                        <span class="detail-label">Jenis Layanan:</span>
                        <span>Penitipan</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Paket:</span>
                        <span><?php echo ucfirst($booking->paket_penitipan); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Check-in:</span>
                        <span><?php echo date('d M Y', strtotime($booking->check_in)); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Check-out:</span>
                        <span><?php echo date('d M Y', strtotime($booking->check_out)); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row justify-content-end mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-purple mb-3">Total Pembayaran</h5>
                        <div class="d-flex justify-content-between">
                            <span class="detail-label">Total:</span>
                            <h4 class="text-purple mb-0">Rp <?php echo number_format($booking->total_harga, 0, ',', '.'); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-4 no-print">
            <button onclick="window.print()" class="btn btn-purple">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>
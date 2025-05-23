<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Happy Paws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .payment-container {
            max-width: 600px;
            margin: 20px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-purple {
            background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
        }
        .btn-purple:hover {
            background: linear-gradient(90deg, #7B1FA2 0%, #BA68C8 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2 class="text-center mb-4">Pembayaran</h2>
        <div class="mb-4">
            <p><strong>Detail Pesanan:</strong></p>
            <p>Nama Pelanggan: <?php echo $booking->nama_pemilik; ?></p>
            <?php if ($type === 'grooming'): ?>
                <p>Paket: <?php 
                    $package_names = [
                        'basic' => 'Basic Grooming',
                        'kutu' => 'Anti Kutu',
                        'full' => 'Full Grooming'
                    ];
                    $package_name = isset($package_names[$booking->paket_grooming]) ? $package_names[$booking->paket_grooming] : $booking->paket_grooming;
                    echo $package_name; 
                ?></p>
                <p>Tanggal: <?php echo date('d F Y', strtotime($booking->tanggal_grooming)); ?></p>
                <p>Waktu: <?php echo date('H:i', strtotime($booking->waktu_booking)); ?></p>
            <?php else: ?>
                <p>Paket: <?php 
                    $package_names = [
                        'regular' => 'Regular',
                        'premium' => 'Premium',
                        'basic' => 'Regular'  // Add this for backward compatibility
                    ];
                    $package_name = isset($package_names[$booking->paket_penitipan]) ? $package_names[$booking->paket_penitipan] : 'Regular';
                    echo $package_name; 
                ?></p>
                <p>Check-in: <?php echo date('d F Y', strtotime($booking->check_in)); ?></p>
                <p>Check-out: <?php echo date('d F Y', strtotime($booking->check_out)); ?></p>
                <p>Nama Hewan: <?php echo $booking->nama_hewan; ?></p>
            <?php endif; ?>
            <p><strong>Total Pembayaran: Rp <?php echo number_format($booking->total_harga, 0, ',', '.'); ?></strong></p>
        </div>
        <form id="paymentForm" action="<?php echo base_url('dashboard/confirm_payment/' . $booking->id); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="<?php echo $type; ?>">
            <div class="form-group mb-4">
                <label for="paymentMethod">Pilih Metode Pembayaran:</label>
                <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                    <option value="qris">QRIS</option>
                    <option value="bankTransfer">Transfer Bank</option>
                </select>
            </div>
            <div id="paymentDetails" class="mb-4">
                <!-- Payment details will be dynamically updated here -->
            </div>
            <div class="form-group mb-4">
                <label for="transactionProof">Upload Bukti Pembayaran</label>
                <input type="file" class="form-control-file" id="transactionProof" name="transactionProof" required>
                <small class="form-text text-muted">Format: JPG, PNG, atau JPEG (Max 2MB)</small>
            </div>
            <input type="hidden" id="qrisUrl" value="<?php echo base_url('assets/images/QRIS.jpeg'); ?>">
            <input type="hidden" id="bankTransferDetails" value="Bank BCA - 1982675431">
            <button type="submit" class="btn btn-purple w-100">Konfirmasi Pembayaran</button>
        </form>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodSelect = document.getElementById('paymentMethod');
    const paymentDetails = document.getElementById('paymentDetails');
    const qrisUrl = document.getElementById('qrisUrl').value;

    paymentMethodSelect.addEventListener('change', function() {
        paymentDetails.innerHTML = '';
        if (this.value === 'qris') {
            paymentDetails.innerHTML = '<p class="text-info">Scan QRIS code di bawah menggunakan aplikasi e-wallet Anda.</p><div style="text-align: center;"><img src="' + qrisUrl + '" alt="QRIS Code" class="img-fluid" style="max-width: 200px;"></div>';
        } else if (this.value === 'bankTransfer') {
            paymentDetails.innerHTML = '<p class="text-info">Silakan transfer ke rekening berikut:</p><p class="font-weight-bold">Bank ABC - 1234567890</p>';
        }
    });

    // Trigger change event untuk load awal
    paymentMethodSelect.dispatchEvent(new Event('change'));
});
</script>
</body>
</html>
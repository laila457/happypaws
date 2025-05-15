<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Happy Paws</title>
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
        .success-container {
            max-width: 600px;
            margin: 20px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        .success-icon {
            color: #28a745;
            font-size: 64px;
            margin-bottom: 20px;
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
    <div class="success-container">
        <i class="fas fa-check-circle success-icon"></i>
        <h2 class="mb-4">Pembayaran Berhasil!</h2>
        <p class="mb-4">Terima kasih atas pembayaran Anda. Tim kami akan segera memverifikasi pembayaran Anda.</p>
        <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-purple">Kembali ke Beranda</a>
    </div>
</body>
</html>
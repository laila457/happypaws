<div class="container-fluid">
    <!-- Header Section -->
    <nav class="navbar navbar-expand-lg" style="background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);">
        <div class="container">
            <a class="navbar-brand text-white" href="#">
                <img src="<?php echo base_url('assets/images/logooo.png'); ?>" alt="Happy Paws" class="logo-img">
            </a>
            <div class="ml-auto">
                <?php if (!$this->session->userdata('logged_in')) : ?>
                    <a href="<?php echo base_url('auth/login'); ?>" class="btn btn-light me-2">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </a>
                    <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-outline-light">
                        <i class="fas fa-user-plus"></i> Daftar
                    </a>
                <?php else : ?>
                    <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-light">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Navigation Menu -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div class="nav-menu">
                    <a href="<?php echo base_url('dashboard'); ?>" class="menu-item active">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                    <a href="<?php echo base_url('dashboard/grooming'); ?>" class="menu-item">
                        <i class="fas fa-cut"></i> Grooming
                    </a>
                    <a href="<?php echo base_url('dashboard/penitipan'); ?>" class="menu-item">
                        <i class="fas fa-hotel"></i> Penitipan
                    </a>
                    <a href="<?php echo base_url('dashboard/akun'); ?>" class="menu-item">
                        <i class="fas fa-user"></i> Akun
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="display-4">Welcome to Happy Paws</h1>
            <p class="lead">
                Setiap hewan memiliki kebutuhan unik, itulah mengapa Happy Paws hadir untuk memberikan pengalaman perawatan yang menyenangkan dan bebas stres bagi hewan kesayangan Anda.
            </p>
        </div>

        <h2 class="text-center mb-4">Layanan Kami</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center d-flex flex-column">
                        <img src="<?php echo base_url('assets/images/grooming.png'); ?>" alt="Grooming" class="service-img mb-3">
                        <h4>Grooming</h4>
                        <p>Layanan grooming profesional untuk menjaga kebersihan dan penampilan hewan peliharaan Anda.</p>
                        <div class="mt-auto">
                            <a href="<?php echo base_url('dashboard/grooming'); ?>" class="btn btn-purple px-4">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center d-flex flex-column">
                        <img src="<?php echo base_url('assets/images/penitipan.png'); ?>" alt="Penitipan" class="service-img mb-3">
                        <h4>Penitipan</h4>
                        <p>Layanan penitipan hewan dengan fasilitas nyaman dan pengawasan 24 jam.</p>
                        <div class="mt-auto">
                            <a href="<?php echo base_url('dashboard/penitipan'); ?>" class="btn btn-purple px-4">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center d-flex flex-column">
                        <img src="<?php echo base_url('assets/images/antar.png'); ?>" alt="Antar Jemput" class="service-img mb-3">
                        <h4>Antar Jemput</h4>
                        <p>Layanan antar jemput hewan kesayangan Anda dengan aman dan nyaman.</p>
                        <div class="mt-auto">
                            <a href="<?php echo base_url('dashboard/delivery'); ?>" class="btn btn-purple px-4">Info</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Syarat dan Ketentuan -->
<div class="container">
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body py-1 mt-3">
            <h5 class="mb-3"><i class="fas fa-info-circle text-purple"></i> Syarat dan Ketentuan</h5>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-purple me-2"></i> Hewan harus dalam kondisi sehat dan tidak agresif</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-purple me-2"></i> Tidak menerima hewan dengan penyakit menular</li>
                        <li><i class="fas fa-check-circle text-purple me-2"></i> Jika hewan sulit dikendalikan, biaya tambahan dapat dikenakan</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-purple me-2"></i> Pembatalan kurang dari 24 jam sebelum jadwal tidak bisa refund</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-purple me-2"></i> Untuk layanan penitipan, hewan wajib sudah divaksin</li>
                        <li><i class="fas fa-check-circle text-purple me-2"></i> Layanan antar jemput hanya tersedia di area tertentu</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

    <!-- Footer Section -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <img src="<?php echo base_url('assets/images/logooo.png'); ?>" alt="Happy Paws" class="footer-logo">
                    <p class="mt-3">Memberikan pelayanan terbaik untuk hewan kesayangan Anda dengan penuh kasih sayang dan profesional.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Contoh No. 123, Kota</li>
                        <li><i class="fas fa-phone"></i> +62 123 4567 890</li>
                        <li><i class="fas fa-envelope"></i> info@happypaws.com</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Jam Operasional</h5>
                    <ul class="list-unstyled">
                        <li>Senin - Jumat: 08:00 - 20:00</li>
                        <li>Sabtu: 09:00 - 18:00</li>
                        <li>Minggu: 10:00 - 16:00</li>
                    </ul>
                </div>
            </div>
            <div class="text-center py-3 border-top">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Happy Paws. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>

<!-- Add this line in the head section of your layout file -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
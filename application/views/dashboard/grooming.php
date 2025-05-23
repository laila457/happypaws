<div class="container-fluid">
    <!-- Header Section -->
    <nav class="navbar navbar-expand-lg" style="background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);">
        <div class="container">
            <a class="navbar-brand text-white" href="#">
                <img src="<?php echo base_url('assets/images/logooo.png'); ?>" alt="Happy Paws" class="logo-img">
            </a>
            <div class="ml-auto">
                <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-light">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </div>
    </nav>

    <!-- Navigation Menu -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div class="nav-menu">
                    <a href="<?php echo base_url('dashboard'); ?>" class="menu-item">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                    <a href="<?php echo base_url('dashboard/grooming'); ?>" class="menu-item active">
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

    <!-- Form Section -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Reservasi Grooming</h2>
                        <form id="bookingForm" action="<?php echo base_url('dashboard/submit_grooming'); ?>" method="POST">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6 border-end">
                                    <div class="form-group mb-4">
                                        <label><i class="fas fa-calendar"></i> Pilih Jadwal</label>
                                        <input type="date" class="form-control" name="selected_date" id="selected_date" required>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label>Waktu Booking</label>
                                        <input type="time" class="form-control" name="time" required>
                                    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.getElementById('selected_date');
    dateInput.min = today;
    
    // If there's a past date already selected, clear it
    if (dateInput.value < today) {
        dateInput.value = '';
    }
    
    // Handle delivery address fields visibility
    const deliveryRadios = document.querySelectorAll('input[name="delivery"]');
    const alamatFields = document.getElementById('alamatFields');

    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            alamatFields.style.display = this.value === 'antar' ? 'block' : 'none';
        });
    });
});
</script>

                                    <div class="form-group mb-4">
                                        <label><i class="fas fa-user"></i> Data Pelanggan</label>
                                        <input type="text" class="form-control mb-2" name="nama" value="<?php echo isset($rebook) ? $rebook->nama_pemilik : ''; ?>" placeholder="Nama Pemilik" required>
                                        <input type="text" class="form-control" name="hp" value="<?php echo isset($rebook) ? $rebook->no_hp : ''; ?>" placeholder="No. Hp" required>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label><i class="fas fa-paw"></i> Jenis Hewan</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="petType" id="anjing" value="anjing" <?php echo (isset($rebook) && $rebook->jenis_hewan == 'anjing') ? 'checked' : ''; ?> required>
                                                <label class="form-check-label" for="anjing">Anjing</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="petType" id="kucing" value="kucing" <?php echo (isset($rebook) && $rebook->jenis_hewan == 'kucing') ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="kucing">Kucing</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label><i class="fas fa-tag"></i> Pilih Paket</label>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <button type="button" class="btn btn-outline-primary package-btn" data-package="basic">
                                                Basic<br>Rp 50.000
                                            </button>
                                            <button type="button" class="btn btn-outline-primary package-btn" data-package="kutu">
                                                Kutu & Jamur<br>Rp 70.000
                                            </button>
                                            <button type="button" class="btn btn-outline-primary package-btn" data-package="full">
                                                Full Service<br>Rp 85.000
                                            </button>
                                        </div>
                                        <input type="hidden" name="selected_package" id="selected_package" required>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label><i class="fas fa-map-marker-alt"></i> Lokasi dan Pengantaran</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="delivery" id="datangSendiri" value="sendiri" <?php echo (isset($rebook) && $rebook->pengantaran == 'sendiri') ? 'checked' : ''; ?> required>
                                                <label class="form-check-label" for="datangSendiri">Datang Sendiri</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="delivery" id="layananAntar" value="antar" <?php echo (isset($rebook) && $rebook->pengantaran == 'antar') ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="layananAntar">Layanan Antar Jemput (Gratis)</label>
                                            </div>
                                        </div>
                                        <div id="alamatFields" class="mt-3" style="display: <?php echo (isset($rebook) && $rebook->pengantaran == 'antar') ? 'block' : 'none'; ?>;">
                                            <select class="form-control mb-2" name="kecamatan" id="kecamatan">
                                                <option value="">Pilih Kecamatan</option>
                                                <option value="Sukaharja" <?php echo (isset($rebook) && $rebook->kecamatan == 'Sukaharja') ? 'selected' : ''; ?>>Telukjambe Timur</option>
                                            </select>
                                            <select class="form-control mb-2" name="desa" id="desa">
                                                <option value="">Pilih Desa/Kelurahan</option>
                                                <option value="Sukaharja" <?php echo (isset($rebook) && $rebook->desa == 'Sukaharja') ? 'selected' : ''; ?>>Sukaharja</option>
                                                <option value="Pinayungan" <?php echo (isset($rebook) && $rebook->desa == 'Pinayungan') ? 'selected' : ''; ?>>Pinayungan</option>
                                                <option value="Puseurjaya" <?php echo (isset($rebook) && $rebook->desa == 'Puseurjaya') ? 'selected' : ''; ?>>Puseurjaya</option>
                                            </select>
                                            <textarea class="form-control" name="detail_alamat" rows="2" placeholder="Detail Alamat (Nama Jalan, RT/RW, Patokan)"><?php echo isset($rebook) ? $rebook->detail_alamat : ''; ?></textarea>
                                        </div>
                                        <small class="text-muted">* Layanan antar jemput gratis berlaku untuk area Sukaharja, Pinayungan, dan Puseurjaya</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-purple w-100" id="submitButton" disabled>Selesaikan Pemesanan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Footer -->
<footer class="footer mt-5 py-4 bg-light">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-md-4 mb-3">
                <img src="<?php echo base_url('assets/images/logooo.png'); ?>" alt="Happy Paws" class="mb-3" style="max-width: 200px;">
                <p class="text-muted">
                    Memberikan pelayanan terbaik untuk hewan kesayangan Anda dengan penuh kasih sayang dan profesional.
                </p>
            </div>
            <div class="col-md-4 mb-3">
                <h5 class="text-purple">Kontak Kami</h5>
                <p class="mb-1"><i class="fas fa-map-marker-alt text-purple"></i> Jl. Contoh No. 123, Kota</p>
                <p class="mb-1"><i class="fas fa-phone text-purple"></i> +62 123 4567 890</p>
                <p class="mb-1"><i class="fas fa-envelope text-purple"></i> info@happypaws.com</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-purple">Jam Operasional</h5>
                <p class="mb-1">Senin - Jumat: 08:00 - 20:00</p>
                <p class="mb-1">Sabtu: 09:00 - 18:00</p>
                <p class="mb-1">Minggu: 10:00 - 16:00</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <p class="mb-0">&copy; 2025 Happy Paws. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageButtons = document.querySelectorAll('.package-btn');
    const packageInput = document.getElementById('selected_package');

    packageButtons.forEach(button => {
        button.addEventListener('click', function() {
            packageButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            packageInput.value = this.dataset.package;
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageButtons = document.querySelectorAll('.package-btn');
    const packageInput = document.getElementById('selected_package');

    packageButtons.forEach(button => {
        button.addEventListener('click', function() {
            packageButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            packageInput.value = this.dataset.package;
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delivery address fields visibility
    const deliveryRadios = document.querySelectorAll('input[name="delivery"]');
    const alamatFields = document.getElementById('alamatFields');

    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            alamatFields.style.display = this.value === 'antar' ? 'block' : 'none';
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bookingForm');
    const submitButton = document.getElementById('submitButton');

    function validateForm() {
        const date = document.querySelector('input[name="selected_date"]').value;
        const time = document.querySelector('input[name="time"]').value;
        const nama = document.querySelector('input[name="nama"]').value;
        const hp = document.querySelector('input[name="hp"]').value;
        const petType = document.querySelector('input[name="petType"]:checked');
        const package = document.getElementById('selected_package').value;
        const delivery = document.querySelector('input[name="delivery"]:checked');
        
        // Additional validation for delivery address if antar is selected
        let addressValid = true;
        if (delivery && delivery.value === 'antar') {
            const kecamatan = document.querySelector('select[name="kecamatan"]').value;
            const desa = document.querySelector('select[name="desa"]').value;
            const detailAlamat = document.querySelector('textarea[name="detail_alamat"]').value;
            addressValid = kecamatan && desa && detailAlamat;
        }

        const isValid = date && time && nama && hp && petType && package && delivery && addressValid;
        submitButton.disabled = !isValid;
        
        if (isValid) {
            submitButton.classList.remove('btn-secondary');
            submitButton.classList.add('btn-purple');
        } else {
            submitButton.classList.remove('btn-purple');
            submitButton.classList.add('btn-secondary');
        }
    }

    // Add event listeners to all form inputs
    form.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('change', validateForm);
        element.addEventListener('input', validateForm);
    });

    // Add event listener to package buttons
    document.querySelectorAll('.package-btn').forEach(button => {
        button.addEventListener('click', validateForm);
    });

    // Initial validation
    validateForm();
});
</script>
<script src="<?php echo base_url('assets/js/grooming.js'); ?>"> </script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</body>
</html>
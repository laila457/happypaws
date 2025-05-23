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
                    <a href="<?php echo base_url('dashboard/grooming'); ?>" class="menu-item">
                        <i class="fas fa-cut"></i> Grooming
                    </a>
                    <a href="<?php echo base_url('dashboard/penitipan'); ?>" class="menu-item active">
                        <i class="fas fa-hotel"></i> Penitipan
                    </a>
                    <a href="<?php echo base_url('dashboard/akun'); ?>" class="menu-item">
                        <i class="fas fa-user"></i> Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Penitipan Modal -->
    <div class="modal fade" id="penitipanModal" tabindex="-1" role="dialog" aria-labelledby="penitipanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="penitipanModalLabel">Booking Penitipan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="penitipanForm">
                        <div class="form-group">
                            <label for="petName">Nama Hewan</label>
                            <input type="text" class="form-control" id="petName" required>
                        </div>
                        <div class="form-group">
                            <label for="petType">Jenis Hewan</label>
                            <select class="form-control" id="petType" required>
                                <option value="">Pilih Jenis Hewan</option>
                                <option value="dog">Anjing</option>
                                <option value="cat">Kucing</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="startDate">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="startDate" required>
                        </div>
                        <div class="form-group">
                            <label for="endDate">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="endDate" required>
                        </div>
                        <div class="form-group">
                            <label for="specialNeeds">Kebutuhan Khusus</label>
                            <textarea class="form-control" id="specialNeeds" rows="3" placeholder="Makanan khusus, obat-obatan, dll"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning">Konfirmasi Booking</button>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Reservasi Penitipan Hewan</h2>
                    <form id="bookingForm" action="<?php echo base_url('dashboard/process_penitipan'); ?>" method="POST">
                        <div class="row">
                            <!-- Right Column -->
                            <div class="col-md-6 border-end">
                                <!-- Periode Penitipan -->
                                <div class="form-group mb-4">
                                    <label class="d-block mb-2"><i class="fas fa-calendar"></i> Periode Penitipan</label>
                                    <div class="mb-3">
                                        <label>Tanggal Check-in</label>
                                        <input type="date" class="form-control" name="check_in" id="check_in" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tanggal Check-out</label>
                                        <input type="date" class="form-control" name="check_out" id="check_out" required>
                                    </div>
                                </div>

                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Set minimum date for check-in and check-out
                                    const today = new Date().toISOString().split('T')[0];
                                    const checkIn = document.getElementById('check_in');
                                    const checkOut = document.getElementById('check_out');
                                    
                                    checkIn.min = today;
                                    checkOut.min = today;
                                    
                                    // Update check-out minimum date when check-in is selected
                                    checkIn.addEventListener('change', function() {
                                        checkOut.min = this.value;
                                        if (checkOut.value && checkOut.value < this.value) {
                                            checkOut.value = this.value;
                                        }
                                    });

                                    // Existing code continues...
                                });
                                </script>
                                <!-- Data Pemilik -->
                                <div class="form-group mb-4">
                                    <label class="mb-2"><i class="fas fa-user"></i> Data Pemilik</label>
                                    <input type="text" class="form-control mb-3" name="nama_pemilik" value="<?php echo isset($rebook) ? $rebook->nama_pemilik : ''; ?>" placeholder="Nama Pemilik" required>
                                    <input type="text" class="form-control" name="no_hp" value="<?php echo isset($rebook) ? $rebook->no_hp : ''; ?>" placeholder="No. HP" required>
                                </div>

                                <!-- Data Hewan -->
                                <div class="form-group mb-4">
                                    <label class="mb-2"><i class="fas fa-paw"></i> Data Hewan</label>
                                    <input type="text" class="form-control mb-3" name="nama_hewan" value="<?php echo isset($rebook) ? $rebook->nama_hewan : ''; ?>" placeholder="Nama Hewan" required>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_hewan" id="anjing" value="anjing" <?php echo (isset($rebook) && $rebook->jenis_hewan == 'anjing') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="anjing">Anjing</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_hewan" id="kucing" value="kucing" <?php echo (isset($rebook) && $rebook->jenis_hewan == 'kucing') ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="kucing">Kucing</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Paket Penitipan -->
                                <div class="form-group mb-4">
                                    <label class="mb-2"><i class="fas fa-tag"></i> Paket Penitipan</label>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="form-check package-option">
                                            <input class="form-check-input" type="radio" name="paket" id="regular" value="regular" required>
                                            <label class="form-check-label" for="regular">
                                                <strong>Regular</strong><br>
                                                Rp 50.000/hari<br>
                                                <small class="text-muted">Kandang standar, makan 2x</small>
                                            </label>
                                        </div>
                                        <div class="form-check package-option">
                                            <input class="form-check-input" type="radio" name="paket" id="premium" value="premium">
                                            <label class="form-check-label" for="premium">
                                                <strong>Premium</strong><br>
                                                Rp 75.000/hari<br>
                                                <small class="text-muted">Kandang besar, makan 3x, grooming</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pengantaran -->
                                <div class="form-group mb-4">
                                    <label class="mb-2"><i class="fas fa-map-marker-alt"></i> Pengantaran</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pengantaran" id="datangSendiri" value="sendiri" <?php echo (isset($rebook) && $rebook->pengantaran == 'sendiri') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="datangSendiri">Datang Sendiri</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pengantaran" id="layananAntar" value="antar" <?php echo (isset($rebook) && $rebook->pengantaran == 'antar') ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="layananAntar">Layanan Antar Jemput</label>
                                        </div>
                                    </div>
                                    <div id="alamatFields" class="mt-3" style="display: <?php echo (isset($rebook) && $rebook->pengantaran == 'antar') ? 'block' : 'none'; ?>;">
                                        <select class="form-control mb-2" name="kecamatan" id="kecamatan">
                                            <option value="">Pilih Kecamatan</option>
                                            <option value="Telukjambe Timur" <?php echo (isset($rebook) && $rebook->kecamatan == 'Telukjambe Timur') ? 'selected' : ''; ?>>Telukjambe Timur</option>
                                        </select>
                                        <select class="form-control mb-2" name="desa" id="desa">
                                            <option value="">Pilih Desa/Kelurahan</option>
                                            <option value="Sukaharja" <?php echo (isset($rebook) && $rebook->desa == 'Sukaharja') ? 'selected' : ''; ?>>Sukaharja</option>
                                            <option value="Pinayungan" <?php echo (isset($rebook) && $rebook->desa == 'Pinayungan') ? 'selected' : ''; ?>>Pinayungan</option>
                                            <option value="Puseurjaya" <?php echo (isset($rebook) && $rebook->desa == 'Puseurjaya') ? 'selected' : ''; ?>>Puseurjaya</option>
                                        </select>
                                        <textarea class="form-control" name="detail_alamat" rows="2" placeholder="Detail Alamat (Nama Jalan, RT/RW, Patokan)"><?php echo isset($rebook) ? $rebook->detail_alamat : ''; ?></textarea>
                                    </div>
                                    <small class="text-muted">* Layanan antar jemput gratis tersedia untuk area Sukaharja, Pinayungan, dan Puseurjaya</small>
                                </div>

                                <!-- Catatan Khusus -->
                                <div class="form-group mb-4">
                                    <label class="mb-2"><i class="fas fa-clipboard"></i> Catatan Khusus</label>
                                    <textarea class="form-control" name="catatan" rows="3" placeholder="Contoh: Jadwal makan, obat-obatan, atau kebiasaan khusus hewan"></textarea>
                                </div>
                            </div>
                        </div>
                        

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-purple w-100" id="submitButton" disabled>Selesaikan Pesanan</button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Existing address fields code
    const deliveryRadios = document.querySelectorAll('input[name="pengantaran"]');
    const alamatFields = document.getElementById('alamatFields');

    // Initial state check
    const selectedDelivery = document.querySelector('input[name="pengantaran"]:checked');
    if (selectedDelivery && selectedDelivery.value === 'antar') {
        alamatFields.style.display = 'block';
    }

    // Listen for changes
    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            alamatFields.style.display = this.value === 'antar' ? 'block' : 'none';
        });
    });

    // Form submission handler
    const bookingForm = document.getElementById('bookingForm');
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Submit form data
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to payment page with booking ID
                window.location.href = '<?php echo base_url('dashboard/payment/'); ?>' + data.booking_id;
            } else {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });

    function validateForm() {
        const checkIn = document.querySelector('input[name="check_in"]').value;
        const checkOut = document.querySelector('input[name="check_out"]').value;
        const namaPemilik = document.querySelector('input[name="nama_pemilik"]').value;
        const noHp = document.querySelector('input[name="no_hp"]').value;
        const namaHewan = document.querySelector('input[name="nama_hewan"]').value;
        const jenisHewan = document.querySelector('input[name="jenis_hewan"]:checked');
        const paket = document.querySelector('input[name="paket"]:checked');
        const pengantaran = document.querySelector('input[name="pengantaran"]:checked');

        let isValid = checkIn && checkOut && namaPemilik && noHp && 
                     namaHewan && jenisHewan && paket && pengantaran;

        // Additional validation for delivery address
        if (pengantaran && pengantaran.value === 'antar') {
            const kecamatan = document.querySelector('select[name="kecamatan"]').value;
            const desa = document.querySelector('select[name="desa"]').value;
            const detailAlamat = document.querySelector('textarea[name="detail_alamat"]').value;
            isValid = isValid && kecamatan && desa && detailAlamat;
        }

        const submitButton = document.getElementById('submitButton');
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
    const form = document.getElementById('bookingForm');
    form.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('change', validateForm);
        element.addEventListener('input', validateForm);
    });

    // Initial validation
    validateForm();
});
</script>

<div class="package-prices" style="display: none;">
        <span id="price-regular" data-price="50000">50.000</span>
        <span id="price-premium" data-price="75000">75.000</span>
    </div>

    <script>
    function calculateTotalPrice() {
        const package = document.querySelector('input[name="package"]:checked').value;
        const checkIn = new Date(document.getElementById('check_in').value);
        const checkOut = new Date(document.getElementById('check_out').value);
        
        if (checkIn && checkOut) {
            const oneDay = 24 * 60 * 60 * 1000;
            const days = Math.round(Math.abs((checkOut - checkIn) / oneDay)) + 1;
            const basePrice = package === 'premium' ? 75000 : 50000;
            const total = basePrice * days;
            
            document.getElementById('totalPrice').textContent = total.toLocaleString('id-ID');
        }
    }
    </script>
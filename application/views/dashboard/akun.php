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
                    <a href="<?php echo base_url('dashboard'); ?>" class="menu-item">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                    <a href="<?php echo base_url('dashboard/grooming'); ?>" class="menu-item">
                        <i class="fas fa-cut"></i> Grooming
                    </a>
                    <a href="<?php echo base_url('dashboard/penitipan'); ?>" class="menu-item">
                        <i class="fas fa-hotel"></i> Penitipan
                    </a>
                    <a href="<?php echo base_url('dashboard/akun'); ?>" class="menu-item active">
                        <i class="fas fa-user"></i> Akun
                    </a>
                </div>
            </div>
        </div>
    </div>

<!-- Akun Saya Section -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Akun Saya</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);">
                    <h5 class="text-white mb-0">Profil</h5>
                </div>
                <div class="card-body text-center">
                    <img src="<?php echo !empty($user->profile_picture) ? base_url($user->profile_picture) : 'https://via.placeholder.com/150'; ?>" 
                         class="rounded-circle mb-3 shadow" 
                         alt="Profile Picture" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                    <h4 class="text-purple"><?php echo $user->username; ?></h4>
                    <p class="text-muted mb-2"><?php echo $user->email; ?></p>
                    <p class="mb-3"><i class="fas fa-phone text-purple me-2"></i><?php echo $user->phone; ?></p>
                    <!-- In the profile card -->
                    <button type="button" class="btn btn-purple btn-sm" data-bs-toggle="modal" data-bs-target="#profilePictureModal">
                        <i class="fas fa-camera me-1"></i> Ubah Foto
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);">
                    <h5 class="text-white mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <form id="updateProfileForm">
                        <div class="form-group row p-2">
                            <label for="username" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="username" value="<?php echo $user->username; ?>" readonly>
                                <small class="form-text text-muted">Username tidak dapat diubah</small>
                            </div>
                        </div>
                        <div class="form-group row p-2">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" value="<?php echo $user->email; ?>">
                            </div>
                        </div>
                        <div class="form-group row p-2">
                            <label for="phone" class="col-sm-3 col-form-label">Nomor HP</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phone" value="<?php echo $user->phone; ?>">
                            </div>
                        </div>
                        <div class="form-group row p-2">
                            <label for="address" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="address" rows="3"><?php echo $user->address; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row p-2">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-purple">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking History Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);">
                    <h5 class="text-white mb-0">Riwayat Booking</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs booking-history-tabs mb-4" id="bookingTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="grooming-tab" data-bs-toggle="tab" href="#grooming" role="tab">Grooming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="penitipan-tab" data-bs-toggle="tab" href="#penitipan" role="tab">Penitipan</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="bookingTabContent">
                        <!-- In the grooming tab -->
                        <div class="tab-pane fade show active" id="grooming" role="tabpanel">
                            <?php if (!empty($grooming_history)): ?>
                                <div class="booking-grid">
                                    <?php 
                                    // Sort grooming history by date, newest first
                                    usort($grooming_history, function($a, $b) {
                                        return strtotime($b->tanggal_grooming) - strtotime($a->tanggal_grooming);
                                    });
                                    foreach ($grooming_history as $booking): ?>
                                        <div class="card booking-card h-100">
                                            <!-- For Grooming History -->
                                            <div class="card-header bg-gradient-purple-light py-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="booking-id mb-0 text-dark"><?php echo $booking->id; ?></h6>
                                                    <div>
                                                        <span class="badge bg-<?php 
                                                            switch($booking->status) {
                                                                case 'process': echo 'info'; break;
                                                                case 'success': echo 'success'; break;
                                                                case 'cancel': echo 'danger'; break;
                                                                default: echo 'warning';
                                                            }
                                                        ?> me-2"><?php echo ucfirst($booking->status); ?></span>
                                                        <span class="badge bg-<?php 
                                                            switch($booking->metode_pembayaran) {
                                                                case 'qris': echo 'success'; break;
                                                                case 'cash': echo 'warning'; break;
                                                                case 'bankTransfer': echo 'info'; break;
                                                                default: echo 'secondary';
                                                            }
                                                        ?>"><?php echo ucfirst($booking->metode_pembayaran ?? 'pending'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="booking-details">
                                                    <div class="detail-item">
                                                        <i class="fas fa-calendar text-purple"></i>
                                                        <span><?php echo date('d M Y', strtotime($booking->tanggal_grooming)); ?></span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-clock text-purple"></i>
                                                        <span><?php echo $booking->waktu_booking; ?></span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-paw text-purple"></i>
                                                        <span><?php echo $booking->jenis_hewan; ?></span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-tag text-purple"></i>
                                                        <span><?php echo ucfirst($booking->paket_grooming); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-white border-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted d-block">Total</small>
                                                        <span class="booking-price fs-6 fw-semibold text-purple">Rp <?php echo number_format($booking->total_harga, 0, ',', '.'); ?></span>
                                                    </div>
                                                    <div class="d-flex gap-1">
                                                        <a href="<?php echo site_url('dashboard/invoice/' . $booking->id . '/grooming'); ?>" class="btn btn-outline-purple btn-sm px-2 py-1" target="_blank">
                                                            <i class="fas fa-receipt fa-sm"></i> Struk
                                                        </a>
                                                        <a href="<?php echo site_url('dashboard/rebook/grooming/' . $booking->id); ?>" class="btn btn-purple btn-sm px-2 py-1">
                                                            <i class="fas fa-redo fa-sm"></i> Pesan Ulang
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="empty-history">
                                    <i class="fas fa-calendar-times"></i>
                                    <p class="text-muted mb-0">Belum ada riwayat grooming</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- In the penitipan tab -->
                        <div class="tab-pane fade" id="penitipan" role="tabpanel">
                            <?php if (!empty($penitipan_history)): ?>
                                <div class="booking-grid">
                                    <?php 
                                    // Sort penitipan history by check-in date, newest first
                                    usort($penitipan_history, function($a, $b) {
                                        return strtotime($b->check_in) - strtotime($a->check_in);
                                    });
                                    foreach ($penitipan_history as $booking): ?>
                                        <div class="card booking-card h-100">
                                            <!-- For Penitipan History -->
                                            <div class="card-header bg-gradient-purple-light py-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="booking-id mb-0 text-dark"><?php echo $booking->id; ?></h6>
                                                    <div>
                                                        <span class="badge bg-<?php 
                                                            switch($booking->status) {
                                                                case 'process': echo 'info'; break;
                                                                case 'success': echo 'success'; break;
                                                                case 'cancel': echo 'danger'; break;
                                                                default: echo 'warning';
                                                            }
                                                        ?> me-2"><?php echo ucfirst($booking->status); ?></span>
                                                        <span class="badge bg-<?php 
                                                            switch($booking->metode_pembayaran) {
                                                                case 'qris': echo 'success'; break;
                                                                case 'cash': echo 'warning'; break;
                                                                case 'bankTransfer': echo 'info'; break;
                                                                default: echo 'secondary';
                                                            }
                                                        ?>"><?php echo ucfirst($booking->metode_pembayaran ?? 'pending'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="booking-details">
                                                    <div class="detail-item">
                                                        <i class="fas fa-calendar-check text-purple"></i>
                                                        <span>Check-in: <?php echo date('d M Y', strtotime($booking->check_in)); ?></span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-calendar-times text-purple"></i>
                                                        <span>Check-out: <?php echo date('d M Y', strtotime($booking->check_out)); ?></span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-paw text-purple"></i>
                                                        <span><?php echo $booking->nama_hewan; ?> (<?php echo $booking->jenis_hewan; ?>)</span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-tag text-purple"></i>
                                                        <span><?php echo ucfirst($booking->paket_penitipan); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-white border-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted d-block">Total</small>
                                                        <span class="booking-price fs-6 fw-semibold text-purple">Rp <?php echo number_format($booking->total_harga, 0, ',', '.'); ?></span>
                                                    </div>
                                                    <div class="d-flex gap-1">
                                                        <a href="<?php echo site_url('dashboard/invoice/' . $booking->id . '/penitipan'); ?>" class="btn btn-outline-purple btn-sm px-2 py-1" target="_blank">
                                                            <i class="fas fa-receipt fa-sm"></i> Struk
                                                        </a>
                                                        <a href="<?php echo site_url('dashboard/rebook/penitipan/' . $booking->id); ?>" class="btn btn-purple btn-sm px-2 py-1">
                                                            <i class="fas fa-redo fa-sm"></i> Pesan Ulang
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="empty-history">
                                    <i class="fas fa-hotel"></i>
                                    <p class="text-muted mb-0">Belum ada riwayat penitipan</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Picture Modal -->
<div class="modal fade" id="profilePictureModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-purple">
                <h5 class="modal-title text-white">Ubah Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadProfilePictureForm" action="<?php echo base_url('dashboard/upload_profile_picture'); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profilePicture" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control" id="profilePicture" name="profilePicture" accept="image/*" required>
                    </div>
                    <div class="text-center mt-3">
                        <img id="profilePreview" src="#" class="img-fluid rounded d-none" alt="Preview" style="max-height: 200px;">
                    </div>
                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-purple">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Profile picture preview
    $('#profilePicture').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePreview').attr('src', e.target.result).removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // Profile picture upload
    $('#uploadProfilePictureForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    alert(response.message || 'Gagal mengupload foto');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengupload foto');
            }
        });
    });
});
</script>
</div>

<script>
$(document).ready(function() {
    // Update Profile Form
    $('#updateProfileForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?php echo base_url('dashboard/update_profile'); ?>',
            type: 'POST',
            data: {
                email: $('#email').val(),
                phone: $('#phone').val(),
                address: $('#address').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
    
    // Change Password Form
    $('#changePasswordForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?php echo base_url('dashboard/change_password'); ?>',
            type: 'POST',
            data: {
                currentPassword: $('#currentPassword').val(),
                newPassword: $('#newPassword').val(),
                confirmPassword: $('#confirmPassword').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $('#changePasswordForm')[0].reset();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
    
    // Profile Picture Upload Handlers
    $('#profilePicture').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePreview').attr('src', e.target.result).removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
    
    $('#uploadProfilePictureForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?php echo base_url('dashboard/upload_profile_picture'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.btn-purple').prop('disabled', true);
                $('#saveProfilePicture').html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
            },
            success: function(response) {
                try {
                    response = typeof response === 'string' ? JSON.parse(response) : response;
                    if (response.status === 'success') {
                        window.location.reload();
                    } else {
                        alert(response.message || 'Gagal mengupload foto profil');
                    }
                } catch (e) {
                    alert('Terjadi kesalahan saat memproses response');
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan saat mengupload foto: ' + error);
            },
            complete: function() {
                $('.btn-purple').prop('disabled', false);
                $('#saveProfilePicture').html('Simpan');
            }
        });
    });
});
</script>
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
<!-- Add these in the head section -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
/* Navbar Styles */
.navbar {
    background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);
    padding: 10px 0;
    height: 110px;
    overflow: hidden;
}

.logo-img {
    height: 100px;
    width: auto;
    object-fit: contain;
    margin-bottom: 5px;
}

.navbar-brand {
    display: flex;
    flex-direction: column;
    align-items: center;
    line-height: 1.2;
}

.navbar-brand small {
    font-size: 12px;
    margin-top: 5px;
}

/* Navigation Menu */
.nav-menu {
    background: white;
    padding: 15px 25px;
    border-radius: 50px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    display: flex;
    justify-content: center;
    gap: 30px;
}

.menu-item {
    color: #666;
    text-decoration: none;
    padding: 12px 25px;
    border-radius: 8px;
    transition: all 0.3s;
    font-weight: 500;
}

.menu-item:hover, .menu-item.active {
    background-color: #BA68C8;
    color: white;
    text-decoration: none;
}

.menu-item i {
    margin-right: 8px;
}
    
    .text-purple {
        color: #7B1FA2;
    }
    
    .btn-purple {
        background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-purple:hover {
        background: linear-gradient(90deg, #7B1FA2 0%, #BA68C8 100%);
        color: white;
        transform: translateY(-2px);
    }
    
    .bg-gradient-purple {
        background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);
    }
    /* Booking Grid Layout */
.booking-grid {
    display: flex;
    flex-wrap: nowrap;
    gap: 20px;
    overflow-x: auto;
    padding: 10px 5px;
    scroll-behavior: smooth;
}

.booking-grid .booking-card {
    min-width: 300px;
    max-width: 300px;
    margin-bottom: 0;
}

.booking-grid::-webkit-scrollbar {
    height: 8px;
}

.booking-grid::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.booking-grid::-webkit-scrollbar-thumb {
    background: #BA68C8;
    border-radius: 10px;
}

.booking-grid::-webkit-scrollbar-thumb:hover {
    background: #7B1FA2;
}

.booking-card {
    transition: transform 0.3s ease;
}

.booking-card:hover {
    transform: translateY(-5px);
}
</style>

<!-- Add these before closing body tag -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</div>

<script>
$(document).ready(function() {
    // Update Profile Form
    $('#updateProfileForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?php echo base_url('dashboard/update_profile'); ?>',
            type: 'POST',
            data: {
                email: $('#email').val(),
                phone: $('#phone').val(),
                address: $('#address').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
    
    // Change Password Form
    $('#changePasswordForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?php echo base_url('dashboard/change_password'); ?>',
            type: 'POST',
            data: {
                currentPassword: $('#currentPassword').val(),
                newPassword: $('#newPassword').val(),
                confirmPassword: $('#confirmPassword').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $('#changePasswordForm')[0].reset();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
    
    // Profile Picture Upload Handlers
    $('#profilePicture').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePreview').attr('src', e.target.result).removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
    
    $('#uploadProfilePictureForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?php echo base_url('dashboard/upload_profile_picture'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.btn-purple').prop('disabled', true);
                $('#saveProfilePicture').html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
            },
            success: function(response) {
                try {
                    response = typeof response === 'string' ? JSON.parse(response) : response;
                    if (response.status === 'success') {
                        window.location.reload();
                    } else {
                        alert(response.message || 'Gagal mengupload foto profil');
                    }
                } catch (e) {
                    alert('Terjadi kesalahan saat memproses response');
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan saat mengupload foto: ' + error);
            },
            complete: function() {
                $('.btn-purple').prop('disabled', false);
                $('#saveProfilePicture').html('Simpan');
            }
        });
    });
});
</script>
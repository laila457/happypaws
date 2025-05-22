<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header bg-gradient-purple">
            <h5 class="text-white mb-0">Daftar Booking Penitipan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="penitipanTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Nama Pemilik</th>
                            <th>No. HP</th>
                            <th>Nama Hewan</th>
                            <th>Jenis Hewan</th>
                            <th>Paket</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <?php
                    // Sort the bookings array by check-in date
                    usort($bookings, function($a, $b) {
                        return strtotime($a->check_in) - strtotime($b->check_in);
                    });
                    ?>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking->id; ?></td>
                            <td><?php echo date('d M Y', strtotime($booking->check_in)); ?></td>
                            <td><?php echo date('d M Y', strtotime($booking->check_out)); ?></td>
                            <td><?php echo $booking->nama_pemilik; ?></td>
                            <td><?php echo $booking->no_hp; ?></td>
                            <td><?php echo $booking->nama_hewan; ?></td>
                            <td><?php echo $booking->jenis_hewan; ?></td>
                            <td><?php 
                                $package_names = [
                                    'regular' => 'Regular',
                                    'premium' => 'Premium'
                                ];
                                echo isset($package_names[$booking->paket_penitipan]) ? 
                                    $package_names[$booking->paket_penitipan] : 'Regular';
                            ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    switch($booking->metode_pembayaran) {
                                        case 'qris': echo 'success'; break;
                                        case 'cash': echo 'warning'; break;
                                        case 'bankTransfer': echo 'info'; break;
                                        case 'transferBank': echo 'info'; break;
                                        default: echo 'secondary';
                                    }
                                ?>"><?php 
                                    $payment_methods = [
                                        'qris' => 'QRIS',
                                        'cash' => 'Cash',
                                        'bankTransfer' => 'Transfer Bank',
                                        'transferBank' => 'Transfer Bank'
                                    ];
                                    echo isset($payment_methods[$booking->metode_pembayaran]) ? 
                                        $payment_methods[$booking->metode_pembayaran] : 'Pending';
                                ?></span>
                            </td>
                            <td>
                                <span class="badge bg-<?php 
                                    switch($booking->status) {
                                        case 'process': echo 'info'; break;
                                        case 'success': echo 'success'; break;
                                        case 'cancel': echo 'danger'; break;
                                        default: echo 'warning';
                                    }
                                ?> mb-2 d-inline-block" style="min-width: 80px"><?php echo ucfirst($booking->status); ?></span>
                                <select class="form-select form-select-sm status-select w-auto min-width-120" data-id="<?php echo $booking->id; ?>" data-type="penitipan">
                                    <option value="pending" <?php echo $booking->status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="process" <?php echo $booking->status == 'process' ? 'selected' : ''; ?>>Process</option>
                                    <option value="success" <?php echo $booking->status == 'success' ? 'selected' : ''; ?>>Success</option>
                                    <option value="cancel" <?php echo $booking->status == 'cancel' ? 'selected' : ''; ?>>Cancel</option>
                                </select>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-danger delete-booking" data-id="<?php echo $booking->id; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#penitipanTable').DataTable();

    // Delete functionality
    $(document).on('click', '.delete-booking', function() {
        const bookingId = $(this).data('id');
        const row = $(this).closest('tr');
        
        if (confirm('Apakah Anda yakin ingin menghapus booking ini?')) {
            $.ajax({
                url: '<?php echo site_url('admin/delete_booking/penitipan/'); ?>' + bookingId,
                type: 'POST',
                success: function(response) {
                    try {
                        const result = JSON.parse(response);
                        if (result.success) {
                            row.remove();
                            toastr.success('Booking berhasil dihapus');
                        } else {
                            toastr.error('Gagal menghapus booking: ' + (result.message || ''));
                        }
                    } catch (e) {
                        console.error('Error:', e);
                        toastr.error('Terjadi kesalahan sistem');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    toastr.error('Terjadi kesalahan sistem');
                }
            });
        }
    });
});
</script>

<style>
    .min-width-120 {
        min-width: 120px !important;
    }
    .status-select {
        padding: 2px 5px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
    .status-select.bg-warning { background-color: #ffc107 !important; }
    .status-select.bg-info { background-color: #17a2b8 !important; }
    .status-select.bg-success { background-color: #28a745 !important; }
    .status-select.bg-danger { background-color: #dc3545 !important; }
    .status-select option {
        background-color: white;
    }
</style>
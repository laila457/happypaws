<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header bg-gradient-purple">
            <h5 class="text-white mb-0">Daftar Booking Grooming</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="groomingTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Nama Pemilik</th>
                            <th>No. HP</th>
                            <th>Jenis Hewan</th>
                            <th>Paket</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td>#<?php echo $booking->id; ?></td>
                            <td><?php echo date('d M Y', strtotime($booking->tanggal_grooming)); ?></td>
                            <td><?php echo $booking->waktu_booking; ?></td>
                            <td><?php echo $booking->nama_pemilik; ?></td>
                            <td><?php echo $booking->no_hp; ?></td>
                            <td><?php echo $booking->jenis_hewan; ?></td>
                            <td><?php echo ucfirst($booking->paket_grooming); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    switch($booking->metode_pembayaran) {
                                        case 'qris': echo 'success'; break;
                                        case 'cash': echo 'warning'; break;
                                        case 'bankTransfer': echo 'info'; break;
                                        default: echo 'secondary';
                                    }
                                ?>"><?php echo ucfirst($booking->metode_pembayaran ?? 'pending'); ?></span>
                            </td>
                            <td>
                                <span class="badge status-badge bg-<?php 
                                    switch($booking->status) {
                                        case 'process': echo 'info'; break;
                                        case 'success': echo 'success'; break;
                                        case 'cancel': echo 'danger'; break;
                                        default: echo 'warning';
                                    }
                                ?>"><?php echo ucfirst($booking->status); ?></span>
                                <select class="form-select form-select-sm status-select mt-1" data-id="<?php echo $booking->id; ?>" data-type="grooming" <?php echo ($booking->status == 'success' || $booking->status == 'cancel') ? 'disabled' : ''; ?>>
                                    <option value="pending" <?php echo $booking->status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="process" <?php echo $booking->status == 'process' ? 'selected' : ''; ?>>Process</option>
                                    <option value="success" <?php echo $booking->status == 'success' ? 'selected' : ''; ?>>Success</option>
                                    <option value="cancel" <?php echo $booking->status == 'cancel' ? 'selected' : ''; ?>>Cancel</option>
                                </select>
                            </td>
                            <td>
                                <a href="<?php echo site_url('dashboard/invoice/' . $booking->id . '/grooming'); ?>" class="btn btn-sm btn-info" target="_blank">
                                    <i class="fas fa-receipt"></i>
                                </a>
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
    const table = $('#groomingTable').DataTable();

    $('.status-select').change(function() {
        const select = $(this);
        const booking_id = select.data('id');
        const status = select.val();
        const currentStatus = select.siblings('.status-badge').text().toLowerCase();
        
        // Prevent changing back to pending if already in process
        if (currentStatus === 'process' && status === 'pending') {
            select.val('process');
            toastr.warning('Cannot change back to pending once in process');
            return;
        }

        $.ajax({
            url: '<?php echo site_url('admin/update_status'); ?>',
            type: 'POST',
            data: {
                booking_id: booking_id,
                status: status
            },
            success: function(response) {
                try {
                    const result = JSON.parse(response);
                    if (result.success) {
                        const badge = select.siblings('.status-badge');
                        const newColor = getStatusColor(status);
                        badge.removeClass().addClass('badge status-badge bg-' + newColor);
                        badge.text(status.charAt(0).toUpperCase() + status.slice(1));
                        toastr.success('Status berhasil diperbarui');
                        
                        // Disable select after success or cancel
                        if (status === 'success' || status === 'cancel') {
                            select.prop('disabled', true);
                        }

                        // Refresh dashboard counters if available
                        if (typeof updateDashboardCounters === 'function') {
                            updateDashboardCounters();
                        }
                    } else {
                        toastr.error('Gagal memperbarui status');
                        select.val(currentStatus);
                    }
                } catch (e) {
                    toastr.error('Terjadi kesalahan sistem');
                    select.val(currentStatus);
                }
            },
            error: function() {
                toastr.error('Terjadi kesalahan sistem');
                select.val(currentStatus);
            }
        });
    });

    function getStatusColor(status) {
        switch(status) {
            case 'process': return 'info';
            case 'success': return 'success';
            case 'cancel': return 'danger';
            default: return 'warning';
        }
    }
});
</script>
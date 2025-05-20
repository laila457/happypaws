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
                            <td><?php echo ucfirst($booking->paket_penitipan); ?></td>
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
                                <select class="form-select form-select-sm status-select" data-id="<?php echo $booking->id; ?>" data-type="penitipan">
                                    <option value="pending" <?php echo $booking->status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="process" <?php echo $booking->status == 'process' ? 'selected' : ''; ?>>Process</option>
                                    <option value="success" <?php echo $booking->status == 'success' ? 'selected' : ''; ?>>Success</option>
                                    <option value="cancel" <?php echo $booking->status == 'cancel' ? 'selected' : ''; ?>>Cancel</option>
                                </select>
                            </td>
                            <td>
                                <a href="<?php echo site_url('dashboard/invoice/' . $booking->id . '/penitipan'); ?>" class="btn btn-sm btn-info" target="_blank">
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
    $('#penitipanTable').DataTable();

    $('.status-select').change(function() {
        const booking_id = $(this).data('id');
        const type = $(this).data('type');
        const status = $(this).val();

        $.ajax({
            url: '<?php echo site_url('admin/update_status'); ?>',
            type: 'POST',
            data: {
                booking_id: booking_id,
                type: type,
                status: status
            },
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    toastr.success('Status berhasil diperbarui');
                } else {
                    toastr.error('Gagal memperbarui status');
                }
            }
        });
    });
});
</script>
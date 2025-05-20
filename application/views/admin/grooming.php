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
                    <?php
                    // Sort the bookings array by booking date
                    usort($bookings, function($a, $b) {
                        return strtotime($a->tanggal_grooming) - strtotime($b->tanggal_grooming);
                    });
                    ?>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking->id; ?></td>
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

    // Use event delegation to handle status changes even for dynamically added elements
    $(document).on('change', '.status-select', function() {
        const select = $(this);
        const booking_id = select.data('id');
        const status = select.val();
        const type = select.data('type');
        const currentStatus = select.siblings('.status-badge').text().toLowerCase();
        
        // Enhanced validation rules
        if (currentStatus === 'process' && status === 'pending') {
            select.val('process');
            toastr.warning('Tidak dapat mengubah kembali ke pending setelah dalam proses');
            return;
        }
        
        if (currentStatus === 'success' || currentStatus === 'cancel') {
            select.val(currentStatus);
            toastr.warning('Status tidak dapat diubah setelah success atau cancel');
            return;
        }

        // Show loading indicator
        select.prop('disabled', true);
        toastr.info('Memperbarui status...');

        // Add CSRF token if you're using CodeIgniter's CSRF protection
        const data = {
            booking_id: booking_id,
            type: type,
            status: status
        };
        
        // Add CSRF token if it exists
        const csrfName = $('meta[name="csrf-token-name"]').attr('content');
        const csrfHash = $('meta[name="csrf-token-value"]').attr('content');
        if (csrfName && csrfHash) {
            data[csrfName] = csrfHash;
        }

        $.ajax({
            url: '<?php echo site_url('admin/update_status'); ?>',
            type: 'POST',
            data: data,
            success: function(response) {
                try {
                    const result = JSON.parse(response);
                    if (result.success) {
                        // Update badge in current view
                        const badge = select.siblings('.status-badge');
                        const newColor = getStatusColor(status);
                        badge.removeClass().addClass('badge status-badge bg-' + newColor);
                        badge.text(status.charAt(0).toUpperCase() + status.slice(1));
                        
                        toastr.success('Status berhasil diperbarui');
                        
                        // Nonaktifkan select setelah sukses atau batal
                        if (status === 'success' || status === 'cancel') {
                            select.prop('disabled', true);
                        } else {
                            select.prop('disabled', false);
                        }

                        // Update dashboard counters
                        updateDashboardCounters();
                        
                        // Update user history view
                        updateUserHistory(booking_id, status);
                        
                        // Broadcast the update to other admin pages
                        broadcastStatusUpdate(booking_id, type, status);
                        
                        // Update CSRF token if returned in the response
                        if (result.csrf_token_name && result.csrf_token_value) {
                            $('meta[name="csrf-token-name"]').attr('content', result.csrf_token_name);
                            $('meta[name="csrf-token-value"]').attr('content', result.csrf_token_value);
                        }
                    } else {
                        toastr.error('Gagal memperbarui status: ' + (result.message || 'Unknown error'));
                        select.val(currentStatus);
                        select.prop('disabled', false);
                    }
                } catch (e) {
                    console.error('Error parsing response:', e, response);
                    toastr.error('Terjadi kesalahan sistem');
                    select.val(currentStatus);
                    select.prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                toastr.error('Terjadi kesalahan sistem: ' + error);
                select.val(currentStatus);
                select.prop('disabled', false);
            },
            complete: function() {
                // Ensure the select is re-enabled if not success/cancel
                if (status !== 'success' && status !== 'cancel') {
                    select.prop('disabled', false);
                }
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
    
    function updateDashboardCounters() {
        $.ajax({
            url: '<?php echo site_url('admin/get_dashboard_counts'); ?>',
            type: 'GET',
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    // Update dashboard counters if they exist
                    if ($('#grooming-count').length) {
                        $('#grooming-count').text(data.grooming_count);
                    }
                    if ($('#penitipan-count').length) {
                        $('#penitipan-count').text(data.penitipan_count);
                    }
                    console.log('Dashboard counters updated');
                } catch (e) {
                    console.error('Error updating dashboard counters:', e);
                }
            }
        });
    }

    function updateUserHistory(booking_id, status) {
        $.ajax({
            url: '<?php echo site_url('user/update_status_view'); ?>',
            type: 'POST',
            data: {
                booking_id: booking_id,
                status: status
            },
            success: function(response) {
                console.log('Riwayat pengguna diperbarui');
            },
            error: function(xhr, status, error) {
                console.error('Gagal memperbarui riwayat pengguna:', error);
            }
        });
    }
    
    function broadcastStatusUpdate(booking_id, type, status) {
        // This function can be used to notify other admin pages about the status update
        // You could implement this with server-sent events, WebSockets, or periodic polling
        
        // For now, we'll use localStorage as a simple way to communicate between tabs
        localStorage.setItem('statusUpdate', JSON.stringify({
            booking_id: booking_id,
            type: type,
            status: status,
            timestamp: new Date().getTime()
        }));
        
        // If you have other admin pages open, they can listen for this event
        window.dispatchEvent(new Event('storage'));
    }
    
    // Listen for status updates from other tabs
    window.addEventListener('storage', function() {
        const updateData = localStorage.getItem('statusUpdate');
        if (updateData) {
            try {
                const data = JSON.parse(updateData);
                // Only process recent updates (within last 5 seconds)
                if (new Date().getTime() - data.timestamp < 5000) {
                    // Find and update the corresponding row if it exists
                    const select = $(`.status-select[data-id="${data.booking_id}"][data-type="${data.type}"]`);
                    if (select.length) {
                        select.val(data.status);
                        const badge = select.siblings('.status-badge');
                        const newColor = getStatusColor(data.status);
                        badge.removeClass().addClass('badge status-badge bg-' + newColor);
                        badge.text(data.status.charAt(0).toUpperCase() + data.status.slice(1));
                        
                        if (data.status === 'success' || data.status === 'cancel') {
                            select.prop('disabled', true);
                        }
                    }
                }
            } catch (e) {
                console.error('Error processing status update:', e);
            }
        }
    });
    
    // Check for updates every 30 seconds (as a fallback)
    setInterval(function() {
        refreshTable();
    }, 30000);
    
    function refreshTable() {
        $.ajax({
            url: '<?php echo site_url('admin/get_grooming_data'); ?>',
            type: 'GET',
            success: function(response) {
                try {
                    // If you implement this endpoint, you can refresh the table data
                    // For now, we'll just reload the page if needed
                    // table.ajax.reload(null, false);
                    console.log('Table data refreshed');
                } catch (e) {
                    console.error('Error refreshing table:', e);
                }
            }
        });
    }
});
</script>
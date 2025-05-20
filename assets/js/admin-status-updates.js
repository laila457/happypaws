document.addEventListener('DOMContentLoaded', function() {
    // Handle status updates for grooming and penitipan
    $(document).on('change', '.status-select', function() {
        const select = $(this);
        const booking_id = select.data('id');
        const status = select.val();
        const type = select.data('type');
        const currentStatus = select.siblings('.status-badge').text().toLowerCase();
        
        if (currentStatus === 'process' && status === 'pending') {
            select.val('process');
            toastr.warning('Tidak dapat mengubah kembali ke pending setelah dalam proses');
            return;
        }

        select.prop('disabled', true);
        toastr.info('Memperbarui status...');

        $.ajax({
            url: baseUrl + 'admin/update_status',
            type: 'POST',
            dataType: 'json',
            data: {
                booking_id: booking_id,
                type: type,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    const badge = select.siblings('.status-badge');
                    const newColor = getStatusColor(status);
                    badge.removeClass().addClass('badge status-badge bg-' + newColor);
                    badge.text(status.charAt(0).toUpperCase() + status.slice(1));
                    
                    toastr.success('Status berhasil diperbarui');
                    
                    if (status === 'success' || status === 'cancel') {
                        select.prop('disabled', true);
                    } else {
                        select.prop('disabled', false);
                    }
                    
                    // Refresh the page after successful update
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error('Gagal memperbarui status');
                    select.val(currentStatus);
                    select.prop('disabled', false);
                }
            },
            error: function() {
                toastr.error('Terjadi kesalahan sistem');
                select.val(currentStatus);
                select.prop('disabled', false);
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
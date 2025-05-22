<div class="container-fluid py-4">
    <h1 class="mb-4">Welcome, <?php echo $username; ?>!</h1>
    
    <div class="row">
        <!-- Grooming Stats -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-purple text-uppercase mb-1">Total Grooming</div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $grooming_count; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cut fa-2x text-purple-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penitipan Stats -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-purple text-uppercase mb-1">Total Penitipan</div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $penitipan_count; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-purple-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Sort the recent grooming array by booking date
    usort($recent_grooming, function($a, $b) {
        return strtotime($a->tanggal_grooming) - strtotime($b->tanggal_grooming);
    });
    
    // Sort the recent penitipan array by check-in date
    usort($recent_penitipan, function($a, $b) {
        return strtotime($a->check_in) - strtotime($b->check_in);
    });
    ?>
    <div class="row mt-4">
        <!-- Grooming Management -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-purple">
                    <h5 class="text-white mb-0">Grooming Management</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(array_slice($recent_grooming, 0, 5) as $booking): ?>
                                <tr>
                                    <td><?php echo $booking->id; ?></td>
                                    <td><?php echo date('d M Y', strtotime($booking->tanggal_grooming)); ?></td>
                                    <td><?php echo $booking->nama_pemilik; ?></td>
                                    <td><span class="badge bg-<?php echo $booking->status == 'success' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'info'); ?>"><?php echo ucfirst($booking->status); ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="<?php echo site_url('admin/grooming'); ?>" class="btn btn-purple btn-sm">View All</a>
                </div>
            </div>
        </div>

        <!-- Penitipan Management -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-purple">
                    <h5 class="text-white mb-0">Penitipan Management</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Check-in</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(array_slice($recent_penitipan, 0, 5) as $booking): ?>
                                <tr>
                                    <td><?php echo $booking->id; ?></td>
                                    <td><?php echo date('d M Y', strtotime($booking->check_in)); ?></td>
                                    <td><?php echo $booking->nama_pemilik; ?></td>
                                    <td><span class="badge bg-<?php echo $booking->status == 'success' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'info'); ?>"><?php echo ucfirst($booking->status); ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="<?php echo site_url('admin/penitipan'); ?>" class="btn btn-purple btn-sm">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function refreshDashboardCounts() {
    $.ajax({
        url: '<?php echo site_url('admin/get_dashboard_counts'); ?>',
        type: 'GET',
        success: function(response) {
            const data = JSON.parse(response);
            $('#grooming-count').text(data.grooming_count);
            $('#penitipan-count').text(data.penitipan_count);
        }
    });
}
</script>
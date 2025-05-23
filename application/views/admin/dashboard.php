<div class="container-fluid py-4">
    <h1 class="mb-4">Welcome, <?php echo $username; ?>!</h1>
    
    <div class="row">
        <!-- Users Stats -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-purple text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold"><?php echo $users_count; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-purple-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Existing stats cards -->
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

    <div class="row mt-4">
        <!-- Users Management -->
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-purple">
                    <h5 class="text-white mb-0">Users Management</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Profile</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($recent_users) && !empty($recent_users)): ?>
                                    <?php foreach(array_slice($recent_users, 0, 5) as $user): ?>
                                    <tr>
                                        <td><?php echo $user->id; ?></td>
                                        <td>
                                            <?php if($user->profile_picture): ?>
                                                <img src="<?php echo base_url('uploads/profiles/' . $user->profile_picture); ?>" alt="Profile" class="rounded-circle" width="40" height="40">
                                            <?php else: ?>
                                                <i class="fas fa-user-circle fa-2x text-secondary"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $user->username; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->phone; ?></td>
                                        <td><span class="badge bg-<?php echo $user->role === 'admin' ? 'danger' : 'info'; ?>"><?php echo ucfirst($user->role); ?></span></td>
                                        <td><?php echo date('d M Y', strtotime($user->created_at)); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No users found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-purple btn-sm">View All Users</a>
                </div>
            </div>
        </div>

        <!-- Existing Grooming and Penitipan sections -->
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
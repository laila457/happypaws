<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Users</h1>
        <a href="<?php echo site_url('admin/users/create'); ?>" class="btn btn-purple">
            <i class="fas fa-user-plus"></i> Tambah User
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Profile Picture</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($users) && !empty($users)): ?>
                            <?php foreach($users as $user): ?>
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
                                <td><?php echo $user->address; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $user->role === 'admin' ? 'purple' : 'info'; ?>">
                                        <?php echo ucfirst($user->role); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d M Y H:i', strtotime($user->created_at)); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/users/edit/' . $user->id); ?>" class="btn btn-sm btn-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo site_url('admin/users/delete/' . $user->id); ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                           title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-secondary mb-3"></i>
                                    <p class="mb-0">Belum ada data users</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
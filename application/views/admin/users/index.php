<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Users Management</h1>
        <a href="<?php echo site_url('admin/users/create'); ?>" class="btn btn-purple">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
    </div>

    <div class="card shadow">
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
                            <th>Address</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo $user->id; ?></td>
                            <td>
                                <?php if($user->profile_picture): ?>
                                    <img src="<?php echo base_url('uploads/profiles/' . $user->profile_picture); ?>" 
                                         alt="Profile" class="rounded-circle" width="40" height="40">
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
                            <td><?php echo date('d M Y', strtotime($user->created_at)); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo site_url('admin/users/edit/'.$user->id); ?>" 
                                       class="btn btn-sm btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="deleteUser(<?php echo $user->id; ?>)" title="Delete">
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
function deleteUser(userId) {
    if(confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            url: '<?php echo site_url('admin/users/delete/'); ?>' + userId,
            type: 'POST',
            success: function(response) {
                location.reload();
            },
            error: function() {
                alert('Failed to delete user');
            }
        });
    }
}
</script>
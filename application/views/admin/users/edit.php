<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-gradient-purple">
                    <h5 class="text-white mb-0">Edit User</h5>
                </div>
                <div class="card-body">
                    <?php echo form_open_multipart('admin/users/edit/'.$user->id); ?>
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $user->email; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Password (leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $user->phone; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="3" required><?php echo $user->address; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="user" <?php echo $user->role == 'user' ? 'selected' : ''; ?>>User</option>
                                <option value="admin" <?php echo $user->role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Profile Picture</label>
                            <?php if($user->profile_picture): ?>
                                <div class="mb-2">
                                    <img src="<?php echo base_url('uploads/profiles/'.$user->profile_picture); ?>" 
                                         alt="Current Profile" class="rounded" width="100">
                                </div>
                            <?php endif; ?>
                            <input type="file" name="profile_picture" class="form-control">
                        </div>
                        <div class="text-end">
                            <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-purple">Update User</button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
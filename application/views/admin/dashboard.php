<div class="container">
    <h1>Welcome, Admin <?php echo $username; ?>!</h1>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5>Admin Dashboard</h5>
                </div>
                <div class="card-body">
                    <p>This is your admin dashboard. You can manage all aspects of the system from here.</p>
                    <p>You are logged in with administrator privileges.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>User Statistics</h5>
                </div>
                <div class="card-body">
                    <p>Here you can see user statistics and manage user accounts.</p>
                    <a href="#" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>System Settings</h5>
                </div>
                <div class="card-body">
                    <p>Configure system settings and preferences.</p>
                    <a href="#" class="btn btn-success">System Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>
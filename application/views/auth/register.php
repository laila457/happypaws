<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - HappyPaws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #BA68C8 0%, #7B1FA2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-container {
            max-width: 500px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            max-width: 200px;
            height: auto;
        }
        .btn-purple {
            background: linear-gradient(90deg, #BA68C8 0%, #7B1FA2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
        }
        .btn-purple:hover {
            background: linear-gradient(90deg, #7B1FA2 0%, #BA68C8 100%);
            color: white;
        }
        .form-control:focus {
            border-color: #BA68C8;
            box-shadow: 0 0 0 0.2rem rgba(186, 104, 200, 0.25);
        }
        a {
            color: #7B1FA2;
        }
        a:hover {
            color: #BA68C8;
            text-decoration: none;
        }
        .form-group label {
            color: #7B1FA2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="logo">
                <img src="<?php echo base_url('assets/images/logooo.png'); ?>" alt="Happy Paws">
                <p class="mt-3 text-muted">Create a new account</p>
            </div>
            
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
            
            <?php echo form_open('auth/register'); ?>
                <div class="form-group">
                    <label for="username"><i class="fas fa-user text-purple"></i> Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo set_value('username'); ?>">
                    <?php echo form_error('username', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope text-purple"></i> Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>">
                    <?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone text-purple"></i> Nomor HP</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone'); ?>" oninput="validatePhoneNumber(this)">
                    <small id="phoneError" class="text-danger" style="display:none;">Tolong masukan angka.</small>
                    <?php echo form_error('phone', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="address"><i class="fas fa-map-marker-alt text-purple"></i> Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="3"><?php echo set_value('address'); ?></textarea>
                    <?php echo form_error('address', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock text-purple"></i> Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-lock text-purple"></i> Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <?php echo form_error('confirm_password', '<small class="text-danger">', '</small>'); ?>
                </div>
                <button type="submit" class="btn btn-purple btn-block">Register</button>
            <?php echo form_close(); ?>
            
            <div class="text-center mt-3">
                <p>Already have an account? <a href="<?php echo base_url('auth'); ?>">Login</a></p>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validatePhoneNumber(input) {
            const phoneError = document.getElementById('phoneError');
            if (/[^0-9]/.test(input.value)) {
                phoneError.style.display = 'block';
            } else {
                phoneError.style.display = 'none';
            }
        }
    </script>
</body>
</html>
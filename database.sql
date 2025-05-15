CREATE DATABASE happypaws;
USE happypaws;

CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY (email),
    UNIQUE KEY (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, phone, address, password, role) VALUES 
('admin', 'admin@happypaws.com', '08123456789', 'Admin Address', '$2y$10$xLRWQQmzJ1v9V1oKA4UkKOsF0Y3fZkmwf7Jtmub9F/QTH/2.kBnwK', 'admin');

-- Update grooming table structure
DROP TABLE IF EXISTS grooming;
CREATE TABLE grooming (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    tanggal_grooming DATE,
    waktu_booking TIME,
    nama_pemilik VARCHAR(255),
    no_hp VARCHAR(15),
    jenis_hewan VARCHAR(50),
    paket_grooming ENUM('basic', 'kutu', 'full') NOT NULL,
    pengantaran ENUM('antar', 'jemput') NOT NULL,
    kecamatan VARCHAR(100),
    desa VARCHAR(100),
    detail_alamat TEXT,
    total_harga DECIMAL(10,2) NOT NULL,
    metode_pembayaran VARCHAR(20) DEFAULT 'pending',
    bukti_transaksi VARCHAR(255) DEFAULT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Update penitipan table structure
DROP TABLE IF EXISTS penitipan;
CREATE TABLE penitipan (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11),
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    nama_pemilik VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    nama_hewan VARCHAR(100) NOT NULL,
    jenis_hewan VARCHAR(50) NOT NULL,
    paket_penitipan ENUM('basic', 'premium', 'exclusive') NOT NULL,
    pengantaran ENUM('antar', 'jemput') NOT NULL,
    kecamatan VARCHAR(100),
    desa VARCHAR(100),
    detail_alamat TEXT,
    catatan TEXT,
    total_harga DECIMAL(10,2) NOT NULL,
    metode_pembayaran VARCHAR(20) DEFAULT 'pending',
    bukti_transaksi VARCHAR(255) DEFAULT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add indexes for better performance
ALTER TABLE grooming
ADD INDEX idx_user_id (user_id),
ADD INDEX idx_status (status),
ADD INDEX idx_tanggal (tanggal_grooming);

ALTER TABLE penitipan
ADD INDEX idx_user_id (user_id),
ADD INDEX idx_status (status),
ADD INDEX idx_dates (check_in, check_out);
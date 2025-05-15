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

CREATE TABLE grooming (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_grooming DATE,
    waktu_booking TIME,
    nama_pemilik VARCHAR(255),
    no_hp VARCHAR(15),
    jenis_hewan VARCHAR(50),
    paket_grooming VARCHAR(50),
    pengantaran VARCHAR(50),
    kecamatan VARCHAR(100),
    desa VARCHAR(100),
    detail_alamat TEXT
);

-- Add missing columns to grooming table
ALTER TABLE grooming 
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

CREATE TABLE `penitipan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `nama_hewan` varchar(100) NOT NULL,
  `jenis_hewan` varchar(50) NOT NULL,
  `paket_penitipan` varchar(50) NOT NULL,
  `pengantaran` varchar(20) NOT NULL,
  `catatan` text,
  `total_harga` decimal(10,2) NOT NULL,
  `metode_pembayaran` varchar(20) DEFAULT 'pending',
  `bukti_transaksi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add address fields to penitipan table
ALTER TABLE penitipan 
ADD COLUMN kecamatan VARCHAR(100) AFTER pengantaran,
ADD COLUMN desa VARCHAR(100) AFTER kecamatan,
ADD COLUMN detail_alamat TEXT AFTER desa;

-- Add profile_picture column to users table
ALTER TABLE users 
ADD COLUMN profile_picture VARCHAR(255) DEFAULT NULL AFTER address;

-- Add user_id and created_at columns to penitipan table
ALTER TABLE penitipan 
ADD COLUMN user_id INT(11) AFTER id,
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

-- Add status column to penitipan table if not exists
ALTER TABLE penitipan 
ADD COLUMN status VARCHAR(20) DEFAULT 'pending' AFTER metode_pembayaran;
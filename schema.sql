-- SAFE-RENT Web v1 database schema

CREATE DATABASE IF NOT EXISTS safe_rent;
USE safe_rent;

CREATE TABLE IF NOT EXISTS properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    address VARCHAR(150) NOT NULL,
    monthly_rent DECIMAL(10,2) NOT NULL,
    status ENUM('available', 'rented') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tenants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    property_id INT,
    lease_start DATE,
    lease_end DATE,
    deposit_amount DECIMAL(10,2),
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE SET NULL
);

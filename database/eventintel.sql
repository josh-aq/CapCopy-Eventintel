CREATE DATABASE IF NOT EXISTS COPYEVENTINTEL CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE COPYEVENTINTEL;

DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS guests;
DROP TABLE IF EXISTS invitations;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS supplier_services;
DROP TABLE IF EXISTS event_services;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  full_name VARCHAR(150),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('client','supplier','coordinator','admin') DEFAULT 'client',
  status ENUM('approved','pending','rejected') DEFAULT 'approved',
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  middle_initial VARCHAR(10),
  age INT,
  gender VARCHAR(20),
  phone VARCHAR(20),
  province VARCHAR(100),
  municipality VARCHAR(100),
  barangay VARCHAR(100),
  postal_code VARCHAR(20),
  business_name VARCHAR(150),
  business_address TEXT,
  valid_id VARCHAR(255),
  business_permit VARCHAR(255),
  face_capture VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
  event_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  title VARCHAR(150),
  event_type VARCHAR(100),
  theme VARCHAR(120),
  budget DECIMAL(12,2),
  event_date DATE,
  event_time TIME,
  guest_count INT,
  venue_name VARCHAR(150),
  venue_address TEXT,
  latitude DECIMAL(10,7),
  longitude DECIMAL(10,7),
  status VARCHAR(50) DEFAULT 'planning',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE event_services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT,
  service_name VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE supplier_services (
  service_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  category VARCHAR(100),
  name VARCHAR(150),
  description TEXT,
  price DECIMAL(10,2),
  address TEXT,
  latitude DECIMAL(10,7),
  longitude DECIMAL(10,7),
  rating DECIMAL(3,2) DEFAULT 5.00,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bookings (
  booking_id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT,
  service_id INT,
  status VARCHAR(50) DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE guests (
  guest_id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT,
  name VARCHAR(150),
  email VARCHAR(150),
  phone VARCHAR(50),
  qr_code VARCHAR(100),
  rsvp_status VARCHAR(50) DEFAULT 'pending',
  attended BOOLEAN DEFAULT 0,
  scanned_at DATETIME,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE invitations (
  invitation_id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT,
  title VARCHAR(150),
  message TEXT,
  theme_color VARCHAR(20),
  font_style VARCHAR(80) DEFAULT 'Segoe UI',
  button_text VARCHAR(100),
  background_image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reviews (
  review_id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT,
  user_id INT,
  service_id INT,
  rating INT,
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Demo accounts. Password for all = password
INSERT INTO users (username, first_name, last_name, full_name, email, password, role, status, business_name, business_address)
VALUES 
('admin','Admin','User','Admin User','admin@test.com','$2y$10$5OEhKWqJU/XxtA0w/smNG.bkkgHwonn7lt3HQc498.S0AxBqWTEve','admin','approved',NULL,NULL),
('client','Client','User','Client User','client@test.com','$2y$10$5OEhKWqJU/XxtA0w/smNG.bkkgHwonn7lt3HQc498.S0AxBqWTEve','client','approved',NULL,NULL),
('supplier','Supplier','User','Supplier User','supplier@test.com','$2y$10$5OEhKWqJU/XxtA0w/smNG.bkkgHwonn7lt3HQc498.S0AxBqWTEve','supplier','approved','Golden Events Supplier','Apalit, Pampanga'),
('coordinator','Coordinator','User','Coordinator User','coord@test.com','$2y$10$5OEhKWqJU/XxtA0w/smNG.bkkgHwonn7lt3HQc498.S0AxBqWTEve','coordinator','approved','Apalit Event Coordination','Apalit, Pampanga');

INSERT INTO supplier_services (user_id, category, name, description, price, address, latitude, longitude, rating)
VALUES
(3,'Venue','The Grand Pavilion','Elegant venue for weddings and birthdays',25000,'Apalit, Pampanga',14.9533,120.7690,4.9),
(3,'Catering','Golden Catering Buffet','Food package for 50-150 guests',18000,'Apalit, Pampanga',14.9550,120.7700,4.8),
(3,'Host','Professional Event Host','Experienced MC for formal and casual events',7000,'Apalit, Pampanga',14.9500,120.7650,4.7),
(3,'Photographer','Event Photography Package','Photo coverage and edited photos',12000,'Apalit, Pampanga',14.9510,120.7680,4.8),
(3,'Sounds & Lights','Pro Audio Lights Setup','Audio system, microphones, lighting rig',15000,'Apalit, Pampanga',14.9540,120.7660,4.6),
(3,'Clothes','Formal Attire Coordination','Gowns and suits coordination',10000,'Apalit, Pampanga',14.9520,120.7670,4.5);

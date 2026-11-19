CREATE DATABASE IF NOT EXISTS eos;
USE eos;

-- ============ AUTH ============

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) DEFAULT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    avatar MEDIUMTEXT DEFAULT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    level VARCHAR(20) NOT NULL DEFAULT 'Initiation', -- 'Initiation' | 'Debutant' | 'Intermediaire' | 'Avancee' | 'Expert' — set only by admin
    email_verified_at DATETIME DEFAULT NULL,
    phone_verified_at DATETIME DEFAULT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending_category', -- pending_category | pending_approval | approved | rejected
    preferred_category VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Email-based tokens: email verification, password reset
CREATE TABLE IF NOT EXISTS tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    type VARCHAR(20) NOT NULL, -- 'email_verify' | 'password_reset'
    token_hash CHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL,
    used_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tokens_user_type (user_id, type),
    INDEX idx_tokens_hash (token_hash),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Phone OTP codes (WhatsApp signup verification)
CREATE TABLE IF NOT EXISTS otp_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    code_hash CHAR(64) NOT NULL,
    attempts TINYINT NOT NULL DEFAULT 0,
    expires_at DATETIME NOT NULL,
    used_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_otp_user (user_id),
    INDEX idx_otp_phone (phone),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS refresh_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token_hash CHAR(64) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    used_at DATETIME DEFAULT NULL,
    revoked_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_refresh_user (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS revoked_access_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    jti VARCHAR(64) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_revoked_exp (expires_at)
);

-- ============ MEMBERSHIP ============

CREATE TABLE IF NOT EXISTS membership_plans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL, -- 'Gold', 'Silver', ...
    price DECIMAL(10,2) NOT NULL,
    classes_per_month INT DEFAULT NULL, -- NULL = unlimited
    duration_months INT NOT NULL DEFAULT 1,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    category VARCHAR(20) DEFAULT NULL, -- 'Strength' | 'Pilates'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS memberships (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    plan_id INT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    auto_renew TINYINT(1) NOT NULL DEFAULT 1,
    classes_used_this_month INT NOT NULL DEFAULT 0,
    started_at DATE NULL,
    renews_at DATE DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_memberships_user (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES membership_plans(id)
);

-- ============ CLASSES & TRAINERS ============

CREATE TABLE IF NOT EXISTS class_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO class_categories (name, sort_order) VALUES
    ('Pilates', 1),
    ('Dance Orientale', 2),
    ('Zumba', 3),
    ('Dance Tunisienne', 4),
    ('Body Attack', 5),
    ('Body Combat', 6),
    ('Body Balance', 7),
    ('Step', 8),
    ('Lia', 9),
    ('Yoga', 10),
    ('Cardio Mix', 11),
    ('CAF', 12),
    ('Abdo', 13),
    ('Circuit Training', 14),
    ('Zumba Kids', 15),
    ('Cross Fit Kids', 16),
    ('EMOM', 17);

CREATE TABLE IF NOT EXISTS trainers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    specialty VARCHAR(255) DEFAULT NULL, -- 'Pilates & Core', 'Strength & Conditioning'
    avatar MEDIUMTEXT DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS classes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    trainer_id INT NOT NULL,
    name VARCHAR(255) NOT NULL, -- 'Reformer Pilates', 'Strength Circuit'
    category VARCHAR(50) DEFAULT NULL, -- 'Pilates' | 'Strength' | ...
    location VARCHAR(100) DEFAULT NULL, -- 'Studio B', 'Weight Room'
    level VARCHAR(20) DEFAULT NULL, -- 'Initiation' | 'Debutant' | 'Intermediaire' | 'Avancee' | 'Expert' (mainly used for Pilates)
    starts_at DATETIME NOT NULL,
    ends_at DATETIME NOT NULL,
    capacity INT NOT NULL DEFAULT 20,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_classes_trainer (trainer_id),
    INDEX idx_classes_start (starts_at),
    INDEX idx_classes_category (category),
    FOREIGN KEY (trainer_id) REFERENCES trainers(id)
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    class_id INT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'booked', -- 'booked' | 'cancelled' | 'attended' | 'no_show'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_booking (user_id, class_id),
    INDEX idx_bookings_class (class_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
);

-- ============ PROGRESS ============

CREATE TABLE IF NOT EXISTS workouts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    class_id INT DEFAULT NULL, -- NULL if logged manually, not tied to a booked class
    type VARCHAR(100) DEFAULT NULL,
    duration_minutes INT DEFAULT NULL,
    calories_burned INT DEFAULT NULL,
    performed_at DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_workouts_user_date (user_id, performed_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
);

-- ============ DIET ============

CREATE TABLE IF NOT EXISTS diet_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    meal_type VARCHAR(20) NOT NULL, -- 'breakfast' | 'lunch' | 'dinner' | 'snack'
    description VARCHAR(255) DEFAULT NULL,
    calories INT DEFAULT NULL,
    logged_at DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_diet_user_date (user_id, logged_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ============ STORE ============

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(50) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image_url MEDIUMTEXT DEFAULT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_products_category (category)
);

CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending', -- pending | paid | fulfilled | cancelled
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_orders_user (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    INDEX idx_order_items_order (order_id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- ============ NOTIFICATIONS ============

CREATE TABLE IF NOT EXISTS notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    message VARCHAR(500) NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_notifications_user (user_id, is_read),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS posters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(120) NOT NULL,
  location VARCHAR(150),
  text TEXT NOT NULL,
  image_url VARCHAR(500),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
 
CREATE TABLE IF NOT EXISTS announcements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  image_url VARCHAR(500),
  link VARCHAR(500),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
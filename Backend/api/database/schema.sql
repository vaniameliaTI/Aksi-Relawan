-- Tabel Relawan
CREATE TABLE IF NOT EXISTS relawan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    no_telp VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL,
    keahlian TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Users (Relawan)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100) NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Activities (Kegiatan)
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    location VARCHAR(255) NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    max_participants INT,
    current_participants INT DEFAULT 0,
    status ENUM('pending', 'ongoing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Activity_Participants (Relasi antara Users dan Activities)
CREATE TABLE IF NOT EXISTS activity_participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    activity_id INT NOT NULL,
    status ENUM('registered', 'attended', 'cancelled') DEFAULT 'registered',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Activity_Photos (Foto-foto kegiatan)
CREATE TABLE IF NOT EXISTS activity_photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activity_id INT NOT NULL,
    photo_url VARCHAR(255) NOT NULL,
    description TEXT,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Jalankan ini di database Anda jika memilih opsi ini:
ALTER TABLE users MODIFY COLUMN full_name VARCHAR(100) NULL;

-- Jalankan ini untuk menghapus kolom token jika sudah ada
ALTER TABLE users DROP COLUMN IF EXISTS token;
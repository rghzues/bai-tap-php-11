CREATE TABLE IF NOT EXISTS Customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(255) NOT NULL,
    gender ENUM('Nam', 'Nữ', 'Khác') DEFAULT 'Nam'
);


INSERT INTO Customer (fullname, address, phone, email, gender) VALUES 
('Nguyễn Văn A', 'Hà Nội', '0912345678', 'example1@gmail.com', 'Nam'),
('Trần Thị B', 'TP.HCM', '0987654321', 'example2@gmail.com', 'Nữ');
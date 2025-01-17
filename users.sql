CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL
);


-- Menambahkan beberapa data contoh
INSERT INTO users (name, email, gender)
VALUES 
    ('Noval raid ramadhan', 'novalraid@gmail.com', 'Male'),
    ('Safrudin', 'udingacor123@gmail.com', 'Male'),
    ('Hardianto', 'hardianto@gmail.com', 'Male');

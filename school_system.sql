CREATE DATABASE school;
USE school;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('teacher', 'student') NOT NULL
);

CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day VARCHAR(20) NOT NULL,
    time VARCHAR(20) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    teacher VARCHAR(100) NOT NULL
);

INSERT INTO users (username, password, role) VALUES
('سيف', '121212', 'teacher'),
('طيب', '131313', 'student'),
('حليم', 'حليم', 'student'),
('هييبا', 'هييبا', 'student');

INSERT INTO schedule (day, time, subject, teacher) VALUES
('الأحد', '08:00 - 09:30', 'لغة إنجليزية', 'الأستاذ سيف'),
('الأحد', '10:00 - 11:30', 'لغة إنجليزية', 'الأستاذ سيف'),
('الإثنين', '12:00 - 13:30', 'لغة إنجليزية', 'الأستاذ سيف');
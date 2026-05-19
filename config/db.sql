CREATE DATABASE IF NOT EXISTS it_training_system;
USE it_training_system;

CREATE TABLE admins (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(100) NOT NULL,
                        email VARCHAR(100) NOT NULL UNIQUE,
                        contact VARCHAR(20) NOT NULL,
                        password VARCHAR(255) NOT NULL,
                        photo VARCHAR(255)
);

CREATE TABLE centers (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         center_name VARCHAR(150) NOT NULL
);

CREATE TABLE course_types (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              type_name VARCHAR(100) NOT NULL
);

CREATE TABLE durations (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           duration_label VARCHAR(50) NOT NULL
);

CREATE TABLE courses (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         course_name VARCHAR(100) NOT NULL,
                         course_type_id INT,
                         duration_id INT,
                         total_fee DECIMAL(10,2) NOT NULL,
                         FOREIGN KEY (course_type_id) REFERENCES course_types(id),
                         FOREIGN KEY (duration_id) REFERENCES durations(id)
);

CREATE TABLE trainees (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(100) NOT NULL,
                          father_name VARCHAR(100) NOT NULL,
                          contact VARCHAR(20) NOT NULL,
                          course_id INT,
                          center_id INT,
                          photo VARCHAR(255),
                          FOREIGN KEY (course_id) REFERENCES courses(id),
                          FOREIGN KEY (center_id) REFERENCES centers(id)
);

CREATE TABLE fees_payments (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               trainee_id INT NOT NULL,
                               amount_paid DECIMAL(10,2) NOT NULL,
                               payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                               payment_method VARCHAR(50),
                               FOREIGN KEY (trainee_id) REFERENCES trainees(id) ON DELETE CASCADE
);

CREATE TABLE enquiries (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           name VARCHAR(100) NOT NULL,
                           contact VARCHAR(20) NOT NULL,
                           interested_course VARCHAR(100),
                           message TEXT,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
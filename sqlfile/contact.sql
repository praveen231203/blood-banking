CREATE DATABASE contactdb;

USE contactdb;

CREATE TABLE tblcontactusquery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    EmailId VARCHAR(255) NOT NULL,
    ContactNumber VARCHAR(20) NOT NULL,
    Message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

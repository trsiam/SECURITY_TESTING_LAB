-- db.sql - Complete database schema
DROP DATABASE IF EXISTS sqli_lab;
CREATE DATABASE sqli_lab;
USE sqli_lab;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50),
    password VARCHAR(255),
    email VARCHAR(100),
    full_name VARCHAR(100),
    is_admin TINYINT DEFAULT 0
);

-- Products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    category VARCHAR(50)
);

-- Orders table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    product_name VARCHAR(100),
    status VARCHAR(20)
);

-- Insert sample users
INSERT INTO users (username, password, email, full_name, is_admin) VALUES
('admin', 'admin123', 'admin@site.com', 'Administrator', 1),
('john', 'john123', 'john@email.com', 'John Doe', 0),
('jane', 'jane123', 'jane@email.com', 'Jane Smith', 0),
('test', 'test123', 'test@email.com', 'Test User', 0);

-- Insert sample products
INSERT INTO products (name, description, price, category) VALUES
('Laptop', 'High performance laptop with 16GB RAM', 999.99, 'Electronics'),
('Phone', 'Smartphone with 5G and 128GB storage', 699.99, 'Electronics'),
('SQL Injection Guide', 'Learn SQL injection from basics to advanced', 29.99, 'Books'),
('Headphones', 'Wireless noise cancelling headphones', 149.99, 'Audio');

-- Insert sample orders
INSERT INTO orders (user_id, product_name, status) VALUES
(1, 'Laptop', 'Shipped'),
(2, 'Phone', 'Processing'),
(3, 'SQL Injection Guide', 'Delivered');
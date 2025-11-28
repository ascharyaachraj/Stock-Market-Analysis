CREATE DATABASE stock_market;
USE stock_market;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE watchlist (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    stock_symbol VARCHAR(10),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
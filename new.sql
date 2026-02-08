CREATE TABLE wallets (
 id INT AUTO_INCREMENT PRIMARY KEY,
 address VARCHAR(100)
);

CREATE TABLE orders (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_code VARCHAR(50),
 product_name VARCHAR(100),
 amount_micro BIGINT,
 wallet_id INT,
 status ENUM('pending','paid','expired'),
 created_at DATETIME
);

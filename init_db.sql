
CREATE DATABASE IF NOT EXISTS artisanhub CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE artisanhub;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS artisans (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  biography TEXT,
  contact VARCHAR(120)
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  artisan_id INT,
  name VARCHAR(150) NOT NULL,
  category VARCHAR(60),
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  description TEXT,
  image VARCHAR(255),
  FOREIGN KEY (artisan_id) REFERENCES artisans(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  total_price DECIMAL(10,2) NOT NULL,
  order_date DATETIME NOT NULL,
  status VARCHAR(60) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Sample data
INSERT INTO users (name,email,password) VALUES
('Demo User','demo@user.com', '$2y$10$7S9n9gJc9c1q8iI7m0O8bOq8xT0qYB1pIaiyH4yLk3F1g9vlbFf9u'); -- password 123456

INSERT INTO artisans (name,biography,contact) VALUES
('Asha Pottery', 'Traditional clay pottery from Kutch.', 'ashapottery@example.com'),
('Maya Textiles', 'Handwoven textiles with natural dyes.', 'maya@example.com');

INSERT INTO products (artisan_id,name,category,price,description,image) VALUES
(1,'Terracotta Vase','pottery',799.00,'Handcrafted terracotta vase with rustic finish.','assets/images/placeholder.jpg'),
(1,'Clay Tea Cups (Set of 4)','pottery',499.00,'Eco-friendly clay cups perfect for chai.','assets/images/placeholder.jpg'),
(2,'Indigo Scarf','textiles',899.00,'Handwoven scarf dyed with natural indigo.','assets/images/placeholder.jpg'),
(2,'Block-Print Tote','textiles',649.00,'Cotton tote with traditional block prints.','assets/images/placeholder.jpg');

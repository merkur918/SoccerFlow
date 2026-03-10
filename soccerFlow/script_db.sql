-- Primero, eliminamos la base de datos existente
DROP DATABASE IF EXISTS soccerflow;
CREATE DATABASE soccerflow;
USE soccerflow;

-- Tabla users (sin cambios)
CREATE TABLE users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    rol ENUM('admin','user') NOT NULL DEFAULT 'user',
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario admin por defecto contraseña "admin123"
INSERT INTO users (name, email, password, rol, email_verified_at)
VALUES (
    'Administrador',
    'admin@soccerflow.com',
    '$2y$10$yMjGD3ptpnlEvfR4q6Hqa.ceXM5C835A/TgWgPNfVfzWtONt6.wn2', -- LA contraseña es "admin123" que esta encriptada 
    'admin',
    NOW()
);

-- Tabla email_verifications (sin cambios)
CREATE TABLE email_verifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    verified_at TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(ID) ON DELETE CASCADE
);

-- Tabla password_resets (sin cambios)
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(ID) ON DELETE CASCADE
);

-- Tabla products MODIFICADA
CREATE TABLE products (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    brand VARCHAR(50),
    team VARCHAR(50) DEFAULT NULL,
    category VARCHAR(50) NOT NULL,
    gender ENUM('Masculino','Femenino','Unisex') DEFAULT 'unisex',
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Las tablas restantes SIN CAMBIOS
CREATE TABLE products_variants (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    size VARCHAR(10),
    size_shoe VARCHAR(10),
    color VARCHAR(50),
    stock INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(ID) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_size_xor CHECK (
        (size IS NOT NULL AND size_shoe IS NULL) OR
        (size IS NULL AND size_shoe IS NOT NULL)
    )
);

CREATE TABLE product_images (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(ID) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE carts(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    status ENUM('active','converted','abandoned') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(ID) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE cart_items(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_variant_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES carts(ID) ON DELETE CASCADE,
    FOREIGN KEY (product_variant_id) REFERENCES products_variants(ID) ON DELETE RESTRICT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    status ENUM('pending','paid','sent','completed','canceled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(ID) ON DELETE RESTRICT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_variant_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(ID) ON DELETE CASCADE,
    FOREIGN KEY (product_variant_id) REFERENCES products_variants(ID) ON DELETE RESTRICT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE contactanos (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    asunto VARCHAR(255) NOT NULL,
    mensaje TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
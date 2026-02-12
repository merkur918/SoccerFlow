INSERT INTO products (name, description, price, brand, team, category, gender) VALUES
('Nike Mercurial Superfly 10 Elite', 'Botas de fútbol de perfil alto para terreno firme', 279.99, 'Nike', NULL, 'botas', 'Masculino'),
('Nike Tiempo Maestro Academy', 'Botas de fútbol de perfil bajo para terreno blando', 89.99, 'Nike', NULL, 'botas', 'Masculino'),
('Nike Tiempo Ligera Pro LE', 'Botas de fútbol de perfil bajo para terreno firme', 159.99, 'Nike', NULL, 'botas', 'Femenino'),
('Nike Premier 3', 'Botas de fútbol de perfil bajo para terreno firme', 109.99, 'Nike', NULL, 'botas', 'Femenino'),
('Nike Phantom 6 Low Academy', 'Botas de fútbol para césped artificial', 89.99, 'Nike', NULL, 'botas', 'unisex'),
('Adidas F50 LEAGUE', 'Bota de fútbol F50 LEAGUE césped natural seco / multisuperficie', 90.00, 'Adidas', NULL, 'botas', 'Masculino'),
('Adidas PREDATOR PRO FOLD-OVER Tongue', 'Bota de fútbol PREDATOR PRO FOLD-OVER Tongue césped natural seco', 160.00, 'Adidas', NULL, 'botas', 'Masculino'),
('Adidas COPA PURE IV', 'Bota de fútbol COPA PURE IV LEAGUE césped natural seco', 85.00, 'Adidas', NULL, 'botas', 'Femenino'),
('Adidas Predator Obsidian Strike', 'Bota de fútbol con lengüeta plegable Predator Obsidian Strike césped natural seco', 300.00, 'Adidas', NULL, 'botas', 'unisex'),
('Puma FUTURE 8 MATCH RE-CHARGE FG/AG', 'Botas ligeras y ágiles con máximo agarre y control del balón.', 79.99, 'Puma', NULL, 'botas', 'Masculino'),
('Puma ULTRA 6 MATCH+ LIGHT UP FG/AG', 'Botas ultraligeras con máxima velocidad y estabilidad en césped natural y artificial.', 95.00, 'Puma', NULL, 'botas', 'Femenino'),
('New Balance 442 Pro FG V3', 'Botas clásicas y ligeras con ajuste cómodo y respuesta moderna', 120.00, 'New Balance', NULL, 'botas', 'Masculino'),
('Under Armour Magnetico Pro 5 FG', 'Botas que se adaptan al pie para ofrecer control total y un ajuste personalizado.', 140.00, 'Under Armour', NULL, 'botas', 'unisex'),
('Joma Aguila Top FG', 'Bota clásica renovada con materiales modernos y rendimiento de máximo nivel.', 63.99, 'Joma', NULL, 'botas', 'unisex');

SET @bota1_id = (SELECT ID FROM products WHERE name = 'Nike Mercurial Superfly 10 Elite');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota1_id, '38', 'Negro / Azul Hielo', 15),
(@bota1_id, '39', 'Negro / Azul Hielo', 15),
(@bota1_id, '40', 'Negro / Azul Hielo', 15),
(@bota1_id, '41', 'Negro / Azul Hielo', 15),
(@bota1_id, '42', 'Negro / Azul Hielo', 15),
(@bota1_id, '43', 'Negro / Azul Hielo', 15);


SET @bota2_id = (SELECT ID FROM products WHERE name = 'Nike Tiempo Maestro Academy');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota2_id, '38', 'Negro / Azul Hielo', 15),
(@bota2_id, '39', 'Negro / Azul Hielo', 15),
(@bota2_id, '40', 'Negro / Azul Hielo', 15),
(@bota2_id, '41', 'Negro / Azul Hielo', 15),
(@bota2_id, '42', 'Negro / Azul Hielo', 15),
(@bota2_id, '43', 'Negro / Azul Hielo', 15);

SET @bota3_id = (SELECT ID FROM products WHERE name = 'Nike Tiempo Ligera Pro LE');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota3_id, '38', 'Bronce Rojo Metálico / Oro Rosa Metálico', 15),
(@bota3_id, '39', 'Bronce Rojo Metálico / Oro Rosa Metálico', 15),
(@bota3_id, '40', 'Bronce Rojo Metálico / Oro Rosa Metálico', 15),
(@bota3_id, '41', 'Bronce Rojo Metálico / Oro Rosa Metálico', 15),
(@bota3_id, '42', 'Bronce Rojo Metálico / Oro Rosa Metálico', 15),
(@bota3_id, '43', 'Bronce Rojo Metálico / Oro Rosa Metálico', 15);

SET @bota4_id = (SELECT ID FROM products WHERE name = 'Nike Premier 3');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota4_id, '38', 'Granate / Negro / Crema', 15),
(@bota4_id, '39', 'Granate / Negro / Crema', 15),
(@bota4_id, '40', 'Granate / Negro / Crema', 15),
(@bota4_id, '41', 'Granate / Negro / Crema', 15),
(@bota4_id, '42', 'Granate / Negro / Crema', 15),
(@bota4_id, '43', 'Granate / Negro / Crema', 15);

SET @bota5_id = (SELECT ID FROM products WHERE name = 'Nike Phantom 6 Low Academy');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota5_id, '38', 'Azul / Blanco / Rosa', 15),
(@bota5_id, '39', 'Azul / Blanco / Rosa', 15),
(@bota5_id, '40', 'Azul / Blanco / Rosa', 15),
(@bota5_id, '41', 'Azul / Blanco / Rosa', 15),
(@bota5_id, '42', 'Azul / Blanco / Rosa', 15),
(@bota5_id, '43', 'Azul / Blanco / Rosa', 15);

SET @bota6_id = (SELECT ID FROM products WHERE name = 'Adidas F50 LEAGUE');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota6_id, '38', 'Amarillo / Negro / Rojo', 15),
(@bota6_id, '39', 'Amarillo / Negro / Rojo', 15),
(@bota6_id, '40', 'Amarillo / Negro / Rojo', 15),
(@bota6_id, '41', 'Amarillo / Negro / Rojo', 15),
(@bota6_id, '42', 'Amarillo / Negro / Rojo', 15),
(@bota6_id, '43', 'Amarillo / Negro / Rojo', 15);

SET @bota7_id = (SELECT ID FROM products WHERE name = 'Adidas PREDATOR PRO FOLD-OVER Tongue');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota7_id, '38', 'Rojo / Negro / Blanco', 15),
(@bota7_id, '39', 'Rojo / Negro / Blanco', 15),
(@bota7_id, '40', 'Rojo / Negro / Blanco', 15),
(@bota7_id, '41', 'Rojo / Negro / Blanco', 15),
(@bota7_id, '42', 'Rojo / Negro / Blanco', 15),
(@bota7_id, '43', 'Rojo / Negro / Blanco', 15);

SET @bota8_id = (SELECT ID FROM products WHERE name = 'Adidas COPA PURE IV');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota8_id, '38', 'Plateado / Negro / Rojo', 15),
(@bota8_id, '39', 'Plateado / Negro / Rojo', 15),
(@bota8_id, '40', 'Plateado / Negro / Rojo', 15),
(@bota8_id, '41', 'Plateado / Negro / Rojo', 15),
(@bota8_id, '42', 'Plateado / Negro / Rojo', 15),
(@bota8_id, '43', 'Plateado / Negro / Rojo', 15);

SET @bota9_id = (SELECT ID FROM products WHERE name = 'Adidas Predator Obsidian Strike');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota9_id, '38', 'Negro / Plateado / Rojo', 15),
(@bota9_id, '39', 'Negro / Plateado / Rojo', 15),
(@bota9_id, '40', 'Negro / Plateado / Rojo', 15),
(@bota9_id, '41', 'Negro / Plateado / Rojo', 15),
(@bota9_id, '42', 'Negro / Plateado / Rojo', 15),
(@bota9_id, '43', 'Negro / Plateado / Rojo', 15);

SET @bota10_id = (SELECT ID FROM products WHERE name = 'Puma FUTURE 8 MATCH RE-CHARGE FG/AG');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota10_id, '38', 'Azul Claro / Azul Hielo / Lavanda / Amarillo', 15),
(@bota10_id, '39', 'Azul Claro / Azul Hielo / Lavanda / Amarillo', 15),
(@bota10_id, '40', 'Azul Claro / Azul Hielo / Lavanda / Amarillo', 15),
(@bota10_id, '41', 'Azul Claro / Azul Hielo / Lavanda / Amarillo', 15),
(@bota10_id, '42', 'Azul Claro / Azul Hielo / Lavanda / Amarillo', 15),
(@bota10_id, '43', 'Azul Claro / Azul Hielo / Lavanda / Amarillo', 15);

SET @bota11_id = (SELECT ID FROM products WHERE name = 'Puma ULTRA 6 MATCH+ LIGHT UP FG/AG');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota11_id, '38', 'Azul / Blanco / Rosa', 15),
(@bota11_id, '39', 'Azul / Blanco / Rosa', 15),
(@bota11_id, '40', 'Azul / Blanco / Rosa', 15),
(@bota11_id, '41', 'Azul / Blanco / Rosa', 15),
(@bota11_id, '42', 'Azul / Blanco / Rosa', 15),
(@bota11_id, '43', 'Azul / Blanco / Rosa', 15);

SET @bota12_id = (SELECT ID FROM products WHERE name = 'New Balance 442 Pro FG V3');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota12_id, '38', 'Negro / Amarillo / Rojo', 15),
(@bota12_id, '39', 'Negro / Amarillo / Rojo', 15),
(@bota12_id, '40', 'Negro / Amarillo / Rojo', 15),
(@bota12_id, '41', 'Negro / Amarillo / Rojo', 15),
(@bota12_id, '42', 'Negro / Amarillo / Rojo', 15),
(@bota12_id, '43', 'Negro / Amarillo / Rojo', 15);

SET @bota13_id = (SELECT ID FROM products WHERE name = 'Under Armour Magnetico Pro 5 FG');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota13_id, '38', 'Verde / Verde Neón / Azul', 15),
(@bota13_id, '39', 'Verde / Verde Neón / Azul', 15),
(@bota13_id, '40', 'Verde / Verde Neón / Azul', 15),
(@bota13_id, '41', 'Verde / Verde Neón / Azul', 15),
(@bota13_id, '42', 'Verde / Verde Neón / Azul', 15),
(@bota13_id, '43', 'Verde / Verde Neón / Azul', 15);

SET @bota14_id = (SELECT ID FROM products WHERE name = 'Joma Aguila Top FG');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota14_id, '38', 'Negro / Blanco', 15),
(@bota14_id, '39', 'Negro / Blanco', 15),
(@bota14_id, '40', 'Negro / Blanco', 15),
(@bota14_id, '41', 'Negro / Blanco', 15),
(@bota14_id, '42', 'Negro / Blanco', 15),
(@bota14_id, '43', 'Negro / Blanco', 15);

INSERT INTO product_images (product_id, image_url) VALUES
(@bota1_id, 'soccerFlow/public/assets/img/products/botas/Nike-Mercurial-Superfly-10Elite-1.png'),
(@bota1_id, 'soccerFlow/public/assets/img/products/botas/Nike-Mercurial-Superfly-10Elite-2.png'),
(@bota1_id, 'soccerFlow/public/assets/img/products/botas/Nike-Mercurial-Superfly-10Elite-3.png'),
(@bota1_id, 'soccerFlow/public/assets/img/products/botas/Nike-Mercurial-Superfly-10Elite-4.png'),
(@bota2_id, 'soccerFlow/public/assets/img/products/botas/Nike-Tiempo-Maestro-Academy-1.png'),
(@bota2_id, 'soccerFlow/public/assets/img/products/botas/Nike-Tiempo-Maestro-Academy-2.png'),
(@bota2_id, 'soccerFlow/public/assets/img/products/botas/Nike-Tiempo-Maestro-Academy-3.png'),
(@bota2_id, 'soccerFlow/public/assets/img/products/botas/Nike-Tiempo-Maestro-Academy-4.png'),
(@bota3_id, 'soccerFlow/public/assets/img/products/botas/Nike-Tiempo-Ligera-ProLE-1.png'),
(@bota3_id, 'soccerFlow/public/assets/img/products/botas/Nike-Tiempo-Ligera-ProLE-2.png'),
(@bota3_id, 'soccerFlow/public/assets/img/products/botas/Nike-Tiempo-Ligera-ProLE-3.png'),
(@bota3_id, 'soccerFlow/public/assets/img/products/botas/Nike-Tiempo-Ligera-ProLE-4.png'),
(@bota4_id, 'soccerFlow/public/assets/img/products/botas/Nike-Premier3-1.png'),
(@bota4_id, 'soccerFlow/public/assets/img/products/botas/Nike-Premier3-2.png'),
(@bota4_id, 'soccerFlow/public/assets/img/products/botas/Nike-Premier3-3.png'),
(@bota4_id, 'soccerFlow/public/assets/img/products/botas/Nike-Premier3-4.png'),
(@bota5_id, 'soccerFlow/public/assets/img/products/botas/Nike-Phantom6-Low-Academy-1.png'),
(@bota5_id, 'soccerFlow/public/assets/img/products/botas/Nike-Phantom6-Low-Academy-2.png'),
(@bota5_id, 'soccerFlow/public/assets/img/products/botas/Nike-Phantom6-Low-Academy-3.png'),
(@bota5_id, 'soccerFlow/public/assets/img/products/botas/Nike-Phantom6-Low-Academy-4.png'),
(@bota6_id, 'soccerFlow/public/assets/img/products/botas/Adidas-F50-LEAGUE-1.png'),
(@bota6_id, 'soccerFlow/public/assets/img/products/botas/Adidas-F50-LEAGUE-2.png'),
(@bota6_id, 'soccerFlow/public/assets/img/products/botas/Adidas-F50-LEAGUE-3.png'),
(@bota6_id, 'soccerFlow/public/assets/img/products/botas/Adidas-F50-LEAGUE-4.png'),
(@bota7_id, 'soccerFlow/public/assets/img/products/botas/Adidas-PREDATOR-PRO-FOLD-OVER-Tongue-1.png'),
(@bota7_id, 'soccerFlow/public/assets/img/products/botas/Adidas-PREDATOR-PRO-FOLD-OVER-Tongue-2.png'),
(@bota7_id, 'soccerFlow/public/assets/img/products/botas/Adidas-PREDATOR-PRO-FOLD-OVER-Tongue-3.png'),
(@bota7_id, 'soccerFlow/public/assets/img/products/botas/Adidas-PREDATOR-PRO-FOLD-OVER-Tongue-4.png'),
(@bota8_id, 'soccerFlow/public/assets/img/products/botas/Adidas-COPA-PURE-IV-1.png'),
(@bota8_id, 'soccerFlow/public/assets/img/products/botas/Adidas-COPA-PURE-IV-2.png'),
(@bota8_id, 'soccerFlow/public/assets/img/products/botas/Adidas-COPA-PURE-IV-3.png'),
(@bota8_id, 'soccerFlow/public/assets/img/products/botas/Adidas-COPA-PURE-IV-4.png'),
(@bota9_id, 'soccerFlow/public/assets/img/products/botas/Adidas-Predator-Obsidian-Strike-1.png'),
(@bota9_id, 'soccerFlow/public/assets/img/products/botas/Adidas-Predator-Obsidian-Strike-2.png'),
(@bota9_id, 'soccerFlow/public/assets/img/products/botas/Adidas-Predator-Obsidian-Strike-3.png'),
(@bota9_id, 'soccerFlow/public/assets/img/products/botas/Adidas-Predator-Obsidian-Strike-4.png'),
(@bota10_id, 'soccerFlow/public/assets/img/products/botas/Puma-FUTURE8-MATCH-RE-CHARGE-1.png'),
(@bota10_id, 'soccerFlow/public/assets/img/products/botas/Puma-FUTURE8-MATCH-RE-CHARGE-2.png'),
(@bota10_id, 'soccerFlow/public/assets/img/products/botas/Puma-FUTURE8-MATCH-RE-CHARGE-3.png'),
(@bota10_id, 'soccerFlow/public/assets/img/products/botas/Puma-FUTURE8-MATCH-RE-CHARGE-4.png'),
(@bota11_id, 'soccerFlow/public/assets/img/products/botas/Puma-ULTRA6-MATCH-LIGHT-UP-1.png'),
(@bota11_id, 'soccerFlow/public/assets/img/products/botas/Puma-ULTRA6-MATCH-LIGHT-UP-2.png'),
(@bota11_id, 'soccerFlow/public/assets/img/products/botas/Puma-ULTRA6-MATCH-LIGHT-UP-3.png'),
(@bota11_id, 'soccerFlow/public/assets/img/products/botas/Puma-ULTRA6-MATCH-LIGHT-UP-4.png'),
(@bota12_id, 'soccerFlow/public/assets/img/products/botas/New-Balance-442-Pro-FG-V3-1.png'),
(@bota12_id, 'soccerFlow/public/assets/img/products/botas/New-Balance-442-Pro-FG-V3-2.png'),
(@bota12_id, 'soccerFlow/public/assets/img/products/botas/New-Balance-442-Pro-FG-V3-3.png'),
(@bota12_id, 'soccerFlow/public/assets/img/products/botas/New-Balance-442-Pro-FG-V3-4.png'),
(@bota13_id, 'soccerFlow/public/assets/img/products/botas/Under-Armour-Magnetico-Pro-5-FG-1.png'),
(@bota13_id, 'soccerFlow/public/assets/img/products/botas/Under-Armour-Magnetico-Pro-5-FG-2.png'),
(@bota13_id, 'soccerFlow/public/assets/img/products/botas/Under-Armour-Magnetico-Pro-5-FG-3.png'),
(@bota13_id, 'soccerFlow/public/assets/img/products/botas/Under-Armour-Magnetico-Pro-5-FG-4.png'),
(@bota14_id, 'soccerFlow/public/assets/img/products/botas/Joma-Aguila-Top-FG-1.png'),
(@bota14_id, 'soccerFlow/public/assets/img/products/botas/Joma-Aguila-Top-FG-2.png'),
(@bota14_id, 'soccerFlow/public/assets/img/products/botas/Joma-Aguila-Top-FG-3.png'),
(@bota14_id, 'soccerFlow/public/assets/img/products/botas/Joma-Aguila-Top-FG-4.png');

INSERT INTO products (name, description, price, brand, team, category, gender) VALUES
('Camiseta Real Madrid 2025/26 Local', 'Camiseta auténtica inspirada en el nuevo Bernabéu, con diseño premium y rendimiento profesional.', 129.99, 'Adidas', 'Real Madrid', 'camisetas', 'Masculino'),
('Camiseta Real Madrid 2025/26 Visitante', 'Camiseta auténtica inspirada en las noches del Bernabéu, con diseño metalizado y rendimiento profesional.', 119.99, 'Adidas', 'Real Madrid', 'camisetas', 'Femenino'),
('Camiseta FC Barcelona 2025/26 Local', 'Camiseta Stadium del Barça 25/26 con franjas degradadas y tecnología Dri‑FIT para máxima comodidad.', 124.99, 'Nike', 'FC Barcelona', 'camisetas', 'Masculino'),
('Camiseta FC Barcelona 2025/26 Visitante', 'Camiseta Barça x Kobe 25/26 con diseño inspirado en la mentalidad Mamba y tecnología Dri‑FIT.', 114.99, 'Nike', 'FC Barcelona', 'camisetas', 'Femenino'),
('Camiseta Atlético de Madrid 2025/26 Local', 'Camiseta del Atlético 25/26 con diseño clásico renovado y tecnología Dri‑FIT para máximo confort.', 99.99, 'Nike', 'Atlético de Madrid', 'camisetas', 'Masculino'),
('Camiseta Valencia CF 2025/26 Local', 'Camiseta del Valencia 25/26 con diseño blanco inspirado en el trencadís y tecnología ULTRAWEAVE ultraligera.', 109.99, 'Puma', 'Valencia CF', 'camisetas', 'Masculino'),
('Camiseta Valencia CF 2025/26 Alternativa', 'Camiseta Senyera 25/26 con diseño renovado y tecnología ULTRAWEAVE ultraligera.', 99.99, 'Puma', 'Valencia CF', 'camisetas', 'Masculino'),
('Camiseta Liverpool FC 2025/26 Local', 'Camiseta del Liverpool 25/26 con diseño clásico rojo‑blanco y tecnología AEROREADY para máxima comodidad.', 104.99, 'Adidas', 'Liverpool FC', 'camisetas', 'Masculino'),
('Camiseta Betis 2025/26 Local', 'Camiseta del Betis 25/26 con diseño retro, tejido Jacquard avanzado y máxima ligereza ULTRAWEAVE.', 99.99, 'Hummel', 'Real Betis Balon pie', 'camisetas', 'Femenino'),
('Camiseta España 2026 Local', 'Camiseta oficial de la selección española con tecnología AEROREADY', 114.99, 'Adidas', 'España', 'camisetas', 'unisex'),
('Camiseta Argentina 2026 Local', 'Camiseta oficial campeona del mundo con las 3 estrellas', 139.99, 'Adidas', 'Argentina', 'camisetas', 'unisex'),
('Camiseta Brasil 2026 Visitante', 'Camiseta oficial de la selección brasileña con tecnología Dri-FIT', 129.99, 'Nike', 'Brasil', 'camisetas', 'unisex'),
('Camiseta Manchester City 2025/26 Local', 'Camiseta del Manchester City 25/26 con la icónica faja celeste y tecnología dryCELL para máximo confort.', 119.99, 'Puma', 'Manchester City', 'camisetas', 'Masculino'),
('Camiseta Bayern Munich 2025/26 Portero', 'Camiseta del Bayern Munich oficial de portero', 114.99, 'Adidas', 'Bayern Munich', 'camisetas', 'Masculino'),
('Camiseta PSG 2025/26 Visitante', 'Camiseta tradicional roja con franjas blancas', 114.99, 'Nike', 'Paris Saint-Germain', 'camisetas', 'Femenino');


SET @realmadrid_local_id = (SELECT ID FROM products WHERE name = 'Camiseta Real Madrid 2025/26 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@realmadrid_local_id, 'S', 'Blanca', 12),
(@realmadrid_local_id, 'M', 'Blanca', 18),
(@realmadrid_local_id, 'L', 'Blanca', 20),
(@realmadrid_local_id, 'XL', 'Blanca', 15);

SET @realmadrid_visitante_id = (SELECT ID FROM products WHERE name = 'Camiseta Real Madrid 2025/26 Visitante');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@realmadrid_visitante_id, 'XS', 'Azul Marino', 10),
(@realmadrid_visitante_id, 'S', 'Azul Marino', 15),
(@realmadrid_visitante_id, 'M', 'Azul Marino', 23),
(@realmadrid_visitante_id, 'XL', 'Azul Marino', 17);

SET @barcelona_local_id = (SELECT ID FROM products WHERE name = 'Camiseta FC Barcelona 2025/26 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@barcelona_local_id, 'XS', 'Azul/Rojo', 14),
(@barcelona_local_id, 'M', 'Azul/Rojo', 18),
(@barcelona_local_id, 'L', 'Azul/Rojo', 19),
(@barcelona_local_id, 'XXL', 'Azul/Rojo', 16);

SET @barcelona_visitante_id = (SELECT ID FROM products WHERE name = 'Camiseta FC Barcelona 2025/26 Visitante');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@barcelona_visitante_id, 'XS', 'Amarillo', 14),
(@barcelona_visitante_id, 'S', 'Amarillo', 11),
(@barcelona_visitante_id, 'L', 'Amarillo', 17),
(@barcelona_visitante_id, 'XL', 'Amarillo', 22);

SET @ATM_id = (SELECT ID FROM products WHERE name = 'Camiseta Atlético de Madrid 2025/26 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@ATM_id, 'L', 'Blanco/Rojo', 13),
(@ATM_id, 'XL', 'Blanco/Rojo', 19),
(@ATM_id, 'XXL', 'Blanco/Rojo', 25);

SET @VCF_local_id = (SELECT ID FROM products WHERE name = 'Camiseta Valencia CF 2025/26 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@VCF_local_id, 'XS', 'Blanco', 16),
(@VCF_local_id, 'S', 'Blanco', 10),
(@VCF_local_id, 'L', 'Blanco', 18),
(@VCF_local_id, 'XL', 'Blanco', 12),
(@VCF_local_id, 'XXL', 'Blanco', 14);

SET @VCF_visitante_id = (SELECT ID FROM products WHERE name = 'Camiseta Valencia CF 2025/26 Alternativa');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@VCF_visitante_id, 'S', 'Azul/Rojo/Amarillo', 12),
(@VCF_visitante_id, 'M', 'Azul/Rojo/Amarillo', 21),
(@VCF_visitante_id, 'L', 'Azul/Rojo/Amarillo', 13);

SET @LVFC_id = (SELECT ID FROM products WHERE name = 'Camiseta Liverpool FC 2025/26 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@LVFC_id, 'S', 'Rojo', 22),
(@LVFC_id, 'M', 'Rojo', 17),
(@LVFC_id, 'L', 'Rojo', 14),
(@LVFC_id, 'XL', 'Rojo', 16);

SET @betis_id = (SELECT ID FROM products WHERE name = 'Camiseta Betis 2025/26 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@betis_id, 'XS', 'Verde/Blanco', 19),
(@betis_id, 'S', 'Verde/Blanco', 15),
(@betis_id, 'M', 'Verde/Blanco', 11);

SET @espana_id = (SELECT ID FROM products WHERE name = 'Camiseta España 2026 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@espana_id, 'S', 'Rojo', 25),
(@espana_id, 'M', 'Rojo', 20),
(@espana_id, 'XL', 'Rojo', 18),
(@espana_id, 'XXL', 'Rojo', 13);

SET @argentina_id = (SELECT ID FROM products WHERE name = 'Camiseta Argentina 2026 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@argentina_id, 'XS', 'Azul Celeste/Blanca', 17),
(@argentina_id, 'M', 'Azul Celeste/Blanca', 21),
(@argentina_id, 'L', 'Azul Celeste/Blanca', 13),
(@argentina_id, 'XXL', 'Azul Celeste/Blanca', 12);

SET @brasil_id = (SELECT ID FROM products WHERE name = 'Camiseta Brasil 2026 Visitante');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@brasil_id, 'M', 'Azul', 30),
(@brasil_id, 'L', 'Azul', 18),
(@brasil_id, 'XL', 'Azul', 19);

SET @manCity_id = (SELECT ID FROM products WHERE name = 'Camiseta Manchester City 2025/26 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@manCity_id, 'S', 'Azul Celeste', 14),
(@manCity_id, 'M', 'Azul Celeste', 16),
(@manCity_id, 'L', 'Azul Celeste', 12),
(@manCity_id, 'XL', 'Azul Celeste', 15);

SET @bayern_id = (SELECT ID FROM products WHERE name = 'Camiseta Bayern Munich 2025/26 Portero');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@bayern_id, 'M', 'Verde', 14),
(@bayern_id, 'L', 'Verde', 16),
(@bayern_id, 'XL', 'Verde', 12);

SET @psg_id = (SELECT ID FROM products WHERE name = 'Camiseta PSG 2025/26 Visitante');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@psg_id, 'S', 'Blanca/Azul/Rojo', 19),
(@psg_id, 'M', 'Blanca/Azul/Rojo', 11),
(@psg_id, 'L', 'Blanca/Azul/Rojo', 17),
(@psg_id, 'XXL', 'Blanca/Azul/Rojo', 18);

INSERT INTO product_images (product_id, image_url) VALUES
(@realmadrid_local_id, 'soccerFlow/public/assets/img/products/camisetas/Madrid-Local-1.png'),
(@realmadrid_local_id, 'soccerFlow/public/assets/img/products/camisetas/Madrid-Local-2.png'),
(@realmadrid_visitante_id, 'soccerFlow/public/assets/img/products/camisetas/Madrid-Visitante-1.png'),
(@realmadrid_visitante_id, 'soccerFlow/public/assets/img/products/camisetas/Madrid-Visitante-2.png'),
(@barcelona_local_id, 'soccerFlow/public/assets/img/products/camisetas/Barcelona-Local-1.png'),
(@barcelona_local_id, 'soccerFlow/public/assets/img/products/camisetas/Barcelona-Local-2.png'),
(@barcelona_visitante_id, 'soccerFlow/public/assets/img/products/camisetas/Barcelona-Visitante-1.png'),
(@barcelona_visitante_id, 'soccerFlow/public/assets/img/products/camisetas/Barcelona-Visitante-2.png'),
(@ATM_id, 'soccerFlow/public/assets/img/products/camisetas/ATM-1.png'),
(@ATM_id, 'soccerFlow/public/assets/img/products/camisetas/ATM-2.png'),
(@VCF_local_id, 'soccerFlow/public/assets/img/products/camisetas/VCF-Local-1.png'),
(@VCF_local_id, 'soccerFlow/public/assets/img/products/camisetas/VCF-Local-2.png'),
(@VCF_visitante_id, 'soccerFlow/public/assets/img/products/camisetas/VCF-Alternativa-1.png'),
(@VCF_visitante_id, 'soccerFlow/public/assets/img/products/camisetas/VCF-Alternativa-2.png'),
(@LVFC_id, 'soccerFlow/public/assets/img/products/camisetas/LVFC-1.png'),
(@LVFC_id, 'soccerFlow/public/assets/img/products/camisetas/LVFC-2.png'),
(@betis_id, 'soccerFlow/public/assets/img/products/camisetas/betis-1.png'),
(@betis_id, 'soccerFlow/public/assets/img/products/camisetas/betis-2.png'),
(@espana_id, 'soccerFlow/public/assets/img/products/camisetas/españa-1.png'),
(@espana_id, 'soccerFlow/public/assets/img/products/camisetas/españa-2.png'),
(@argentina_id, 'soccerFlow/public/assets/img/products/camisetas/argentina-1.png'),
(@argentina_id, 'soccerFlow/public/assets/img/products/camisetas/argentina-2.png'),
(@brasil_id, 'soccerFlow/public/assets/img/products/camisetas/brasil-1.png'),
(@brasil_id, 'soccerFlow/public/assets/img/products/camisetas/brasil-2.png'),
(@manCity_id, 'soccerFlow/public/assets/img/products/camisetas/City-1.png'),
(@manCity_id, 'soccerFlow/public/assets/img/products/camisetas/City-2.png'),
(@bayern_id, 'soccerFlow/public/assets/img/products/camisetas/bayern-1.png'),
(@bayern_id, 'soccerFlow/public/assets/img/products/camisetas/bayern-2.png'),
(@psg_id, 'soccerFlow/public/assets/img/products/camisetas/psg-1.png'),
(@psg_id, 'soccerFlow/public/assets/img/products/camisetas/psg-2.png');

INSERT INTO products (name, description, price, brand, team, category, gender) VALUES
('Adidas Predator League', 'Guantes adidas Predator League con palma URG 3.0 de gran agarre y ajuste estable para máximo control.', 70.00, 'Adidas', NULL, 'guantes', 'Masculino'),
('Nike Grip3', 'Guantes Nike Grip3 con espuma envolvente para mayor agarre, estabilidad y control en cada parada.', 69.99, 'Nike', NULL, 'guantes', 'Masculino'),
('Nike Match', 'Guantes con palma de espuma acolchada para absorber impactos, gran agarre y ventilación para mantener las manos frescas.', 29.99, 'Nike', NULL, 'guantes', 'Masculino'),
('Uhlsport Fangmaschine Aquagrip', 'Guantes Uhlsport Aquagrip HN con palma AQUAGRIP para máximo agarre en lluvia y corte negativo de gran comodidad.', 139.99, 'Uhlsport', NULL, 'guantes', 'Masculino'),
('Reusch Attrakt Freegel Fusion Goaliator', 'Guantes Reusch Attrakt Freegel Fusion Goaliator con palma Grip Fusion para agarre en cualquier clima, corte negativo y cierre AdaptiveFlex para ajuste profesional.', 129.99, 'Reusch', NULL, 'guantes', 'Masculino'),
('PUMA ULTRA Match Protect', 'Guantes PUMA con palma de látex de 3 mm para agarre superior, dorso flexible y protección en los 4 dedos para máxima seguridad en cada parada.', 60.00, 'Puma', NULL, 'guantes', 'Masculino'),
('Sells Total Contact Detonate Excel', 'Guantes Sells Total Contact Detonate Excel con palma Opti‑Response para agarre en cualquier clima, corte Total Contact envolvente y cierre de vendaje para máxima sujeción.', 60.00, 'Sells', NULL, 'guantes', 'Masculino'),
('New Balance Destroy Flat', 'Guantes New Balance Destroy Flat con látex Supersoft, tecnología Finger Sling y construcción ligera en textil y neopreno para un ajuste profesional y ultra cómodo.', 94.99, 'New Balance', NULL, 'guantes', 'Masculino'),
('Vende guantes Wrap Aqua Pure', 'Guantes españoles con látex alemán y protección de dedos', 59.99, 'Vende', NULL, 'guantes', 'Masculino'),
('Ho Soccer Infantil Rage Plus Electric', 'Guantes para entrenamiento con agarre seco y mojadoGuante diseñado específicamente para terrenos artificiales.', 24.99, 'Ho Soccer', NULL, 'guantes', 'unisex');

SET @guante1_id = (SELECT ID FROM products WHERE name = 'Adidas Predator League');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante1_id, '7', 'Limón lúcido / Blanco / Negro', 15),
(@guante1_id, '8', 'Limón lúcido / Blanco / Negro', 15),
(@guante1_id, '9', 'Limón lúcido / Blanco / Negro', 15),
(@guante1_id, '10', 'Limón lúcido / Blanco / Negro', 15),
(@guante1_id, '11', 'Limón lúcido / Blanco / Negro', 15);

SET @guante2_id = (SELECT ID FROM products WHERE name = 'Nike Grip3');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante2_id, '7', 'Azul / Negro / Rosa', 15),
(@guante2_id, '8', 'Azul / Negro / Rosa', 15),
(@guante2_id, '9', 'Azul / Negro / Rosa', 15),
(@guante2_id, '10', 'Azul / Negro / Rosa', 15),
(@guante2_id, '11', 'Azul / Negro / Rosa', 15);

SET @guante3_id = (SELECT ID FROM products WHERE name = 'Nike Match');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante3_id, '7', 'Negro / Blanco', 15),
(@guante3_id, '8', 'Negro / Blanco', 15),
(@guante3_id, '9', 'Negro / Blanco', 15),
(@guante3_id, '10', 'Negro / Blanco', 15),
(@guante3_id, '11', 'Negro / Blanco', 15);

SET @guante4_id = (SELECT ID FROM products WHERE name = 'Uhlsport Fangmaschine Aquagrip');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante4_id, '7', 'Azul marino oscuro', 15),
(@guante4_id, '8', 'Azul marino oscuro', 15),
(@guante4_id, '9', 'Azul marino oscuro', 15),
(@guante4_id, '10', 'Azul marino oscuro', 15),
(@guante4_id, '11', 'Azul marino oscuro', 15);

SET @guante5_id = (SELECT ID FROM products WHERE name = 'Reusch Attrakt Freegel Fusion Goaliator');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante5_id, '7', 'Azul / Naranja / Blanco', 15),
(@guante5_id, '8', 'Azul / Naranja / Blanco', 15),
(@guante5_id, '9', 'Azul / Naranja / Blanco', 15),
(@guante5_id, '10', 'Azul / Naranja / Blanco', 15),
(@guante5_id, '11', 'Azul / Naranja / Blanco', 15);

SET @guante6_id = (SELECT ID FROM products WHERE name = 'PUMA ULTRA Match Protect');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante6_id, '7', 'Amarillo / Negro', 15),
(@guante6_id, '8', 'Amarillo / Negro', 15),
(@guante6_id, '9', 'Amarillo / Negro', 15),
(@guante6_id, '10', 'Amarillo / Negro', 15),
(@guante6_id, '11', 'Amarillo / Negro', 15);

SET @guante7_id = (SELECT ID FROM products WHERE name = 'Sells Total Contact Detonate Excel');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante7_id, '7', 'Negro / Amarillo / Naranja', 15),
(@guante7_id, '8', 'Negro / Amarillo / Naranja', 15),
(@guante7_id, '9', 'Negro / Amarillo / Naranja', 15),
(@guante7_id, '10', 'Negro / Amarillo / Naranja', 15),
(@guante7_id, '11', 'Negro / Amarillo / Naranja', 15);

SET @guante8_id = (SELECT ID FROM products WHERE name = 'New Balance Destroy Flat');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante8_id, '7', 'Negro / Blanco / Azul', 15),
(@guante8_id, '8', 'Negro / Blanco / Azul', 15),
(@guante8_id, '9', 'Negro / Blanco / Azul', 15),
(@guante8_id, '10', 'Negro / Blanco / Azul', 15),
(@guante8_id, '11', 'Negro / Blanco / Azul', 15);

SET @guante9_id = (SELECT ID FROM products WHERE name = 'Vende guantes Wrap Aqua Pure');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante9_id, '7', 'Blanco / Azul Aqua', 15),
(@guante9_id, '8', 'Blanco / Azul Aqua', 15),
(@guante9_id, '9', 'Blanco / Azul Aqua', 15),
(@guante9_id, '10', 'Blanco / Azul Aqua', 15),
(@guante9_id, '11', 'Blanco / Azul Aqua', 15);

SET @guante10_id = (SELECT ID FROM products WHERE name = 'Ho Soccer Infantil Rage Plus Electric');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@guante10_id, '7', 'Negro / Blanco / Azul / Rojo', 15),
(@guante10_id, '8', 'Negro / Blanco / Azul / Rojo', 15),
(@guante10_id, '9', 'Negro / Blanco / Azul / Rojo', 15),
(@guante10_id, '10', 'Negro / Blanco / Azul / Rojo', 15),
(@guante10_id, '11', 'Negro / Blanco / Azul / Rojo', 15);

INSERT INTO product_images (product_id, image_url) VALUES
(@guante1_id, 'soccerFlow/public/assets/img/products/guantes/1-1.png'),
(@guante1_id, 'soccerFlow/public/assets/img/products/guantes/1-2.png'),
(@guante2_id, 'soccerFlow/public/assets/img/products/guantes/2-1.png'),
(@guante2_id, 'soccerFlow/public/assets/img/products/guantes/2-2.png'),
(@guante3_id, 'soccerFlow/public/assets/img/products/guantes/3-1.png'),
(@guante3_id, 'soccerFlow/public/assets/img/products/guantes/3-2.png'),
(@guante4_id, 'soccerFlow/public/assets/img/products/guantes/4-1.png'),
(@guante4_id, 'soccerFlow/public/assets/img/products/guantes/4-2.png'),
(@guante5_id, 'soccerFlow/public/assets/img/products/guantes/5-1.png'),
(@guante5_id, 'soccerFlow/public/assets/img/products/guantes/5-2.png'),
(@guante6_id, 'soccerFlow/public/assets/img/products/guantes/6-1.png'),
(@guante6_id, 'soccerFlow/public/assets/img/products/guantes/6-2.png'),
(@guante7_id, 'soccerFlow/public/assets/img/products/guantes/7-1.png'),
(@guante7_id, 'soccerFlow/public/assets/img/products/guantes/7-2.png'),
(@guante8_id, 'soccerFlow/public/assets/img/products/guantes/8-1.png'),
(@guante8_id, 'soccerFlow/public/assets/img/products/guantes/8-2.png'),
(@guante9_id, 'soccerFlow/public/assets/img/products/guantes/9-1.png'),
(@guante9_id, 'soccerFlow/public/assets/img/products/guantes/9-2.png'),
(@guante10_id, 'soccerFlow/public/assets/img/products/guantes/10-1.png'),
(@guante10_id, 'soccerFlow/public/assets/img/products/guantes/10-2.png');

INSERT INTO products (name, description, price, brand, team, category, gender) VALUES
('Chandal Real Madrid 2025/26', 'Chándal adidas del Real Madrid 25/26 con escudo oficial y tecnología AEROREADY para máxima comodidad.', 130.00, 'Adidas', 'Real Madrid', 'chandals', 'Masculino'),
('Chandal FC Barcelona 2025/26', 'Chándal de entrenamiento del FC Barcelona con tecnología Nike Dri‑FIT, escudo oficial y diseño con chaqueta de cremallera y pantalón ajustable.', 139.99, 'Nike', 'FC Barcelona', 'chandals', 'Masculino'),
('Chandal Valencia CF 2025/26', 'Luce los colores de tu equipo con la colección de paseo 25/26.', 109.99, 'Puma', 'Valencia CF', 'chandals', 'Masculino'),
('Chandal Manchester City 2025/26', 'Sudadera y pantalones del Manchester City, cómodos y cálidos, ideales para relajarte mientras muestras tu orgullo Cityzen.', 94.99, 'Puma', 'Manchester City', 'chandals', 'Masculino'),
('Chandal Bayern Munich 2025/26', 'Conjunto casual deportivo con sudadera y pantalón', 89.99, NULL, 'Bayern Munich', 'chandals', 'unisex'),
('Chandal PSG 2025/26', 'Consigue el estilo de tus jugadores preferidos del equipo.', 82.99, 'Nike', 'PSG', 'chandals', 'Masculino'),
('Chandal Atletico de Madrid 2025/26', 'Chándal de entrenamiento, con diseño Nike moderno que combina estilo y rendimiento para lucir la esencia rojiblanca.', 111.99, 'Nike', 'Atletico de Madrid', 'chandals', 'unisex'),
('Chandal Chelsea 2025/26', 'Conjunto de entrenamiento Nike con ajuste ceñido, tejido elástico y tecnología Dri‑FIT para mantenerte seco y moverte con libertad.', 75.00, 'Nike', 'Chelsea', 'chandals', 'unisex'),
('Chandal Inter de Milan 2025/26', 'Chándal del Inter con tejido Woven ligero y cómodo, ideal para entrenar o relajarte con el estilo clásico de Nike.', 137.99, 'Nike', 'Inter de Milan', 'chandals', 'Masculino'),
('Chandal Francia 2026', 'Chándal de fútbol de tejido Knit Nike Dri-FIT - Hombre', 97.99, 'Nike', 'Francia', 'chandals', 'Masculino');

SET @chandal_realmadrid_id = (SELECT ID FROM products WHERE name = 'Chandal Real Madrid 2025/26');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_realmadrid_id, 'S', 'Verde Lima / Caqui Oscuro', 18),
(@chandal_realmadrid_id, 'M', 'Verde Lima / Caqui Oscuro', 22),
(@chandal_realmadrid_id, 'L', 'Verde Lima / Caqui Oscuro', 15),
(@chandal_realmadrid_id, 'XL', 'Verde Lima / Caqui Oscuro', 20);

SET @chandal_barcelona_id = (SELECT ID FROM products WHERE name = 'Chandal FC Barcelona 2025/26');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_barcelona_id, 'XS', 'Negro / Escarlata', 25),
(@chandal_barcelona_id, 'M', 'Negro / Escarlata', 19),
(@chandal_barcelona_id, 'L', 'Negro / Escarlata', 14),
(@chandal_barcelona_id, 'XXL', 'Negro / Escarlata', 16);

SET @chandal_valencia_id = (SELECT ID FROM products WHERE name = 'Chandal Valencia CF 2025/26');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_valencia_id, 'XS', 'Negro / Naranja', 17),
(@chandal_valencia_id, 'S', 'Negro / Naranja', 23),
(@chandal_valencia_id, 'XL', 'Negro / Naranja', 21),
(@chandal_valencia_id, 'XXL', 'Negro / Naranja', 13);

SET @chandal_mancity_id = (SELECT ID FROM products WHERE name = 'Chandal Manchester City 2025/26');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_mancity_id, 'S', 'Negro / Azul Celeste', 24),
(@chandal_mancity_id, 'M', 'Negro / Azul Celeste', 27),
(@chandal_mancity_id, 'L', 'Negro / Azul Celeste', 18),
(@chandal_mancity_id, 'XL', 'Negro / Azul Celeste', 15);

SET @chandal_bayern_id = (SELECT ID FROM products WHERE name = 'Chandal Bayern Munich 2025/26');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_bayern_id, 'S', 'Negro / Rojo', 26),
(@chandal_bayern_id, 'M', 'Negro / Rojo', 30),
(@chandal_bayern_id, 'XL', 'Negro / Rojo', 19),
(@chandal_bayern_id, 'XXL', 'Negro / Rojo', 14);

SET @chandal_psg_id = (SELECT ID FROM products WHERE name = 'Chandal PSG 2025/26');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_psg_id, 'XS', 'Azul Marino / Rojo', 16),
(@chandal_psg_id, 'M', 'Azul Marino / Rojo', 22),
(@chandal_psg_id, 'L', 'Azul Marino / Rojo', 20),
(@chandal_psg_id, 'XXL', 'Azul Marino / Rojo', 13);

SET @chandal_atm_id = (SELECT ID FROM products WHERE name = 'Chandal Atletico de Madrid 2025/26');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_atm_id, 'S', 'Gris / Rojo', 28),
(@chandal_atm_id, 'M', 'Gris / Rojo', 25),
(@chandal_atm_id, 'L', 'Gris / Rojo', 21),
(@chandal_atm_id, 'XL', 'Gris / Rojo', 17);

SET @chandal_chelsea_id = (SELECT ID FROM products WHERE name = 'Chandal Chelsea 2025/26');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_chelsea_id, 'XS', 'Verde', 19),
(@chandal_chelsea_id, 'S', 'Verde', 23),
(@chandal_chelsea_id, 'M', 'Verde', 26),
(@chandal_chelsea_id, 'XL', 'Verde', 15);

SET @chandal_inter_id = (SELECT ID FROM products WHERE name = 'Chandal Inter de Milan 2025/26');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_inter_id, 'M', 'Negro / Azul', 29),
(@chandal_inter_id, 'L', 'Negro / Azul', 24),
(@chandal_inter_id, 'XL', 'Negro / Azul', 18);

SET @chandal_francia_id = (SELECT ID FROM products WHERE name = 'Chandal Francia 2026');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_francia_id, 'XS', 'Azul Marino / Blanco', 20),
(@chandal_francia_id, 'S', 'Azul Marino / Blanco', 27),
(@chandal_francia_id, 'L', 'Azul Marino / Blanco', 22),
(@chandal_francia_id, 'XL', 'Azul Marino / Blanco', 16);


INSERT INTO product_images (product_id, image_url) VALUES
(@chandal_realmadrid_id, 'soccerFlow/public/assets/img/products/chandals/1-1.png'),
(@chandal_realmadrid_id, 'soccerFlow/public/assets/img/products/chandals/1-2.png'),
(@chandal_realmadrid_id, 'soccerFlow/public/assets/img/products/chandals/1-3.png'),
(@chandal_barcelona_id, 'soccerFlow/public/assets/img/products/chandals/2-1.png'),
(@chandal_barcelona_id, 'soccerFlow/public/assets/img/products/chandals/2-2.png'),
(@chandal_barcelona_id, 'soccerFlow/public/assets/img/products/chandals/2-3.webp'),
(@chandal_valencia_id, 'soccerFlow/public/assets/img/products/chandals/3-1.png'),
(@chandal_valencia_id, 'soccerFlow/public/assets/img/products/chandals/3-2.png'),
(@chandal_valencia_id, 'soccerFlow/public/assets/img/products/chandals/3-3.png'),
(@chandal_mancity_id, 'soccerFlow/public/assets/img/products/chandals/4-1.png'),
(@chandal_mancity_id, 'soccerFlow/public/assets/img/products/chandals/4-2.png'),
(@chandal_mancity_id, 'soccerFlow/public/assets/img/products/chandals/4-3.png'),
(@chandal_bayern_id, 'soccerFlow/public/assets/img/products/chandals/5-1.png'),
(@chandal_bayern_id, 'soccerFlow/public/assets/img/products/chandals/5-2.png'),
(@chandal_bayern_id, 'soccerFlow/public/assets/img/products/chandals/5-3.png'),
(@chandal_psg_id, 'soccerFlow/public/assets/img/products/chandals/6-1.png'),
(@chandal_psg_id, 'soccerFlow/public/assets/img/products/chandals/6-2.png'),
(@chandal_psg_id, 'soccerFlow/public/assets/img/products/chandals/6-3.png'),
(@chandal_atm_id, 'soccerFlow/public/assets/img/products/chandals/7-1.png'),
(@chandal_atm_id, 'soccerFlow/public/assets/img/products/chandals/7-2.png'),
(@chandal_atm_id, 'soccerFlow/public/assets/img/products/chandals/7-3.png'),
(@chandal_chelsea_id, 'soccerFlow/public/assets/img/products/chandals/8-1.png'),
(@chandal_chelsea_id, 'soccerFlow/public/assets/img/products/chandals/8-2.png'),
(@chandal_chelsea_id, 'soccerFlow/public/assets/img/products/chandals/8-3.png'),
(@chandal_inter_id, 'soccerFlow/public/assets/img/products/chandals/9-1.png'),
(@chandal_inter_id, 'soccerFlow/public/assets/img/products/chandals/9-2.png'),
(@chandal_inter_id, 'soccerFlow/public/assets/img/products/chandals/9-3.png'),
(@chandal_francia_id, 'soccerFlow/public/assets/img/products/chandals/10-1.png'),
(@chandal_francia_id, 'soccerFlow/public/assets/img/products/chandals/10-2.png'),
(@chandal_francia_id, 'soccerFlow/public/assets/img/products/chandals/10-3.avif');


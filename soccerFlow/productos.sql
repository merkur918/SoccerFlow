-- 1. Insertar categorías
INSERT INTO categories (name, description) VALUES
('botas', 'Botas de fútbol para diferentes tipos de terreno'),
('camisetas', 'Camisetas oficiales de equipos'),
('guantes', 'Guantes de portero y de entrenamiento'),
('chandals', 'Conjuntos deportivos para entrenamiento');

-- 2. Insertar 15 botas
INSERT INTO products (name, description, price, brand, categorie_id, gender) VALUES
('Nike Mercurial Vapor 15 Elite FG', 'Botas de velocidad elite para terreno firme con tecnología Flyknit y placa Speed', 299.99, 'Nike', 
 (SELECT ID FROM categories WHERE name = 'botas'), 'male'),
('Adidas Predator Accuracy+ FG', 'Botas de precisión premium con Demonskin 2.0 y suela Primeknit', 279.99, 'Adidas',
 (SELECT ID FROM categories WHERE name = 'botas'), 'male'),
('Nike Phantom GX2 Elite FG', 'Botas para creatividad con tejido Gripknit y suela Dynamic Fit', 289.99, 'Nike',
 (SELECT ID FROM categories WHERE name = 'botas'), 'male'),
('Puma Future 7 Match FG/AG', 'Botas versátiles con sistema FUZIONFIT+ y suela mixta', 179.99, 'Puma',
 (SELECT ID FROM categories WHERE name = 'botas'), 'male'),
('Adidas X Speedportal.3 FG', 'Botas ligeras para velocidad con suela Carbón', 159.99, 'Adidas',
 (SELECT ID FROM categories WHERE name = 'botas'), 'male'),
('Nike Tiempo Legend 10 Academy FG', 'Botas de cuero kanguro premium para máximo control', 169.99, 'Nike',
 (SELECT ID FROM categories WHERE name = 'botas'), 'male'),
('Mizuno Morelia Neo IV Beta AG', 'Botas ligeras japonesas con cuero kanguro y suela AG', 129.99, 'Mizuno',
 (SELECT ID FROM categories WHERE name = 'botas'), 'male'),
('New Balance Furon v7 Pro FG', 'Botas de ataque con tecnología Hypoknit y Kinetic Stitch', 119.99, 'New Balance',
 (SELECT ID FROM categories WHERE name = 'botas'), 'male'),
('Under Armour Magnetico Pro 2 FG', 'Botas con tecnología FormTrue para mejor ajuste', 109.99, 'Under Armour',
 (SELECT ID FROM categories WHERE name = 'botas'), 'male'),
('Nike Phantom Luna 2 Elite FG', 'Botas diseñadas específicamente para mujer con Gripknit', 269.99, 'Nike',
 (SELECT ID FROM categories WHERE name = 'botas'), 'female'),
('Adidas Predator Edge.3 FG Mujer', 'Botas de precisión para mujer con ajuste optimizado', 149.99, 'Adidas',
 (SELECT ID FROM categories WHERE name = 'botas'), 'female'),
('Puma Ultra Playmaker IT Mujer', 'Botas ligeras para mujer con tecnología Grip Control Pro', 139.99, 'Puma',
 (SELECT ID FROM categories WHERE name = 'botas'), 'female'),
('Adidas Copa Pure.3 TF', 'Botas para césped artificial con cuero sintético premium', 89.99, 'Adidas',
 (SELECT ID FROM categories WHERE name = 'botas'), 'unisex'),
('Nike Premier 3 FG', 'Botas clásicas de cuero kanguro retro, diseño italiano', 99.99, 'Nike',
 (SELECT ID FROM categories WHERE name = 'botas'), 'unisex'),
('Joma Maxima FG', 'Botas profesionales con cuero microfibras y sistema air cool', 79.99, 'Joma',
 (SELECT ID FROM categories WHERE name = 'botas'), 'unisex');

-- Insertar variantes para cada bota (ejemplo para las primeras 3)
-- Para Nike Mercurial Vapor 15 Elite FG
SET @bota1_id = (SELECT ID FROM products WHERE name = 'Nike Mercurial Vapor 15 Elite FG');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota1_id, '40', 'Azul eléctrico/Naranja', 8),
(@bota1_id, '41', 'Azul eléctrico/Naranja', 10),
(@bota1_id, '42', 'Azul eléctrico/Naranja', 12),
(@bota1_id, '43', 'Azul eléctrico/Naranja', 6),
(@bota1_id, '44', 'Azul eléctrico/Naranja', 4);

-- Para Adidas Predator Accuracy+ FG
SET @bota2_id = (SELECT ID FROM products WHERE name = 'Adidas Predator Accuracy+ FG');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota2_id, '39', 'Blanco/Negro/Rojo', 7),
(@bota2_id, '40', 'Blanco/Negro/Rojo', 9),
(@bota2_id, '41', 'Blanco/Negro/Rojo', 11),
(@bota2_id, '42', 'Blanco/Negro/Rojo', 13),
(@bota2_id, '43', 'Blanco/Negro/Rojo', 5),
(@bota2_id, '44', 'Blanco/Negro/Rojo', 3);

-- Para Nike Phantom GX2 Elite FG
SET @bota3_id = (SELECT ID FROM products WHERE name = 'Nike Phantom GX2 Elite FG');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@bota3_id, '40', 'Verde limón/Negro', 6),
(@bota3_id, '41', 'Verde limón/Negro', 8),
(@bota3_id, '42', 'Verde limón/Negro', 10),
(@bota3_id, '43', 'Verde limón/Negro', 7),
(@bota3_id, '44', 'Verde limón/Negro', 4);

-- Insertar imágenes de ejemplo
INSERT INTO product_images (product_id, image_url) VALUES
(@bota1_id, '/img/products/botas/nike-mercurial-vapor-15-1.jpg'),
(@bota1_id, '/img/products/botas/nike-mercurial-vapor-15-2.jpg'),
(@bota1_id, '/img/products/botas/nike-mercurial-vapor-15-3.jpg'),
(@bota2_id, '/img/products/botas/adidas-predator-accuracy-1.jpg'),
(@bota2_id, '/img/products/botas/adidas-predator-accuracy-2.jpg'),
(@bota3_id, '/img/products/botas/nike-phantom-gx2-1.jpg'),
(@bota3_id, '/img/products/botas/nike-phantom-gx2-2.jpg');

-- Insertar las 15 camisetas
INSERT INTO products (name, description, price, brand, team, categorie_id, gender) VALUES
('Camiseta Real Madrid 2023/24 Local', 'Camiseta oficial local temporada 2023/24 con tecnología AEROREADY', 129.99, 'Adidas', 'Real Madrid',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'male'),
('Camiseta FC Barcelona 2023/24 Local', 'Camiseta local oficial con tecnología Dri-FIT Advance', 124.99, 'Nike', 'FC Barcelona',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'male'),
('Camiseta Atlético de Madrid 2023/24 Local', 'Camiseta oficial local con diseño tradicional rojiblanco', 119.99, 'Nike', 'Atlético de Madrid',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'male'),
('Camiseta Valencia CF 2023/24 Local', 'Camiseta local oficial con el tradicional color naranja y negro', 109.99, 'Puma', 'Valencia CF',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'male'),
('Camiseta Sevilla FC 2023/24 Local', 'Camiseta oficial local con tecnología AEROREADY', 104.99, 'Castore', 'Sevilla FC',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'male'),
('Camiseta Athletic Club 2023/24 Local', 'Camiseta tradicional de rayas rojiblancas', 99.99, 'New Balance', 'Athletic Club',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'male'),
('Camiseta España 2024 Local', 'Camiseta oficial de la selección española con tecnología AEROREADY', 114.99, 'Adidas', 'España',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'unisex'),
('Camiseta Argentina 2024 Local', 'Camiseta oficial campeona del mundo con las 3 estrellas', 139.99, 'Adidas', 'Argentina',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'unisex'),
('Camiseta Brasil 2024 Local', 'Camiseta oficial de la selección brasileña con tecnología Dri-FIT', 129.99, 'Nike', 'Brasil',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'unisex'),
('Camiseta Manchester City 2023/24 Local', 'Camiseta oficial del campeón de la Champions', 119.99, 'Puma', 'Manchester City',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'male'),
('Camiseta Bayern Munich 2023/24 Local', 'Camiseta tradicional roja con franjas blancas', 114.99, 'Adidas', 'Bayern Munich',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'male'),
('Camiseta PSG 2023/24 Local', 'Camiseta oficial con diseño inspirado en París', 109.99, 'Nike', 'PSG',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'male'),
('Camiseta Real Madrid 2023/24 Mujer', 'Camiseta local oficial con corte específico para mujer', 119.99, 'Adidas', 'Real Madrid',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'female'),
('Camiseta FC Barcelona 2023/24 Visitante', 'Camiseta oficial visitante color granate', 114.99, 'Nike', 'FC Barcelona',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'unisex'),
('Camiseta Valencia CF 2023/24 Visitante', 'Camiseta visitante oficial color blanco con detalles naranjas', 99.99, 'Puma', 'Valencia CF',
 (SELECT ID FROM categories WHERE name = 'camisetas'), 'unisex');

-- Insertar variantes para las camisetas del Valencia (ejemplo)
-- Para Camiseta Valencia CF Local
SET @valencia_local_id = (SELECT ID FROM products WHERE name = 'Camiseta Valencia CF 2023/24 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@valencia_local_id, 'S', 'Naranja', 15),
(@valencia_local_id, 'M', 'Naranja', 20),
(@valencia_local_id, 'L', 'Naranja', 25),
(@valencia_local_id, 'XL', 'Naranja', 12),
(@valencia_local_id, 'XXL', 'Naranja', 8);

-- Para Camiseta Valencia CF Visitante
SET @valencia_visitante_id = (SELECT ID FROM products WHERE name = 'Camiseta Valencia CF 2023/24 Visitante');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@valencia_visitante_id, 'XS', 'Blanco', 10),
(@valencia_visitante_id, 'S', 'Blanco', 15),
(@valencia_visitante_id, 'M', 'Blanco', 20),
(@valencia_visitante_id, 'L', 'Blanco', 18),
(@valencia_visitante_id, 'XL', 'Blanco', 10);

-- Insertar variantes para Real Madrid (ejemplo)
SET @real_madrid_id = (SELECT ID FROM products WHERE name = 'Camiseta Real Madrid 2023/24 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@real_madrid_id, 'S', 'Blanco', 25),
(@real_madrid_id, 'M', 'Blanco', 30),
(@real_madrid_id, 'L', 'Blanco', 35),
(@real_madrid_id, 'XL', 'Blanco', 20),
(@real_madrid_id, 'XXL', 'Blanco', 15),
(@real_madrid_id, 'M', 'Blanco (Edición Jugador)', 12),
(@real_madrid_id, 'L', 'Blanco (Edición Jugador)', 10);

-- Insertar variantes para España
SET @espana_id = (SELECT ID FROM products WHERE name = 'Camiseta España 2024 Local');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@espana_id, 'XS', 'Rojo', 12),
(@espana_id, 'S', 'Rojo', 18),
(@espana_id, 'M', 'Rojo', 22),
(@espana_id, 'L', 'Rojo', 20),
(@espana_id, 'XL', 'Rojo', 15),
(@espana_id, 'S', 'Rojo (Edición Fans)', 25),
(@espana_id, 'M', 'Rojo (Edición Fans)', 30);

-- Insertar imágenes de ejemplo para las camisetas
INSERT INTO product_images (product_id, image_url) VALUES
(@valencia_local_id, '/img/products/camisetas/valencia-local-1.jpg'),
(@valencia_local_id, '/img/products/camisetas/valencia-local-2.jpg'),
(@valencia_local_id, '/img/products/camisetas/valencia-local-3.jpg'),
(@valencia_visitante_id, '/img/products/camisetas/valencia-visitante-1.jpg'),
(@valencia_visitante_id, '/img/products/camisetas/valencia-visitante-2.jpg'),
(@real_madrid_id, '/img/products/camisetas/real-madrid-local-1.jpg'),
(@real_madrid_id, '/img/products/camisetas/real-madrid-local-2.jpg'),
(@espana_id, '/img/products/camisetas/espana-2024-1.jpg'),
(@espana_id, '/img/products/camisetas/espana-2024-2.jpg');

-- Insertar 15 guantes
INSERT INTO products (name, description, price, brand, team, categorie_id, gender) VALUES
('Adidas Predator Pro Hybrid', 'Guantes profesionales con palma URG 3.0 Hybrid y corte negativo', 169.99, 'Adidas', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('Nike Vapor Grip3 Pro', 'Guantes elite con tecnología Grip3 y sistema de ajuste Dynamic Fit', 159.99, 'Nike', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('Uhlsport Eliminator Supergrip+', 'Guantes profesionales con tecnología Supergrip+ y Flex Frame', 179.99, 'Uhlsport', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('Reusch Attrakt Freegel Pro', 'Guantes con tecnología Freegel 3.0 y sistema de ventilación Attrakt', 139.99, 'Reusch', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('Puma Future Pro Ultra Grip', 'Guantes con tecnología Ultra Grip y corte híbrido', 129.99, 'Puma', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('Sells Total Contact Pro', 'Guantes con palma de látex alemán premium y sistema Aqua Repel', 149.99, 'Sells', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('Mizuno Morelia Neo Grip', 'Guantes japoneses con látex Contact Grip y diseño ergonómico', 99.99, 'Mizuno', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('New Balance Furon Pro Grip', 'Guantes con tecnología Hypoknit y sistema de ajuste Jet', 89.99, 'New Balance', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('Kaliaaer Condor Carbon Pro', 'Guantes españoles con látex alemán y protección de dedos', 109.99, 'Kaliaaer', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('Adidas Predator League TF Mujer', 'Guantes para mujer con palma URG 2.0 y diseño específico', 79.99, 'Adidas', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'female'),
('Nike Vapor Match Jr', 'Guantes junior para entrenamiento con tecnología Grip2', 59.99, 'Nike', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'unisex'),
('Puma Future Match Mujer', 'Guantes para mujer con tecnología Grip Control y ajuste Comfort', 69.99, 'Puma', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'female'),
('Storelli Gladiator Elite', 'Guantes con protección máxima y sistema de impacto reducido', 119.99, 'Storelli', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'male'),
('Joma Top Flex Pro', 'Guantes profesionales con látex alemán y sistema de ventilación', 74.99, 'Joma', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'unisex'),
('Decathlon Kipsta F500', 'Guantes para entrenamiento con agarre seco y mojado', 49.99, 'Kipsta', NULL,
 (SELECT ID FROM categories WHERE name = 'guantes'), 'unisex');

-- Insertar 15 chandals
INSERT INTO products (name, description, price, brand, team, categorie_id, gender) VALUES
('Chandal Real Madrid 2023/24 Entrenamiento', 'Conjunto oficial de entrenamiento completo', 159.99, 'Adidas', 'Real Madrid',
 (SELECT ID FROM categories WHERE name = 'chandals'), 'male'),
('Chandal FC Barcelona 2023/24 Tercera', 'Conjunto tercera equipación para entrenamientos', 149.99, 'Nike', 'FC Barcelona',
 (SELECT ID FROM categories WHERE name = 'chandals'), 'male'),
('Chandal Atlético de Madrid 2023/24 Entrenamiento', 'Conjunto oficial rojiblanco de entrenamiento', 139.99, 'Nike', 'Atlético de Madrid',
 (SELECT ID FROM categories WHERE name = 'chandals'), 'male'),
('Chandal Valencia CF 2023/24 Entrenamiento', 'Conjunto oficial naranja y negro para entrenar', 129.99, 'Puma', 'Valencia CF',
 (SELECT ID FROM categories WHERE name = 'chandals'), 'male'),
('Chandal Nike Sportswear Club Fleece', 'Conjunto casual deportivo con sudadera y pantalón', 89.99, 'Nike', NULL,
 (SELECT ID FROM categories WHERE name = 'chandals'), 'unisex'),
('Chandal Adidas Tiro 24 Training', 'Conjunto profesional para entrenamiento con tecnología AEROREADY', 119.99, 'Adidas', NULL,
 (SELECT ID FROM categories WHERE name = 'chandals'), 'male'),
('Chandal España 2024 Entrenamiento', 'Conjunto oficial de la selección española', 134.99, 'Adidas', 'España',
 (SELECT ID FROM categories WHERE name = 'chandals'), 'unisex'),
('Chandal Argentina 2024 Entrenamiento', 'Conjunto del campeón del mundo con 3 estrellas', 144.99, 'Adidas', 'Argentina',
 (SELECT ID FROM categories WHERE name = 'chandals'), 'unisex'),
('Chandal Manchester City Entrenamiento', 'Conjunto oficial del campeón de Europa', 139.99, 'Puma', 'Manchester City',
 (SELECT ID FROM categories WHERE name = 'chandals'), 'male'),
('Chandal Real Madrid 2023/24 Mujer', 'Conjunto de entrenamiento con corte específico para mujer', 149.99, 'Adidas', 'Real Madrid',
 (SELECT ID FROM categories WHERE name = 'chandals'), 'female'),
('Chandal Nike Sportswear Mujer', 'Conjunto deportivo casual con diseño femenino', 79.99, 'Nike', NULL,
 (SELECT ID FROM categories WHERE name = 'chandals'), 'female'),
('Chandal Puma Teamtraining Mujer', 'Conjunto para entrenamiento con tecnología dryCELL', 99.99, 'Puma', NULL,
 (SELECT ID FROM categories WHERE name = 'chandals'), 'female'),
('Chandal Under Armour Rival Fleece', 'Conjunto térmico para clima frío con tecnología ColdGear', 109.99, 'Under Armour', NULL,
 (SELECT ID FROM categories WHERE name = 'chandals'), 'unisex'),
('Chandal New Balance Essential', 'Conjunto básico de entrenamiento con tejido transpirable', 69.99, 'New Balance', NULL,
 (SELECT ID FROM categories WHERE name = 'chandals'), 'unisex'),
('Chandal Kappa Heritage Track', 'Conjunto retro de los 90s con diseño vintage', 89.99, 'Kappa', NULL,
 (SELECT ID FROM categories WHERE name = 'chandals'), 'unisex');

-- Insertar variantes para guantes (tallas de guante)
SET @guante1_id = (SELECT ID FROM products WHERE name = 'Adidas Predator Pro Hybrid');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@guante1_id, '8', 'Negro/Rojo', 8),
(@guante1_id, '9', 'Negro/Rojo', 12),
(@guante1_id, '10', 'Negro/Rojo', 10),
(@guante1_id, '11', 'Negro/Rojo', 6);

SET @guante2_id = (SELECT ID FROM products WHERE name = 'Nike Vapor Grip3 Pro');
INSERT INTO products_variants (product_id, size_shoe, color, stock) VALUES
(@guante2_id, '7', 'Naranja/Negro', 6),
(@guante2_id, '8', 'Naranja/Negro', 10),
(@guante2_id, '9', 'Naranja/Negro', 12),
(@guante2_id, '10', 'Naranja/Negro', 8);

-- Insertar variantes para chandals (tallas de ropa)
SET @chandal_valencia_id = (SELECT ID FROM products WHERE name = 'Chandal Valencia CF 2023/24 Entrenamiento');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_valencia_id, 'S', 'Naranja/Negro', 10),
(@chandal_valencia_id, 'M', 'Naranja/Negro', 15),
(@chandal_valencia_id, 'L', 'Naranja/Negro', 20),
(@chandal_valencia_id, 'XL', 'Naranja/Negro', 12),
(@chandal_valencia_id, 'XXL', 'Naranja/Negro', 8);

SET @chandal_espana_id = (SELECT ID FROM products WHERE name = 'Chandal España 2024 Entrenamiento');
INSERT INTO products_variants (product_id, size, color, stock) VALUES
(@chandal_espana_id, 'XS', 'Rojo/Azul', 8),
(@chandal_espana_id, 'S', 'Rojo/Azul', 12),
(@chandal_espana_id, 'M', 'Rojo/Azul', 18),
(@chandal_espana_id, 'L', 'Rojo/Azul', 15),
(@chandal_espana_id, 'XL', 'Rojo/Azul', 10);

-- Insertar imágenes
INSERT INTO product_images (product_id, image_url) VALUES
(@guante1_id, '/img/products/guantes/adidas-predator-pro-1.jpg'),
(@guante1_id, '/img/products/guantes/adidas-predator-pro-2.jpg'),
(@guante2_id, '/img/products/guantes/nike-vapor-grip3-1.jpg'),
(@chandal_valencia_id, '/img/products/chandals/valencia-chandal-1.jpg'),
(@chandal_valencia_id, '/img/products/chandals/valencia-chandal-2.jpg'),
(@chandal_espana_id, '/img/products/chandals/espana-chandal-1.jpg'),
(@chandal_espana_id, '/img/products/chandals/espana-chandal-2.jpg');
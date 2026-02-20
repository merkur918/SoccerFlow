# SoccerFlow
Trabajo final de grado
Proyecto TFG: plataforma web de futbol con tienda de productos, autenticacion con verificacion de email y modulo de competiciones/noticias via API externa.

## Vista rapida
- Front controller con rutas limpias en `public/index.php`
- Arquitectura tipo MVC simple (`app/Controllers`, `app/Models`, `app/Views`)
- Autenticacion con sesiones, registro, login, verificacion de email y reset de password
- Catalogo de productos con filtros y detalle
- API interna para auth y noticias deportivas
- Docker con Apache + PHP 8.2 + MySQL 8

## Requisitos
- Docker Desktop o compatible (recomendado)
- Alternativa local: PHP 8.2 + MySQL 8 + Apache con mod_rewrite

## Arranque rapido (Docker)
1. Levantar contenedores
```bash
cd soccerFlow
docker compose up --build
```
2. Abrir la app
- Web: `http://localhost:8080`
-- Web (HTTPS): `https://localhost:8443`
- phpMyAdmin: `http://localhost:8081` (host: `db`, user: `root`, pass: `root`)

## Base de datos
El esquema esta en `soccerFlow/script_db.sql`.

Ejemplo de carga:
```bash
docker exec -i mysql_db mysql -uroot -proot < soccerFlow/script_db.sql
```

## Variables de entorno
La API de noticias usa `FOOTBALL_DATA_TOKEN`.

Crear un `.env` en `soccerFlow/.env`:
```
FOOTBALL_DATA_TOKEN=tu_token
```

## Estructura del proyecto
- `soccerFlow/public/` entrada web y assets
- `soccerFlow/app/Controllers/` controladores web y API
- `soccerFlow/app/Models/` acceso a datos
- `soccerFlow/app/Views/` vistas HTML
- `soccerFlow/app/Core/` autoload, sesiones, DB
- `soccerFlow/app/libs/` helpers y mail
- `soccerFlow/docker/` configuracion Apache/PHP

## Rutas principales (web)
- `/home`
- `/register` / `/register_post`
- `/login` / `/login_post`
- `/logout`
- `/verify-email`
- `/passw` / `/email_post`
- `/password-verify` / `/password_post`
- `/productos`
- `/product-details?id=...`
- `/competiciones`
- `/noticias`
- `/cart`

## API (JSON)
- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `GET /api/v1/auth/me`
- `POST /api/v1/auth/logout`
- `GET /api/v1/auth/verify-email?token=...`
- `GET /api/news?league=PL&type=next`
- `GET /api/news?mode=leagues`

## Notas de seguridad (pendientes recomendadas)
- Mover credenciales SMTP y tokens a variables de entorno
- Añadir proteccion CSRF en formularios
- Validar expiracion en reset de password

## Licencia
Uso academico (TFG). Si quieres definir otra licencia, agrega el texto aqui.
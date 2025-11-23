# Docker - Guía de Uso Rápida

## DESARROLLO

```bash
# Copiar variables de entorno
cp .env.example .env

# Construir y iniciar
docker compose -f docker-compose.dev.yml up -d

# Instalar dependencias
docker compose -f docker-compose.dev.yml exec app composer install

# Generar clave
docker compose -f docker-compose.dev.yml exec app php artisan key:generate

# Migraciones
docker compose -f docker-compose.dev.yml exec app php artisan migrate

# Ver logs
docker compose -f docker-compose.dev.yml logs -f

#Conexion a mariadb
docker compose -f docker-compose.dev.yml exec db mariadb -u almacen -p12345678 almacen_db

#Servidor php (Terminal 1)
docker compose -f docker-compose.dev.yml exec app php artisan serve --host=0.0.0.0 --port=8000

#Vite dev (Terminal 2)
docker compose -f docker-compose.dev.yml exec app npm run dev
```

## PRODUCCIÓN

**Multi-stage Build**: El Dockerfile.prod compila assets y optimiza dependencias automáticamente:

-   Stage 1: Node.js compila assets con Vite (`npm run build`)
-   Stage 2: PHP instala dependencias optimizadas (`composer install --no-dev`)
-   Stage 3: Imagen final ligera con solo lo necesario

```bash
# Copiar variables de entorno
cp .env.example .env

# Construir imagen (tarda más por el multi-stage build)
docker compose -f docker-compose.prod.yml build

# Iniciar contenedores
docker compose -f docker-compose.prod.yml up -d

# Generar clave
docker compose -f docker-compose.prod.yml exec app php artisan key:generate

# Migraciones
docker compose -f docker-compose.prod.yml exec app php artisan migrate

# Optimizaciones de producción (cachear configuración)
docker compose -f docker-compose.prod.yml exec app php artisan config:cache
docker compose -f docker-compose.prod.yml exec app php artisan route:cache
docker compose -f docker-compose.prod.yml exec app php artisan view:cache

# Servidor php
docker compose -f docker-compose.prod.yml exec app php artisan serve --host=0.0.0.0 --port=8000

# Detener
docker compose -f docker-compose.prod.yml down
```

**Nota**: En producción NO necesitas ejecutar `npm install` o `npm run build` manualmente, ya está incluido en el build de la imagen.

## BASE DE DATOS

-   Host: `localhost`
-   Puerto: `3306`
-   Usuario: `almacen_user`
-   Contraseña: `almacen_password`
-   Base de datos: `almacen_db`

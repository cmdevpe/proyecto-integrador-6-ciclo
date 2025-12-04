# ERP Clothing Stack - TALL

Sistema ERP para gestión de ropa construido con el stack TALL (Tailwind, Alpine, Laravel, Livewire).

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

-   PHP >= 8.1
-   Composer
-   Node.js >= 16.x
-   npm o yarn
-   MySQL o PostgreSQL
-   Git

## 🚀 Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local:

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd erp-clothing-stack-tall
```

### 2. Configurar el archivo de entorno

Copia el archivo de ejemplo `.env.example` y crea tu propio archivo `.env`:

```bash
copy .env.example .env
```

> **Nota:** En Linux/Mac usa `cp .env.example .env`

Edita el archivo `.env` y configura los siguientes parámetros según tu entorno:

-   **Base de datos:**

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_de_tu_base_de_datos
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
    ```

-   **Otros parámetros importantes:** Revisa y ajusta según sea necesario (mail, cache, queue, etc.)

### 3. Instalar dependencias de PHP

```bash
composer install
```

### 4. Generar la clave de aplicación

```bash
php artisan key:generate
```

Este comando genera una clave única para tu aplicación que se usa para encriptar datos.

### 5. Crear el enlace simbólico de storage

```bash
php artisan storage:link
```

Este comando crea un enlace simbólico desde `public/storage` a `storage/app/public` para acceder a archivos almacenados.

### 6. Ejecutar las migraciones y seeders

```bash
php artisan migrate:fresh --seed
```

> ⚠️ **Advertencia:** El comando `migrate:fresh` eliminará todas las tablas existentes y las recreará. Úsalo solo en desarrollo.

Este comando:

-   Elimina todas las tablas de la base de datos
-   Ejecuta todas las migraciones
-   Puebla la base de datos con datos de prueba (seeders)

### 7. Instalar dependencias de Node.js

```bash
npm install
```

### 8. Compilar assets

En una terminal, ejecuta:

```bash
npm run dev
```

Este comando compilará los assets (CSS, JS) y quedará escuchando cambios para recompilar automáticamente.

> **Nota:** Para producción usa `npm run build`

### 9. Iniciar el servidor de desarrollo

En otra terminal, ejecuta:

```bash
php artisan serve
```

El servidor estará disponible en: [http://localhost:8000](http://localhost:8000)

## 📦 Scripts Disponibles

-   `npm run dev` - Compila assets en modo desarrollo con hot reload
-   `npm run build` - Compila assets para producción
-   `npm run watch` - Compila assets y observa cambios
-   `php artisan test` - Ejecuta las pruebas

## 🔧 Comandos Útiles de Laravel

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan optimize

# Ver rutas disponibles
php artisan route:list

# Crear nueva migración
php artisan make:migration nombre_de_la_migracion

# Crear nuevo modelo
php artisan make:model NombreDelModelo

# Crear nuevo controlador
php artisan make:controller NombreController
```

## 🗂️ Estructura del Proyecto

```
erp-clothing-stack-tall/
├── app/                # Código de la aplicación
├── bootstrap/          # Archivos de inicialización
├── config/             # Archivos de configuración
├── database/           # Migraciones y seeders
├── public/             # Punto de entrada público
├── resources/          # Vistas, assets sin compilar
├── routes/             # Definición de rutas
├── storage/            # Archivos generados
├── tests/              # Tests automatizados
└── vendor/             # Dependencias de Composer
```

## 🤝 Contribución

Si deseas contribuir al proyecto:

1. Crea un fork del repositorio
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

**¡Disfruta desarrollando! 🎉**

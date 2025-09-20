# Documentación del Proyecto MatchGoal

## Descripción General del Proyecto
MatchGoal es una aplicación web basada en Laravel para gestionar predicciones de apuestas deportivas, ligas, equipos y canales. El proyecto sigue una arquitectura estándar de Laravel 10 con herramientas frontend modernas.

## Stack Tecnológico

### Backend
- **Framework**: Laravel 10.10+ (PHP 8.1+)
- **Autenticación**: Laravel Breeze con tokens API de Sanctum
- **Base de Datos**: MySQL (configurable)
- **Herramientas de Debug**: Laravel Debugbar para desarrollo

### Frontend
- **Herramienta de Build**: Vite 4.0+
- **Framework CSS**: Tailwind CSS 3.4+ con plugin de Forms
- **JavaScript**: Alpine.js 3.4+, Axios para peticiones HTTP
- **Tablas de Datos**: DataTables.net con Bootstrap 5 y extensiones responsive

### Herramientas de Desarrollo
- **Gestor de Paquetes**: Composer (PHP), npm (JavaScript)
- **Calidad de Código**: Laravel Pint (estilo PHP)
- **Testing**: PHPUnit 10.1+
- **Contenedor**: Laravel Sail (entorno Docker opcional)

## Estructura del Proyecto

```
matchgoal/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           # Controladores de autenticación
│   │   │   ├── BetController.php
│   │   │   ├── LeagueController.php
│   │   │   ├── ProfileController.php
│   │   │   └── TeamController.php
│   │   └── Middleware/         # Middleware personalizado
│   ├── Models/
│   │   ├── Bet.php
│   │   ├── Channel.php
│   │   ├── League.php
│   │   ├── Team.php
│   │   └── User.php
│   └── Providers/              # Proveedores de servicios
├── database/
│   ├── migrations/             # Esquema de base de datos
│   ├── factories/              # Factories de modelos
│   └── seeders/               # Seeders de base de datos
├── resources/
│   ├── css/
│   │   └── app.css            # Hoja de estilos principal
│   ├── js/
│   │   ├── app.js             # JavaScript principal
│   │   └── bootstrap.js       # Configuración de Bootstrap
│   └── views/
│       ├── app/               # Vistas de la aplicación
│       │   ├── bets/
│       │   ├── leagues/
│       │   └── teams/
│       └── welcome.blade.php   # Página de inicio
├── routes/
│   ├── web.php                # Rutas web
│   ├── api.php                # Rutas API
│   ├── auth.php               # Rutas de autenticación
│   ├── channels.php           # Canales de broadcast
│   └── console.php            # Comandos de consola
└── public/                    # Assets públicos
```

## Funcionalidades Principales

### Sistema de Autenticación
- Registro e inicio de sesión de usuarios vía Laravel Breeze
- Soporte para verificación de email (configurable)
- Funcionalidad de restablecimiento de contraseña
- Gestión de perfil

### Funcionalidades Principales de la Aplicación
1. **Sistema de Apuestas**: Crear y gestionar predicciones de apuestas
2. **Gestión de Ligas**: Crear y organizar ligas deportivas
3. **Gestión de Equipos**: Gestionar información y estadísticas de equipos
4. **Dashboard**: Panel de usuario autenticado

### Modelos de Base de Datos
- **User**: Modelo de usuario estándar de Laravel con tokens API
- **Bet**: Predicciones de apuestas y datos relacionados
- **League**: Información de ligas deportivas
- **Team**: Datos de equipos y relaciones
- **Channel**: Canales de comunicación o transmisión

## Comandos de Desarrollo

### Comandos Laravel/PHP
```bash
# Iniciar servidor de desarrollo
php artisan serve

# Ejecutar migraciones de base de datos
php artisan migrate

# Sembrar base de datos
php artisan db:seed

# Limpiar caché de aplicación
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generar clave de aplicación
php artisan key:generate

# Ejecutar tests
php artisan test
# o
./vendor/bin/phpunit

# Formateo de código
./vendor/bin/pint
```

### Comandos Frontend
```bash
# Instalar dependencias
npm install

# Iniciar servidor de desarrollo con hot reload
npm run dev

# Build para producción
npm run build
```

### Configuración del Entorno
```bash
# Copiar archivo de entorno
cp .env.example .env

# Instalar dependencias PHP
composer install

# Instalar dependencias Node
npm install

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate
```

## Configuración

### Variables de Entorno
Variables clave en `.env`:
- `APP_NAME`: Nombre de la aplicación
- `APP_ENV`: Entorno (local, staging, production)
- `APP_DEBUG`: Modo debug (true/false)
- `APP_URL`: URL de la aplicación
- `DB_*`: Configuraciones de conexión a base de datos
- `MAIL_*`: Configuración de email
- `VITE_*`: Variables de build frontend

### Base de Datos
- Por defecto: MySQL
- Configurable vía variable de entorno `DB_CONNECTION`
- Migraciones ubicadas en `database/migrations/`

### Configuración Frontend
- **Vite**: Configuración en `vite.config.js`
- **Tailwind**: Configuración en `tailwind.config.js`
- **PostCSS**: Configuración en `postcss.config.js`

## Rutas

### Rutas Web (`routes/web.php`)
- `/`: Página de bienvenida
- `/dashboard`: Panel de usuario autenticado
- `/profile/*`: Gestión de perfil
- `/predictions`: Ver predicciones de apuestas
- `/bets/*`: Gestión de apuestas
- `/leagues/*`: Gestión de ligas
- `/teams/*`: Gestión de equipos

### Rutas de Autenticación
- Manejadas por Laravel Breeze
- Ubicadas en `routes/auth.php`
- Incluye login, registro, restablecimiento de contraseña, etc.

## Testing

### Ejecutar Tests
```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar archivo de test específico
php artisan test tests/Feature/ExampleTest.php

# Ejecutar con cobertura
php artisan test --coverage
```

### Estructura de Tests
- **Feature Tests**: `tests/Feature/`
- **Unit Tests**: `tests/Unit/`
- **Base de Datos de Test**: Configurada para entorno de testing

## Despliegue

### Build de Producción
```bash
# Instalar dependencias
composer install --optimize-autoloader --no-dev
npm ci

# Build de assets frontend
npm run build

# Optimizar Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
php artisan migrate --force
```

### Requisitos del Servidor
- PHP 8.1+
- MySQL 5.7+ o base de datos compatible
- Composer
- Node.js 16+ (para build de assets)
- Servidor web (Apache/Nginx)

## Notas Adicionales

### Laravel Breeze
- Proporciona scaffolding de autenticación
- Incluye login, registro, restablecimiento de contraseña
- Usa plantillas Blade con Tailwind CSS

### Arquitectura Frontend
- Componentes de página única con plantillas Blade
- Tailwind CSS para estilos
- Alpine.js para componentes interactivos
- DataTables para gestión de datos
- Vite para compilación de assets

### Herramientas de Desarrollo
- Laravel Debugbar habilitado en desarrollo
- Laravel Sail disponible para desarrollo con Docker
- Laravel Pint para estilo de código PHP
- Soporte de hot reload vía Vite

## Estructura de Ramas Git
- **main**: Rama de producción
- **development**: Rama de desarrollo actual
- Las ramas de funcionalidades deben crearse desde `development`

Esta documentación proporciona una visión completa de la estructura del proyecto MatchGoal, configuración y flujo de trabajo de desarrollo.
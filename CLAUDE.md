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
1. **Sistema de Predicciones Deportivas**: Crear y gestionar predicciones de apuestas con algoritmo de análisis automático
2. **Gestión de Ligas**: Crear y organizar ligas deportivas con datos reales
3. **Gestión de Equipos**: Gestionar información y estadísticas de equipos
4. **Sistema de Creación de Partidos**: Workflow de 6 pasos para análisis predictivo
5. **Dashboard**: Panel de usuario autenticado con estadísticas

### Modelos de Base de Datos
- **User**: Modelo de usuario estándar de Laravel con tokens API
- **Bet**: Predicciones de apuestas y datos relacionados
- **League**: Información de ligas deportivas con descripciones
- **Team**: Datos de equipos (ciudad, año fundación, descripción) y relaciones
- **FootballMatch**: Partidos de fútbol con equipos local/visitante
- **Prediction**: Predicciones generadas por el algoritmo de análisis
- **TeamStat**: Estadísticas de equipos por liga y temporada
- **UserSetting**: Configuraciones de usuario (stakes, bankroll)
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
- `/leagues/*`: Gestión de ligas (CRUD completo)
- `/teams/*`: Gestión de equipos (CRUD completo)
- `/matches/create/*`: Workflow de 6 pasos para crear partidos con análisis predictivo

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

## Sistema de Predicciones Deportivas

### Workflow de Creación de Partidos (6 Pasos)
1. **Paso 1**: Selección de liga y equipos (local y visitante) con fecha del partido
2. **Paso 2**: Porcentajes de victoria (local, empate, visitante) - deben sumar 100%
3. **Paso 3**: Estadísticas del equipo local con rachas simples y formato X/Y
4. **Paso 4**: Estadísticas del equipo visitante con rachas simples y formato X/Y
5. **Paso 5**: Cuotas de mercados activos para análisis predictivo
6. **Paso 6**: Análisis automático y confirmación del partido

### Tipos de Estadísticas de Equipos

#### Rachas Simples (Número consecutivo)
- **Racha de Victorias**: Número de victorias consecutivas
- **Racha de Derrotas**: Número de derrotas consecutivas
- **Racha Sin Derrotas**: Número de partidos consecutivos sin perder
- **Ninguna Portería a Cero**: Número de partidos consecutivos sin portería imbatida

#### Rachas con Formato (Aciertos/Total)
- **Primero en Marcar**: X/Y partidos donde el equipo anota primero
- **Ganador Primer Tiempo**: X/Y partidos donde gana el primer tiempo
- **Ambos Equipos Anotan**: X/Y partidos donde ambos equipos anotan
- **Más de 2.5 Goles**: X/Y partidos con más de 2.5 goles totales
- **Menos de 2.5 Goles**: X/Y partidos con menos de 2.5 goles totales

### Algoritmo de Análisis
- **MarketAnalysisService**: Servicio que analiza las estadísticas de ambos equipos
- **Mercados Analizados**: 1X2, Primer Gol, Ganador Primer Tiempo, Ambos Anotan, Over/Under 2.5
- **Scoring de Confianza**: Basado en la efectividad de las rachas y consistencia
- **Cálculo ROI**: Retorno de inversión estimado por apuesta
- **Guardar Siempre**: Los partidos se guardan independientemente de si se genera predicción

### Sistema de Stakes (Apuestas)
- **Unidad Base**: 5,000 COP por unidad
- **Escalas**: 1-4 unidades según confianza
- **Configuración**: Ajustable por usuario vía UserSettings

### Datos Reales Incluidos
- **LaLiga EA Sports**: 12 equipos principales
- **Premier League**: 8 equipos principales
- **Serie A TIM**: 8 equipos principales
- **Bundesliga**: 8 equipos principales

Cada equipo incluye: nombre, ciudad, año de fundación, y descripción.

## Últimas Actualizaciones (Septiembre 2025)

### Mejoras en el Sistema de Estadísticas
- **Campos Reorganizados**: Se reorganizó la estructura de campos en pasos 3 y 4 para ser más intuitivos
- **Nuevos Campos Agregados**:
  - "Menos de 2.5 Goles" en formato X/Y
  - "Ninguna Portería a Cero" como racha simple
- **Cambios de Nomenclatura**: "Primer Gol" cambió a "Primero en Marcar"
- **Validación Mejorada**: Todos los campos son opcionales (nullable) para mayor flexibilidad

### Mejoras en el Flujo de Creación
- **Guardar Sin Predicción**: Los partidos ahora se guardan siempre, independientemente de si se genera predicción
- **Mensajes Personalizados**: Diferentes mensajes de éxito según si hay predicción o no
- **Manejo de Errores**: Mejor gestión de errores en el análisis predictivo
- **Botón Adicional**: Opción "Guardar Partido Sin Predicción" cuando no hay análisis disponible

### Archivos Modificados
- `resources/views/matches/create/step3.blade.php`: Campos reorganizados y nuevos campos
- `resources/views/matches/create/step4.blade.php`: Mismas mejoras para equipo visitante
- `resources/views/matches/create/analyze.blade.php`: Botón adicional y mejor manejo de predicciones
- `app/Http/Controllers/MatchCreatorController.php`: Validaciones opcionales y lógica mejorada

Esta documentación proporciona una visión completa de la estructura del proyecto MatchGoal, configuración y flujo de trabajo de desarrollo.
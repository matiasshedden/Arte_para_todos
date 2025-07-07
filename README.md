# 🍽️ Arte para Todos - Sistema de Gestión de Restaurante

**Arte para Todos** es una aplicación web moderna diseñada para gestionar el restaurante "Arte para Todos", una cooperativa gastronómica con inclusión neurodiversa. El sistema permite a los clientes realizar reservas online y a los administradores gestionar menús semanales y visualizar estadísticas.

## ✨ Funcionalidades

### Para Clientes
- 🏠 **Página principal** con información del restaurante
- 📅 **Sistema de reservas** online intuitivo
- 📋 **Visualización del menú** semanal actual
- 📱 **Diseño responsive** para móviles y tablets

### Para Administradores
- 🔐 **Panel de administración** seguro
- 📊 **Dashboard** con estadísticas de reservas
- 🍜 **Gestión de menús** semanales
- 👥 **Visualización de reservas** en tiempo real
- 📈 **Estadísticas** de ocupación y reservas

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 7.4+ con arquitectura MVC
- **Frontend**: HTML5, CSS3, JavaScript vanilla
- **Templates**: Twig 3.x
- **Base de datos**: MariaDB/MySQL
- **Autoloading**: PSR-4 con Composer
- **Estilos**: PicoCSS para diseño moderno
- **Gestión de dependencias**: Composer

## 📁 Estructura del Proyecto

```
Arte_para_todos/
├── 📁 public/                # Punto de entrada público
│   ├── index.php            # Router principal
│   ├── 📁 assets/           # Recursos estáticos
│   │   ├── 📁 css/          # Estilos CSS
│   │   ├── 📁 js/           # Scripts JavaScript  
│   │   └── 📁 img/          # Imágenes
├── 📁 src/                  # Código fuente (PSR-4)
│   ├── 📁 Controllers/      # Controladores MVC
│   ├── 📁 Models/           # Modelos de datos
│   ├── 📁 Core/             # Clases base del framework
│   └── 📁 Services/         # Servicios de la aplicación
├── 📁 templates/            # Plantillas Twig
├── 📁 database/             # Base de datos
│   ├── 📁 migrations/       # Scripts de migración
│   ├── connection.php       # Conexión a BD
│   └── queries.php          # Consultas SQL
├── 📁 config/               # Configuración
├── 📁 storage/              # Almacenamiento
│   ├── 📁 logs/             # Logs de la aplicación
│   └── 📁 cache/            # Cache de templates
├── .env.example             # Variables de entorno ejemplo
├── composer.json            # Dependencias PHP
└── README.md               # Esta documentación
```

## 🚀 Instalación y Configuración

### Prerrequisitos
- PHP 7.4 o superior
- MariaDB/MySQL 5.7+
- Composer
- Servidor web (Apache/Nginx) o XAMPP

### Pasos de Instalación

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/matiasshedden/A_la_mesa-restaurant_V2-.git
   cd Arte_para_todos
   ```

2. **Instalar dependencias:**
   ```bash
   composer install
   ```

3. **Configurar variables de entorno:**
   ```bash
   # Copiar archivo de ejemplo
   cp .env.example .env
   
   # Editar las variables según tu configuración
   # Especialmente DB_HOST, DB_NAME, DB_USER, DB_PASS
   ```

4. **Crear base de datos:**
   ```sql
   CREATE DATABASE arte_para_todos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

5. **Ejecutar migraciones:**
   ```bash
   php migrate.php
   ```

6. **Configurar servidor web:**
   - **XAMPP**: Coloca el proyecto en `htdocs/Arte_para_todos`
   - **Servidor local**: `php -S localhost:8000 -t public`

## 🌐 Acceso a la Aplicación

### URLs Principales
- **Sitio principal**: `http://localhost/Arte_para_todos/public/`
- **Panel admin**: `http://localhost/Arte_para_todos/public/admin`

### Credenciales Predeterminadas
- **Usuario**: `admin`
- **Contraseña**: `admin123`

⚠️ **Importante**: Cambia estas credenciales después del primer acceso.

## 📖 Manual de Usuario

### Para Clientes
1. **Hacer una reserva:**
   - Visita la página principal
   - Ve a la sección "Reservas"
   - Completa el formulario con tus datos
   - Confirma la reserva

### Para Administradores
1. **Acceder al panel:**
   - Ve a `/admin` e ingresa credenciales
   
2. **Gestionar menú semanal:**
   - En el dashboard, ve a "Gestión de Menú Semanal"
   - Selecciona fechas de inicio y fin de semana
   - Escribe los platos (uno por línea)
   - Agrega notas especiales si es necesario
   - Guarda cambios

3. **Ver reservas:**
   - El dashboard muestra todas las reservas
   - Filtra por fecha si es necesario
   - Ve estadísticas de ocupación

## 🔧 Configuración Avanzada

### Variables de Entorno (.env)
```env
# Aplicación
APP_NAME="Arte para Todos"
APP_ENV=development
DEBUG=true
BASE_URL=http://localhost/Arte_para_todos

# Base de datos
DB_HOST=localhost
DB_NAME=arte_para_todos
DB_USER=root
DB_PASS=

# Sesiones
SESSION_LIFETIME=7200

# Archivos
MAX_UPLOAD_SIZE=5242880
ALLOWED_EXTENSIONS=jpg,jpeg,png,gif,pdf
```

### Estructura de Base de Datos

**Tabla `reserva`:**
- `id`: Identificador único
- `nombre`: Nombre del cliente
- `telefono`: Teléfono de contacto
- `fecha`: Fecha de la reserva
- `hora`: Hora de la reserva
- `nro_personas`: Número de comensales
- `created_at`: Fecha de creación

**Tabla `weekly_menu`:**
- `id`: Identificador único
- `week_start`: Fecha inicio de semana
- `week_end`: Fecha fin de semana
- `menu_items`: Platos del menú
- `special_notes`: Notas especiales
- `created_at`: Fecha de creación

**Tabla `admins`:**
- `id`: Identificador único
- `username`: Nombre de usuario
- `password_hash`: Contraseña encriptada

## 🚨 Troubleshooting

### Problemas Comunes

1. **Error de conexión a BD:**
   - Verifica credenciales en `.env`
   - Asegúrate de que MySQL/MariaDB esté ejecutándose

2. **Error 404 en rutas:**
   - Verifica que el archivo `.htaccess` esté presente
   - Confirma que `mod_rewrite` esté habilitado

3. **Error de autoloading:**
   - Ejecuta `composer dump-autoload`
   - Verifica que todas las clases tengan el namespace correcto

4. **Problemas de permisos:**
   ```bash
   # En Linux/Mac
   chmod -R 755 storage/
   chmod -R 755 cache/
   ```

## 🔒 Seguridad

- ✅ **Contraseñas hasheadas** con `password_hash()`
- ✅ **Validación de entrada** en formularios
- ✅ **Prepared statements** para consultas SQL
- ✅ **Sanitización** de datos de usuario
- ✅ **Gestión de sesiones** segura

## 📈 Futuras Mejoras

- [ ] Sistema de notificaciones por email
- [ ] Integración con WhatsApp para confirmaciones
- [ ] Dashboard con gráficos avanzados
- [ ] Sistema de comentarios y reviews
- [ ] API REST para aplicación móvil
- [ ] Integración con sistema de pagos

## 🤝 Contribución

Para contribuir al proyecto:
1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crea un Pull Request

## 📞 Soporte

- **Email**: support@arteparatodos.com
- **Issues**: [GitHub Issues](https://github.com/matiasshedden/A_la_mesa-restaurant_V2-/issues)
- **Documentación**: Este README.md

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver `LICENSE` para más detalles.

---

**Desarrollado con ❤️ para Arte para Todos - Cooperativa con Inclusión Neurodiversa**

# Docuu - Prueba Técnica Fullstack (Backend Laravel)

## Descripción
Este proyecto implementa el **backend API RESTful** para la gestión de órdenes de impresión, parte de la prueba técnica Fullstack Semi-Senior de **Docuu**.  
El backend está desarrollado en **Laravel 12+**, con soporte para **JWT Authentication** y validaciones completas de integridad.

---

## Tecnologías
- **Laravel 12+**
- **PHP 8.3+**
- **MySQL 8+**
- **JWT Auth** (paquete `tymon/jwt-auth`)
- **Eloquent ORM**
- **Form Requests para validaciones**
- **Seeder para datos de ejemplo**

---

## Instalación y ejecución

1. **Clonar el repositorio**
   ```bash
   git clone <url-del-repo>
   ```

2. **Instalar dependencias de PHP**
   ```bash
   composer install
   ```

3. **Configurar entorno**
   Copia el archivo `.env.example` a `.env` y edita las variables de conexión a base de datos:
   ```bash
   cp .env.example .env
   ```

   Ajusta los valores:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=docuu_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generar la key de la aplicación**
   ```bash
   php artisan key:generate
   ```

5. **Ejecutar migraciones**
   ```bash
   php artisan migrate
   ```

6. **Ejecutar seeders**
   ```bash
   php artisan db:seed
   ```

   Esto creará unos usuarios **operator@docuu.test**, **admin@docuu.test**, **viewer@docuu.test** por defecto y algunas órdenes de prueba la clave de estos usuarios es: 'password' .

7. **Iniciar el servidor**
   ```bash
   php artisan serve
   ```

   La API quedará disponible en: [http://localhost:8000/api](http://localhost:8000/api)

---

## Endpoints principales

### Autenticación
| Método | Endpoint | Descripción |
|--------|-----------|--------------|
| POST | `/api/auth/login` | Inicia sesión y devuelve `access_token` |
| GET | `/api/auth/me` | Devuelve el usuario autenticado |
| POST | `/api/auth/logout` | Cierra sesión y revoca token |
| POST | `/api/auth/refresh` | (Opcional) refresca token expirado |

### Órdenes
| Método | Endpoint | Descripción |
|--------|-----------|--------------|
| GET | `/api/orders` | Lista de órdenes (paginada) |
| GET | `/api/orders/{id}` | Detalle de orden |
| POST | `/api/orders` | Crea una nueva orden |
| PUT | `/api/orders/{id}` | Actualiza una orden |
| DELETE | `/api/orders/{id}` | Elimina una orden |

---

## Roles disponibles
| Rol | Descripción |
|-----|--------------|
| viewer | Solo lectura |
| operator | Listar, Ver, Crear, editar y eliminar órdenes |
| admin | Control total del sistema |

---

## Validaciones de negocio
- `client_name`: requerido, máx. 100 caracteres.
- `description`: requerido, máx. 500 caracteres.
- `status`: debe ser uno de `pending`, `in_progress`, `completed`.
- `delivery_date`: fecha válida (hoy o futura).
- **Regla de integridad:** no se permiten duplicados `client_name + delivery_date`.

---

## Semillas incluidas
Ejecutar `php artisan db:seed` crea:
- Un usuario admin:  
  **Email:** admin@docuu.com  
  **Password:** password  
- 5 órdenes de ejemplo en la tabla `orders`.

---

## Autor
Prueba técnica desarrollada por **[Camilo Lopez]** para **Docuu**.  
Backend implementado con **Laravel 12**, JWT y MySQL.

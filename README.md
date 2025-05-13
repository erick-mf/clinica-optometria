# CUVO - Clínica de Optometría

CUVO es un sistema web desarrollado para gestionar la atención en una clínica de optometría. Permite al
personal administrar profesionales, pacientes, horarios, y citas de forma eficiente, brindando una
experiencia moderna y automatizada.

<p align="center">
  <img src="./public/assets/icons/logo-clinica.webp" alt="CUVO Logo" width="400">
</p>

---

## Características principales

- ✅ Gestión de profesionales por parte del administrador.
- ✅ Generación de horarios disponibles.
- ✅ Solicitud de citas por parte del paciente.
- ✅ Envio de correo con la información de la cita.
- ✅ Paneles personalizados para cada rol: administrador, profesional y paciente.
- ✅ Sistema de turnos y control de disponibilidad.

---

## Tecnologías utilizadas

- **Backend:** PHP 8.3 + Laravel 11
- **Frontend:** Blade, JavaScript, TailwindCSS
- **Autenticación:** Laravel Breeze
- **Base de datos:** SQLite (adaptado por compatibilidad con el servidor compartido)
- **Correo electrónico:** PHPMailer / Laravel Mail
- **Extras:** Flatpickr (selección de fechas)

---

## Tipos de usuario

- **Admin**
- **Profesional**
- **Paciente**

---

<details>
<summary> Instalación con Laravel Sail </summary>

> Requiere tener Docker instalado en tu sistema

```bash
git clone https://github.com/repositorio.git
cd cuvo-clinica

# Instalar dependencias
composer install && npm install

# Copiar archivo de entorno y levantar Sail
cp .env.example .env
./vendor/bin/sail up -d

# Generar clave de aplicación
./vendor/bin/sail artisan key:generate

# Ejecutar migraciones y seeders
./vendor/bin/sail artisan migrate --seed

# Levantar el proyecto
./vendor/bin/sail composer dev
```
</details>
<br>
<details margin-top="100px">
<summary>Instalación sin Docker</summary>

> Para entornos sin Docker. Requiere PHP 8.3+, Composer, Node.js y SQLite.

```bash
git clone https://github.com/repositorio.git
cd cuvo-clinica

# Instalar dependencias
composer install && npm install

# Copiar archivo de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones y seeders
php artisan migrate --seed

# Levantar el proyecto
composer run dev
```
</details>

---
> Las credenciales de prueba creadas por los seeders son:
- Email: admin@example.com
- Contraseña: 1234567890

# Sistema de Gestión de Proyectos

Sistema de Gestión de Proyectos para Control de Tareas, Equipos y Recursos

## Requisitos del Sistema

- PHP >= 8.1
- Composer
- Node.js >= 14.x
- NPM >= 6.x
- Laravel >= 11.x
- MySQL >= 8.x
- Filament >= 3.x
- Livewire >= 3.x
- TailwindCSS >= 3.x
- Vite >= 5.x

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/Sam-droid22/ControlProjects
   ```
2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```

3. Instala las dependencias de JavaScript:
   ```bash
   npm install
   ```

4. Copia el archivo de configuración:
   ```bash
   cp .env.example .env
   ```

5. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

6. Configura tu base de datos en el archivo `.env`

7. Ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```

8. Compila los assets:
   ```bash
   npm run dev
   ```

## Uso

funcionalidades:
- Control de Tareas
- Control de Equipos
- Control de Recursos
- Control de Proyectos
- Control de Recursos Humanos
- Control de Recursos Tecnologicos
- Control de Recursos Financieros

## Licencia

El framework Laravel es un software de código abierto licenciado bajo la licencia MIT.

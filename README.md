## Running Seedling_Harvest with Docker

This project provides a Docker-based setup for local development and testing. The included `Dockerfile` and `docker-compose.yml` define all necessary services and dependencies.

### Requirements
- Docker
- Docker Compose

### Services and Versions
- **PHP**: 8.2 (FPM, Alpine)
- **Composer**: 2.7 (for dependency installation)
- **MySQL**: latest official image

### Environment Variables
The MySQL service uses the following environment variables (see `docker-compose.yml`):
- `MYSQL_DATABASE`: `laravel`
- `MYSQL_USER`: `laravel`
- `MYSQL_PASSWORD`: `secret`
- `MYSQL_ROOT_PASSWORD`: `rootsecret`

> **Note:** Application secrets and environment variables should be provided at runtime. The `.env` file is not included in the Docker image and should be managed separately.

### Ports
- **php-app**: Exposes port `9000` (PHP-FPM, for use with a web server like nginx)
- **mysql-db**: Exposes port `3306` (MySQL)

### Build and Run Instructions
1. **Clone the repository** and ensure you have Docker and Docker Compose installed.
2. **Build and start the containers:**
   ```bash
   docker compose up --build
   ```
3. **Accessing the application:**
   - The PHP-FPM service runs on port 9000 and is intended to be used behind a web server (e.g., nginx). You may need to set up an nginx container or proxy for browser access.
   - MySQL is available on port 3306 for database connections.
4. **Environment configuration:**
   - Copy `.env.example` to `.env` and adjust settings as needed for your environment.
   - Ensure your `.env` database settings match those in `docker-compose.yml`:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=mysql-db
     DB_PORT=3306
     DB_DATABASE=laravel
     DB_USERNAME=laravel
     DB_PASSWORD=secret
     ```
5. **Install dependencies and run migrations (if needed):**
   - You can run artisan commands inside the container:
     ```bash
     docker compose exec php-app php artisan migrate
     ```

### Special Configuration
- The Dockerfile creates a non-root user (`appuser`) and sets appropriate permissions for `storage` and `bootstrap/cache`.
- The `.env` file should **not** be committed or copied into the image; provide it at runtime.
- If you use frontend assets, uncomment the relevant sections in the Dockerfile and add a web server container as needed.

For further customization, refer to the `Dockerfile` and `docker-compose.yml` in the project root.
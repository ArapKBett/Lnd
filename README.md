
### Local Setup Steps on Kali Linux

#### Prerequisites
1. **Install Dependencies**:
   - **PHP 8.2**:
     ```bash
     sudo apt update
     sudo apt install php8.2 php8.2-mysql php8.2-curl php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip
     ```
   - **Composer**:
     ```bash
     sudo apt install composer
     ```
   - **Node.js and npm** (for Tailwind, Alpine.js, Chart.js):
     ```bash
     sudo apt install nodejs npm
     ```
   - **MySQL**:
     ```bash
     sudo apt install mysql-server
     sudo systemctl start mysql
     sudo systemctl enable mysql
     ```
   - **Git** (for cloning or version control):
     ```bash
     sudo apt install git
     ```

2. **Configure MySQL**:
   - Secure MySQL installation:
     ```bash
     sudo mysql_secure_installation
     ```
   - Log in to MySQL and create a database:
     ```bash
     sudo mysql -u root -p
     CREATE DATABASE wealthbuild;
     GRANT ALL PRIVILEGES ON wealthbuild.* TO 'wealthbuild_user'@'localhost' IDENTIFIED BY 'secure_password';
     FLUSH PRIVILEGES;
     EXIT;
     ```

3. **Verify Versions**:
   ```bash
   php -v  # Should show PHP 8.2.x
   composer --version
   node -v  # Should show Node.js v16 or higher
   npm -v
   mysql --version
   ```

#### Project Setup
1. **Clone this Project**
     

2. **Copy Project Files**:

3. **Install Dependencies**:
   - Composer dependencies:
     ```bash
     composer require spatie/laravel-permission guzzlehttp/guzzle intervention/image iankumu/mpesa
     ```
   - npm dependencies:
     ```bash
     npm install alpinejs chart.js tailwindcss
     npx tailwindcss init
     npm run build
     ```

4. **Configure Environment**:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Edit `.env` with your MySQL credentials and API keys:
     
   - Generate app key:
     ```bash
     php artisan key:generate
     ```

5. **Set File Permissions** (Kali-specific, as it runs as root by default):
   - Ensure Laravel directories are writable:
     ```bash
     sudo chown -R $USER:$USER storage bootstrap/cache
     chmod -R 775 storage bootstrap/cache
     ```

#### When to Run `php artisan migrate --seed`
- **Purpose**: The `php artisan migrate --seed` command runs all database migrations to create tables (e.g., `users`, `loans`, `savings`, `payments`) and seeds the database with initial data (e.g., admin, staff, clients) using seeders.
- **When to Run**:
  - **After setting up the database** in MySQL and configuring `.env` with correct DB credentials.
  - **After defining migrations and seeders** (as provided in previous responses, e.g., `UserFactory`, `AdminSeeder`, `ClientSeeder`).
  - **Before testing the application** to ensure the database is populated with test data.
  - **Only once initially** unless you need to reset the database (use `php artisan migrate:fresh --seed` to drop and recreate tables).
- **Execution**:
  ```bash
  php artisan migrate --seed
  ```
  - This runs migrations from `database/migrations/` and seeders from `database/seeders/`.
  - If you encounter errors (e.g., DB connection issues), verify `.env` settings and MySQL service (`sudo systemctl status mysql`).



   **Configure Mail** (for reminders):
   - Update `.env` with mail settings (e.g., Mailtrap for testing):
     ```env
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.mailtrap.io
     MAIL_PORT=2525
     MAIL_USERNAME=your_mailtrap_username
     MAIL_PASSWORD=your_mailtrap_password
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS="no-reply@wealthbuild.com"
     MAIL_FROM_NAME="WealthBuild Loans"
     ```
   - Test the command:
     ```bash
     php artisan loans:remind
     ```



5. **Run Migration and Seeding**:
   - After setting up `.env` and ensuring MySQL is running:
     ```bash
     php artisan migrate --seed
     ```
   - This creates:
     - 1 admin (`admin@wealthbuild.com`, password: `password`)
     - 3 staff (`staff@wealthbuild.com` + 2 random, password: `password`)
     - 6 clients (`client@wealthbuild.com` + 5 random, password: `password`), each with savings and loans.

6. **Test Users**:
   - Log in at `http://localhost:8000/login`:
     - **Admin**: `admin@wealthbuild.com` / `password`
       - Access: `http://localhost:8000/admin/dashboard`
     - **Staff**: `staff@wealthbuild.com` / `password`
       - Access: `http://localhost:8000/staff/dashboard`
     - **Client**: `client@wealthbuild.com` / `password`
       - Access: `http://localhost:8000/client/dashboard`
   - Verify role-based access (e.g., clients can’t access `/admin/*`).

#### Final Setup and Testing
1. **Start Development Server**:
   ```bash
   php artisan serve
   ```
   - Access at `http://localhost:8000`.

2. **Test Features**:
   - **Landing Page**: Visit `http://localhost:8000` to see the hero image and 360° loan simulator.
   - **Client Dashboard**: Log in as `client@wealthbuild.com` to view loans, savings, and upload documents.
   - **Admin Dashboard**: Log in as `admin@wealthbuild.com` to manage clients and loans.
   - **Staff Approvals**: Log in as `staff@wealthbuild.com` to approve/reject loans.
   - **M-Pesa**: Test STK Push with sandbox credentials (POST to `/mpesa/stk`).
   - **Crypto**: Test Coinremitter payment (POST to `/crypto/pay`).
   - **Security**: Run tests:
     ```bash
     php artisan test
     ```
     - Tests SQLi, XSS, auth, rate limiting, etc., as in `ApiTest.php`.

3. **Troubleshooting (Kali-specific)**:
   - **Permission Issues**: If errors occur due to Kali’s root user, run:
     ```bash
     sudo chown -R $USER:$USER .
     chmod -R 775 storage bootstrap/cache
     ```
   - **MySQL Errors**: Ensure MySQL is running (`sudo systemctl start mysql`) and `.env` credentials match.
   - **Port Conflicts**: If `8000` is in use, specify another port:
     ```bash
     php artisan serve --port=8001
     ```

Below, I’ll provide detailed steps for setting up the `wealthbuild-loans` Laravel project locally on **Kali Linux**, including when to run `php artisan migrate --seed`, how to register the `AdminMiddleware` in the Laravel application, and how to create a custom Artisan command (`loans:remind`) referenced in the `Kernel.php`. I’ll also guide you through creating default admin, staff, and client users for testing, ensuring compatibility with the project’s role-based access control using the `spatie/laravel-permission` package. The setup assumes you’re using PHP 8.2, MySQL, Composer, Node.js, and npm, which are compatible with Kali Linux.

---

### Local Setup Steps on Kali Linux

Kali Linux is a Debian-based distribution, so the setup process is similar to other Linux environments, but I’ll account for Kali-specific considerations (e.g., security-focused environment, root user defaults). Follow these steps to set up the `wealthbuild-loans` project:

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
1. **Clone or Create Project Directory**:
   - If you have a Git repository:
     ```bash
     git clone <your-repo-url> wealthbuild-loans
     cd wealthbuild-loans
     ```
   - Or create manually:
     ```bash
     mkdir wealthbuild-loans
     cd wealthbuild-loans
     composer create-project laravel/laravel .
     ```

2. **Copy Project Files**:
   - Copy all previously provided files (e.g., controllers, models, migrations, views) into the `wealthbuild-loans` directory, maintaining the structure.
   - Ensure `public/images/` contains:
     - `landing-hero.jpg` (download from Unsplash: `https://unsplash.com/photos/person-holding-black-android-smartphone-7okkFhxrxNw`).
     - `dashboard-bg.png` and `logo.png` (create via Canva).
     - `360-loan.jpg` (panorama for loan simulator).

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
     ```env
     APP_NAME=WealthBuildLoans
     APP_ENV=local
     APP_KEY=
     APP_DEBUG=true
     APP_URL=http://localhost:8000

     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=wealthbuild
     DB_USERNAME=wealthbuild_user
     DB_PASSWORD=secure_password

     MPESA_ENVIRONMENT=sandbox
     MPESA_CONSUMER_KEY=your_mpesa_consumer_key
     MPESA_CONSUMER_SECRET=your_mpesa_consumer_secret
     MPESA_SHORTCODE=your_mpesa_shortcode
     MPESA_PASSKEY=your_mpesa_passkey

     COINREMITTER_API_KEY=your_coinremitter_api_key
     ```
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

#### Registering `AdminMiddleware` in `app/Console/Kernel.php`
The `AdminMiddleware` (provided in your query) is an HTTP middleware, not a console command, so it should be registered in `app/Http/Kernel.php`, not `app/Console/Kernel.php`. The `app/Console/Kernel.php` references a `loans:remind` command, which we’ll create below. Here’s how to register the `AdminMiddleware`:

1. **Ensure `AdminMiddleware.php` Exists**:
   - The provided `AdminMiddleware.php` is correct and should be in `app/Http/Middleware/AdminMiddleware.php`.

2. **Register in `app/Http/Kernel.php`**:
   - Open `app/Http/Kernel.php` and ensure the `AdminMiddleware` is registered in the `$routeMiddleware` array. It’s already included in the previously provided `Kernel.php`:
     ```php
     protected $routeMiddleware = [
         'auth' => \App\Http\Middleware\Authenticate::class,
         'admin' => \App\Http\Middleware\AdminMiddleware::class,
         'staff' => \App\Http\Middleware\StaffMiddleware::class,
         'client' => \App\Http\Middleware\ClientMiddleware::class,
         'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
     ];
     ```
   - If not present, add `'admin' => \App\Http\Middleware\AdminMiddleware::class,` to the array.

3. **Verify Usage**:
   - The middleware is used in routes (e.g., `routes/web.php`):
     ```php
     Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
         Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
     });
     ```
   - This ensures only users with the `admin` role can access admin routes.

4. **Fixing `app/Console/Kernel.php`**:
   - The provided `app/Console/Kernel.php` references a non-existent `loans:remind` command in the schedule. Let’s create this command to avoid errors.

   **Create `app/Console/Commands/LoanReminder.php`**:
   ```php
   <?php
   namespace App\Console\Commands;
   use Illuminate\Console\Command;
   use App\Models\Loan;
   use Illuminate\Support\Facades\Mail;

   class LoanReminder extends Command {
       protected $signature = 'loans:remind';
       protected $description = 'Send reminders for due loans';

       public function handle() {
           $loans = Loan::where('status', 'approved')->where('term_months', '<=', 1)->get();
           foreach ($loans as $loan) {
               // Example: Send email reminder (configure Mail in .env)
               Mail::to($loan->client->email)->send(new \App\Mail\LoanReminder($loan));
           }
           $this->info('Loan reminders sent: ' . $loans->count());
       }
   }
   ```

   **Create `app/Mail/LoanReminder.php`** (for email reminders):
   ```php
   <?php
   namespace App\Mail;
   use Illuminate\Bus\Queueable;
   use Illuminate\Mail\Mailable;
   use Illuminate\Queue\SerializesModels;
   use App\Models\Loan;

   class LoanReminder extends Mailable {
       use Queueable, SerializesModels;
       public $loan;

       public function __construct(Loan $loan) {
           $this->loan = $loan;
       }

       public function build() {
           return $this->subject('Loan Repayment Reminder')
                       ->view('emails.loan_reminder')
                       ->with(['loan' => $this->loan]);
       }
   }
   ```

   **Create `resources/views/emails/loan_reminder.blade.php`**:
   ```html
   <p>Dear {{ $loan->client->name }},</p>
   <p>Your loan of KSh {{ number_format($loan->amount, 2) }} is nearing its due date.</p>
   <p>Please make a payment via M-Pesa or Crypto to avoid penalties.</p>
   <p>Thank you, WealthBuild Loans</p>
   ```

   **Update `app/Console/Kernel.php`**:
   - Ensure the command is registered:
     ```php
     <?php
     namespace App\Console;
     use Illuminate\Console\Scheduling\Schedule;
     use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

     class Kernel extends ConsoleKernel {
         protected $commands = [
             \App\Console\Commands\LoanReminder::class, // Register command
         ];

         protected function schedule(Schedule $schedule): void {
             $schedule->command('loans:remind')->daily();
         }

         protected function commands(): void {
             $this->load(__DIR__.'/Commands');
             require base_path('routes/console.php');
         }
     }
     ```

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

#### Creating Default Admin, Staff, and Clients for Testing
To test the program, you need default users with roles (`admin`, `staff`, `client`) seeded into the database. The `AdminSeeder` and `ClientSeeder` were provided earlier, but I’ll consolidate and add a `StaffSeeder` for completeness.

1. **Update `database/seeders/DatabaseSeeder.php`**:
   ```php
   <?php
   namespace Database\Seeders;
   use Illuminate\Database\Seeder;

   class DatabaseSeeder extends Seeder {
       public function run(): void {
           $this->call([
               AdminSeeder::class,
               StaffSeeder::class,
               ClientSeeder::class,
           ]);
       }
   }
   ```

2. **Ensure `AdminSeeder.php` (from previous response)**:
   ```php
   <?php
   namespace Database\Seeders;
   use App\Models\User;
   use Illuminate\Database\Seeder;
   use Spatie\Permission\Models\Role;

   class AdminSeeder extends Seeder {
       public function run(): void {
           Role::create(['name' => 'admin']);
           $admin = User::create([
               'name' => 'Admin User',
               'email' => 'admin@wealthbuild.com',
               'password' => bcrypt('password'),
               'role' => 'admin',
           ]);
           $admin->assignRole('admin');
       }
   }
   ```

3. **Create `StaffSeeder.php`**:
   ```php
   <?php
   namespace Database\Seeders;
   use App\Models\User;
   use Illuminate\Database\Seeder;
   use Spatie\Permission\Models\Role;

   class StaffSeeder extends Seeder {
       public function run(): void {
           Role::create(['name' => 'staff']);
           $staff = User::create([
               'name' => 'Staff User',
               'email' => 'staff@wealthbuild.com',
               'password' => bcrypt('password'),
               'role' => 'staff',
           ]);
           $staff->assignRole('staff');

           // Additional staff for testing
           User::factory()->count(2)->create(['role' => 'staff'])->each(function ($user) {
               $user->assignRole('staff');
           });
       }
   }
   ```

4. **Ensure `ClientSeeder.php` (from previous response, expanded)**:
   ```php
   <?php
   namespace Database\Seeders;
   use App\Models\User;
   use App\Models\Loan;
   use App\Models\Savings;
   use Illuminate\Database\Seeder;
   use Spatie\Permission\Models\Role;

   class ClientSeeder extends Seeder {
       public function run(): void {
           Role::create(['name' => 'client']);
           // Default client
           $client = User::create([
               'name' => 'Test Client',
               'email' => 'client@wealthbuild.com',
               'password' => bcrypt('password'),
               'role' => 'client',
           ]);
           $client->assignRole('client');
           Savings::create(['client_id' => $client->id, 'balance' => 5000]);
           Loan::create([
               'client_id' => $client->id,
               'amount' => 10000,
               'term_months' => 12,
               'interest_rate' => 10,
               'limit_boost' => 2500, // 50% of savings
               'status' => 'pending',
           ]);

           // Additional clients
           User::factory()->count(5)->create(['role' => 'client'])->each(function ($user) {
               $user->assignRole('client');
               Savings::factory()->create(['client_id' => $user->id]);
               Loan::factory()->count(2)->create(['client_id' => $user->id]);
           });
       }
   }
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

---

### Summary
- **When to Run `php artisan migrate --seed`**:
  - After configuring `.env` with MySQL credentials.
  - After defining migrations and seeders.
  - Before testing to populate the database with tables and test users.
- **Registering `AdminMiddleware`**:
  - Registered in `app/Http/Kernel.php`, not `app/Console/Kernel.php`.
  - Used in `routes/web.php` for admin routes.
- **Fixing `app/Console/Kernel.php`**:
  - Created `loans:remind` command and registered it.
  - Added email reminder functionality with Mailtrap config.
- **Default Users**:
  - Admin: `admin@wealthbuild.com` / `password`
  - Staff: `staff@wealthbuild.com` / `password` (+2 random)
  - Clients: `client@wealthbuild.com` / `password` (+5 random with loans/savings).
- **Kali Linux**:
  - Ensured compatibility with PHP 8.2, MySQL, and file permissions.
  - Use `sudo` for package installation and MySQL setup if needed.

You can now test the full application locally on Kali Linux. If you need additional views, specific API testing scripts, or help with M-Pesa/Coinremitter sandbox setup, let me know!

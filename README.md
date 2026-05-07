# WealthBuild Loans (QuantumLoans)

A Laravel 11 loan lending platform with role-based dashboards, M-Pesa/Crypto payment integration, and a CreditBoost savings feature.

## Features

- **Role-based access**: Admin, Staff, and Client dashboards
- **Loan lifecycle**: Application, staff approval, admin disbursement, payment tracking
- **CreditBoost**: Savings-based loan limit multiplier (5x savings = additional borrowing power)
- **Payment integration**: M-Pesa (Safaricom Daraja API) and Cryptocurrency (CoinRemitter)
- **Admin dashboard**: Financial analytics, staff management, security monitoring, audit logs
- **Session tracking**: Device/browser/IP logging for security

## Tech Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Database**: MySQL
- **Frontend**: Tailwind CSS, Alpine.js, Chart.js
- **Packages**: Spatie Laravel Permission, iankumu/mpesa, Jenssegers Agent

## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+ (optional, for asset compilation)

## Installation

```bash
# Clone the repository
git clone <repo-url> && cd Lnd

# Install PHP dependencies
composer install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Configure your database in .env
# DB_DATABASE=wealthbuild
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed default users
php artisan db:seed

# Create storage symlink
php artisan storage:link

# Start the development server
php artisan serve
```

## Default Login Credentials

| Role   | Email                    | Password   |
|--------|--------------------------|------------|
| Admin  | admin@wealthbuild.com    | password   |
| Staff  | staff@wealthbuild.com    | password   |
| Client | client@wealthbuild.com   | password   |

## Routes Overview

| Prefix     | Description              |
|------------|--------------------------|
| `/`        | Landing page             |
| `/login`   | Authentication           |
| `/register`| Client registration      |
| `/admin/*` | Admin dashboard & management |
| `/staff/*` | Staff loan processing    |
| `/client/*`| Client loans & profile   |

## Payment Configuration

### M-Pesa (Safaricom)
Set these in `.env`:
```
MPESA_ENVIRONMENT=sandbox
MPESA_CONSUMER_KEY=your_key
MPESA_CONSUMER_SECRET=your_secret
MPESA_SHORTCODE=your_shortcode
MPESA_PASSKEY=your_passkey
```

### Cryptocurrency (CoinRemitter)
```
COINREMITTER_API_KEY=your_api_key
```

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Dashboard, Client, Loan, Staff, Report, Settings controllers
│   ├── Auth/           # Login, Register controllers
│   ├── Client/         # Dashboard, Loan, Profile controllers
│   ├── Payment/        # Mpesa, Crypto controllers
│   └── Staff/          # Dashboard, Loan, Report controllers
├── Models/             # User, Loan, LoanPayment, Savings, Payment, UserSession
├── Services/           # LoanService, PaymentService, SavingsCalculator
└── Http/Middleware/     # CheckRole, TrackUserSession
```

## License

Proprietary - Built by ARAP.

# CRM Application - Laravel Based

A comprehensive Customer Relationship Management (CRM) system built with Laravel 12, featuring modern PHP development practices and deployment-ready configuration.

## 🚀 Quick Start

### Development Environment
```bash
# Clone and setup
git clone <repository-url>
cd salesforce

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Start development server
php artisan serve --host=0.0.0.0 --port=8000
```

**Access**: http://localhost:8000  
**Login**: admin@example.com / password

### Production Deployment
See [DEPLOYMENT.md](DEPLOYMENT.md) for complete production setup guide.

## 📋 Features

- **Lead Management**: Capture, track, and convert leads
- **Deal Pipeline**: Manage sales opportunities with stages
- **Contact Management**: Comprehensive contact database
- **Company Profiles**: Detailed company information
- **Activity Tracking**: Log interactions and follow-ups
- **Quote Generation**: Create and manage quotes with PDF export
- **Dashboard Analytics**: Visual insights and reporting
- **User Authentication**: Secure login with role management

## 🛠 Tech Stack

- **Backend**: Laravel 12, PHP 8.2+
- **Database**: SQLite (dev) / MySQL (production)
- **Frontend**: Bootstrap 5, Chart.js
- **PDF Generation**: DomPDF
- **Authentication**: Laravel Sanctum

## 📁 Project Structure

```
├── app/Models/          # Eloquent models (Lead, Deal, Contact, etc.)
├── app/Http/Controllers/# Application controllers
├── database/migrations/ # Database schema
├── resources/views/     # Blade templates
├── routes/web.php      # Application routes
└── public/             # Web assets
```

## 🔧 Configuration

### Environment Variables
Key configurations for deployment:

```env
# Production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Development  
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### Database
- **Development**: SQLite (included)
- **Production**: MySQL/PostgreSQL recommended

## 📖 Documentation

- [PROJECT-STATUS.md](PROJECT-STATUS.md) - Current status and access info
- [DEPLOYMENT.md](DEPLOYMENT.md) - Production deployment guide
- [TODO.md](TODO.md) - Development roadmap

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

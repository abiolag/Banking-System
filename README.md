# 🏦 Arkard Bank - Banking System

A complete banking system built with Laravel featuring money transfers, transaction history, and user management.

## ✨ Features

- ✅ User Registration & Authentication
- ✅ Account Dashboard with Balance
- ✅ Domestic Transfers between Arkard Bank Users
- ✅ International Wire Transfers
- ✅ Transaction History with Filters
- ✅ User Profile Management
- ✅ Professional Banking UI
- ✅ Secure Database Design

## 🧪 Test Accounts

- **John Smith**: john@example.com / password (Account: 10000001)
- **Sarah Johnson**: sarah@example.com / password (Account: 10000002)

**Routing Number**: 021000021  
**Bank Name**: Arkard Bank

## 🚀 Quick Start

```bash
# Clone the repository
git clone https://github.com/YOUR_USERNAME/arkard-bank.git
cd arkard-bank

# Install dependencies
composer install

# Setup environment
copy .env.example .env
php artisan key:generate

# Setup database (update .env with your database credentials)
php artisan migrate --seed

# Start development server
php artisan serve
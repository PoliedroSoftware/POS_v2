# AGENTS.md — Ultimate POS

## Stack
- Laravel **5.8** / PHP **^7.1.3**
- Vue **2** + AdminLTE (Bootstrap 3) + jQuery
- MySQL, Laravel Mix (webpack), Pusher (real-time)
- Laravel Passport (API auth)

## Structure
- `app/Http/Controllers/` — 63 controllers, one per domain
- `app/Utils/` — domain logic classes (TransactionUtil, ProductUtil, etc.)
- `resources/views/` — 65 Blade view folders matching controller names
- `Modules/` — `nwidart/laravel-modules` v5.1.0; active modules: `Superadmin`, `Repair` (plus `.zip` archives)
- `routes/web.php` — all app routes; `routes/install_r.php` — install wizard routes
- `routes/api.php` — minimal (municipalities endpoint + Passport user)

## Key custom middleware (registered in `app/Http/Kernel.php`)
`setData`, `SetSessionData`, `language`, `timezone`, `AdminSidebarMenu`, `CheckUserLogin`, `EcomApi`, `superadmin`

## Commands
```bash
# Dev
npm run dev            # Laravel Mix development build
npm run watch          # watch mode
npm run prod           # production build
npm run format         # prettier --write 'public/js/*.{css,js,vue}'

# PHP CS Fixer (config in .php_cs)
# No npm script; run directly:
# vendor/bin/php-cs-fixer fix

# Tests
vendor/bin/phpunit                          # all tests
vendor/bin/phpunit tests/Unit/ExampleTest.php
vendor/bin/phpunit tests/Feature/ExampleTest.php

# Laravel defaults apply
php artisan key:generate
php artisan module:make <name>             # create new module
php artisan storage:link
```

## Testing
- PHPUnit 7.5, two suites: `Unit` (`tests/Unit/`) and `Feature` (`tests/Feature/`)
- Standard Laravel test setup with `CreatesApplication.php`
- Testing env overrides: `CACHE_DRIVER=array`, `SESSION_DRIVER=array`, `QUEUE_CONNECTION=sync`

## Code style
- **PHP**: PSR-2 via PHP-CS-Fixer, short arrays, ordered imports, no unused imports
- **JS/CSS/Vue**: Prettier (single quotes, tabWidth 4, printWidth 100, trailing commas es5)
- `app/Http/helpers.php` is autoloaded (global helpers file)

## Notable config (`config/constants.php`)
- `langs` includes `es` (Spanish) + 14 more; `es/` lang dir present with custom translations
- `asset_version: 478` — bump to invalidate cached assets
- Various feature flags (`enable_gst_report_india`, `enable_b2b_marketplace`, etc.)
- Document/image size limit: 5MB

## Architecture notes
- Facturación Electrónica (Colombia DIAN) controllers: `FacturacionElectronicaController`, `facturacionElectronicaReportesController`
- Restaurant sub-module under `app/Restaurant/` (tables, modifiers, kitchen, orders, bookings)
- Payments: Stripe, PayPal, Razorpay, Pesapal (Kenya), Paystack (Nigeria), Flutterwave
- WooCommerce sync supported (`toggle-woocommerce-sync`)
- E-commerce API routes at `/api/ecom/*` with dedicated middleware
- Recurring invoices / subscriptions supported
- Backup: `spatie/laravel-backup` config in `config/backup.php`
- Barcode printing via `milon/barcode`

## Gotchas
- .gitignore excludes `public/css/`, `public/fonts/`, `public/modules/`, `public/images/` — these are build artifacts
- `.shift` file is a stale artifact from Laravel Shift, safe to delete
- Frontend assets are combined into `public/js/vendor.js` and `public/css/vendor.css` (not standard Laravel Mix output)
- `app/Http/helpers.php` is globally loaded — check there first for utility functions
- ENV requires `ENVATO_PURCHASE_CODE` and `MAC_LICENCE_CODE` for licensed features

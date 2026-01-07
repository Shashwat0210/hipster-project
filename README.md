Laravel Multi-Auth Product Management System

Overview

This project is a backend-focused Laravel application built to demonstrate:

- Multi-authentication using separate Admin and Customer guards
- Secure product management with CRUD operations
- Large-scale product import using queues and chunk processing
- Real-time user presence using WebSockets
- Proper test coverage for core flows


Tech Stack

- Laravel 12  
- PHP 8.2  
- MySQL (application) 
- Laravel Reverb (WebSockets)  
- Laravel Queues (database driver)  
- maatwebsite/excel (CSV / Excel imports)  
- PHPUnit (testing)  

Setup Instructions

1. Clone the repository
```bash
git clone <your-repo-url>
cd hipster-project
```

2. Install dependencies
```bash
composer install
```

3. Environment configuration
```bash
cp .env.example .env
php artisan key:generate
```

Update database credentials in `.env`.

4. Run migrations
```bash
php artisan migrate
```

5. Create storage symlink
```bash
php artisan storage:link
```

6. Start background services

Queue worker (required for imports):
```bash
php artisan queue:work
```

WebSocket server:
```bash
php artisan reverb:start
```

7. Run the application
```bash
php artisan serve
```



Authentication System (Multi-Auth)

The application uses separate authentication guards instead of role-based conditionals.

Admin
- Table: `admins`
- Guard: `auth:admin`
- Access:
  - Admin dashboard
  - Product CRUD
  - Bulk imports
  - User presence monitoring

Customer
- Table: `customers`
- Guard: `auth:customer`
- Access:
  - Customer dashboard

Each user type has its own login, registration, session handling, and protected routes.



Product Management

Admin Capabilities
- Create, update, delete products
- Fields:
  - name
  - description
  - price
  - category
  - stock
  - image
- Default image is assigned if none is provided
- Pagination is used to avoid large result sets

All product routes are protected using the `auth:admin` middleware.



Bulk Product Import

Features
- Supports CSV and Excel files
- Handles imports of up to 100,000 products
- Uses background queues to prevent timeouts
- Chunked processing to control memory usage

Implementation Details
- Uses `maatwebsite/excel`
- Each chunk runs as an independent queued job
- Invalid rows fail safely without breaking the entire import
- Default product image is applied if missing in the file

Sample File
A real sample file used during development is included:

```
products_sample_import.csv
```



Real-Time Updates (WebSockets)

Stack Used
- Laravel Reverb
- Laravel Echo
- Presence Channels

Features
- Real-time online/offline presence for Admins and Customers
- Admin dashboard shows live presence updates

Design Notes
Presence state is persisted in the database (`user_presences` table) and treated as the source of truth.
WebSockets are used only for real-time join/leave updates.



Testing

The project includes both feature tests and unit tests.

Feature Test
- Verifies that an authenticated Admin can create a product
- Covers:
  - Guard-based authentication
  - Route protection
  - Database persistence

Unit Test
- Verifies user presence online/offline toggling
- Covers:
  - Business logic
  - Boolean casting behavior

Run tests
```bash
php artisan test
```



Architectural & Performance Decisions

- Separate auth tables instead of role flags
- Queue + chunk processing for large imports
- Database-backed presence state for reliability
- WebSockets used exclusively
- Thin controllers, minimal business logic in controllers

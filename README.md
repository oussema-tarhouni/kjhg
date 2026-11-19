# EOS Fitness & Pilates (PHP + MySQL)

Needs PHP 8.0+ with `pdo_mysql`, and MySQL/MariaDB (XAMPP works).

1. Import the schema: `mysql -u root -p < eos_schema_fixed.sql`
2. Set the DB values in `config.php` (and `ADMIN_GATE_CODE` in `config.admin.php`).
3. Create an admin: set `role='admin'` on a user, and store a real hash in `password_hash`
   (`php -r "echo password_hash('PASSWORD', PASSWORD_DEFAULT);"`). Plain-text passwords will not work.
4. Open `/` for the site. The admin login is at `/admin/<ADMIN_GATE_CODE>` (username + password only),
   and the panel is at `/access-admin`.

Dev server: `php -S localhost:8000 router.php`

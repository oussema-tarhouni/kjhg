1. mysql -u root -p < eos_schema_fixed.sql
2. Edit DB_* in config.php
3. php -S localhost:8000   -> open /register.php
Make admin: UPDATE users SET role='admin' WHERE email='you@x.com';

<?php
// ---- Configuration (override with environment variables) ----
define('API_BASE', rtrim(getenv('EOS_API_BASE') ?: 'http://localhost:3000/api', '/')); // the existing Node API
define('BASE', rtrim(getenv('EOS_BASE') ?: '', '/'));                                   // sub-folder, e.g. /eos ('' = web root)
define('APP_NAME', 'EOS Gym');
define('DEFAULT_CATEGORIES', ['Pilates','Dance Orientale','Zumba','Dance Tunisienne','Body Attack','Body Combat','Body Balance','Step','Lia','Yoga','Cardio Mix','CAF','Abdo','Circuit Training','Zumba Kids','Cross Fit Kids','EMOM']);

// ---- MySQL (XAMPP defaults) ----
define('DB_HOST', '127.0.0.1'); define('DB_PORT', 3306); define('DB_NAME', 'eos'); define('DB_USER', 'root'); define('DB_PASS', '');
define('AUTO_APPROVE', true); // true: new members are approved right after choosing a plan (no admin panel yet)

// ---- Email (verification code + password reset). Leave SMTP_USER empty to only log codes to otp_log.txt ----
define('SMTP_HOST', 'smtp.gmail.com'); define('SMTP_PORT', 587);
define('SMTP_USER', ''); // your Gmail address
define('SMTP_PASS', ''); // Gmail "App password" (16 chars), NOT your normal password

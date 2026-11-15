<?php
// ---- Configuration (override with environment variables) ----
define('API_BASE', rtrim(getenv('EOS_API_BASE') ?: 'http://localhost:3000/api', '/')); // the existing Node API
define('BASE', rtrim(getenv('EOS_BASE') ?: '', '/'));                                   // sub-folder, e.g. /eos ('' = web root)
define('APP_NAME', 'EOS Gym');
define('DEFAULT_CATEGORIES', ['Pilates','Dance Orientale','Zumba','Dance Tunisienne','Body Attack','Body Combat','Body Balance','Step','Lia','Yoga','Cardio Mix','CAF','Abdo','Circuit Training','Zumba Kids','Cross Fit Kids','EMOM']);

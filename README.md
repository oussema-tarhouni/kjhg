# EOS Fitness & Pilates — PHP version (converted from Angular 18)

Front end only, like the Angular app: it talks to the **same Node API** (`http://localhost:3000/api`).
Needs PHP 8.0+ with the `curl` extension.

## Run
    export EOS_API_BASE=http://localhost:3000/api   # your Node API
    php -S localhost:8000 router.php                # dev server
On Apache, point the document root here (`.htaccess` included). Sub-folder install: set `EOS_BASE=/folder`.

## Layout
- `index.php` front controller = `app.routes.ts` (guards -> `require_auth()`, `require_admin()`, reset-token check, admin gate code check)
- `lib/http.php` API client (access token + refresh cookie kept in the PHP session, never sent to the browser), `lib/helpers.php` layout helpers
- `api/proxy.php` same-origin `/api/*` proxy used by page scripts
- Server-rendered PHP: forgot/reset password, plan selection, admin gate, admin dashboard, terms, privacy
- Script-driven pages (landing, login, signup, OTP, pending, member dashboard): original HTML in `views/`, original logic transpiled to `assets/js/*.js`; `assets/js/eos-runtime.js` replaces Angular services/router
- `assets/css/*` = component styles; `data/*.json` = plan catalog, admin resource definitions, legal text
- `build.js` is the converter used (re-run against the Angular source to regenerate views/JS/CSS)

## Notes
- `AuthService.updateProfile()` is used by the dashboard but was missing from the repo; assumed `PUT /auth/me` (multipart) in `eos-runtime.js` — adjust to your API.
- Plan page: the selected category comes from `?cat=` instead of sessionStorage.
- Not executed against a live API here (no Node backend in the repo); all PHP files were syntax-checked.

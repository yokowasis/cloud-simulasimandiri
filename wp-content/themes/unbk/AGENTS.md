# AGENTS.md

## What this repo is

A commercial WordPress theme (`unbk`) implementing a full CBT (Computer-Based Test / UNBK exam simulation) platform — not a standard display theme. Core features: student management, question banks, answer submission, scoring, attendance, REST API, and a standalone admin SPA (`cbtadmin/`).

## Critical files NOT in the repo (gitignored)

Must be provisioned separately per deployment:

- `indb.php` — database credentials; referenced by `restapi/conn.php` and loaded throughout
- `lisensi.php` — license validation; silently included via `@include` in `functions.php` on every request

Without these, the site will silently fail license checks and lose all DB connectivity.

## Directory layout (non-obvious parts)

| Path             | Purpose                                                                             |
| ---------------- | ----------------------------------------------------------------------------------- |
| `functions.php`  | Main WP theme bootstrap; loads license, roles, hooks                                |
| `restapi/`       | Custom REST API (`conn.php` = DB connection, `query.php` = logic)                   |
| `cbtadmin/`      | Standalone HTML/JS SPA admin dashboard — not WP-templated                           |
| `api-18575621/`  | Obscurely named API directory (security by obscurity)                               |
| `js/*.js.php`    | PHP-generated JavaScript (e.g. server-side question randomization injected into JS) |
| `pm2/`           | PM2 config + trivial `index.js` placeholder to keep a Node process alive            |
| `admin-pages/`   | WP admin UI pages (settings, license, CDN, exam config)                             |
| `template-*.php` | WordPress page templates (exam, score check, confirmation, etc.)                    |

## PHP linting

```bash
vendor/bin/phpcs
```

No `phpcs.xml` ruleset in repo — specify standard manually (e.g. `--standard=PSR2`). Install deps first:

```bash
composer install
```

## No JS build pipeline

No `package.json`, no webpack/gulp/Vite. `jsconfig.json` exists (targets ES2015, `node16` modules) but references a `src/` directory that is not in the repo — likely leftover/aspirational config.

## No automated tests or CI

No PHPUnit, Jest, or CI workflows exist.

## PM2 sidecar

```bash
pm2 start pm2/ecosystem.config.js
```

Runs `pm2/index.js` — a trivial process that just stays alive (placeholder, possibly for a future real-time sync server).

## WordPress quirks

- `functions.php` defines `reset_role_akrr()` which manually resets WP roles and capabilities — the theme heavily overrides default WP user management.
- `func.php` contains only an empty `hitungnilai()` stub — don't assume this function has logic.
- `shortcode.php` defines WP shortcodes used across page templates.

## Exam client / Android bridge — focus-loss logout

The theme enforces an Android exam client in two ways:

**1. Android client detection (`header.php:175–185`)**

- If the `opt_iframe` option is enabled, students may only log in from inside an iframe OR when the URL contains the string `bimasoftcbt` (the Android WebView app identifier).
- Failing both checks replaces the login form with "Wajib Menggunakan Aplikasi Android Untuk Login".
- There is no native WebView JSInterface (`window.Android.*`) — detection is URL-string-only.

**2. Focus-loss logout (`archives/js/script.js:13–35`)**

- `selesaiTest()` (line 15) is the focus-loss logout function. When called it:
  - Starts a 2-second `setTimeout` that redirects to `"../"` (logout).
  - Shows a toast warning the student they will be logged out in 2 seconds.
- `logoutTimer` (line 13) is the timer handle; `$(document).click` (line 28) cancels it and shows "Logout di dibatalkan".
- **Critical gap: `selesaiTest()` is defined but never wired to any event.** No `visibilitychange`, `window blur`, `pause`, or equivalent listener currently calls it. To activate the feature, bind it to the appropriate event, e.g.:
  ```javascript
  document.addEventListener("visibilitychange", function () {
    if (document.hidden) selesaiTest();
  });
  ```

**3. Server-driven logout (`archives/js/script.js:137–142`)**

- Inside `jawabsoal()`, if the server returns `"logout"` the client alerts and redirects. This covers proctor-reset scenarios, not app-switch detection.

## Style / text domain

- Theme text domain: `unbk`
- Version tracked in both `style.css` header and `versi.txt` (must stay in sync)

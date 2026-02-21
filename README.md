# Laravel API Starter

A Laravel 12 API-only starter kit with [Laravel Sanctum](https://laravel.com/docs/sanctum) authentication, rate limiting, CORS, and OpenAPI documentation via [Scramble](https://scramble.dedoc.co).

## Features

- **API-only** — No frontend; designed for SPA or mobile clients
- **Sanctum authentication** — Token-based auth with register, login, logout
- **Email verification** — Optional verification flow with resend
- **Password reset** — Forgot and reset password via token
- **Rate limiting** — Throttling for auth, API, and authenticated endpoints
- **CORS** — Configurable via `APP_FRONTEND_URL` / `CORS_ALLOWED_ORIGINS`
- **OpenAPI docs** — Scramble generates docs from routes and Form Requests

## Requirements

- PHP 8.2+
- Composer
- SQLite (default) or MySQL/PostgreSQL

## Installation

```bash
# Clone and enter the project
git clone <repository-url> laravel-api-starter
cd laravel-api-starter

# One-time setup (install, .env, key, migrate)
composer run setup
```

Or step by step:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Configuration

- **`.env`** — Copy from `.env.example`. Set `APP_URL` and, for CORS, `APP_FRONTEND_URL` or `CORS_ALLOWED_ORIGINS` (comma-separated).
- **Database** — Default is SQLite; configure `DB_*` for MySQL/PostgreSQL if needed.
- **Mail** — Set `MAIL_*` for email verification and password reset (e.g. Mailtrap, SMTP).

## Running the Application

The app is intended to be served by [Laravel Herd](https://herd.laravel.com) at `https://laravel-api-starter.test` (or your project’s kebab-case name). No `php artisan serve` is required when using Herd.

For local development without Herd:

```bash
php artisan serve
```

Optional (if using queues):

```bash
composer run dev   # runs serve + queue:listen
```

## API Documentation

Scramble serves interactive API docs at **`/docs/api`** when the app is running. It builds OpenAPI from your routes and Form Request validation.

## API Endpoints

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/register` | — | Register; returns user + token; sends verification email |
| POST | `/login` | — | Login; returns user + token |
| POST | `/logout` | Bearer | Revoke current token |
| GET | `/user` | Bearer | Current authenticated user |
| POST | `/email/verify/{id}/{hash}` | Bearer + Signed | Verify email |
| POST | `/email/send-verification` | Bearer | Resend verification email |
| POST | `/forgot-password` | — | Request password reset email |
| POST | `/reset-password` | — | Reset password with token |

Authenticated requests must send: `Authorization: Bearer <token>`.

## Testing

Tests use [Pest](https://pestphp.com). Run:

```bash
php artisan test --compact
```

Or via Composer:

```bash
composer run test
```

## Code Style

[Laravel Pint](https://laravel.com/docs/pint) is used for formatting:

```bash
vendor/bin/pint --dirty --format agent
```

## License

The Laravel framework is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

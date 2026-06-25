# VoteHub Online Voting System

VoteHub is a Laravel-based online voting system created as a final project for ELECTIVE 1. The system supports voter registration, authenticated login, election and candidate management, ballot submission, vote receipts, public result viewing, and admin-only analytics.

## Project Members

- Mariphil Marigmen
- Mariella Ovido
- Manuelito Latiza

## Main Features

- User registration and login
- Admin and voter role separation
- Election management for admins
- Candidate management for admins
- Active-election voting window using start and end date/time
- Ballot submission with one President, one Vice President, and up to three Senators
- One completed ballot per voter per election
- Vote receipt page with optional print action
- Public election result endpoint
- Admin-only result and analytics endpoints
- Token-based API authentication for protected API calls

## Tech Stack

- PHP 8.3
- Laravel 13
- SQLite
- Blade templates
- Tailwind CSS
- Alpine.js
- Vite
- Pest / PHPUnit

## Installation

Clone the repository, then install PHP and JavaScript dependencies:

```bash
composer install
npm install
```

Create the environment file and application key:

```bash
cp .env.example .env
php artisan key:generate
```

Create the SQLite database if it does not exist:

```bash
touch database/database.sqlite
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```

Build frontend assets:

```bash
npm run build
```

Start the local server:

```bash
php artisan serve
```

The application will usually run at:

```text
http://127.0.0.1:8000
```

## Default Accounts

After running the seeders, the following accounts are available:

| Role | Email | Password |
| --- | --- | --- |
| Admin | admin@example.com | password123 |
| Voter | test@example.com | password |

Newly registered users are not logged in automatically. After registration, users are redirected to the login page and must enter their credentials before accessing the dashboard.

## Web Authentication Flow

1. Open the system in the browser.
2. Register a voter account or use one of the seeded accounts.
3. Log in using email and password.
4. The dashboard redirects users based on their role:
   - Admins can manage elections, candidates, results, and analytics.
   - Voters can view active elections and submit ballots.
5. Log out from the account menu when finished.

## API Authentication Flow

The API uses bearer token authentication. Public endpoints can be viewed without a token, but protected endpoints require a token from `/api/login`.

### Login And Get Token

```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password123"}'
```

The response includes a token:

```json
{
  "token": "generated-api-token",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@example.com",
    "is_admin": true
  }
}
```

### Access Protected Endpoint

Use the token in the `Authorization` header:

```bash
curl http://127.0.0.1:8000/api/user \
  -H "Accept: application/json" \
  -H "Authorization: Bearer generated-api-token"
```

### Logout API Token

```bash
curl -X POST http://127.0.0.1:8000/api/logout \
  -H "Accept: application/json" \
  -H "Authorization: Bearer generated-api-token"
```

## API Route Summary

Public endpoints:

- `POST /api/login`
- `GET /api/candidates`
- `GET /api/candidates/{candidate}`
- `GET /api/elections`
- `GET /api/elections/{election}`
- `GET /api/elections/{election}/candidates`
- `GET /api/elections/{election}/results/public`

Authenticated voter endpoints:

- `GET /api/user`
- `POST /api/logout`
- `POST /api/votes`
- `GET /api/votes`

Authenticated admin endpoints:

- `POST /api/elections`
- `PUT/PATCH /api/elections/{election}`
- `DELETE /api/elections/{election}`
- `POST /api/candidates`
- `PUT/PATCH /api/candidates/{candidate}`
- `DELETE /api/candidates/{candidate}`
- `GET /api/elections/{election}/results`
- `GET /api/elections/{election}/results/summary`

## Running Tests

```bash
php artisan test
```

## Notes

- Only active elections can be voted on.
- Voters can vote only once per election.
- Admin routes are protected by authentication and admin middleware.
- API protected routes require `Authorization: Bearer <token>`.

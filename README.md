# GovPrep Hub (Core PHP + MySQL)

Production-oriented Government Job & Competitive Exam preparation platform using HTML5, Tailwind CSS, Vanilla JS, Core PHP, MySQL, AJAX, and Font Awesome.

## Modules Included
- Course selling with secure checkout and coupon handling.
- Test series with timed attempt page, auto-submit and negative-marking score calculation.
- Job alert portal with state/qualification filters, save-job workflow and share actions.
- Blog system scaffold.
- User auth (bcrypt hashing, password_verify, CSRF, session regeneration) with token-based password reset flow.
- User dashboard (courses, results, saved jobs, orders) and role-based admin panel.
- SEO essentials (`sitemap.xml`, `robots.txt`).

## Folder Structure
```text
.
├── admin/
├── app/
│   ├── ajax/
│   ├── config/
│   ├── controllers/
│   ├── helpers/
│   ├── middleware/
│   └── views/
├── assets/
│   ├── css/
│   └── js/
├── database/
│   └── schema.sql
├── docs/
├── public/
│   ├── certificates/
│   ├── invoices/
│   └── uploads/
├── *.php pages
├── robots.txt
└── sitemap.xml
```

## Setup
1. Create database and import schema:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
2. Copy env:
   ```bash
   cp .env.example .env
   ```
3. Serve app:
   ```bash
   php -S 0.0.0.0:8000
   ```
4. Login as admin:
   - Email: `admin@govprephub.in`
   - Password: `admin123`

## Security Controls
- Prepared statements throughout endpoints.
- Bcrypt password hashing and password verification.
- CSRF token generation and validation.
- Session fixation protection with `session_regenerate_id(true)`.
- RBAC middleware for admin routes.

## Payment Integration Notes
- `/app/ajax/payment_checkout.php` contains Razorpay/UPI/Card checkout flow scaffolding.
- Replace demo transaction creation with Razorpay order API call and signature verification in production.

## Deployment Guide
See `docs/DEPLOYMENT.md`.

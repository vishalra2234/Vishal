# Deployment Guide

## 1. Server Requirements
- PHP 8.1+
- MySQL 8+
- Nginx/Apache
- SSL certificate

## 2. Production Steps
1. Upload project to server.
2. Configure `.env` with production DB and Razorpay keys.
3. Import `database/schema.sql`.
4. Set writable permissions for:
   - `public/uploads`
   - `public/invoices`
   - `public/certificates`
5. Point web root to project root (or proxy requests accordingly).
6. Enable HTTPS and secure session cookies.
7. Add cron for notification emails/jobs scraping (optional extension).

## 3. Nginx Example
```nginx
server {
  listen 443 ssl;
  server_name yourdomain.com;
  root /var/www/govprep;
  index index.php;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
  }
}
```

## 4. Hardening
- Disable PHP error display in production.
- Rotate DB credentials.
- Enable backup/monitoring.
- Implement rate limiting and brute-force mitigation.

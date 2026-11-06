# Akhitech.com - Enterprise Agency & IT Solutions Platform

A modern, high-performance, and secure enterprise Agency & IT Solutions web platform built with **Laravel 13.17** and **PHP 8.4**. Featuring a dynamic customer-facing website, a comprehensive Admin Panel (CMS), hardened security layers, automated SEO sitemap generation, and role-based access control.

---

## 🌟 Key Features

### 🌐 Frontend (Public Website)
- **Modern Responsive Design:** Tailored for IT services, software agencies, and digital consulting firms.
- **Dynamic Services & Pricing Packages:** Showcase tiered pricing plans, features, and service offerings.
- **Portfolio Showcase:** Project gallery with filterable categories and dedicated slug-based detail pages.
- **Blog & Knowledge Base:** Search-engine-friendly blog engine with categories, reading times, and slug URLs.
- **Interactive Forms:** Contact inquiry forms, custom quotation requests, and newsletter subscription with CSRF protection and server-side validation.
- **Custom Pages Engine:** Unlimited custom landing pages with custom header/footer menu placements and full SEO meta tags.
- **OpenGraph & Social Meta:** Dynamic OpenGraph (Facebook, LinkedIn, WhatsApp) and Twitter Card tags on all pages.

### 🛡️ Hardened Security Architecture
- **Custom Secure Admin Portal:** Concealed admin login entry point at `/secure-portal` (default `/admin` or `/login` are blocked/redirected to prevent automated bot probing).
- **Rate Limiting & Brute-Force Protection:** Intelligent throttling on authentication attempts to mitigate brute-force attacks.
- **Session & Login Activity Auditing:** Full audit trail tracking IP address, User Agent, device/browser, login time, and status.
- **Remote Force-Logout:** Terminate active sessions of any administrator account in real time.
- **Inactivity Timeout:** Automatic admin session invalidation after periods of idle time.
- **Re-Authentication on Critical Actions:** Mandatory password verification before sensitive account or password updates.
- **Security Headers Middleware:** Full suite of enterprise HTTP security headers pre-configured (`HSTS`, `X-Content-Type-Options`, `X-Frame-Options: SAMEORIGIN`, `Content-Security-Policy`, `Referrer-Policy`, `Permissions-Policy`).
- **Military-Grade File Upload Security:**
  - Strict extension whitelisting (`.png`, `.jpg`, `.jpeg`, `.webp`, `.gif`).
  - Server-side MIME type inspection inspecting file binary headers.
  - 5 MB file size limit enforcement.
  - Cryptographically random 40-character filenames (original filenames discarded).
  - Null-byte injection and double-extension blocking (`shell.php.jpg`).
  - PHP GD safe image reprocessing (re-encodes raw pixel data, stripping EXIF, metadata, and embedded script payloads).
  - Direct script execution denial via `public/uploads/.htaccess` (`-ExecCGI`, `php_flag engine off`).

### ⚙️ Content Management System (Admin Panel)
- **Admin Dashboard:** Real-time business metrics, visitor inquiries, and system overviews.
- **Full CRUD Management:**
  - Services, Pricing Packages, Portfolio Projects, Blog Posts, Testimonials, Team Members, Achievements, and Custom Pages.
- **Customer Leads:** View, manage, and filter contact inquiries and quotation requests.
- **Global Website Settings:**
  - Brand identity, logos (header/footer/favicon), hero banners, about section, social links, and contact info.
  - SEO tracking: **Google Analytics 4 (Measurement ID)**, **Google Search Console verification**, and **Bing Webmaster Tools (`msvalidate.01`)**.
- **SEO XML Sitemap Manager (`/sitemap.xml`):**
  - Real-time dynamic URL generation for search engine crawlers.
  - Dedicated Admin Panel interface with one-click **"Generate / Update Sitemap"** button.
  - URL inspection table with priority, change frequency, and last modified dates.
  - Direct `sitemap.xml` download and submission instructions for Google and Bing.
- **Granular RBAC (Roles & Permissions):** Powered by Spatie Permission with custom module-based access control.

---

## 📋 System Requirements

Ensure your server or hosting environment meets the following specifications:

| Component | Minimum Requirement | Recommended |
| :--- | :--- | :--- |
| **PHP Version** | `>= 8.2` | `8.4` |
| **Database** | MySQL `8.0+` / MariaDB `10.4+` | MySQL `8.0+` |
| **Web Server** | Apache `2.4+` (with `mod_rewrite`) or Nginx | Nginx or Apache |
| **Composer** | `2.x+` | Latest |
| **Node.js & NPM** | `18.x+` (for compiling assets) | `20.x+ LTS` |

### Required PHP Extensions:
- `BCMath`
- `Ctype`
- `cURL`
- `DOM / XML`
- `Fileinfo`
- `GD` (compiled with WebP, JPEG, PNG, GIF support)
- `JSON`
- `Mbstring`
- `OpenSSL`
- `PDO` & `pdo_mysql` (or `pdo_sqlite`)
- `Tokenizer`

---

## 🚀 Installation & Setup Guide

### 1. Clone or Extract the Repository
```bash
git clone https://github.com/bdnahid55/akhitech.com.git
cd akhitech.com
```

### 2. Install PHP Dependencies
```bash
composer install --optimize-autoloader
```
*(For production deployments, add the `--no-dev` flag)*

### 3. Configure the Environment
Create your `.env` configuration file from the sample:
```bash
cp .env.example .env
```
Open `.env` in your text editor and configure your database and application URL:
```env
APP_NAME="Akhitech"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=akhitech_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Database Migrations & Seeders
This creates all required database tables and provisions default roles, permissions, settings, and the default Super Admin user:
```bash
php artisan migrate --seed
```

### 6. Create Storage Symlink & Set Folder Permissions
Ensure web server has write access to storage, cache, and uploads:
```bash
php artisan storage:link
```
On Linux/macOS or cPanel/VPS:
```bash
chmod -R 775 storage bootstrap/cache public/uploads
```

### 7. Compile Frontend Assets (Vite)
```bash
npm install
npm run build
```

### 8. Generate Initial XML Sitemap
```bash
php artisan sitemap:generate
```

### 9. Start Local Development Server
```bash
php artisan serve
```
Your website is now accessible at: **`http://localhost:8000`**

---

## 🔐 Default Admin Credentials

For security, the administration panel is located at the custom secure portal URL:

- **Admin Login URL:** `http://localhost:8000/secure-portal`
- **Email:** `admin@akhitech.com`
- **Password:** `password123`

> [!IMPORTANT]
> Immediately upon logging in to a production or public environment, navigate to **Admins (`/admin/admins`)** or your profile to change the default email and password.

---

## 🚢 Production Deployment Checklist

When deploying to a live server (cPanel, Shared Hosting, VPS, or Laravel Cloud):

1. **Set Production Environment in `.env`:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   ```

2. **Configure Mail Server (SMTP):**
   To receive contact form and quotation requests via email, configure valid SMTP credentials in `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailgun.org (or your host)
   MAIL_PORT=587
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="no-reply@yourdomain.com"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

3. **Web Server Document Root:**
   Ensure your web server's Document Root points strictly to the **`public/`** folder (never the project root).
   - *Apache:* Ensure `mod_rewrite` is enabled.
   - *Nginx:* Ensure standard Laravel `try_files $uri $uri/ /index.php?$query_string;` block is configured.

4. **Optimize for Production:**
   Run the following optimization commands:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan event:cache
   ```

5. **Submit Sitemap to Search Engines:**
   - **Google Search Console:** Submit `sitemap.xml` under *Sitemaps*.
   - **Bing Webmaster Tools:** Submit `https://yourdomain.com/sitemap.xml`.

---

## 🛠️ Handy Artisan Commands

```bash
# Generate / Refresh XML Sitemap
php artisan sitemap:generate

# Clear all application caches
php artisan optimize:clear

# Cache configuration, routes, and views for speed
php artisan optimize

# Run automated test suite
php artisan test --compact

# Code style formatting (Laravel Pint)
vendor/bin/pint
```

---

## 🧪 Automated Testing

This project includes a comprehensive test suite covering authentication, security headers, file upload protection, inactivity logout, permissions, and sitemap generation.

To run the full test suite:
```bash
php artisan test
```
All **61 automated tests (396 assertions)** are passing out of the box.

---

## 📄 License & Credits

- Developed for **Akhitech.com**
- Framework: [Laravel](https://laravel.com)
- Icons: [FontAwesome 5](https://fontawesome.com)
- Admin Template: [AdminLTE 3](https://adminlte.io)

For inquiries or support, contact [info@akhitech.com](mailto:info@akhitech.com).

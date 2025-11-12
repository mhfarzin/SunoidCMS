# Sunoid CMS

A lightweight, secure, and framework-free **Content Management System (CMS)** built with pure PHP.  
Ideal for small websites, blogs, personal projects, or learning core PHP MVC concepts.

---

## ✨ Features

- **No external dependencies** – pure PHP (7.4+)
- **Secure by default** – protected config/core files, no direct access allowed
- **Dynamic pages** – store and manage pages in a database
- **Theme support** – easily switch between front-end templates
- **Admin panel** – built-in interface for managing content
- **Asset versioning** – cache-busting via file modification time
- **Installation wizard** – one-click setup with database auto-creation
- **PDO-based database layer** – safe from SQL injection

---

## 📁 Project Structure

```
/cms
├── admin/                # Admin panel (publicly accessible)
├── config/
│   └── database.php      # Database credentials (protected)
├── core/
│   ├── db.php            # PDO wrapper
│   ├── functions.php     # Helper functions (dd, asset, etc.)
│   ├── router.php        # URL routing & page dispatching
│   └── template.php      # Theme-based rendering engine
├── public/
│   └── index.php         # Public front controller
├── templates/
│   └── default/
│       └── pages/        # Page view files (e.g., home.php, raw.php)
├── index.php             # Bootstrap & setup guard
├── setup.php             # Installation script (auto-locks after first run)
├── installed.lock        # Prevents re-installation
└── README.md
```

> 🔒 **Security Note**  
> Only `index.php`, `public/`, `admin/`, and `setup.php` are meant to be web-accessible.  
> All other directories (`config/`, `core/`, etc.) are protected via `.htaccess` (`Require all denied`) **and** PHP-level access checks (`defined('CMS_LOADED')`).

---

## 🛠️ Requirements

- PHP 7.4 or higher  
- MySQL 5.7+ (or MariaDB 10.2+)  
- Apache with `mod_rewrite` enabled (for clean URLs)  
- Write permission in project root (for `installed.lock`)

---

## 🚀 Installation

1. **Upload** the project files to your web server (e.g., `public_html/`).
2. **Create** a MySQL database and user.
3. **Edit** `config/database.php` with your credentials:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'your_db_name');
   define('DB_USER', 'your_db_user');
   define('DB_PASS', 'your_strong_password');
   ```

4. **Visit** your site in a browser:  
   `http://yoursite.com/setup.php`

5. Follow the installer — it will create the `pages` table and a sample homepage.
6. After installation, you’ll be redirected to the homepage automatically.

> ⚠️ **Important:**  
> After successful installation, **do not delete** `installed.lock` in production.  
> It prevents accidental re-installation and data loss.

---

## 🔒 Security Best Practices

- ✅ Never commit `config/database.php` to version control (add it to `.gitignore`)
- ✅ Set `DEBUG = false` in `index.php` on production
- ✅ Ensure `config/` and `core/` are not directly accessible (`.htaccess` included)
- ✅ Use strong database credentials (avoid using root with an empty password)
- ✅ Remove or password-protect `setup.php` after deployment (optional but recommended)

---

## 🧩 Customization

### ➕ Add a New Page Template
1. Create a file in `templates/default/pages/` (e.g., `about.php`).
2. When creating a page in admin, set **Template** to `about`.
3. The system will render your custom layout automatically.

### 🛣️ Add a Static Route
In `public/index.php`:
```php
$router->add('contact', function() {
    include __DIR__ . '/../custom/contact.php';
});
```

---

## 🧰 Helper Functions

- `dd($var)` – Dump and die (with nice formatting)  
- `asset('css/style.css')` – Returns `/templates/default/assets/css/style.css?v=123456789`

---

## 📜 License

MIT License – feel free to use, modify, and distribute.  

Built with simplicity and security in mind.  
**Happy coding! 💻**

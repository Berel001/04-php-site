# Prime Cleaners Ltd

A responsive, multi-page website for a fictional cleaning business. The project is a hands-on PHP 8 learning site: shared includes keep page layouts consistent, service and team details are stored as PHP arrays, and the contact form validates and stores submissions as JSON Lines.

## Features

- Shared header, footer, navigation, and site configuration.
- Home, About, Services, Contact, and individual service-detail pages.
- Services and team members rendered from data arrays.
- Escaped dynamic output through a reusable helper.
- Contact form with server-side validation, sticky values, CSRF protection, and Post/Redirect/Get.
- Timestamped contact submissions appended to `storage/messages.jsonl`.
- Password-protected local inbox at `messages.php`, sorted newest first.
- Responsive styling with accessibility considerations.

## Tech stack

- PHP 8 with strict types
- HTML5
- CSS3
- JSON Lines for local contact-message storage
- Apache through XAMPP

## Run with XAMPP

1. Install and start **Apache** from the XAMPP Control Panel.
2. Keep the project folder at:

   ```text
   C:\xampp\htdocs\swd\04-php-site
   ```

3. Open the site at:

   [http://localhost/swd/04-php-site/](http://localhost/swd/04-php-site/)

4. Open the message inbox at:

   [http://localhost/swd/04-php-site/messages.php](http://localhost/swd/04-php-site/messages.php)

5. For this local learning project, the inbox password is `local-learning-password`. It is configured in `includes/config.php`; change it before using the local inbox.

The contact form creates `storage/messages.jsonl` on the first successful submission. The `storage/.htaccess` file denies direct web access to that folder when Apache's `.htaccess` rules are enabled.

## Project structure

```text
04-php-site/
+-- about.php
+-- contact.php
+-- index.php
+-- messages.php
+-- service.php
+-- services.php
+-- README.md
+-- assets/
|   +-- css/
|       +-- style.css
+-- includes/
|   +-- config.php
|   +-- data.php
|   +-- footer.php
|   +-- functions.php
|   +-- header.php
+-- storage/
    +-- .htaccess
    +-- messages.jsonl  (created after the first successful contact submission)
```

## What I learned

- I learned how to use PHP includes and `require_once`:
  - _Write your notes here._
- I learned how to use arrays and `foreach` to render repeated content:
  - _Write your notes here._
- I learned how to validate and safely display form input:
  - _Write your notes here._
- I learned how sessions, CSRF tokens, and Post/Redirect/Get work:
  - _Write your notes here._
- I learned how to read and write JSON Lines data in PHP:
  - _Write your notes here._

## Local learning security note

The inbox password is hard-coded in a PHP configuration file and is checked using a simple session flag. This is only suitable for a local learning exercise. It is not production-grade authentication: the password is not managed through a secure user system, there is no rate limiting or audit trail, and deployment mistakes could expose the configuration or message data. For a real site, use proper authentication, secure secret management, HTTPS, restrictive file permissions, and a database or protected storage service. Do not deploy this demo inbox publicly.

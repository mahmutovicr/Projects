# Log in form

<p align="center">
  <img src="Log_in_Form_scr.webp" alt="Login Page" width="45%"/>
  <img src="Log_in_Form.webp" alt="Registration Page" width="45%"/>
</p>

<p align="center">
  <em>Log in page</em>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <em>Registration Page</em>
</p>

## About

A secure user authentication system built with PHP and MySQL featuring registration, login, and session management.

## Features

- User registration and login
- Password hashing with bcrypt
- Session-based authentication
- Form validation and error handling
- SQL injection prevention using prepared statements
- Responsive design with Bootstrap 5

## Tech Stack

PHP | MySQL | HTML | CSS | Bootstrap 5

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache server (XAMPP, WAMP, or similar)

## Database Setup

1. Create a MySQL database named `login_register`
2. Create the `users` table with the following structure:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. Update database credentials in `database.php`:
   - Default port: `3307` (change if needed)
   - Host: `localhost`
   - Username: `root`
   - Password: `` (empty by default)

## Installation

1. Clone the repository or download the files
2. Place files in your web server directory (e.g., `htdocs` for XAMPP)
3. Configure database connection in `database.php`
4. Start Apache and MySQL servers
5. Navigate to `http://localhost/log-in-form/registration.php` to create an account


## ⚠️ For production use:

- Change database credentials from defaults
- Enable HTTPS
- Add CSRF protection
- Implement rate limiting
- Add email verification

## License

MIT License - See [LICENSE](../LICENSE) file for details


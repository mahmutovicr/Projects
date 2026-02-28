# Log In Form

<table align="center">
  <tr>
    <td align="center"><img src="Log_in_Form_scr.webp" alt="Login Page" width="100%"/></td>
    <td align="center"><img src="Log_in_Form.webp" alt="Registration Page" width="100%"/></td>
  </tr>
  <tr>
    <td align="center"><em>Log in page</em></td>
    <td align="center"><em>Registration Page</em></td>
  </tr>
</table>

A secure authentication system with user registration, log in and session management

## Features
- User registration and log in
- Password hashing with bcrypt
- Session-based authentication
- Form validation and error handling
- SQL injection prevention using prepared statements
- Responsive design with Bootstrap 5

## Tech Stack
PHP | MySQL | HTML | CSS | Bootstrap 5

## Database Setup
1. Create a MySQL database named `login_register`
2. Create the `users` table:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
3. Update database credentials in `database.php`

## Installation
1. Clone the repository or download the files
2. Place files in your web server directory (e.g., `htdocs` for XAMPP)
3. Configure database connection in `database.php`
4. Start Apache and MySQL servers
5. Navigate to `http://localhost/log-in-form/registration.php`

## Production Checklist
- Change default database credentials
- Enable HTTPS
- Add CSRF protection
- Implement rate limiting
- Add email verification

## License
MIT License - See [LICENSE](../LICENSE) file for details


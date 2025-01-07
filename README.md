# Hotel Reception Panel

## Project Description
An admin and receptionist panel for a hotel to manage bookings, rooms, guests, employees, and additional services.

---

## Features
- **Booking Management:**
  - Create, view, edit, delete, and search for bookings.
  - Update booking statuses.
- **Room Management:**
  - View, add, edit, and delete rooms.
  - Manage room properties.
  - Search rooms based on availability:
    - Search for rooms that are currently free.
    - Search for occupied rooms that will be available on specific dates (flexible search) with additional properties
- **Guest Management:**
  - Create, edit, delete, and search for guests.
  - Manage relationships between guests.
- **Employee Management:**
  - Add, edit, and delete employees.
- **Additional Services Management:**
  - Create, edit, and delete services.
---

## Installation and Setup

### Requirements:
- PHP 8.2+
- Laravel 11.0+
- MySQL
- Composer

### Instructions:
1. Clone the repository:
   ```bash
   git clone https://github.com/svtcore/laravel-hotel-reception-panel.git
   cd laravel-hotel-reception-panel
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Create a `.env` file and configure the parameters (example in `.env.example`):
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hotel_db
   DB_USERNAME=root
   DB_PASSWORD=secret
   CSP_ENABLED=TRUE
   ```
4. Generate application key
   ```
   php artisan key:generate
   ```
5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```
6. Start the local server:
   ```bash
   php artisan serve
   ```
6. Open `http://localhost:8000` in your browser
   
7. Default admin credentials
    ```
    admin@admin.com:password
    ```
---

## Security

To ensure the security of the Laravel application, several security mechanisms have been implemented:

- **Input data are sanitized**: All user inputs are filtered to prevent SQL injection, XSS, and other malicious activities.

- **Content Security Policy (CSP)**

- **Permission Policy**

- **External file integrity on blade templates**
## Screenshots
![Screenshot_1](https://github.com/svtcore/laravel-hotel-reception-panel/blob/main/screenshots/Screenshot_1.png)
![Screenshot_2](https://github.com/svtcore/laravel-hotel-reception-panel/blob/main/screenshots/Screenshot_2.png)
![Screenshot_3](https://github.com/svtcore/laravel-hotel-reception-panel/blob/main/screenshots/Screenshot_3.png)

---

## License
This project is licensed under the MIT License. See [LICENSE](https://github.com/svtcore/laravel-hotel-reception-panel/blob/main/LICENSE) for details.


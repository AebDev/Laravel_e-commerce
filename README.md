Laravel E-Commerce


A robust and scalable e-commerce platform built with Laravel 11, designed for modern online stores. This project integrates essential features like user authentication, product management, cart functionality, and order processing, providing a solid foundation for any e-commerce application.

🚀 Features
User Authentication: Secure login and registration with Laravel Breeze.

Product Management: Admin panel for adding, editing, and deleting products.

Shopping Cart: Add products to the cart with quantity adjustments.

Order Management: Users can place orders and view order history.

Responsive Design: Mobile-first design ensuring a seamless shopping experience.

Admin Dashboard: Overview of orders, products, and users.

🛠️ Technologies Used
Backend: PHP 8.2+, Laravel 11

Frontend: Blade templating, Bootstrap 5

Database: MySQL

Authentication: Laravel Breeze

Development Tools: Composer, NPM, Artisan

📦 Installation
Prerequisites
Ensure you have the following installed:

PHP 8.2 or higher

Composer

Node.js and NPM

MySQL or MariaDB

Steps
Clone the repository:

bash
Copier
Modifier
git clone https://github.com/AebDev/Laravel_e-commerce.git
cd Laravel_e-commerce
Install PHP dependencies:

bash
Copier
Modifier
composer install
Copy the example environment file:

bash
Copier
Modifier
cp .env.example .env
Generate the application key:

bash
Copier
Modifier
php artisan key:generate
Set up your database in .env:

env
Copier
Modifier
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
Run migrations and seed the database:

bash
Copier
Modifier
php artisan migrate --seed
Install frontend dependencies and compile assets:

bash
Copier
Modifier
npm install
npm run dev
Serve the application:

bash
Copier
Modifier
php artisan serve
Access the application at http://localhost:8000.

🔐 Authentication
Admin Login: Use the credentials set during seeding or create a new admin user via Tinker:

bash
Copier
Modifier
php artisan tinker
User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);
📸 Screenshots




📄 License
This project is open-source and available under the MIT License.

🙏 Acknowledgements
Surfside Media for the Laravel 11 E-Commerce Project tutorial.

Bootstrap for the responsive frontend framework.

Laravel for the powerful PHP framework.

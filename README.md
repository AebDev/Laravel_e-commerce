
# Laravel E-Commerce

![Laravel E-Commerce](https://www.surfsidemedia.in/post/laravel-11-e-commerce-project-project-layout-setup)

A robust and scalable e-commerce platform built with Laravel 11, designed for modern online stores. This project integrates essential features like user authentication, product management, cart functionality, and order processing, providing a solid foundation for any e-commerce application.

## 🚀 Features

* **User Authentication**: Secure login and registration with Laravel Breeze.
* **Product Management**: Admin panel for adding, editing, and deleting products.
* **Shopping Cart**: Add products to the cart with quantity adjustments.
* **Order Management**: Users can place orders and view order history.
* **Responsive Design**: Mobile-first design ensuring a seamless shopping experience.
* **Admin Dashboard**: Overview of orders, products, and users.

## 🛠️ Technologies Used

* **Backend**: PHP 8.2+, Laravel 11
* **Frontend**: Blade templating, Bootstrap 5
* **Database**: MySQL
* **Authentication**: Laravel Breeze
* **Development Tools**: Composer, NPM, Artisan

## 📦 Installation

### Prerequisites

Ensure you have the following installed:

* PHP 8.2 or higher
* Composer
* Node.js and NPM
* MySQL or MariaDB

### Steps

1. Clone the repository:

   ```bash
   git clone https://github.com/AebDev/Laravel_e-commerce.git
   cd Laravel_e-commerce
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Copy the example environment file:

   ```bash
   cp .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Set up your database in `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

6. Run migrations and seed the database:

   ```bash
   php artisan migrate --seed
   ```

7. Install frontend dependencies and compile assets:

   ```bash
   npm install
   npm run dev
   ```

8. Serve the application:

   ```bash
   php artisan serve
   ```

   Access the application at [http://localhost:8000](http://localhost:8000).

## 🔐 Authentication

* **Admin Login**: Use the credentials set during seeding or create a new admin user via Tinker:

  ```bash
  php artisan tinker
  User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);
  ```

## 📸 Screenshots

![Home Page](https://www.surfsidemedia.in/post/laravel-11-e-commerce-project-project-layout-setup)

![Admin Dashboard](https://www.surfsidemedia.in/post/laravel-11-e-commerce-project-project-layout-setup)

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

## 🙏 Acknowledgements

* [Surfside Media](https://www.surfsidemedia.in) for the Laravel 11 E-Commerce Project tutorial.
* [Bootstrap](https://getbootstrap.com) for the responsive frontend framework.
* [Laravel](https://laravel.com) for the powerful PHP framework.

---

Feel free to customize this README further to match your project's specific features and branding!

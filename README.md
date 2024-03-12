# Disclaimer

This project was carried out as part of the Internet Applications course in computer engineering at the Polytechnic Institute of Leiria.

# About Project

The **objective** of this project is to implement a server-based Web application, using the Laravel Framework, to simulate an online store "ImagineShirt" that sells printed t-shirts.

The online store "ImagineShirt" allows customers to choose images for t-shirts from the store's catalog or submit their own images. Customers can add t-shirts to the shopping cart, selecting color, size, and quantity. To confirm the purchase, the customer needs to authenticate and provide payment and shipping information. Orders remain pending until payment is confirmed, then marked as paid and closed after shipping. Employees handle orders, declaring them as paid or closed. Administrators can also cancel orders. There are four prices for t-shirts, depending on the image's origin and quantity discounts.
# Softwares Requeriments

This project used the following softwares:

- **Laravel** - An open-source web application framework written in PHP. It provides a structure for developing robust and secure web applications.
- **DataBase** - Laravel supports various database management systems like MySQL, PostgreSQL, SQLite, and SQL Server.
- For dependencies **npm** - The default package manager for the JavaScript ecosystem. It is used to install and manage project dependencies.

**Optional Softwares**

- **Postman** - A collaboration tool for API development. It is used to test the application's endpoints. (Remember that the project already has a built-in **telescope** for debugging)
- **Laragon** - A local development environment that includes Apache, PHP, MySQL, and other essential tools for web developers. It is a recommended option for web application development on Windows.
# How to run Project

Laravel Folder

```bash
# Inside the LaravelAPI folder (first time)
composer install
php artisan key:generate
php artisan migrate:fresh
composer dump-autoload
php artisan db:seed # Choose option 0 for test
php artisan storage:link
npm install
npm run build

# When not using Laragon - Run Server
php artisan serve
```

This project simulates an sender mail with https://mailtrap.io/, then you need to make the corresponding changes to the project's .env file

**Caution** - To log-in into web application you need to go to the database and get an email address from users_table and the password for anyone is 123

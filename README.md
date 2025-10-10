# UIO Paws - API Backend

This repository contains the backend API for **UIO Paws**, a comprehensive pet adoption platform. This API is built with Laravel and provides a secure, role-based RESTful service for managing users and platform data. It uses Laravel Sanctum for authentication.

---

## ✨ Features

-   **Secure Authentication**: User registration, login, and logout endpoints powered by Laravel Sanctum.
-   **Role-Based Access Control (RBAC)**: Differentiates between regular users and administrators, protecting sensitive endpoints.
-   **Full User Management**: Complete CRUD (Create, Read, Update, Delete) functionality for administrators to manage all users.
-   **RESTful Architecture**: Follows REST principles for predictable and easy-to-understand API design.

---

## 🛠️ Technology Stack

-   **Framework**: Laravel 12
-   **Language**: PHP 8.3
-   **Database**: MySQL
-   **Authentication**: Laravel Sanctum

---

## 🚀 Getting Started

Follow these instructions to get the API server up and running on your local machine.

### Prerequisites

-   PHP >= 8.3
-   Composer
-   MySQL or another compatible database
-   A command-line interface (CLI)

### Installation & Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/uio-paws-api.git
    cd uio-paws-api
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Create the environment file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure your database:**
    -   Create a new database for the project (e.g., `uio_paws`).
    -   Open the `.env` file and update the `DB_*` variables with your database credentials:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=uio_paws
        DB_USERNAME=root
        DB_PASSWORD=your_password
        ```

6.  **Run database migrations and seeders:**
    This will create the necessary tables and seed the database with an initial administrator account.
    ```bash
    php artisan migrate --seed
    ```
    An admin user will be created with the following credentials:
    -   **Email**: `admin@adopcion.com`
    -   **Password**: `UioPaws123`

7.  **Run the development server:**
    It's recommended to run the API on port `8000`.
    ```bash
    php artisan serve --port=8000
    ```

The API is now running and accessible at `http://127.0.0.1:8000`.

---

## 🔑 API Endpoints

All data is returned in JSON format. Protected routes require a `Bearer Token` in the `Authorization` header.

### Authentication

| Method | Endpoint          | Description                    | Protection |
| :----- | :---------------- | :----------------------------- | :--------- |
| `POST` | `/api/register`   | Creates a new user account.    | Public     |
| `POST` | `/api/login`      | Logs in a user, returns a token. | Public     |
| `POST` | `/api/logout`     | Logs out the authenticated user. | Sanctum    |
| `GET`  | `/api/profile`    | Gets the authenticated user's profile. | Sanctum    |

### Admin: User Management

These routes are protected and require both a valid token and admin privileges.

| Method   | Endpoint                | Description                       | Protection     |
| :------- | :---------------------- | :-------------------------------- | :------------- |
| `GET`    | `/api/admin/users`      | Get a list of all users.          | Sanctum, Admin |
| `POST`   | `/api/admin/users`      | Create a new user.                | Sanctum, Admin |
| `GET`    | `/api/admin/users/{id}` | Get a single user by ID.          | Sanctum, Admin |
| `PUT`    | `/api/admin/users/{id}` | Update a user's details.          | Sanctum, Admin |
| `DELETE` | `/api/admin/users/{id}` | Delete a user.                    | Sanctum, Admin |

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE.md).
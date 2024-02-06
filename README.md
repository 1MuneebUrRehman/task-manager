# Task Manager

This project offers a comprehensive task management system with three distinct roles: Admin, Manager, and Users. Admins
possess full control over permissions, while Managers can edit, view, and provide feedback on tasks. Users are limited
to viewing tasks and providing feedback. Enjoy streamlined task management tailored to your organizational needs!

## Installation

1. Open your terminal or command prompt.
2. Navigate to the directory where you want to clone the project.
3. Run the following command:

```bash
 git clone https://github.com/1MuneebUrRehman/task-manager.git
```

## Installation and Setup

```bash

 cd task-manager

 composer install

 npm install

 cp .env.example .env

 php artisan key:generate

 php artisan migrate:fresh --seed


```

## Running the Application

```bash

 php artisan serve

 npm run dev


```

## Multiple Registration Links

This Laravel project supports multiple types of user registration:

- **Simple User Registration**: This link allows regular users to register for the application.

- **Register as Manager**: Managers have additional privileges compared to regular users. They might have access to
  certain administrative functions or advanced features.

- **Admin Registration**: An admin account is already seeded into the database. You can log in using the following
  credentials:
    - Email: `1muneeburrehman@gmail.com`
    - Password: `1muneeburrehman@gmail.com`

To access these registration links, navigate to the following URLs after running the application:

- Simple User Registration: `http://localhost:8000/register`
- Register as Manager: `http://localhost:8000/register-as-manager`
- Admin Panel (Login): `http://localhost:8000/login`

## API Usage and Testing

This project utilizes Laravel Passport for API authentication. Passport provides a full OAuth2 server implementation for
your Laravel application, allowing you to easily authenticate API requests.

## API Endpoints and Testing

### API Endpoints

#### User Registration

- **Method**: `POST`
- **Endpoint**: `/api/register`
- **Description**: Allows users to register for the application.
- **Required Parameters**: `name`, `email`, `password`, `password_confirmation`

#### User Login

- **Method**: `POST`
- **Endpoint**: `/api/login`
- **Description**: Allows users to log in to the application and obtain an access token.
- **Required Parameters**: `email`, `password`

#### User Logout

- **Method**: `POST`
- **Endpoint**: `/api/logout`
- **Description**: Allows users to log out of the application.
- **Required Headers**: `Authorization` with valid access token

#### Tasks API Resources

- **Methods**: `GET`, `POST`, `PUT`, `DELETE`
- **Endpoint**: `/api/tasks`
- **Description**: Provides CRUD operations for tasks.
- **Authorization**: Requires a valid access token in the `Authorization` header.

### Testing with PHPUnit

PHPUnit tests have been implemented to ensure the reliability and functionality of the application. To run the PHPUnit
test cases, execute the following command in your terminal:

```bash
php artisan test


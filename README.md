# Library Management API

This repository contains a Laravel-based API for managing a library system. It includes endpoints for user authentication, book management, and loan transactions.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Testing](#testing)
- [API Documentation](#api-documentation)
  - [Authentication](#authentication)
  - [Books](#books)
  - [Loans](#loans)
- [Postman Collection](#postman-collection)

## Features

- User authentication (register, login, logout)
- CRUD operations for books
- Managing book loans (create, retrieve)
- Email notifications for loan events

## Requirements

- PHP >= 7.4
- Composer
- MySQL or MariaDB
- Redis (for queue processing)

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/seu-usuario/nome-do-repositorio.git
    ```

2. Navigate into the project directory:

    ```bash
    cd nome-do-repositorio
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

5. Generate an application key:

    ```bash
    php artisan key:generate
    ```

6. Update the `.env` file with your database and mail settings:

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=biblioteca
    DB_USERNAME=root
    DB_PASSWORD=root

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=seu_mailtrap_username
    MAIL_PASSWORD=seu_mailtrap_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=from@example.com
    MAIL_FROM_NAME=YourAppName
    ```

7. Migrate the database:

    ```bash
    php artisan migrate
    ```

8. Start the local development server:

    ```bash
    php artisan serve
    ```

## Configuration

- **Mail Configuration**: Update the `.env` file with your SMTP mail settings for sending notifications.

## Running the Application

To run the application locally after installation, use:

```bash
php artisan serve
```
This will start a development server at [http://localhost:8000](http://localhost:8000).

## Testing

To run the automated tests:

```bash
php artisan test
```

# API Documentation

## Authentication

### Register User

- **URL**: `/api/register`
- **Method**: `POST`
- **Parameters**:
  - `name` (string, required)
  - `email` (string, required)
  - `password` (string, required)
  - `password_confirmation` (string, required)

- **Example Request**:

  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
  }
  ```

### Login User

**URL:** `/api/login`

**Method:** `POST`

**Parameters:**

- `email` (string, required)
- `password` (string, required)

**Example Request:**

```json
{
  "email": "john@example.com",
  "password": "password"
}
```

**Example Response:**

```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

## Books

### Create Book

**URL:** `/api/books`

**Method:** `POST`

**Parameters:**

- `title` (string, required)
- `publication_year` (date, required, format: "YYYY-MM-DD")
- `author_ids` (array of integers, required, existing author IDs)

**Example Request:**
```json
{
  "title": "Book Title",
  "publication_year": "2023-01-01",
  "author_ids": [1, 2]
}
```

**Example Response:**
```json
{
  "id": 1,
  "title": "Book Title",
  "publication_year": "2023-01-01",
  "authors": [
    {
      "id": 1,
      "name": "Author One"
    },
    {
      "id": 2,
      "name": "Author Two"
    }
  ],
  "created_at": "2024-07-02T10:00:00Z",
  "updated_at": "2024-07-02T10:00:00Z"
}
```

### Update Book

**URL:** `/api/books/{id}`

**Method:** `PUT`

**Parameters:**

- `title` (string)
- `publication_year` (date, format: "YYYY-MM-DD")
- `author_ids` (array of integers, existing author IDs)

**Example Request:**
```json
{
  "title": "Updated Book Title",
  "publication_year": "2024-01-01",
  "author_ids": [2]
}
```

**Example Response:**
```json
{
  "id": 1,
  "title": "Updated Book Title",
  "publication_year": "2024-01-01",
  "authors": [
    {
      "id": 2,
      "name": "Author Two"
    }
  ],
  "created_at": "2024-07-02T10:00:00Z",
  "updated_at": "2024-07-02T12:00:00Z"
}
```

## Loans

### Create Loan

**URL:** `/api/loans`

**Method:** `POST`

**Parameters:**

- `user_id` (integer, required, existing user ID)
- `book_id` (integer, required, existing book ID)
- `loan_date` (date, required, format: "YYYY-MM-DD")
- `return_date` (date, optional, format: "YYYY-MM-DD")

**Example Request:**
```json
{
  "user_id": 1,
  "book_id": 1,
  "loan_date": "2024-07-02",
  "return_date": "2024-07-16"
}
```

**Example Response:**
```json
{
  "id": 1,
  "user_id": 1,
  "book_id": 1,
  "loan_date": "2024-07-02",
  "return_date": "2024-07-16",
  "created_at": "2024-07-02T10:00:00Z",
  "updated_at": "2024-07-02T10:00:00Z"
}
```

## Postman Collection

For testing the API endpoints, you can import the Postman collection provided in this repository.

[https://documenter.getpostman.com/view/21137699/2sA3dvjsDS]



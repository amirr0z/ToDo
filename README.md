
# Laravel To-Do List Application

This is a simple to-do list application built with Laravel. Users can register, log in, and manage their tasks by adding, editing, and deleting them.

## Features

-   User authentication (registration, login, logout) using Laravel Sanctum.
-   CRUD (Create, Read, Update, Delete) operations for tasks.
-   Email verification for new user registration.
-   Unit and feature tests for models, controllers, and API endpoints.
-   API documentation using Laravel RESTful Documentation (LRD).

## Prerequisites

Before running this project locally, make sure you have the following installed:

-   PHP >= 8.2
-   Composer
-   MySQL or other compatible database

## Getting Started

Follow these steps to get the project up and running on your local machine:

1.  Clone the repository:
    
    
    `git clone https://github.com/amirr0z/ToDo.git` 
    
2.  Navigate into the project directory:
        
    `cd ToDo` 
    
3.  Install PHP dependencies:
        
    `composer install` 
    
4.  Copy the `.env.example` file to `.env` and update the database configuration:
        
    `cp .env.example .env` 
    
    Update the `.env` file with your database credentials:
        
    `DB_CONNECTION=mysql`
    `DB_HOST=127.0.0.1`
    `DB_PORT=3306`
    `DB_DATABASE=your_database_name`
    `DB_USERNAME=your_database_username`
    `DB_PASSWORD=your_database_password` 

5.  Update the `.env` file with your mail service credentials:
        
    `MAIL_MAILER=smtp`
    `MAIL_HOST=sandbox.smtp.mailtrap.io`
    `MAIL_PORT=2525`
    `MAIL_USERNAME=your_mail_service_username`
    `MAIL_PASSWORD=your_mail_service_password`
    `MAIL_ENCRYPTION="tls"`
    `MAIL_FROM_ADDRESS="test@example.com"`
    `MAIL_FROM_NAME="${APP_NAME}"`
    
6.  Generate the application key:
        
    `php artisan key:generate` 
    
7.  Run the database migrations:
        
    `php artisan migrate` 
    
8.  (Optional) Seed the database with test data:
        
    `php artisan db:seed` 
    
9.  Start the queue to listen to jobs:
        
    `php artisan queue:work` 
        
10.  Start the development server:
        
    `php artisan serve` 
    
    The application will be accessible at `http://localhost:8000`.
    

## Viewing API Documentation

To view the API documentation for this project, access the following URL in your web browser:

`http://localhost:8000/request-docs` 

The API documentation has been generated using Laravel RESTful Documentation (LRD) and provides detailed information about the available endpoints, request methods, request/response formats, and authentication requirements.

## Running Tests

To run the unit and feature tests, use the following command:

`php artisan test` 

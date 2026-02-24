# SaaS Helpdesk API (Laravel 12)

A RESTful Helpdesk backend system built using **Laravel 12 + Sanctum Authentication**.

## Features Implemented

* User Registration API
* User Login API
* Token Based Authentication (Laravel Sanctum)
* Protected Route (/me)
* Logout (Token Revocation)

## Tech Stack

* Laravel 12
* PHP 8+
* MySQL
* Laravel Sanctum

## API Endpoints

POST /api/register
POST /api/login
GET /api/me (Protected)
POST /api/logout (Protected)

## How to Run

1. Clone repo
2. composer install
3. copy .env.example to .env
4. set DB credentials
5. php artisan key:generate
6. php artisan migrate
7. php artisan serve

Server runs at:
http://127.0.0.1:8000

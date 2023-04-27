<p align="center">
<h1 align="center">
    Availability-Calendar     
    
[   ![version](https://img.shields.io/badge/version-0.1.0-blue.svg)](https://semver.org)
</h1>
</p>

The app is all about creating calendars, marking the availability and embedding to various websites. It is a SaaS application. The app is built with Laravel 9 and Tailwind CSS. The app is currently in development.

## Installation

-   Clone the repository
-   Run `composer install`
-   Run `npm install`
-   Run `npm run dev`
-   Run `cp .env.example .env`
-   Run `php artisan key:generate`
-   Goto `.env` file and set your database credentials
-   Create a database and set the database name in `.env` file
-   Run `php artisan storage:link`
-   Run `php artisan migrate:fresh --seed`
-   Run `npx vite --port=3000` (in a separate terminal)
-   Run `php artisan serve`

## Requirements

-   PHP 8
-   Composer version 2.4
-   Node 14
-   NPM 6
-   MySQL 8

## Technologies

**Frontend:** Tailwind CSS, Alpine JS

**Backend:** Laravel 9

**Database** MySQL 8

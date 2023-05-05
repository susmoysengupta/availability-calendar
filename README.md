<p align="center">
<h1 align="center">
    Availability-Calendar     
    
[   ![version](https://img.shields.io/badge/version-0.1.0-blue.svg)](https://semver.org)
</h1>
</p>

The app is all about creating calendars, marking the availability and embedding to various websites. It is a SaaS application. The app is built with Laravel 9 and Tailwind CSS.

## Features

-   Create calendars
-   Mark availability
-   Embed calendars to websites
-   Customize embeds
-   Sync calendars with external calendars
-   Export calendars to iCal
-   Manage calendars
-   Customize calendars
-   Assign calendars to users
-   Manage users
-   Customize user profiles
-   Manage user roles
-   Customize welcome email
-   Dynamic email templates

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
-   Run `php artisan queue:work --sleep=1 --tries=5` (in a separate terminal)
-   Run `php artisan serve`
-   Visit `localhost:8000` in your browser

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

## Screenshots

**Dashboard / Calendars**
![Calendars](https://user-images.githubusercontent.com/32735407/236562931-ee00e4d1-d279-47c3-b724-f20dd5138bd5.png)

**Availability**
![Availability](https://user-images.githubusercontent.com/32735407/236563693-b82b0f43-c987-40ea-8a49-02bdc29431eb.png)

**Embed**

<div style="display:flex; gap: 10px; margin-bottom:10px;">
    <div style="display:flex; flex-direction:column; width:50%;">
        <img src="https://user-images.githubusercontent.com/32735407/236564145-e9a4d405-2d70-4a8f-a26b-779568ed4a74.png" width="100%" />
        <em>Embed Options</em>
    </div>
    <div style="display:flex; flex-direction:column; width:50%;">
        <img src="https://user-images.githubusercontent.com/32735407/236565058-defdb579-99db-441a-a9ee-e9bfb33082fd.png" width="100%" />
        <em>Embedded inside a Notion Page</em>
    </div>
</div>

**Syncing with External Calendars**
![image](https://user-images.githubusercontent.com/32735407/236566214-26adcf2f-d8e3-4c6f-ad3e-f7b643d8bf16.png)

**Settings**
![image](https://user-images.githubusercontent.com/32735407/236566393-b6ab31bd-707e-4bd8-8002-2d9923ffefdc.png)

**Customized Welcome Email**
![image](https://user-images.githubusercontent.com/32735407/236567213-188957bf-b3d6-41b9-825a-efa4967c7cdf.png)

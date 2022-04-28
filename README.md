
<div  align="center">

![](public/hegmataneh.jpg)

</div>


<h1 align="center">HEGMATANEH</h1>

<h2>What is Hegmataneh Web Service?</h2>
<p>Hegmataneh Web Service is a secure web service for people who want to start and develop their own blog or store with any taste, but do not have enough time to implement the desired web service. This service consists of features that code Makes writing and development easy.</p>

## Features
- ✅Authentication
    - login
    - register
    - verify registeration
- ✅Settings 
    - Get List setings 
    - Update settings 
- ✅Language 
    - CRUD Languages 
- ✅Currency 
    - CRUD Currencies
- ✅Manage the access level of roles
    - CRUD Roles & Permissions 
- ✅User 
    - CRUD users 
    - Show Single User Information
- ✅Tags 
    - CRUD Tags
- ✅Category 
    - CRUD Categories
- ✅Skills 
    - CRUD Skills
- ✅File 
    - Filemanager System
- ✅Pages 
    - CRUD Pages
- ✅Post 
    - CRUD Posts
- ✅Product 
    - CRUD Products 
- ✅Series 
    - CRUD Series
- ✅Gateway 
    - CRUD Gatewaies 
- ✅Portfolio 
    - CRUD User Portfolio
- ✅Shopping Cart
    - Guest & User Shopping Cart (remove & add)
- ✅Manage reporting tools
    - Charts & Staticts 
- ✅User Profile 
    - Edit Profile & Password & Notification
- ❌Order and sales
- ❌Comments
- ❌Manage customer quotes
- ❌Menu
- ❌Slider
- ❌Contact System

<br />

## Installation
Download or clone this repository, then go to the hegmataneh folder and open the command line and install the composer to install the relevant packages.
```php
git clone https://github.com/ghaninia/hegmataneh.git
```

```php
composer install
```

After installation, we need to configure the database. Just edit the .env file, and then you can migrate the database and add fake data to the database.

```php
php artisan migrate:refresh --seed
```

If the type of operation is checked, run the system test

```php
php artisan test
```

<a href="https://documenter.getpostman.com/view/14577533/TzmBCtDy" target="_blank">
Document On Postman
</a>
|
<a href="https://trello.com/b/4HK9UyyD/amen" target="_blank">
trello board
</a>
|
<a href="https://hegmat.ir" target="_blank">
Online
</a>

# CF Partners Mehmet Test

A simple CRUD application to manage details and credentials of users with CI4 and SmartAdmin template. 

## Installation & updates

`git clone` or download this source code then run `composer update` whenever there is a new release of the framework.

## Setup

- Copy `env` to `.env` and tailor for your app, specifically the baseURL and any database settings.
- Run `php spark db:create` to create a new database schema It will ask you DB name. Make sure it is same as .env file. (In .env file it is cf_partners).
- Run `php spark migrate` to running database migration
- Run `php spark db:seed users` to seeding default database user (It will generate additional 1000 users)
- Run `php spark key:generate` to create encrypter key
- Run `php spark serve` to launching the CodeIgniter PHP-Development Server

## Server Requirements

PHP version 8.0 is required


## Features

Features on this project:

- Authentication
- Authorization
- List users with datatable server side processing with 2 extra filter
- User Create/update or soft delete


## Todo

Due to work load during the week, 
- I could not have time to add CRUD operations for role managemet. 
- It will be also good to minfiy external JS/CSS libs in gulp
- Unit Test


## Template

You can download the template here: https://github.com/andreipa/smartadmin-html-full


## Secreenshots

- login Page
![login](https://github.com/mbultraslan/cf_test/blob/uploads/Screenshot_9.png)


- Users DataTable

![list](https://github.com/mbultraslan/cf_test/blob/uploads/Screenshot_11.png)

- Add/Edit User Form
![form](https://github.com/mbultraslan/cf_test/blob/uploads/Screenshot_12.png)

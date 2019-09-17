# MoniCAG - Monitor CAG Inventory ! · [![Build Status](https://travis-ci.com/Lenophie/MoniCAG.svg?branch=master)](https://travis-ci.com/Lenophie/MoniCAG)

*MoniCAG* is a web application to be used by *Centr'All Games* (*CAG*) to manage its inventory and monitor borrowings.  
*Centr'All Games* is a gaming club from *École Centrale de Lille*. All students from the school can come and play the club's games, or borrow them to play at home.  
Historically, the club was managing its assets and borrowings with paperwork. More recently, the club started using a *Google Form* paired with a *Google Sheet* to declare and track borrowings.  

This application aims at :
* Simplifying the borrowing process
* Creating a persistent database for the inventory
* Facilitating the club's annual audit
* Allowing every student from *Centrale Lille* to easily check out the available games
* Preventing bad practices when making borrowings

---

*Just MoniCAG.*  
**Version :** *MoniCAG v1.0.0* - [Changelog](./changelog.md)  
**French README [here](./readme.fr-FR.md)**

# How to use

* Install `Composer` and `npm`
* Create a `.env` file at the root of the project
    * Use the `.env.example` file as a template
    * Fill it with your own settings
* Run `composer install` to install `PHP` dependencies
* Run `npm install` to install `js` dependencies
* Setup a local-hosted `MariaDB` database named `monicag`
* Run `php artisan key:generate` to create generate an application key (stored in `.env`)
* Run `php artisan migrate --seed` to migrate the database
* Run `php artisan passport:install` to migrate OAuth tables
* Run `php artisan storage:link` to create the symbolic link from "public/storage" to "storage/app/public"
* Run `php artisan lang:generate` to generate the public translation files
* Run `php artisan serve` to serve the application
* Run `npm run watch` to bundle the `js` resources
* Go to `localhost:8000` with a web navigator

# How to test

* Setup a local-hosted `MariaDB` database named `monicag_testing`
* Create a `.env.testing` file at the root of the project
    * Use the `.env.testing.example` file as a template
    * Fill it with your own settings
* Copy-paste `.env.testing` and rename the copy `.env.dusk.local`
* Run `php artisan key:generate --env=testing` to create generate an application key (stored in `.env.testing`)
* Run `php artisan key:generate --env=dusk.local` to create generate an application key (stored in `.env.dusk.local`)
* Run `php artisan migrate --seed --env=testing` to migrate the testing database
* Run `php artisan dusk:chrome-driver` to install the latest Chrome driver for Laravel Dusk
* Run `composer phpunit` to perform unit tests
* Run `php artisan serve --env=dusk.local` and `composer dusk` to perform browser tests
    * *Don't perform unit and browser tests at the same time, they share the same database !*

# Local deployment

* [Install Docker CE](https://docs.docker.com/install/)
* [Install docker-compose](https://docs.docker.com/compose/install/)
* Run `sudo docker-compose -f docker-compose.yml up --build`

# Deployment tips

* May have to `chown` the root of the project for it to match the www user group.
* May have to `chmod -R 775 /storage`.
* May have to set trusted proxies in `.env` for CSS assets and images to be accessible.

# License

Code released under the [MIT License](./LICENSE).

# Author

Lenophie

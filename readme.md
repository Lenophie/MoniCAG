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

**Version :** *MoniCAG v0.16.1* - [Changelog](./changelog.md)

# How to use

* Install `Composer` and `npm`
* Run `composer install` to install `PHP` dependencies
* Run `npm install` to install `js` dependencies
* Setup a local-hosted `MariaDB` database named `monicag`
* Create a `.env` file at the root of the project
    * Use the `.env.example` file as a template
    * Fill it with your own settings
* Run `php artisan migrate --seed` to migrate the database
* Run `php artisan serve` to serve the application
* Run `npm run watch` to bundle the `js` resources
* Go to `localhost:8000` with a web navigator

# How to test

* Setup a local-hosted `MariaDB` database named `monicag_testing`
* Create a `.env.testing` file at the root of the project
    * Use the `.env.testing.example` file as a template
    * Fill it with your own settings
* Copy-paste `.env.testing` and rename the copy `.env.dusk.local`
* Run `php artisan migrate --seed --env=testing` to migrate the testing database
* Run `composer phpunit` to perform unit tests
* Run `php artisan serve --env=dusk.local` and `composer dusk` to perform browser tests

# Local deployment

* [Install Docker CE](https://docs.docker.com/install/)
* [Install docker-compose](https://docs.docker.com/compose/install/)
* Run `sudo docker-compose -f docker-compose.yml up --build`


# License

Code released under the [MIT License](./LICENSE).

# Author

Lenophie

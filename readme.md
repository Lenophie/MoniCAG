# MoniCAG - Monitor CAG Inventory !

*MoniCAG* is a web application to be used by *Centr'All Games* (*CAG*) to manage its inventory and monitor borrowings.  
*Centr'All Games* is a gaming club from *École Centrale de Lille*. All students from the school can come and play the club's games, or borrow them to play at home.  
Historically, the club was managing its assets and borrowings with paperwork. More recently, the club started using a *Google Form* paired with a *Google Sheet* to declare and track borrowings.  

This application aims at :
* Simplying the borrowing process
* Creating a persistent database for the inventory
* Facilitating the club's annual audit
* Allowing every student from *Centrale Lille* to easily check out the available games
* Preventing bad practices when making borrowings

---

*Just MoniCAG.*

**Version :** *MoniCAG v0.15.0* - [Changelog](./changelog.md)

**Work in progress :**

* Removing jQuery.

---

# How to use

* Install ```Composer``` and ```npm```
* Run ```composer install``` to install ```PHP``` dependencies
* Run ```npm install``` to install ```js``` dependencies
* Setup a local-hosted ```MariaDB``` database named ```monicag```
* Run ```php artisan migrate --seed``` to migrate the database
* Run ```php artisan serve``` to serve the application
* Run ```npm run watch``` to bundle the ```js``` resources
* Go to ```localhost:8000``` with a web navigator

# How to test
* Setup a local-hosted ```MariaDB``` database named ```monicag_testing```
* Run ```php artisan migrate --seed --env=testing``` to migrate the testing database
    * The testing database is currently only used for unit tests
* Run ```vendor\bin\phpunit tests\Unit``` to perform unit tests
* Run ```php artisan dusk tests\Browser``` to perform browser tests

---

# License

Code released under the [MIT License](./LICENSE).

# Author

Lenophie
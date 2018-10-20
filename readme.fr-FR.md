# MoniCAG - Monitor CAG Inventory !

*MoniCAG* est une application web destinée à *Centr'All Games* (*CAG*) afin de gérer son inventaire et suivre ses emprunts.  
*Centr'All Games* est un club de jeux de l'*École Centrale de Lille*. Tous les étudiants de l'école peuvent venir jouer aux jeux du club ou les emprunter pour y jouer chez eux.  
Historiquement, le club gérait ses biens et ses emprunts par suivi papier. Plus récemment, le club a commencé à utiliser un *Google Form* couplé à un *Google Sheet* pour déclarer et suivre les emprunts.  

Cette application cherche à :
* Simplifier le processus d'emprunt
* Créer une base de données persistente de l'inventaire
* Faciliter l'audit annuel du club
* Permetter à tous les étudiants de *Centrale Lille* de facilement accéder à la liste des jeux du club
* Remédier aux mauvaises pratiques liées à la déclaration d'emprunts

---

*Juste MoniCAG.*

**Version :** *MoniCAG v0.15.0* - [Changelog](./changelog.md)

# Utilisation

* Installer ```Composer``` et ```npm```
* Exécuter ```composer install``` pour installer les dépendances ```PHP```
* Exécuter ```npm install``` pour installer les dépendances ```js```
* Mettre en place une base de données ```MariaDB``` s'appelant ```monicag``` hébergée localement
* Exécuter ```php artisan migrate --seed``` pour migrer la base de données
* Exécuter ```php artisan serve``` pour servir l'application
* Exécuter ```npm run watch``` pour bundle les ressources ```js```
* Se rendre à ```localhost:8000``` avec un navigateur web

# Réalisation des tests
* Mettre en place une base de données ```MariaDB``` s'appelant ```monicag_testing``` hébergée localement
* Exécuter ```php artisan migrate --seed --env=testing``` pour migrer la base de données de test
    * Actuellement, la base de données de test n'est exploitée que par les tests unitaires
* Exécuter ```vendor\bin\phpunit tests\Unit``` pour réaliser les tests unitaires
* Exécuter ```php artisan dusk tests\Browser``` pour réaliser les tests de navigation

# Licence

Code mis à disposition selon la [Licence MIT](./LICENSE).

# Auteur

Lenophie
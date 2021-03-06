# MoniCAG - Monitor CAG Inventory ! · [![Build Status](https://travis-ci.com/Lenophie/MoniCAG.svg?branch=master)](https://travis-ci.com/Lenophie/MoniCAG)

*MoniCAG* est une application web destinée à *Centr'All Games* (*CAG*) afin de gérer son inventaire et suivre ses emprunts.  
*Centr'All Games* est un club de jeux de l'*École Centrale de Lille*. Tous les étudiants de l'école peuvent venir jouer aux jeux du club ou les emprunter pour y jouer chez eux.  
Historiquement, le club gérait ses biens et ses emprunts par suivi papier. Plus récemment, le club a commencé à utiliser un *Google Form* couplé à un *Google Sheet* pour déclarer et suivre les emprunts.  

Cette application cherche à :
* Simplifier le processus d'emprunt
* Créer une base de données persistente de l'inventaire
* Faciliter l'audit annuel du club
* Permettre à tous les étudiants de *Centrale Lille* de facilement accéder à la liste des jeux du club
* Remédier aux mauvaises pratiques liées à la déclaration d'emprunts

---

*Juste MoniCAG.*

**Version :** *MoniCAG v1.0.0* - [Changelog](./changelog.md)

# Utilisation

* Installer `Composer` et `npm`
* Créer un fichier `.env` à la racine du projet
    * Utiliser le fichier `.env.example` comme template
    * Le remplir avec ses propres paramètres
* Exécuter `composer install` pour installer les dépendances `PHP`
* Exécuter `npm install` pour installer les dépendances `js`
* Mettre en place une base de données `MariaDB` s'appelant `monicag` hébergée localement
* Exécuter `php artisan key:generate` pour générer une clé (stockée dans `.env`)
* Exécuter `php artisan migrate --seed` pour migrer la base de données
* Exécuter `php artisan passport:install` pour migrer les tables de OAuth
* Exécuter `php artisan storage:link` pour créer un lien symbolique de "public/storage" vers "storage/app/public"
* Exécuter `php artisan lang:generate` pour générer les fichiers publics de traduction
* Exécuter `php artisan serve` pour servir l'application
* Exécuter `npm run watch` pour bundle les ressources `js`
* Se rendre à `localhost:8000` avec un navigateur web

# Réalisation des tests

* Mettre en place une base de données `MariaDB` s'appelant `monicag_testing` hébergée localement
* Créer un fichier `.env.testing` à la racine du projet
    * Utiliser le fichier `.env.testing.example` comme template
    * Le remplir avec ses propres paramètres
* Copier-coller `.env.testing` et renommer la copie `.env.dusk.local`
* Exécuter `php artisan key:generate --env=testing` pour générer une clé (stockée dans `.env.testing`)
* Exécuter `php artisan key:generate --env=dusk.local` pour générer une clé (stockée dans `.env.dusk.local`)
* Exécuter `php artisan migrate --seed --env=testing` pour migrer la base de données de test
* Exécuter `php artisan dusk:chrome-driver` pour installer le dernier driver Chrome pour Laravel Dusk
* Exécuter `composer unit` pour réaliser les tests unitaires
* Exécuter `php artisan serve --env=dusk.local` et `composer dusk` pour réaliser les tests d'intégration
    * *Attention à ne pas lancer les tests unitaires et les tests d'intégration en même temps, ils partagent la même base de données !*

# Déploiement local

* [Installer Docker CE](https://docs.docker.com/install/)
* [Installer docker-compose](https://docs.docker.com/compose/install/)
* Exécuter `sudo docker-compose -f docker-compose.yml up --build`

# Deployment tips

* Potentiellement devoir `chown` la racine du projet pour la donner au user group responsable du service (type "www").
* Potentiellement exécuter `chmod -R 775 /storage`.
* Potentiellement indiquer des proxys connus dans `.env` pour que les images et les fichiers CSS soient correctement servis.

# Licence

Code mis à disposition selon la [Licence MIT](./LICENSE).

# Auteur

Lenophie

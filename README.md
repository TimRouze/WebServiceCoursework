---------- PASSWORD : ----------------
- login : hilderic et mdp : 1234
- login : timothé et mdp : 456

---------- Particularités ----------------

- Les formulaires du sites des erreurs sont "intelligents" et vont guider l'utilisateur.
Par exemple, le login peut préciser si il s'agit de l'identifiants ou le mot de passe qui est faux. Il précise aussi que les champs doivent être rempli
L'application possède globalement cette capacité à essayer de décrire le mieux possible l'erreur.

- La pagination est intelligente et affiche uniquement des page existantes/accesibles.

- Le parser(news updater) évite de rajouter deux fois les mêmes news. 
Pour cela il se base sur la date de la dernière news présente en base. Et les news parsés doivent avoir un date supérieur à celle çi.

- Les nombre de news par page est stocké dans un fichier, pour éviter d'avoir à utiliser la BDD pour si peu.

- L'admin peut lancer le avec le bouton "update news" provoquer la récupération des flux RSS et la mise en base des news.

---- CRON TASK ------
- Pour que l'application mette à jour à interval réguliers ses news;  il faut call le script UpdateTask.php dans tools:
* * * * * * php-cli -f PATH_TO_FOLSZE/config/UpdateTask.php

---- REPO -----
- https://github.com/TimRouze/PHP-SiteNews/

---------- DEV ------------------
- Pour lancer le projet : 
- Installer WAMP(windows) / Lampp(linux)
- Forcer l'utilisation de php7 sur wamp (défault est à 5)
- Lancer le scripts de initDB sur phpmyadmin

- MYSQL : 
- Créer une DB nebulae
- Laisser le mdp et nom par défaut lors de l'installation

Trello Board : 
https://trello.com/invite/b/34sp4GVB/d967c28cd9bace0b63dd9075e9c0b96c/phpproject

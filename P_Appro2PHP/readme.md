# Installation de Visual Studio Code & PHP & (Admin)

VSC : Pour l'environnement de code, télécharger la dernière version de Visual Studio Code : https://code.visualstudio.com/

- Une fois l'application installé, on se rend sur les extensions VS -> On tape @buildin php, et on désactive PHP Language Features. Puis on télécharge les extensions PHP Server et PHP Intelephense.

- Pour que PHP fonctionne, on va ensuite dans les paramètres avancés du système -> Modifier un environnement de variables pour le compte -> rajouter le chemin vers le dossier php qui a été créé à la racine C:

- Tester si php est installé dans le terminal (commande : php -v)

- Pour lancer le projet sur le navigateur : 

Ouvrir le projet P_Appro2 dans visuel code et sélectionner index.php -> Clique droit sur l'interface de code -> Lancer le projet avec PHP Server

# Installation d'un serveur windows PHP & MySQL / PhpMyAdmin (non Admin)

Dans le cas d'un utilisateur n'ayant pas les droits admin dans son environnement de travail, on peut passer par uWamp ou XAMPP qui vont interpréter le php sur un serveur local, exemple avec uWamp :

- Télécharger uWamp (dernière version) -> https://www.uwamp.com/fr/

- Extraire le zip (où on veut).

- Lancer le .exe du dossier. Sur le panel de l'application -> cliquer sur le bouton "Dossier www"

- Extraire le projet P_Appro_2 dans le /www 

- On se rend ensuite de nouveau sur le panel d'application -> cliquer sur le bouton "PhpMyAdmin"

- taper "root", "root", puis importer la db dans le dossier "MySQLConnector" dans la section "importer".

- Depuis le panel uWamp, cliquer sur "Navigation web" et naviguer jusqu'à index.php


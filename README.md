# projet GSB BTS 2023
 
# GSB-2023

## Folder Structure
    .
    ├── bin # 
        └── gendata # 
            ├── fonction.php
            ├── hashMdp.php
            └── majGSB.php
    ├── config # Contient packages Symfony
        ├── bdd.php
        └── define.php
    ├── docs
        ├── build #npm
        ├── img # Contient les images necessaire à l'application
        ├── .htaccess # (à créer)
        └── index.php # Controlleur frontal
    ├──public
    ├── resources
        └── Sujet # Controlleur frontal
            ├── outil
            └── bdd
    ├── src
        ├── Controller
        ├── Entity
        └── Repository
    ├── tests
        ├── script python connexion
            ├── connexion d'un utilisateur.py
            └── script.py
        ├── TODO.txt
    ├──  .gitignore
    ├──  README.md
    ├──  composer.json
    └──  composer.lock
---

## Installation de l'environnement
### Wampserver
#### Dans le cas de possession d'un dump recent :
1. Installer [WampServer](https://www.wampserver.com/)
2. Installer git en regardant la [documentation](https://git-scm.com/book/fr/v2/D%C3%A9marrage-rapide-Installation-de-Git)
3. Installer [PaperCut SMTP](https://github.com/ChangemakerStudios/Papercut-SMTP/releases)
4. Cloner le projet
5. Créer un utilisateur usergsb avec mdp = usergsb dans le sgbd avec le compte root
6. Executer le script du dump de bdd le plus récent sur le serveur de base de données

#### Dans le cas de non possession d'un dump recent :
1.  Installer [WampServer](https://www.wampserver.com/)
2.  Installer git en regardant la [documentation](https://git-scm.com/book/fr/v2/D%C3%A9marrage-rapide-Installation-de-Git)
3.  Installer [PaperCut SMTP](https://github.com/ChangemakerStudios/Papercut-SMTP/releases)
4.  Cloner le projet
5.  Créer un utilisateur usergsb avec mdp = secret dans le sgbd avec le compte root
6.  Executer dans la base de donnée le script sql `gsb_restore_pascal.sql`
7.  Ouvrir un terminal powershell à la racine du projet
8.  Executer la commande `php ./bin/gendatas/majGSB.php`
9.  Executer dans la base de donnée le script sql `addcomptables.sql`
10.  Executer la commande `php ./bin/gendatas/hashMdp.php`
11. Executer dans la base de donnée le script `codepin.sql`
12. Executer dans la base de donnée le script `puissancevoiture.sql`
---

### Serveur production
#### Dans le cas de possession d'un dump recent :
utilisation de la doc ici : [guillaume-cortes.fr](https://guillaume-cortes.fr/serveur-web-apache-debian-9/)
1. Dans le terminal taper la commande `apt install apache2`
2. Dans le terminal taper la commande `apt install php`
3. Dans le terminal taper la commande `apt install git`
4. Dans le terminal taper la commande `apt install mariadb-server`
5. dans le terminal taper les commandes `mariadb` `>create user usergsb@localhost identified by 'usergsb'` `>grant all privileges on *.* to usergsb@localhost`
6. cloner le projet
7. Executer le script du dump de bdd le plus récent sur le serveur de base de données

#### Dans le cas de non possession d'un dump recent :
utilisation de la doc ici : [guillaume-cortes.fr](https://guillaume-cortes.fr/serveur-web-apache-debian-9/)
1. Dans le terminal taper la commande `apt install apache2`
2. Dans le terminal taper la commande `apt install php`
3. Dans le terminal taper la commande `apt install git`
4. Dans le terminal taper la commande `apt install mariadb-server`
5. dans le terminal taper les commandes 
```
mariadb 
>create user usergsb@localhost identified by 'usergsb'
>grant all privileges on *.* to usergsb@localhost
```
6.  cloner le projet
7.  Executer dans la base de donnée le script sql `gsb_restore_pascal.sql`
8  Executer la commande `php ./bin/gendatas/majGSB.php`
9  Executer dans la base de donnée le script sql `addcomptables.sql`
10 Executer la commande `php ./bin/gendatas/hashMdp.php`
11 Executer dans la base de donnée le script `codepin.sql`
12 Executer dans la base de donnée le script `puissancevoiture.sql`

AP Galaxy Swiss-Bourdin - BTS SIO 2023 - GRIMONT JEREMY - CROCHARD PASCAL - RAISIN LOGAN

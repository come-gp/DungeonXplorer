# DungeonXplorer

DungeonXplorer est une application web interactive inspirée des livres "dont vous êtes le héros". Ce projet utilise une architecture MVC en PHP et nécessite une base de données MySQL.

## Installation

Suivez ces étapes pour installer le projet localement :

1.  **Cloner le projet**
    Vous devez cloner le dépôt dans votre dossier serveur local (ex: `htdocs` ou `www`) de manière à ce qu'il soit accessible à l'adresse suivante :
    `localhost/DungeonXplorer`

2.  **Installer les dépendances**
    Ouvrez un terminal dans le dossier `/DungeonXplorer` et exécutez la commande suivante pour installer les bibliothèques nécessaires via Composer :
    ```bash
    composer install
    ```

## Configuration

Pour que l'application puisse fonctionner, vous devez créer un fichier nommé `.env` à la racine du projet. Ce fichier doit contenir les 4 lignes de configuration suivantes pour la base de données :

```env
DB_HOST=localhost
DB_NAME=dungeonxplorer
DB_USER=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe

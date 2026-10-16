# Fichiers SQL — Vite & Gourmand

Ce dossier contient les fichiers nécessaires pour créer la structure de la base de données et importer un jeu de données de démonstration.

## Contenu

- `01_schema.sql` : structure de la base MySQL (tables, index et contraintes).
- `02_demo_data.sql` : données de démonstration pour les catégories et les menus de navigation.

## Prérequis

- MySQL compatible avec le projet Laravel.
- Une base de données vide créée pour l'installation.
- Un utilisateur MySQL disposant des droits nécessaires.

## Installation

1. Créer une base de données vide.
2. Importer `01_schema.sql` dans cette base.
3. Importer ensuite `02_demo_data.sql`.

Exemple de commandes, à adapter à votre environnement :

```bash
mysql -u VOTRE_UTILISATEUR -p VOTRE_BASE < database/sql/01_schema.sql
mysql -u VOTRE_UTILISATEUR -p VOTRE_BASE < database/sql/02_demo_data.sql
```

Remplacer `VOTRE_UTILISATEUR` et `VOTRE_BASE` par les valeurs adaptées. Le mot de passe est demandé de manière interactive ; ne pas l'inscrire dans les commandes ni dans le dépôt Git.

## Précautions

- **Importer uniquement dans une base vide** : le fichier de démonstration utilise des identifiants explicites et n'est pas conçu pour être importé plusieurs fois.
- Ne pas importer ces fichiers dans une base contenant des données à conserver.
- Configurer les variables `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` et `DB_PASSWORD` dans le fichier `.env` de Laravel.
- Le fichier `.env` contenant les identifiants de connexion ne doit jamais être publié dans le dépôt.

## Maintenance

Après toute modification des migrations, vérifier que le fichier `01_schema.sql` correspond à la structure attendue. Tester les deux imports dans une base de test vide avant de livrer le projet.

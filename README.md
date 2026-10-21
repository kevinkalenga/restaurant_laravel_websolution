# Vite & Gourmand

## Présentation du projet

**Vite & Gourmand** est une application web développée avec Laravel dans le cadre d'un projet de formation (ECF).

L'objectif est de proposer une plateforme de présentation de restaurants et de leurs menus, avec une interface accessible aux utilisateurs et des fonctionnalités de gestion adaptées aux besoins du projet.

## Fonctionnalités

Les fonctionnalités sont à adapter à l'état final de l'application.

- Création de compte et connexion des utilisateurs.
- Consultation des restaurants, menus et plats.
- Affichage des informations relatives aux plats et aux allergènes.
- [Ajouter les fonctionnalités de réservation, d'avis ou autres si elles sont effectivement implémentées.]
- Interface d'administration pour la gestion des données, selon les fonctionnalités retenues.

## Technologies utilisées

- **Backend :** PHP et Laravel.
- **Base de données :** [MySQL / MariaDB / autre, à confirmer].
- **Frontend :** Blade, HTML, CSS, JavaScript et [framework CSS utilisé, le cas échéant].
- **Gestion de versions :** Git et GitHub.

## Prérequis

Avant d'installer le projet, vérifier que les outils suivants sont disponibles :

- PHP dans une version compatible avec le projet.
- Composer.
- Le moteur de base de données utilisé par l'application.
- Node.js et npm, si nécessaire pour compiler les ressources frontend.
- Git.

## Installation

### 1. Récupérer le projet

```bash
git clone <URL_DU_DEPOT>
cd Restaurant_Food_Laravel
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

Modifier ensuite le fichier `.env` pour renseigner les paramètres de la base de données et les autres paramètres nécessaires au fonctionnement de l'application.

**Attention :** ne jamais publier le fichier `.env` ni les identifiants ou mots de passe qu'il contient.

### 4. Préparer la base de données

Créer une base de données vide, puis configurer ses paramètres dans `.env`.

Exécuter les migrations :

```bash
php artisan migrate
```

Si le projet dispose de seeders destinés à créer des données de démonstration, utiliser la commande appropriée après vérification de leur contenu.

### 5. Installer les dépendances frontend

Si le projet utilise npm :

```bash
npm install
npm run build
```

### 6. Lancer l'application

```bash
php artisan serve
```

L'application sera accessible à l'adresse locale indiquée dans le terminal, généralement `http://127.0.0.1:8000`.

## Structure du projet

Les principaux répertoires Laravel sont :

- `app/` : logique applicative, modèles, contrôleurs et services.
- `routes/` : définition des routes.
- `resources/` : vues et ressources frontend.
- `database/migrations/` : structure de la base de données.
- `database/seeders/` : données initiales ou de démonstration, si disponibles.
- `public/` : point d'entrée et ressources publiques.
- `config/` : configuration de l'application.

## Gestion du code source

Le projet utilise Git pour le suivi des modifications.

- `main` : branche principale du projet.
- `develop` : branche de développement et d'intégration.
- Les branches `feature/*` et `fix/*` servent respectivement au développement de fonctionnalités et à la correction de problèmes.

Les modifications sont intégrées selon l'organisation des branches du dépôt.

## Sécurité et configuration

- Les identifiants et secrets doivent rester dans les variables d'environnement ou dans un système de configuration sécurisé.
- Les paramètres SMTP doivent être configurés selon le mécanisme prévu par l'application.
- En production, `APP_DEBUG` doit être désactivé et la configuration doit être adaptée à l'environnement de déploiement.

## État du projet

Le projet est en cours de développement. Les fonctionnalités, les données et les instructions de lancement seront actualisées au fur et à mesure de leur validation.

## Auteur

Projet réalisé dans le cadre d'un ECF de formation.

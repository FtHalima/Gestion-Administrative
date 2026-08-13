# GESTAC - Système de Gestion Académique
## Description

GESTAC est une application web de gestion administrative destinée aux établissements de formation.
L'application permet de gérer l'ensemble du cycle académique : personnel enseignant en formation, paramétrage des sessions universitaires, et saisie des notes à travers cinq types d'évaluation (examens, modules, semestres, mémoires, stages), avec génération de relevés de notes au format PDF.

## Stack technique
- Framework : Laravel 13
- Langage : PHP >= 8.4
- Base de données : MySQL
- Frontend : Blade + Tailwind CSS
- Authentification : Laravel Breeze (adapté à une table utilisateurs personnalisée)
- Génération PDF : DomPDF (barryvdh/laravel-dompdf)
- Import/Export : traitement CSV natif PHP

## Prérequis
- PHP >= 8.4
- Composer
- MySQL >= 8.0
- Node.js 
- npm

## Installation
```
# 1. Cloner le dépôt
git clone https://github.com/FtHalima/Gestion-Administrative.git
cd Gestion-Administrative

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JavaScript
npm install

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer la base de données dans .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=gest_acade
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Créer la base de données (vide) dans MySQL, puis lancer les migrations
php artisan migrate

# 7. Créer un compte administrateur de test
php artisan db:seed --class=UtilisateurSeeder

# 8. Lier le stockage public (nécessaire pour les fichiers uploadés)
php artisan storage:link

# 9. Compiler les assets front-end
npm run build

# 10. Lancer le serveur de développement
php artisan serve
```

L'application est ensuite accessible à l'adresse indiquée dans le terminal (généralement **http://127.0.0.1:8000)**.

## 🔑 Compte de test
| Email | Mot de passe | 
|-----------|-----------|
| admin@gestac.test | password  | 
| enseignant@test.com | password  | 

## Fonctionnalités principales

### Authentification et rôles
- Connexion sécurisée avec deux rôles distincts : Administration et Enseignant
- Inscription publique désactivée — seul un administrateur peut créer des comptes 
- Accès restreint aux modules affectés pour les enseignants

### Gestion administrative
- Gestion des utilisateurs (création, modification, suppression, réinitialisation de mot de passe)
- Gestion des étudiants (fiche complète : identité, baccalauréat, licence, diplômes, carrière, affectation)
- Import/export CSV des listes d'étudiants

### Paramétrage académique
- Années universitaires
- Semestres
- Modules (avec affectation à un enseignant)
- Groupes

### Saisie des notes
- Notes d'examen (Contrôle Continu / Examen)
- Notes de module (calcul automatique : 25% contrôle + 75% examen)
- Notes de semestre (moyenne calculée à partir des notes de module)
- Notes de mémoire (moyenne soutenance/rapport pondérée à 50/50)
- Notes de stage (avec upload de document justificatif)
- Calcul automatique du statut (Validé / Racheter / Rattrapage) selon la moyenne

### Rapports
- Génération de relevés de notes semestriels au format PDF
- Export CSV des notes par module

## Structure du projet
```
app/Http/Controllers/   → Logique métier (CRUD, saisie de notes, rapports)
app/Models/              → Modèles Eloquent
database/migrations/     → Structure de la base de données
resources/views/         → Vues Blade organisées par module fonctionnel
routes/web.php           → Déclaration des routes
```

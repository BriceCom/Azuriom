# Plugin Quiz pour Azuriom

Ce plugin permet de créer des quiz quotidiens pour votre communauté avec des récompenses configurables.

## Fonctionnalités

### 1. Délai entre chaque quiz
- Un délai configurable peut être défini entre deux participations à un quiz (ex: 24h, 12h).
- Ce délai empêche l'accès à un nouveau quiz avant son expiration.
- Le temps restant est affiché à l'utilisateur.

### 2. Difficulté par question
- Chaque question possède un niveau de difficulté : **Facile**, **Moyen** ou **Difficile**.
- La difficulté est définie lors de la création ou de l'édition d'une question.
- Elle peut être utilisée pour indexer les récompenses.

### 3. Temps limité par question
- Un temps limite (en secondes) peut être configuré pour chaque question.
- Un minuteur s'affiche côté utilisateur dès le début du quiz.
- Si le temps expire :
    - La réponse est automatiquement refusée.
    - Le quiz est marqué comme échoué (statut `expired`).
    - Aucune réponse n'est acceptée après expiration.

### 4. Récompenses
#### 4.1 Récompenses par difficulté
- Vous pouvez configurer des récompenses spécifiques pour chaque niveau de difficulté dans les paramètres du plugin.
- Types de récompenses supportés : Points (score du plugin), Monnaie (argent du site), Objet virtuel.

#### 4.2 Récompenses aléatoires
- Une liste de récompenses aléatoires peut être définie.
- Chaque récompense possède une probabilité de tirage.
- Ces récompenses s'ajoutent aux récompenses de difficulté si elles sont tirées.

## Installation et Configuration
1. Activez le plugin dans le panel d'administration.
2. Configurez les paramètres globaux (délai, classement, récompenses par difficulté) dans `Quiz > Paramètres`.
3. Créez vos questions dans `Quiz > Questions`. Chaque question doit avoir une date d'activation unique (une question par jour).

## Développement
- Modèles : `Question`, `Answer`, `Response`, `UserScore`.
- Contrôleurs : `QuizHomeController` (côté utilisateur), `AdminController` & `QuestionController` (côté admin).
- Vues : Utilisent Blade et Bootstrap (Azuriom core).

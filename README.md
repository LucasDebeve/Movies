# Saé PHP
Le contenu de ce dépôt git sera le résultat du travail réalisé dans le cadre de la Saé de fin de première année de BUT Info (2023).

Le projet a été réalisé par :
| Noms | Prénoms |
| :-: | :-: |
| DEBEVE | Lucas |
| FOULIARD | Bryan |

## Installation
Pour installer le projet, il faut tout d'abord cloner le dépôt git :
```bash
git clone https://iut-info.univ-reims.fr/gitlab/debe0033/sae2-01.git
```

Ensuite, il faut installer les dépendances Composer du projet :
```bash
composer install
```

## Serveur Web local
### Sur Linux
```bash
composer start:linux
```
Puis aller sur [localhost:8000/]().
### Sur Windows
```bash
composer start:windows
```
ou
```bash
composer start
```
Puis aller sur [localhost:8000/]().

## Roadmap

- [x] Liste des films
  - [x] Affichage des films
  - [x] Style de la page
- [x] Détail d'un film
  - [x] Affichage des informations du film
  - [x] Affichage des acteurs du film
  - [x] Style de la page
- [ ] Détail d'un acteur
  - [x] Affichage des informations de l'acteur
  - [x] Affichage des films de l'acteur
  - [ ] Style de la page
- [ ] Création d'un film
- [ ] Modification d'un film
- [ ] Suppression d'un film
- [ ] Filtrage par genre des films

## Style de codage
Utilisation de PHP CS Fixer pour respecter la recommandation PSR-12.
### Affiche les erreurs et les corrections
```bash
composer test:cs
```

### Corrige les erreurs de style
```bash
composer fix:cs
```

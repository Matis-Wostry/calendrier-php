# Calendrier Dynamique en PHP

Ce projet est un calendrier interactif développé en PHP natif avec une interface stylisée via Tailwind CSS.

## Fonctionnalités implémentées

- **Génération dynamique :** Affichage du mois en cours avec gestion du décalage des jours.
- **Navigation :** Boutons "Précédent/Suivant" pour changer de mois.
- **Mémorisation :** Le mois sélectionné est conservé en Session PHP.
- **Jours désactivés :** Les dimanches sont visuellement grisés et hachurés, et l'ajout d'événement y est bloqué.
- **CRUD complet des événements :**
  - Ajout d'un événement avec titre, date et image (Optionnelle).
  - Affichage des événements sur le calendrier (avec une icône si une image est jointe).
  - Pop-up de visualisation détaillée (avec affichage de l'image).
  - Modification et Suppression (accessibles uniquement si l'utilisateur est l'auteur de l'événement grâce aux cookies).

## Installation et Configuration

1. **Cloner le projet** dans le répertoire de votre serveur local.
2. **Base de données :**
   - Créer une base de données nommée `dev_crea`.
   - Importer le fichier `database.sql`.
3. **Configuration PHP :**
   - Allez dans le dossier `config/`.
   - Dupliquez le fichier `database.example.php` et renommez-le en `database.php`.
   - Vérifiez les identifiants de connexion (par défaut : `root` / `root`).
4. **Lancement :** Ouvrir le projet dans le navigateur en pointant sur le dossier `public/index.php`.
   - Exemple : http://localhost/calendrier-php/public/index.php

## Choix techniques et Sécurité

- **Upload d'images :** N'ayant pas l'extension `fileinfo` activée par défaut sur mon environnement MAMP Windows, j'ai sécurisé l'upload en utilisant une double vérification : validation stricte de l'extension via `pathinfo()` ET vérification du contenu réel du fichier avec `getimagesize()` pour empêcher l'upload de faux fichiers images contenant des scripts malveillants.
- **Protection XSS & Injections SQL :** Utilisation systématique de requêtes préparées via PDO (`execute`) et de `htmlspecialchars()` pour l'affichage et l'intégration des variables PHP dans le JavaScript.
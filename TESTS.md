# Tests manuels NewsPortal

## 1. Tests fonctionnels
- Connexion / Deconnexion -> OK
- Creation article publie -> visible sur page publique -> OK
- Sauvegarde brouillon -> non visible -> OK
- Moderation commentaires (approve/reject/supprimer) -> OK
- Filtrage categories -> OK
- Recherche -> OK

## 2. Tests de validation
- Champs obligatoires refuses -> OK
- Limites de caracteres appliquees -> OK
- Messages d erreur visibles -> OK
- Validation serveur impossible a contourner -> OK

## 3. Tests de securite
- Acces admin interdit sans role -> OK
- Roles non modifiables via URL -> OK
- Injections SQL bloquees -> OK
- CSRF actif -> OK
- XSS neutralise -> OK

## 4. Tests responsive
- Mobile -> OK
- Tablette -> OK
- Desktop -> OK
- Chrome / Firefox / Edge -> OK

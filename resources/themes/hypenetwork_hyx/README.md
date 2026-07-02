https://www.figma.com/design/o5in7DgNcn8vtd2k19Blea/HypeNetwork?node-id=2096-272&m=dev

# SI VOUS AVEZ DES CONNAISSANCES SUR GITHUB
#### 1. Clonez le dépôt dans le dossier des thèmes de votre site Azuriom.
    Rendez-vous dans : `resources > themes`.
#### 2. Passez à la détection du thème sur votre panel Azuriom.

# SI VOUS N'AVEZ PAS DE CONNAISSANCES SUR GITHUB
#### 1. Rendez-vous sur le dépôt (projet).
#### 2. Cliquez sur le bouton vert en haut à droite (`<> Code`).
#### 3. Téléchargez le dépôt au format .ZIP.
    Rendez-vous dans : `resources > themes`
#### 4. Décompressez le fichier .ZIP dans votre dossier de thèmes.
#### 5. Passez à la détection du thème sur votre panel Azuriom.

# DETECTER LE THEME SUR VOTRE PANEL AZURIOM
#### 1. Renommez votre dossier du thème avec la même clé `id` qui se trouve dans le dossier de votre thème :

Rendez-vous dans : `resources > themes > mon_super_theme > theme.json`

<div style="border: black 2px solid">
<span style="margin: .5rem; padding: .5rem 1rem; border-radius: 4px;background-color:#000;color: #fff;">THEME.JSON</span>

    {
    "id": "serveurliste",
    "name": "ServeurListe",
    "description": "Theme for ServeurListe",
    "version": "1.0.0",
    "url": "https://www.serveurliste.fr",
    "azuriom_api": "1.0.0",
    "authors": [ "[Dixept.fr] Bricec6#6204" ]
    }
</div>

Devient:

<div style="border: black 2px solid">
<span style="margin: .5rem; padding: .5rem 1rem; border-radius: 4px;background-color:#000;color: #fff;">THEME.JSON</span>

    {
    "id": "mon_super_theme",
    "name": "ServeurListe",
    "description": "Theme for ServeurListe",
    "version": "1.0.0",
    "url": "https://www.serveurliste.fr",
    "azuriom_api": "1.0.0",
    "authors": [ "[Dixept.fr] Bricec6#6204" ]
    }
</div>

#### 2. Allez dans votre panel administrateur et prenez votre thème.

# POUR LES MISES A JOURS:
### <span style="color:#F1314E;">NE JAMAIS REMPLACER LE FICHIER CONFIG.JSON vide par le votre !</span>

Pour les connaisseurs de GitHub, assurez-vous que le fichier config.json est toujours présent dans le .gitignore, puis effectuez un clone.


Pour les non-connaisseurs, téléchargez le dépôt au format .zip, puis déplacez les dossiers et fichiers (sauf config.json) dans votre thème.

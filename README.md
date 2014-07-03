# Maintenance mode module for Thelia 2 (en_US)

This module allow the store owner to put the store in maintenance mode while performing changes to the store.

## How to install

Download the .zip file of this module or create a git submodule into your project like this :

```
cd /path-to-thelia
git submodule add https://github.com/nicolasleon/Maintenance.git local/modules/Mainteance
```

To install the module, copy the folder Maintenance into your ```modules/``` directory (install_dir/local/modules).

Copy maintenance.html file to /templates/frontOffice/default

Next, go to your Thelia admin panel and activate the module.


## Configuration

You can manage the store maintenance mode settings by clicking the "Configure" button on the modules list.

Under the Configure tab you can set the following options:

**Put the store in maintenance mode**: Check the box to put the store in maintenance mode.

**Maintenance page name**: the name of the template to be displayed when the maintenance mode is active (See the provided maintenance.html in templates/fontOffice/default folder of the module).

**Reminder message**: a message to display in the store front when the maintenance mode is active.


## How to use

Click on "Configure" button and check "Put the store in maintenance mode".
Define the message displayed to the shop visitors in Reminder message field.

Save you settings. The store is now in maintenance mode.

Any store admin can still accesss the store in maintenance mode (They will see the reminder message at the top of the page).


# Module Mode Maintenance pour Thelia 2 (fr_FR)

Ce module permet au ecommerçant de mettre la boutique en mode maintenance pendant la mise à jour de cette dernière.

## Installation

Téléchargez le fichier zip du module ou créez un submodule Git dans votre projet comme ceci :

```
cd /dossier-thelia
git submodule add https://github.com/nicolasleon/Maintenance.git local/modules/Mainteance
```

Pour installer le module, copiez le dossier Maintenance dans le répertoire /local/modules situé à la racine de votre dossier Thelia (mon-dossier-thelia/local/modules).

Copiez le fichier maintenance.html dans le dossier /template/frontOffice/default.

Activez le module dans l'interface d'administration Thelia.


## Configuration

Vous pouvez régler les paramètres du mode maintenance de la boutique en cliquant sur le bouton "Configuration" du module.

Les paramètres disponibles sont les suivants :

**Afficher la page de maintenance**: cochez cette case pour passer la boutique en mode maintenance.

**Nom du template**: le nom du template que les visiteurs verront quand la boutique est en mode maintenance (le template fourni maintenance.html pourra êtreSee the provided maintenance.html in templates/fontOffice/default folder of the module).

**Message d'attente**: Un message à afficher sur la page de maintenance quand la boutique est en maintenance.


## Utilisation

Réglez les paramètres du module, cochez la case "Afficher le mode maintenance".
Click on "Configure" button and check "Put the store in maintenance mode".
Define the message displayed to the shop visitors in Reminder message field.

Enregistrez vos paramètres. La boutique est en mode maintenance. Pour quittez le mode maintenance décochez la case et enregistreé votre configuration.

Dans le mode maintenance, les utilisateurs connectés au backoffice Thelia accèdent normalement à la boutique (un message est affiché en haut des pages rappelle que le mode maintenance est activé).
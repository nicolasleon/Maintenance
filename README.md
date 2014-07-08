# Maintenance mode module for Thelia 2 (en_US)

This module allow the store owner to put the store in maintenance mode while performing changes to the store.

## How to install

Download the .zip file of this module or create a git submodule into your project like this :

```
cd /path-to-thelia
git submodule add https://github.com/nicolasleon/Maintenance.git local/modules/Mainteance
```

To install the module, copy the folder Maintenance into your ```modules/``` directory (install_dir/local/modules).

Next, go to your Thelia admin panel and activate the module.


## Configuration

You can manage the store maintenance mode settings by clicking the "Configure" button on the modules list.

Under the Configure tab you can set the following options:

**Put the store in maintenance mode**: Check the box to put the store in maintenance mode.

**Maintenance page name**: the name of the template to be displayed when the maintenance mode is active (See the provided templates in /templates/fontOffice/module_maintenance folder of the module).

**Reminder message**: a message to display in the store front when the maintenance mode is active.

**Allowed ips**: Ip addresses that are allowed to see the store in maintenance mode is active (e.g.: "212.127.1.5, 192.135.0.1")


## How to use

Click on "Configure" button and check "Put the store in maintenance mode".
Define the message displayed to the shop visitors in Reminder message field.

The maintenance templates are stored in Maintenance/templates/frontOffice/maintenance_module folder. There are 3 samples maintenance templates provided (maintenance, simple and light) with the modules. Feel free to customize them to best match your store design.

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

Activez le module dans l'interface d'administration Thelia.


## Configuration

Vous pouvez régler les paramètres du mode maintenance de la boutique en cliquant sur le bouton "Configuration" du module.

Les paramètres disponibles sont les suivants :

**Afficher la page de maintenance**: cochez cette case pour passer la boutique en mode maintenance.

**Nom du template**: le nom du template que les visiteurs verront quand la boutique est en mode maintenance (le template fourni maintenance.html pourra êtreSee the provided maintenance.html in templates/fontOffice/default folder of the module).

**Message d'attente**: Un message à afficher sur la page de maintenance quand la boutique est en maintenance.

**Adresses ip autorisées**: Liste des adresses ip pouvant accéder à la boutique quand celle-ci est en maintenance ("212.127.1.5, 192.135.0.1").

## Utilisation

Réglez les paramètres du module, cochez la case "Afficher le mode maintenance".
Click on "Configure" button and check "Put the store in maintenance mode".
Define the message displayed to the shop visitors in Reminder message field.

Les templates du mode maintenance sont définis dans /templates/frontOffice/module_maintenance. N'hésitez pas à personnaliser les 3 (maintenance, simple et light) exemples fournis pour mieux correspondre au design de votre boutique.

Enregistrez vos paramètres. La boutique est en mode maintenance. Pour quittez le mode maintenance décochez la case et enregistreé votre configuration.

Dans le mode maintenance, les utilisateurs connectés au backoffice Thelia accèdent normalement à la boutique (un message est affiché en haut des pages rappelle que le mode maintenance est activé).
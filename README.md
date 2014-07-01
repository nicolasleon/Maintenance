# Maintenance mode module for Thelia 2

This module allow the store owner to put the store in maintenance mode while performing change in the store.

## How to install

Download the .zip file of this module or create a git submodule into your project like this :

```
cd /path-to-thelia
git submodule add https://github.com/nicolasleon/Maintenance.git local/modules/Mainteance
```

To install the module, copy the folder Maintenance into your ```modules/``` directory (install_dir/local/modules).

Copy maintenance.html file to /templates/fontOffice/default

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
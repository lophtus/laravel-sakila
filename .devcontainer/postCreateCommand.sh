#!/bin/sh

# Setup and enable apache2 site
sudo cp ./.devcontainer/etc/apache2/sites-available/laravel-sakila.conf /etc/apache2/sites-available/laravel-sakila.conf
sudo a2ensite laravel-sakila

# Enable mod_rewrite
sudo a2enmod rewrite

sudo service apache2 restart
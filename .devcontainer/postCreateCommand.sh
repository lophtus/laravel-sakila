#!/bin/sh

NODE_VERSION=16

# Setup and enable apache2 site
sudo cp ./.devcontainer/etc/apache2/sites-available/laravel-sakila.conf /etc/apache2/sites-available/laravel-sakila.conf
sudo a2ensite laravel-sakila

# Enable mod_rewrite
sudo a2enmod rewrite

# Restart Apache
sudo service apache2 restart

# Install Node.js
. /usr/local/share/nvm/nvm.sh && nvm install ${NODE_VERSION} 2>&1

#!/bin/sh
cd p7
php bin/console doctrine:schema:create
php bin/console doctrine:fixtures:load -n
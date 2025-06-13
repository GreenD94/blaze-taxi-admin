#!/usr/bin/env bash

if ! php -m | grep -q 'zip'; then
    yum -y install libzip libzip-devel
    pecl upgrade zip
else
    echo "La extensión zip ya está instalada."
fi
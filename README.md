# raspberry-current-meter
Raspberry Pi, current/voltage meter INA219, and data visualization by the web interface.

You need to setup Raspberry Pi (minimal raspbian image) with something like this

sudo apt-get install python-pip libglib2.0-dev git apache2

sudo apt-get install mysql-server

sudo mysql_secure_installation

sudo apt-get install php libapache2-mod-php php-mcrypt php-mysql php-cli

sudo apt-get install phpmyadmin php-mbstring php-gettext

sudo apt-get install libmariadbclient-dev

sudo pip install MySQL-python

sudo systemctl restart apache2


For the mySQL database:

CREATE DATABASE ina_data;

CREATE TABLE `ina_data`.`ina_values` ( `id` INT NOT NULL AUTO_INCREMENT , `bus_voltage` FLOAT NOT NULL , `load_voltage` FLOAT NOT NULL , `current` FLOAT NOT NULL , `millisec` INT NOT NULL , `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;

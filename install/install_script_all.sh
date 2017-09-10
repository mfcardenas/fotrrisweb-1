#Server ubuntu 15 (Recomendable)
#BASE:
sudo apt-get install -y gzip git curl python libssl-dev pkg-config build-essential
sudo apt-get install -y nodejs npm git

# (nodejs or node-legacy)
# Si es necesario, instalar nodejs siguiendo las instrucciones de la web de NodeJs (son las siguientes)
# curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -
#sudo apt-get install -y nodejs

#MySQL:
sudo apt-get install -y mysql-server
sudo apt-get install -y mysql-client

#Apache:
sudo apt-get install -y apache2

# PHP:
sudo apt-get install -y php5
sudo apt-get install -y php
sudo apt-get install -y php5 libapache2-mod-php5
sudo apt-get install -y libapache2-mod-php

# Conectar PHP con Apache
sudo apt-get install -y php5-mysql
sudo apt-get install -y php-mysql

# Conectar PHP con MySQL
# PHPMyAdmin
sudo apt-get update
sudo apt-get install -y phpmyadmin

sudo php5enmod mcrypt
sudo service apache2 restart

sudo mkdir /srv
cd /srv
sudo git clone https://github.com/mfcardenas/fotrrisserver.git

sudo git clone https://github.com/mfcardenas/fotrrisweb.git

# Instalar DB 
cd /srv/fotrrisweb/db/
mysql -u adminfotrris -p -h localhost fotrrisdb < export_db_fotrris.sql

# Copiar el contenido de fotrrisweb en la ruta /var/www/html/
# Eliminar el fichero /var/www/html/index.html (por defecto de apache)
cp -r fotrrisweb/* /var/www/html/

# Arrancar el servidor fotrrisserver
cd /srv/fotrrisserver
nohup bin/run.sh &


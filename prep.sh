#!/bin/bash
######### Install requirements.
apt-get install nginx php-apc php5 php5-fpm php5-gd php5-curl php5-mysql php5-sqlite


sed -i 's/cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /etc/php5/fpm/php.ini

sed -i 's/listen = 127.0.0.1:9000/listen = /var/run/php5-fpm.sock/g' /etc/php5/fpm/php.ini

sudo service php5-fpm restart

server {
        listen   80;


        root /usr/share/nginx/www;
        index index.php index.html index.htm;

        server_name example.com;

        location / {
                try_files $uri $uri/ /index.html;
        }

        error_page 404 /404.html;

        error_page 500 502 503 504 /50x.html;
        location = /50x.html {
              root /usr/share/nginx/www;
        }

        # pass the PHP scripts to FastCGI server listening on the php-fpm socket
        location ~ \.php$ {
                try_files $uri =404;
                fastcgi_pass unix:/var/run/php5-fpm.sock;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;

        }

}

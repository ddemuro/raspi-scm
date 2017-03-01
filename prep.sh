#!/bin/bash

##############################################
# Raspi scm installer.                       #
##############################################

######### Install requirements.
echo "Updating repos."
apt-get update
echo "Installing dependencies."
apt-get install nginx php-apc php5 php5-fpm php5-gd php5-curl php5-mysql php5-sqlite vim \
 php5-mysqli php5-rrd php5-readline php5-redis php5-ssh2 php5-xmlrpc php5-memcache php5-json php5-geoip php5-apcu git openvpn

# Make sure OPT exists
echo "Cloning raspberrypi project."
mkdir -p /opt/
cd /opt
# Clone raspberry pi extras
git clone https://github.com/ddemuro/raspberrypi.git
# Go back to main dir
cd ~

# Clone raspiscm project
echo "Cloning raspi-scm project."
cd /usr/share/nginx/html
git clone https://github.com/ddemuro/raspi-scm.git
mkdir -p /usr/share/nginx/html/raspberry-scm
cd raspi-scm
mv * /usr/share/nginx/html/raspberry-scm
mv .htaccess /usr/share/nginx/html/raspberry-scm
cd ..
rm -rf raspi-scm
chown www-data:www-data * -R
chown 755 * -R
cd ~

# Sysctl changes:
echo "Setting sysctl."
echo "vm.swappiness = 30
kernel.sysrq = 0
kernel.panic = 10
net.ipv4.tcp_syncookies = 1
net.ipv6.conf.all.disable_ipv6 = 1" >> /etc/sysctl.conf
sysctl -p

echo "Setting PHP FPM."
sed -i 's/cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /etc/php5/fpm/php.ini
sed -i 's/listen = 127.0.0.1:9000/listen = /var/run/php5-fpm.sock/g' /etc/php5/fpm/php.ini

echo "Restarting php5-fpm."
sudo service php5-fpm restart

echo "Configuring nginx default to raspi-scm."
# Nginx default conf changes:
echo "server {
        listen   80;

        root /usr/share/nginx/html/raspberry-scm;
        set $yii_bootstrap "index.php";
        index index.php index.html index.htm;

        server_name _;
        charset utf-8;

        error_page 404 /404.html;

        error_page 500 502 503 504 /50x.html;
        location = /50x.html {
              root /usr/share/nginx/www;
        }

        # pass the PHP scripts to FastCGI server listening on the php-fpm socket
        location ~ \.php$ {
                try_files $uri =404;
            		fastcgi_pass unix:/var/run/php5-fpm.sock;
                #fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;

        }
        autoindex off;
        #avoid processing of calls to unexisting static files by yii
        location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
            try_files $uri =404;
        }

        location ~ \.svn/.* {
          deny all;
        }

        location /.htaccess {
          deny all;
        }

        location ~ /(protected|framework|nbproject) {
            deny all;
            access_log off;
            log_not_found off;
        }

        location ~ ^/(protected|framework|themes/\w+/views) {
            deny  all;
        }

        location / {
            index  index.html $yii_bootstrap;
            try_files $uri $uri/ /$yii_bootstrap?$args;
        }
}" > /etc/nginx/sites-available/default

echo "Configuring nginx fastcgi config."
# Nginx fastcgi conf changes:
echo "fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
fastcgi_param  QUERY_STRING       $query_string;
fastcgi_param  REQUEST_METHOD     $request_method;
fastcgi_param  CONTENT_TYPE       $content_type;
fastcgi_param  CONTENT_LENGTH     $content_length;

fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
fastcgi_param  REQUEST_URI        $request_uri;
fastcgi_param  DOCUMENT_URI       $document_uri;
fastcgi_param  DOCUMENT_ROOT      $document_root;
fastcgi_param  SERVER_PROTOCOL    $server_protocol;
fastcgi_param  HTTPS              $https if_not_empty;

fastcgi_param  GATEWAY_INTERFACE  CGI/1.1;
fastcgi_param  SERVER_SOFTWARE    nginx/$nginx_version;

fastcgi_param  REMOTE_ADDR        $remote_addr;
fastcgi_param  REMOTE_PORT        $remote_port;
fastcgi_param  SERVER_ADDR        $server_addr;
fastcgi_param  SERVER_PORT        $server_port;
fastcgi_param  SERVER_NAME        $server_name;

# PHP only, required if PHP was built with --enable-force-cgi-redirect
fastcgi_param  REDIRECT_STATUS    200;
" > /etc/nginx/fastcgi.conf

# Nginx conf changes:
echo "Configuring nginx config."
echo "user www-data;
worker_processes 4;
pid /run/nginx.pid;

events {
	worker_connections 768;
	# multi_accept on;
}

http {

	##
	# Basic Settings
	##

	sendfile on;
	tcp_nopush on;
	tcp_nodelay on;
	keepalive_timeout 65;
	types_hash_max_size 2048;
	# server_tokens off;

	# server_names_hash_bucket_size 64;
	# server_name_in_redirect off;

	include /etc/nginx/mime.types;
	default_type application/octet-stream;

	##
	# SSL Settings
	##

	ssl_protocols TLSv1 TLSv1.1 TLSv1.2; # Dropping SSLv3, ref: POODLE
	ssl_prefer_server_ciphers on;

	##
	# Logging Settings
	##

	access_log /var/log/nginx/access.log;
	error_log /var/log/nginx/error.log;

	##
	# Gzip Settings
	##

	gzip on;
	gzip_disable "msie6";

	# gzip_vary on;
	# gzip_proxied any;
	# gzip_comp_level 6;
	# gzip_buffers 16 8k;
	# gzip_http_version 1.1;
	# gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;

	##
	# Virtual Host Configs
	##

	include /etc/nginx/conf.d/*.conf;
	include /etc/nginx/sites-enabled/*;
}" > /etc/nginx/fastcgi.conf

echo "Setting timezone:"
echo "Etc/UTC" > /etc/timezone

echo ""

echo "Configuring run forever."
# Nginx fastcgi conf changes:
echo "#!/bin/bash
while true; do
PID=$(</tmp/raspi-scm.pid)
  if ps -p $PID > /dev/null; then
    echo "$PID is running"
  else
    php /usr/share/nginx/html/raspberry-scm/command.php cron > /dev/null &disown
    echo "Wasnt running on $PID"
  fi
echo "Sleeping 60"
sleep 60
done" > /root/run_forever.sh

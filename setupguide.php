sudo chown -R www-data.www-data /var/www/flood-detection/storage
sudo chown -R www-data.www-data /var/www/flood-detection/bootstrap/cache

sudo nano /etc/nginx/sites-available/flood-detection


server {
    listen 80;
    server_name 159.223.127.231;
    root /var/www/flood-detection/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
sudo ln -s /etc/nginx/sites-available/flood-detection /etc/nginx/sites-enabled/
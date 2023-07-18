# The PHP Banner App

🖼 Pet-project for the tracking banner views app using vanilla PHP.

![The PHP Banner App](https://i.ibb.co/Jv9K4VG/image.png)


## Project Task Overview

**Task**: Create an application that tracks banner views while displaying pages with a banner. The application should record user data and viewing time without using any frameworks.

The project should contain a minimum of 4 files:
- index1.html
- index2.html
- banner.php
- scheme.sql

The MySQL table structure should have the following mandatory columns:
- _ip_address_
- _user_agent_
- _view_date_
- _page_url_
- _views_count_


The **index1.html** and **index2.html** pages should have an image tag that inserts some image into the page using **banner.php** file: _< img src="banner.php" >_

Every time the image is loaded, the page visitor's info should be recorded in the MySQL table:
- IP address of the visitor (_ip_address_ column);
- Their user-agent (_user_agent_ column);
- The date and time the image was shown for this visitor (_view_date_ column);
- URL of the page where the image was loaded (_page_url_ column);
- Number of image loads for the same visitor (_views_count_ column).

If a user with the same IP address, user-agent, and page URL hits the page again, the _view_date_ column has to be updated with the current date and time, as well as views_count column has to be increased by 1.

## Installation Overview

**1. Install prerequisites.**
- nginx
- php-fpm 8.0
- mysql 8
- composer

**2. Clone project.**

```sh
git clone git@github.com:maxbratuta/the-php-banner-app.git
```

**3. Configure nginx.**
```sh
server {

    listen 80;
    listen [::]:80;

    server_name the-php-banner-app;
    root /var/www/the-php-banner-app/public;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php-fpm_8.0:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

**4. Create MySQL database and tables.**

Run `visitors-scheme.sql`.

**5. Run install script.**

Run next command to install external libraries.
```sh
composer install
```

# mockapi-php
This application provide mock api service for web developers, and it's written with php. You can specify response content and url for a http request, but not need to write any code.


## Original intention
* Front engineer can debug code when backend engineer's code has not be ready.
* Base dependent service down. Like login service.
* For fun. :)

## Runtime
php 5.5.x ~ 5.6.x
phalcon 2.0.6  
mongodb 3.0.5


## Config file and command for quick start
### MongoDB config for linux

    systemLog:
       destination: file
       path: "/home/rd/mongodb3.0.5/log/mongod.log"
       logAppend: true
    storage:
       dbPath: "/home/rd/mongodb3.0.5/data"
       journal:
          enabled: true
    processManagement:
       fork: true
    net:
       port: 8717
    security:
       authorization: enabled

### MongoDB config for windows

    systemLog:
       destination: file
       path: 'C:\Program Files\MongoDB\Server\3.0\log\mongod.log'
       logAppend: true
    storage:
       dbPath: 'C:\Program Files\MongoDB\Server\3.0\data'
       journal:
          enabled: false
    net:
       port: 8717
    security:
       authorization: enabled

### Nginx config
Modify `$NGINX_HOME/conf/nginx.conf`.

    location / {
        root html/mockapi;
        fastcgi_pass   unix:/dev/shm/php-cgi_5.6.5.sock;
        fastcgi_param  SCRIPT_FILENAME $document_root/public/index.php;
        include        fastcgi_params;
    }
### Apache config
Modify `$APACHE_HOME/conf/httpd.conf`.  
First you should enable Mod Rewrite module . Just remove '#' for this line:

    LoadModule rewrite_module modules/mod_rewrite.so

Second you shoud enable set `AllowOverride All` for mockapi directory.

    <Directory "D:/sites/example/">
        Options Indexes FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>

### Command for mongodb
#### shell on linux

You need export **MONGODB_HOME** in your **rc** file. e.g. `~/.bashrc`.

`startup.sh`

    #!/bin/sh
    cd $MONGODB_HOME
    bin/mongod  --config conf/mongo.conf

`shutdown.sh`

    #!/bin/sh
    cd $MONGODB_HOME
    bin/mongod --shutdown --config conf/mongo.conf

#### batch script on windows
`startup.bat`

    "C:\Program Files\MongoDB\Server\3.0\bin\mongod.exe" --smallfiles --config "C:\Program Files\MongoDB\Server\3.0\conf\mongo.conf"


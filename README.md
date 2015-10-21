# mockapi-php
This application provide mock api service for web developers, and it's written with php. You can specify response content and url for a http request, but not need to write any code.


## Original intention
* Front engineer can debug code when backend engineer's code has not be ready.
* Business system can run normally even dependent base service down. Like login service.
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
First step. Enable Mod Rewrite module and Mod VhostAlias.  
Modify `$APACHE_HOME/conf/httpd.conf`.  

    LoadModule rewrite_module modules/mod_rewrite.so  
    LoadModule vhost_alias_module modules/mod_vhost_alias.so  
    ...  
    # Virtual hosts  
    Include conf/extra/httpd-vhosts.conf

Second step. Set `AllowOverride All` for mockapi directory.

    <Directory "d:/wamp/www/">
        Options Indexes FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>

Third step. Add vhost in `httpd-vhosts.conf`:

    <VirtualHost *:8800>
        ServerAdmin webmaster@dummy-host.example.com
        DocumentRoot "D:/wamp/www/mockapi/mocker"
        ServerName mocker.mockapi.com
        ErrorLog "logs/mockapi.mocker-error.log"
        CustomLog "logs/mockapi.mocker-access.log" common
    </VirtualHost>
    <VirtualHost *:8900>
        ServerAdmin webmaster@dummy-host2.example.com
        DocumentRoot "D:/wamp/www/mockapi/workshop"
        ServerName workshop.mockapi.com
        ErrorLog "logs/mockapi.workshop-error.log"
        CustomLog "logs/mockapi.workshop-access.log" common
    </VirtualHost>
    
    
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
    

## Test Data
   Test data is in [mockapi_rule.txt](mockapi_rule.txt). Insert this data into mongodb.

## Url
### test url for mocker
    http://127.0.0.1:8800/testin
    http://127.0.0.1:8800/testempty
    http://127.0.0.1:8800/testisset
    http://127.0.0.1:8800/testless
    http://127.0.0.1:8800/testgrater
    http://127.0.0.1:8800/testequals
    http://127.0.0.1:8800/testcontain
### url for workshop
    http://127.0.0.1:8900/rule/list
    http://127.0.0.1:8900/rule/add
    http://127.0.0.1:8900/rule/modify
    http://127.0.0.1:8900/rule/remove
    http://127.0.0.1:8900/rule/saveRuleCondition
    http://127.0.0.1:8900/rule/removeRuleCondition

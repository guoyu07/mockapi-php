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

    server {
        listen       8800;
        server_name  localhost;
        default_type  text/html;
        server_name_in_redirect off;
        fastcgi_intercept_errors on;
        error_page 404  /404.html;
        root html/mockapi/workshop;
        index index.php;
        try_files $uri $uri/ @rewrite;
        
        location @rewrite {
            rewrite ^/(.*)$ /public/index.php?_url=/$1;
        }
        
        location ~ (\.php$|/$) {
            root html/mockapi/mocker;
            fastcgi_index  /public/index.php;
            fastcgi_pass   unix:/dev/shm/php-cgi_5.6.5.sock;
            include        fastcgi_params;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }
        
        location = /404.html {
           return 200 "no no no....";
           break;
        }
    } 
    server {
        listen       8810;
        server_name  localhost;
        default_type  text/html;
        server_name_in_redirect off;
        fastcgi_intercept_errors on;
        error_page 404  /404.html;
        root html/mockapi/workshop;
        index index.php;
        try_files $uri $uri/ @rewrite;
        location @rewrite {
            rewrite ^/(.*)$ /public/index.php?_url=/$1;
        }
        
        location ~ (\.php$|/$) {
            root html/mockapi/workshop;
            fastcgi_index  /public/index.php;
            fastcgi_pass   unix:/dev/shm/php-cgi_5.6.5.sock;
            include        fastcgi_params;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }
        
        location ~ \.(gif|jpg|png|js|css|woff|eot|ttf)$ {
           root html/mockapi/workshop/public;
        }
        
        location ~* \.(eot|otf|ttf|woff)$ {
            add_header Access-Control-Allow-Origin *;
            root html/mockapi/workshop/public;
        }
        
        location = /404.html {
           return 200 "no no no....";
           break;
        }
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

## Group
We use group to implement multiple users use same url but would't disturb others. You can set http header `http_mockapi_group` to specify the group which you want. A sample way to set http header is that use http proxy server, such as `nginx`.

### Nginx Proxy Example
add a server in nginx.conf. Just like this:
    
    server {
        listen 8008;
        location /{
            # address of mocker
            proxy_pass http://127.0.0.1:8800/;
            # set group name with 'rd'
            proxy_set_header mockapi-group rd;
            
            proxy_redirect off; 
            proxy_set_header Host $http_host; 
            proxy_set_header X-Real-IP $remote_addr; 
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for; 
            proxy_set_header Cookie $http_cookie; 
        }
     }

Then you can use the `http://127.0.0.1:8008/testcontain` and `http://127.0.0.1:8008/testequals` to verify the group.

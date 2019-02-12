Web application boilerplate
===========================

Angular 7 and Symfony 4 on API Platform minimal starter. Includes debug tools for back end. Implemented JWT authentication.

Dependencies
------------

- Ubuntu
- Docker with Docker compose


Install
-------
You cat install application manual or automatic with `./install.sh`

Build docker image :

    docker-compose -f ./devtools/docker-compose.yml build

Install requires for api:

    docker-compose -f ./devtools/docker-compose.yml run --rm composer install --ignore-platform-reqs
    
Generate the SSH keys, passphrase from `./api/.env` :
    
    docker-compose -f ./devtools/docker-compose.yml run --rm workspace openssl genrsa -out api/config/jwt/private.pem -aes256 4096
    docker-compose -f ./devtools/docker-compose.yml run --rm workspace openssl rsa -pubout -in api/config/jwt/private.pem -out api/config/jwt/public.pem
    docker-compose -f ./devtools/docker-compose.yml run --rm workspace chmod a+rw api/config/jwt/*

Create schema and add fixtures for API :
   
    docker-compose -f ./devtools/docker-compose.yml run --rm workspace api/bin/console doctrine:database:drop --force
    docker-compose -f ./devtools/docker-compose.yml run --rm workspace api/bin/console doctrine:database:create
    docker-compose -f ./devtools/docker-compose.yml run --rm workspace api/bin/console doctrine:schema:update --force
    docker-compose -f ./devtools/docker-compose.yml run --rm workspace api/bin/console api:user:create user@onlamp secret
    
Install requires to front:    
    
    docker-compose -f ./devtools/docker-compose.yml run --rm workspace npm i --unsafe-perm --prefix ./web
    docker-compose -f ./devtools/docker-compose.yml run --rm workspace npm run build --prefix ./web


Run
---

Start environment :

    docker-compose -f ./devtools/docker-compose.yml up -d nginx
    
And go:
- `http://localhost` - fron end
- `http://localhost/api/docs` - api documentation
- `http://localhost/_profiler/search?limit=10` - symfony profiler

Development
-----------

Start environment :

    docker-compose -f ./devtools/docker-compose.yml up -d

Symfony console like as :

    docker-compose -f ./devtools/docker-compose.yml exec workspace api/bin/console
    
Angular start dev :
    
    docker-compose -f ./devtools/docker-compose.yml exec workspace npm start --prefix ./web



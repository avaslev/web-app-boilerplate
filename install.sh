#!/bin/bash

#Build docker image :
docker-compose -f ./devtools/docker-compose.yml build

#Install requires for api and service:
docker-compose -f ./devtools/docker-compose.yml run --rm composer install --ignore-platform-reqs --working-dir=./api
docker-compose -f ./devtools/docker-compose.yml run --rm composer install --ignore-platform-reqs --working-dir=./image-service

#Generate the SSH keys :
sed -n 's/^JWT_PASSPHRASE= *\([^ ]*\) */\1/p' ./api/.env | openssl genrsa -passout stdin -out api/config/jwt/private.pem -aes256 4096
sed -n 's/^JWT_PASSPHRASE= *\([^ ]*\) */\1/p' ./api/.env | openssl rsa -passin stdin -pubout -in api/config/jwt/private.pem -out api/config/jwt/public.pem
docker-compose -f ./devtools/docker-compose.yml run --rm workspace chmod a+rw api/config/jwt/*

#Create schema and add fixtures for API :
docker-compose -f ./devtools/docker-compose.yml run --rm workspace api/bin/console doctrine:database:drop --force
docker-compose -f ./devtools/docker-compose.yml run --rm workspace api/bin/console doctrine:database:create
docker-compose -f ./devtools/docker-compose.yml run --rm workspace api/bin/console doctrine:schema:update --force
docker-compose -f ./devtools/docker-compose.yml run --rm workspace api/bin/console api:user:create user@onlamp secret

#Create exchanges and queues:
docker-compose -f ./devtools/docker-compose.yml run --rm workspace image-service/bin/console rabbitmq:setup-fabric
docker-compose -f ./devtools/docker-compose.yml run --rm workspace api/bin/console rabbitmq:setup-fabric

#Install requires to front:
docker-compose -f ./devtools/docker-compose.yml run --rm workspace npm i --unsafe-perm --prefix ./web
docker-compose -f ./devtools/docker-compose.yml run --rm workspace npm run build --prefix ./web

#Web application boilerplate

##Dependencies

- Ubuntu
- Docker with Docker compose


##Install

Install requires :

    docker-compose -f ./devtools/docker-compose.yml run --rm composer install --ignore-platform-reqs
    
Generate the SSH keys :
    
    mkdir -p api/config/jwt # For Symfony3+, no need of the -p option
    openssl genrsa -out api/config/jwt/private.pem -aes256 4096
    openssl rsa -pubout -in api/config/jwt/private.pem -out api/config/jwt/public.pem

    ## For automatic
    mkdir -p api/config/jwt # For Symfony3+, no need of the -p option
    grep -oP 'JWT_PASSPHRASE=.*' api/.env | sed 's/JWT_PASSPHRASE=/asd/g' > ./passout.txt
    openssl genrsa -passout file:passout.txt -out api/config/jwt/private.pem -aes256 4096
    openssl rsa -passin file:passout.txt -pubout -in api/config/jwt/private.pem -out api/config/jwt/public.pem
    rm ./passout.txt

Create schema and add fixtures for API :

    docker-compose -f ./devtools/docker-compose.yml up -d
    docker-compose -f ./devtools/docker-compose.yml exec workspace api/bin/console doctrine:database:drop --force
    docker-compose -f ./devtools/docker-compose.yml exec workspace api/bin/console doctrine:database:create
    docker-compose -f ./devtools/docker-compose.yml exec workspace api/bin/console doctrine:schema:update --force
    docker-compose -f ./devtools/docker-compose.yml exec workspace api/bin/console api:user:create user@onlamp secret
    docker-compose -f ./devtools/docker-compose.yml down

##Run





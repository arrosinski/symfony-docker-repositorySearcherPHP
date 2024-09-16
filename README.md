It's code compatible with php8.3 to search code in github with sorting, page choose and adapt number of results on page.

It uses strategy pattern if you want to add another repo, maybe I will do it too.

To run this project you need to do the following steps:

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

You can find more info in the `docs` folder if you need to about options and other stuff.

## Environment Configuration

1. Copy the `.env.example` file to `.env` and update the values as needed:
   ```sh
   cp .env.example .env
2.Install the dependencies using Docker:  
docker compose run --rm php composer install
3.Set up the database:  
docker compose run --rm php php bin/console doctrine:database:create
docker compose run --rm php php bin/console doctrine:schema:update --force 
4.Generate JWT keys:  
docker compose run --rm php mkdir -p config/jwt
docker compose run --rm php openssl genpkey -algorithm RSA -out config/jwt/private.pem -aes256 -pass pass:your_jwt_passphrase
docker compose run --rm php openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout -passin pass:your_jwt_passphrase

Docker Setup
Build the Docker containers:  
docker compose build
Start the Docker containers:  
docker compose up -d
Run the application:  
docker compose run --rm php symfony server:start


Main URL for this RestAPI looks like this: https://localhost/api/v1/code/search?code=class&page=1&per_page=35  

It uses Symfony Docker from Dunglas as a startup for the Symfony framework. 

Doc for API can be found at: https://localhost/api/doc

It's code compatible with php8.3 to search code in github with sorting, page choose and adapt number of results on page.

It uses strategy pattern if you want to add another repo , maybe i will do it do.

To run this project you need to do following steps like :
1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.
You can find also more info in docs folder if you need to about options and other stuff


Main url for this RestAPI look like this
https://localhost/api/v1/code/search?code=class&page=1&per_page=35

It uses symfony docker from dunglas as startup for symfony framework

Doc for api you can find
https://localhost/api/doc

You need to also cp env. env.dev and add this lines

GITHUB_API_TOKEN=your_github_generated_token

JWT_SECRET_KEY=your_secret_key_generated

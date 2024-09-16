It's code compatible with php8.3 to search code in github with sorting, page choose and adapt number of results on page.

It uses strategy pattern if you want to add another repo , maybe i will do it do.

Main url for this RestAPI look like this
https://localhost/api/v1/code/search?code=class&page=1&per_page=35

It uses symfony docker from dunglas as startup for symfony framework

Doc for api you can find
https://localhost/api/doc

You need to also cp env. env.dev and add this lines

GITHUB_API_TOKEN=your_github_generated_token

JWT_SECRET_KEY=your_secret_key_generated

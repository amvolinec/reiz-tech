## Installing

Clone project from git and install dependencies

cd project directory/api 

Copy .env.example to .env and edit

## Docker based development environment

1. `cd api/`
2. `cp .env.example .env`
3. add API_TOKEN to .env
4. `cd scripts/`
5. `cp .env.dist .env`
6. build/run containers `./start-dev.sh`
7. run in backend container `./backend.sh`
8. `composer install`
9 `php artisan queue:work`

## Code analyze and fix:

    composer lint
    composer lint-fix

## Endpoints:

    POST /api/jobs - Accept a JSON request body that includes array of URLs to scrape and HTML/CSS selectors.
    GET /api/jobs/{id} - Return job details and scraped data from URL.
    DELETE /api/jobs/{id} - Remove job.

## Example request body:
    
    ```json
    {
        "urls": [
            "https://delfi.lt"        
        ],
    "selectors": [
            "h5 a"
        ]
    }
    ```

## URL encoded parameter for authentication:

    `?api_token=your_api_token`

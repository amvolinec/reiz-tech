## Installing

Clone project from git and install dependencies

cd task

Copy .env.example to .env and edit

## Docker based development environment

1. cd project directory
2. `cp .env.example .env`
3. `cd scripts/`
4. `cp .env.dist .env`
5. build/run containers `./start-dev.sh`
6. run in backend container `./backend.sh`
7. `php artisan queue:work`

## Code analyze and fix:

    composer lint
    composer lint-fix

# Reproducer for: https://github.com/zenstruck/foundry/issues/909

## Steps top reproduce
1. Run `docker compose build --pull --no-cache` to build fresh images
2. Run `docker compose up --wait` to set up and start a fresh Symfony project
3. run `docker compose exec -T php bin/console do:fi:lo` to load the fixtures

2 order items will be loaded one with poisition=1 and one with position=2
The position column is unique but set to deferred see migraions: ALTER TABLE "order" ADD CONSTRAINT unq_order_position UNIQUE (position) DEFERRABLE INITIALLY DEFERRED
This means the constraint is only applied at the transaction.

4. visit the page "https://localhost" it will switch the positions sucessfully [{"id":1,"name":"order1","position":1},{"id":2,"name":"order2","position":2}] will become [{"id":1,"name":"order1","position":2},{"id":2,"name":"order2","position":1}] when you refresh.

5. now run test "SwitchTest". All it does is visit this page `docker compose exec -T php bin/phpunit`
It fails with  An exception occurred while executing a query: SQLSTATE[23505]: Unique violation: 7 ERROR:  duplicate key value violates unique constraint "unq_order_position"
DETAIL:  Key ("position")=(2) already exists." at ExceptionConverter.php line 53



# Symfony Docker

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up --wait` to set up and start a fresh Symfony project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Features

* Production, development and CI ready
* Just 1 service by default
* Blazing-fast performance thanks to [the worker mode of FrankenPHP](https://github.com/dunglas/frankenphp/blob/main/docs/worker.md) (automatically enabled in prod mode)
* [Installation of extra Docker Compose services](docs/extra-services.md) with Symfony Flex
* Automatic HTTPS (in dev and prod)
* HTTP/3 and [Early Hints](https://symfony.com/blog/new-in-symfony-6-3-early-hints) support
* Real-time messaging thanks to a built-in [Mercure hub](https://symfony.com/doc/current/mercure.html)
* [Vulcain](https://vulcain.rocks) support
* Native [XDebug](docs/xdebug.md) integration
* Super-readable configuration

**Enjoy!**

## Docs

1. [Options available](docs/options.md)
2. [Using Symfony Docker with an existing project](docs/existing-project.md)
3. [Support for extra services](docs/extra-services.md)
4. [Deploying in production](docs/production.md)
5. [Debugging with Xdebug](docs/xdebug.md)
6. [TLS Certificates](docs/tls.md)
7. [Using MySQL instead of PostgreSQL](docs/mysql.md)
8. [Using Alpine Linux instead of Debian](docs/alpine.md)
9. [Using a Makefile](docs/makefile.md)
10. [Updating the template](docs/updating.md)
11. [Troubleshooting](docs/troubleshooting.md)

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.dev), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).

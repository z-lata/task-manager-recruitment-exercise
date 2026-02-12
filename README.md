# TaskManager API

## Tech Stack & Code Quality

### Core Technologies

* **PHP 8.4**
* **Symfony 7.4**
* **API Platform 4.1**

### Code Quality & Static Analysis

To maintain the highest code standards and automate refactoring, this project uses:

* **PHPStan** – Focuses on finding bugs in your code without writing tests.
* **Rector** – Automated tool for instant upgrades and refactoring.
* **Easy Coding Standard (ECS)** – Combines PHP_CodeSniffer and PHP-CS-Fixer for consistent coding style.

## Development Commands

### Docker

#### Building the Project

```shell
docker compose build --pull --no-cache
```

#### Starting the Project

```shell
docker compose up -d --wait
```

#### Stopping the Project

```shell
docker compose down --remove-orphans -v
```

#### Accessing the Container

```shell
docker exec -it api bash
```

### Automatic Setup on Docker Start

When the Docker container starts, the `docker-entrypoint.sh` script automatically:

* **Creates the database** (if it doesn't exist)
* **Runs migrations** – Applies all pending database migrations from the `/migrations` directory
* **Loads fixtures** – In development environment (`APP_ENV != prod`), automatically loads test data from fixtures

This ensures that your development environment is fully set up and ready to use immediately after running `docker compose up`.

> **Note:** Fixtures are only loaded in development mode. For production environments, migrations run without loading test data.

#### Default Test User Credentials

All test users are created with the following default password: `Admin3579!`

### Loading Dummy Data

Load test users from the API [JSONPlaceholder](https://jsonplaceholder.typicode.com/):

#### Quick Load (Recommended)

```shell
docker exec -it api php bin/console doctrine:fixtures:load --no-interaction --purge-with-truncate
```

#### Step-by-Step Guide

##### Step 1: Access the Container

```shell
docker exec -it api bash
```

##### Step 2: Create the Database

```shell
php bin/console doctrine:database:create --if-not-exists --no-interaction
```

##### Step 3: Run Migrations

```shell
php bin/console doctrine:migrations:migrate --no-interaction
```

##### Step 4: Load Fixtures

```shell
php bin/console doctrine:fixtures:load --no-interaction
```

### Static Code Analysis & Formatting

| Tool        | Action | Command                  | Description                               |
|:------------|:-------|:-------------------------|:------------------------------------------|
| **PHPStan** | Check  | `composer phpstan:check` | Deep static analysis of the codebase.     |
|             | Fix    | `composer phpstan:fix`   | Automatically resolve fixable violations. |
|             | Base   | `composer phpstan:base`  | Update the error baseline.                |
| **Rector**  | Check  | `composer rector:check`  | Preview automated refactoring changes.    |
|             | Fix    | `composer rector:fix`    | Apply code upgrades and refactoring.      |
| **ECS**     | Check  | `composer ecs:check`     | Verify coding style and formatting.       |
|             | Fix    | `composer ecs:fix`       | Automatically format code to standards.   |

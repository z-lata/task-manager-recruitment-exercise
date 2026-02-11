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

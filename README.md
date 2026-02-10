# API Skeleton

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

```shell
docker compose build --pull --no-cache
```

```shell
docker compose up -d --wait
```

```shell
docker compose down --remove-orphans -v
```

```shell
docker exec -it api bash
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

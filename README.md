# POC : Build static website using php

> Personal website build with Symfony framework and SSG approach.

Using a standard symfony project, I use markdown files for content like articles or projects
and a custom command to generate a static site. This site can be deployed fully statically.

## Usage

Require `composer`, `php8.2` and `symfony-cli`.

### Run dev server :

```
make dev

# Stop
make dev-stop

# Get logs
make log
```

### Build production website :

```
make build

# Show production website
make prod
```

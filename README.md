# Pickup Points

## Getting Started

### Mac/Linux
Run the following command to start the development containers with Xdebug enabled:

```sh
XDEBUG_MODE=debug docker compose -f compose.yaml -f compose.override.yaml up -d
```

### Windows
Run this command in PowerShell:
```
$env:XDEBUG_MODE="debug"; docker compose -f compose.yaml -f compose.override.yaml up -d
```

If you do not need Xdebug, you can start the default build with:
```
docker compose up -d
```

## About this application

Once the Docker containers are successfully initialized, you can access the application at:

```
https://localhost/pickup-points
```

### Testing the Pickup Points API Provider

This project includes a command for testing the pickup points API provider:
```
php bin/console app:dump-easypack-resource
```

By default, API responses are mocked in the development environment. To test in a production environment, run the command with:

```
php bin/console app:dump-easypack-resource --env=prod
```

Alternatively, you can set the environment variable `APP_ENV=prod` in env file.

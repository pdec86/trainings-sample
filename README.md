# Trainings - sample

## Development

### Run project for development
```shell
docker compose -f docker-compose.yml up -d --build --force-recreate
```

### Run tests
```shell
bin/phpunit
```

### Inside container execute
```shell
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load
```
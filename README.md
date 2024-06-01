# Trainings - sample

## Development

### Run project for development
```shell
docker compose -f docker-compose.yml up -d --build --force-recreate
```

### Inside container execute
```shell
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load
```

### Run tests
```shell
bin/console doctrine:migrations:migrate --env=test
bin/console doctrine:fixtures:load --env=test
bin/phpunit
```
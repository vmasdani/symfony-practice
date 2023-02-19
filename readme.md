# Steps

1. Install symfony CLI & PHP
2. copy .env.example.sh to .env
3. change DATABASE_URL
4. Run

```sh
php bin/console doctrine:migrations:migrate
```

5. Start

```sh
symfony server:start
```

# Docker (WIP)

needs linux and python.

```
./manage.py run
```

## Accessible routes (all GET)

- '/test'
- '/test/template'
- '/persist-employee'
- '/employees'

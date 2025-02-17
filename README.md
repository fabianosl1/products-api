## Resume:

Api rest para gerenciamento de produtos, tags e categorias.

`pdo` e `php-di` são as unicas libs utilizadas.

> estrutura de pastas:
```bash
/src
|---App/                # aplicação principial
|---|---Controllers/
|---|---Dtos/
|---|---Entities/
|---|---Exceptions/
|---|---Repositories/
|---|---Services/
|---|--Logger.php
|---Router/            # roteador
|---di.php             # resolução de dependencias
|---routes.php         # definição das rotas
```
## Develop
> http://localhost:8080
```bash
docker compose up
```
ou

```bash
docker compose up -d database

export $(cat .env.local)

php -S localhost:8080 -t ./public
```

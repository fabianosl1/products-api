## Resumo:

Api rest para gerenciamento de produtos, tags e categorias.

`pdo` e `php-di` são as unicas libs utilizadas.

- Optei por utilizar o servidor embutido do PHP.
- Para implementar o router me baseei no Hono.js

> estrutura de pastas:
```bash
/src
|---App/                # aplicação principial
|---|---Controllers/
|---|---Dtos/
|---|---Entities/
|---|---Exceptions/
|---|---repositories/
|---|---|---Impl/
|---|---Services/
|---Router/             # roteador
|---di.php              # resolução de dependencias
|---routes.php          # definição das rotas
```
## Dev:
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
## Rotas:

na pasta `docs` tem um [collection](./docs/api-products.postman_collection.json) do postman.

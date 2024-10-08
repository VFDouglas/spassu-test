## Spassu Test

## Esta é uma aplicação criada com base em um teste solicitado pela <b>Spassu</b>.

### Características do projeto:

- Separação de componentes em contêineres (Docker);
- PHP 8.2;
- Laravel 11;
- MySQL;
- Redis;
- NGINX;
- Bootstrap CSS;
- Relatório exportado para planilha utilizando o pacote "maatwebsite/excel".

### Requisitos:

- Docker
- WSL

### Como Usar:

- Clone o projeto no GitHub:

```
git clone https://github.com/VFDouglas/spassu-test.git
```

Execute os comandos a seguir:

```
cd spassu-test
cp .env.example .env
docker compose build --no-cache --build-arg uid=$(id -u $(whoami))
docker-compose up -d

# Entre no contêiner para executar os próximos comandos
docker compose exec php bash
composer install
npm install
php artisan key:generate
php artisan migrate
npm run dev

# Execute os testes com o comando abaixo
php artisan test
```


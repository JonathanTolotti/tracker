# 🚀 Projeto Tracker

Este projeto utiliza **Docker** para facilitar a configuração do ambiente de desenvolvimento Laravel.

## 🐳 Subindo o ambiente

Para iniciar os containers, execute o comando:  
**`docker compose up -d`**

## ⚙️ Configuração inicial

Após subir os containers, você deve acessar o container PHP e rodar os seguintes comandos:

1. **Entrar no container PHP**  
   Use o comando: `docker exec -it tracker-app bash`

2. **Copiar o arquivo `.env.example` para `.env`**  
   Execute: `cp .env.example .env`

3. **Instalar as dependências PHP**  
   Execute: `composer install`

4. **Rodar as migrações do banco de dados**  
   Execute: `php artisan migrate`

5. **Gerar a chave da aplicação Laravel**  
   Execute: `php artisan key:generate`

## ✅ Pronto!

Após isso, o ambiente estará configurado e acessível em:  
**http://localhost:8000**

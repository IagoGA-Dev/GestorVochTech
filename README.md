# Projeto Laravel

Uma aplicação Laravel que demonstra a execução de funcionalidades básicas com banco de dados, autenticação e testes.

## Instalação

1. Faça o clone do repositório.
2. Instale as dependências do PHP:
   ```
   composer install
   ```
3. Instale as dependências do npm:
   ```
   npm install
   ```

## Configuração

1. Um arquivo `.env` já está configurado. Recomendo utilizar este arquivo, alterando apenas os parâmetros necessários (Por padrão o banco é gestor_voch_tech, usuário root e senha superpassword). 
   Caso prefira usar o arquivo de exemplo:
   ```
   cp .env.example .env
   ```
2. Configure as variáveis de ambiente conforme necessário. Em especial, verifique a variável **SEED_TEST_DATA**:
   - Quando definida como <code>true</code>, o servidor é iniciado com dados de teste. Observação: nenhum usuário padrão é criado; é necessário registrar um novo usuário manualmente.

> **Nota**: Este projeto foi configurado e testado com Herd. Recomendo seu uso para melhor compatibilidade e facilidade de deploy.

## Banco de Dados

1. Execute as migrações:
   ```
   php artisan migrate
   ```

## Execução

Inicie o servidor de desenvolvimento:
```
php artisan serve
```
Acesse o aplicativo via navegador em:
```
http://localhost:8000
```
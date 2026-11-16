# Achados e Perdidos Escolar

Aplicação Laravel para consultar objetos encontrados na escola. Visitantes podem
visualizar e filtrar o mural; somente administradores podem cadastrar, editar,
marcar como devolvido e excluir objetos.

## Requisitos

- PHP 8.3 ou superior
- Composer
- MySQL
- Node.js e npm (para compilar os assets)

## Configuração

1. Copie `.env.example` para `.env` e ajuste as credenciais do MySQL:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=achados_e_perdidos
   DB_USERNAME=root
   DB_PASSWORD=sua_senha
   ```

2. Crie o banco `achados_e_perdidos` no MySQL e prepare a aplicação:

   ```bash
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   npm install
   npm run build
   ```

3. Configure a senha inicial do painel no `.env`:

   ```dotenv
   ADMIN_PASSWORD=uma-senha-forte
   ```

4. Crie a conta administrativa inicial:

   ```bash
   php artisan db:seed
   ```

   O acesso ao painel é feito somente com essa senha, em `/admin/login`. Depois
   de entrar, use **Alterar senha** no menu para definir uma nova senha. A
   configuração `ADMIN_PASSWORD` é usada apenas para criar a conta inicial;
   executar o seeder novamente não substitui uma senha já alterada pelo painel.

5. Inicie o servidor local:

   ```bash
   php artisan serve
   ```

O mural público fica na página inicial e em `/objetos`. A administração fica em
`/admin/login`. Não existe cadastro público de contas.

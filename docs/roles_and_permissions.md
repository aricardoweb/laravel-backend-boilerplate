# Documentação de Roles e Permissões (RBAC)

Este projeto utiliza o pacote [spatie/laravel-permission](https://spatie.be/docs/laravel-permission/v6/introduction) para gerenciar o controle de acesso baseado em funções (Role-Based Access Control - RBAC).

## Roles Implementadas

Atualmente, o sistema possui duas roles principais:

1.  **Super Admin**: Possui acesso total e irrestrito ao sistema.
2.  **User**: Role padrão para usuários comuns da plataforma.

## Usuário Administrador Padrão

Durante o processo de instalação e seeding (`php artisan migrate:fresh --seed`), um usuário "Super Admin" é criado automaticamente para facilitar o primeiro acesso:

- **Email**: `admin@email.com`
- **Senha**: `123123`

> [!WARNING]
> Certifique-se de alterar as credenciais de administrador em ambientes de produção.

## Como utilizar no código

### Verificar Roles no Model User

Você pode verificar se um usuário possui uma role específica diretamente no objeto `$user`:

```php
if ($user->hasRole('Super Admin')) {
    // Lógica para super admin
}
```

### Proteger Rotas via Middleware

Você pode proteger rotas no arquivo `routes/web.php` ou `routes/api.php` utilizando o middleware fornecido pelo pacote:

```php
Route::group(['middleware' => ['role:Super Admin']], function () {
    // Rotas acessíveis apenas por Super Admin
});
```

### Verificação em Templates Blade

Utilize as diretivas customizadas para ocultar ou exibir elementos da interface:

```blade
@role('Super Admin')
    <p>Este texto só aparece para administradores.</p>
@endrole
```

## Seeder de Roles

As roles são definidas e populadas através do arquivo:
`database/seeders/RolesAndPermissionsSeeder.php`

Para recriar as roles e o usuário admin, você pode rodar:

```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

## Persistência no Frontend

O sistema de autenticação retorna as roles do usuário no momento do login. No frontend, essas roles são armazenadas no `localStorage`:

- **Chave**: `user_roles`
- **Formato**: JSON array (ex: `["Super Admin"]`)

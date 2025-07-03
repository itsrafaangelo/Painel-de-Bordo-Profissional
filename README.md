# Painel de Produtividade Profissional

Um hub central para sua produtividade que combina gestão de tarefas, repositório de código e caderno de anotações em uma única aplicação.

## 🚀 Funcionalidades

### 📋 Projetos

-   Crie e gerencie projetos para organizar seu trabalho
-   Status: Ativo, Arquivado, Concluído
-   Descrições detalhadas para cada projeto

### 📝 Kanban (Tarefas)

-   Painel visual com drag & drop
-   Três colunas: A Fazer, Em Andamento, Concluído
-   Associação opcional com projetos
-   Prazos e descrições detalhadas
-   Atualização de status via AJAX

### 📖 Anotações

-   Editor de texto rico (TinyMCE)
-   Formatação completa (negrito, listas, links, etc.)
-   Associação opcional com projetos
-   Visualização organizada

### 💻 Snippets de Código

-   Syntax highlighting para 80+ linguagens
-   Biblioteca pessoal de trechos úteis
-   Associação opcional com projetos
-   Interface limpa e organizada

### 📊 Dashboard

-   Resumo visual da produtividade
-   Estatísticas em tempo real
-   Tarefas para hoje
-   Últimas anotações e snippets

## 🛠️ Tecnologias

-   **Backend**: Laravel 12
-   **Frontend**: Blade + Tailwind CSS
-   **Banco de Dados**: MySQL
-   **Autenticação**: Laravel Breeze
-   **Syntax Highlighting**: Prism.js
-   **Editor de Texto**: TinyMCE
-   **Drag & Drop**: SortableJS

## 📋 Pré-requisitos

-   PHP 8.2+
-   Composer
-   MySQL 8.0+
-   Node.js (para compilar assets)

## 🔧 Instalação

1. **Clone o repositório**

    ```bash
    git clone <url-do-repositorio>
    cd painel-produtividade
    ```

2. **Instale as dependências**

    ```bash
    composer install
    npm install
    ```

3. **Configure o ambiente**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure o banco de dados**

    - Crie um banco MySQL
    - Atualize as credenciais no arquivo `.env`:
        ```env
        DB_DATABASE=seu_banco
        DB_USERNAME=seu_usuario
        DB_PASSWORD=sua_senha
        ```

5. **Execute as migrations**

    ```bash
    php artisan migrate
    ```

6. **Compile os assets**

    ```bash
    npm run build
    ```

7. **Inicie o servidor**

    ```bash
    php artisan serve
    ```

8. **Acesse a aplicação**
    - Abra http://localhost:8000
    - Registre-se e comece a usar!

## 🎯 Como Usar

### Primeiros Passos

1. **Registre-se** na aplicação
2. **Crie seu primeiro projeto** para organizar o trabalho
3. **Adicione tarefas** ao seu Kanban
4. **Faça anotações** importantes
5. **Salve snippets** de código úteis

### Fluxo de Trabalho

1. **Dashboard**: Veja o resumo diário
2. **Projetos**: Organize por contexto
3. **Kanban**: Gerencie tarefas visualmente
4. **Anotações**: Documente ideias e reuniões
5. **Snippets**: Mantenha código reutilizável

### Dicas de Produtividade

-   Use projetos para separar contextos diferentes
-   Mantenha o Kanban atualizado
-   Documente decisões importantes nas anotações
-   Salve funções úteis como snippets
-   Revise o dashboard regularmente

## 🏗️ Estrutura do Projeto

```
app/
├── Http/Controllers/
│   ├── DashboardController.php
│   ├── ProjectController.php
│   ├── TaskController.php
│   ├── NoteController.php
│   └── SnippetController.php
├── Models/
│   ├── Project.php
│   ├── Task.php
│   ├── Note.php
│   └── Snippet.php
└── Policies/
    ├── ProjectPolicy.php
    ├── TaskPolicy.php
    ├── NotePolicy.php
    └── SnippetPolicy.php

resources/views/
├── layouts/
│   └── app.blade.php
├── dashboard.blade.php
├── projects/
├── tasks/
├── notes/
└── snippets/
```

## 🔒 Segurança

-   Autenticação obrigatória para todas as rotas
-   Policies para controle de acesso
-   Validação de dados em todos os formulários
-   Proteção CSRF ativa
-   Sanitização de conteúdo HTML

## 🚀 Deploy

### Produção

1. Configure o ambiente de produção
2. Execute `php artisan config:cache`
3. Execute `php artisan route:cache`
4. Configure o servidor web (Apache/Nginx)
5. Configure SSL

### Docker (Opcional)

```bash
# Dockerfile disponível para containerização
docker build -t painel-produtividade .
docker run -p 8000:8000 painel-produtividade
```

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

## Usuário de Demonstração

Acesse o sistema com as credenciais abaixo para testar todas as funcionalidades:

-   **E-mail:** demo@demo.com
-   **Senha:** 123456

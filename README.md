Projeto Ferrorama - Sistema de Gestão e Monitoramento Ferroviário
Sumário
Sobre o Projeto

Funcionalidades e Requisitos

Arquitetura e Tecnologias

Estrutura do Repositório

Pré-requisitos e Instalação

Configuração do Banco de Dados

Controle de Acesso e Autenticação

Pesquisas Técnicas e Acadêmicas

Metodologia Ágil e Kanban

Equipe e Contribuidores

1. Sobre o Projeto
O Ferrorama é um sistema web desenvolvido no contexto da Situação de Aprendizagem do curso técnico. A aplicação realiza o controle, gerenciamento e monitoramento em tempo real de maquetes e circuitos ferroviários automatizados, integrando autenticação segura de usuários, gerenciamento de sensores de pista, cadastro completo de trens e rotas, e simulação de telemetria.

Nas etapas iniciais, o projeto foi prototipado em HTML5/CSS3/JavaScript e estruturado em PHP procedural com conexões MySQLi e inclusão de componentes reutilizáveis.

Nas Etapas 6 a 9 (Fase Final), a aplicação foi consolidada com:

Autenticação de usuários reforçada por criptografia BCRYPT e sessões PHP ($_SESSION);

Middleware de controle de acesso no backend (includes/auth.php) restringindo rotas administrativas ao perfil Administrador;

CRUD completo de Trens e Rotas com suporte a Chaves Estrangeiras (FOREIGN KEY);

Validação e simulação em tempo real para sensores IoT em JavaScript (JavaScript/sensores.js);

Pesquisas acadêmicas abrangendo Scrum, PDO/MySQLi, CRUD, XAMPP e APIs RESTful (JSON, HTTP e cURL).

2. Funcionalidades e Requisitos
Requisitos Funcionais (RF)
[RF01] Autenticação e Login (tela-login.php / verifica-login.php): Autenticação segura de usuários com validação de senha por hash BCRYPT e encerramento de sessão em logout.php.

[RF02] Controle de Permissões no Backend (includes/auth.php): Proteção de rotas sensíveis; usuários do perfil Comprador/Padrão são impedidos de acessar áreas restritas do Administrador.

[RF03] Gestão de Usuários (tela-lista-usuarios.php): Cadastro, edição, listagem e remoção segura de usuários do sistema.

[RF04] Gestão de Trens (tela-lista-trens.php / tela-cadastro-trem.php): Cadastro e manutenção de locomotivas, velocidade máxima, modelo, status operacional e vinculação ao usuário responsável.

[RF05] Gestão de Rotas (tela-lista-rotas.php / tela-cadastro-rota.php): Mapeamento de trajetos com estação de origem, destino, distância (km), tempo estimado e vinculação obrigatória a um trem.

[RF06] Gerenciamento e Telemetria de Sensores (tela-lista-sensores.php): Cadastro e simulação em tempo real de leitura de sensores de presença, velocidade e temperatura via JavaScript.

[RF07] Painel de Controle Ferroviário (Tela-trilho.php / tela-home.php): Dashboard para visualização geral do circuito e navegação pelos módulos do sistema.

Requisitos Não Funcionais (RNF)
[RNF01] Criptografia e Segurança: Armazenamento seguro de senhas utilizando o algoritmo BCRYPT (password_hash e password_verify).

[RNF02] Prevenção contra SQL Injection: Uso rigoroso de Prepared Statements em todas as operações de consulta e escrita no MySQL.

[RNF03] Integridade Referencial: Relacionamentos no banco de dados protegidos por Foreign Keys (usuarios -> trens -> rotas).

[RNF04] Modularidade: Componentes reutilizáveis em PHP (cabecalho.php, rodape.php, conexao.php, auth.php).

[RNF05] Rastreabilidade: Cobertura de 100% das tarefas no GitHub Projects (Kanban) mapeadas para os commits correspondentes.

3. Arquitetura e Tecnologias
A aplicação utiliza uma arquitetura cliente-servidor monolítica baseada no padrão modular PHP.

Backend: PHP 8.2 (Procedural e Modular com $_SESSION e Prepared Statements)

Banco de Dados: MySQL 8.0 (MySQLi com relatórios de exceção e Foreign Keys)

Frontend: HTML5, CSS3, JavaScript (ES6+ assíncrono para sensores)

Segurança: Criptografia BCRYPT e Middleware Backend de Autorização

Controle de Versão: Git e GitHub

Gestão do Projeto: GitHub Projects (Kanban)

Servidor Local: XAMPP (Apache + MariaDB/MySQL)

4. Estrutura do Repositório
Organização padronizada das pastas e arquivos do sistema:

ferrorama/
│
├── documentação/                 # Documentação técnica e pesquisas acadêmicas
│   ├── pesquisa-apis.md          # Estudo técnico sobre APIs REST, JSON, Métodos HTTP e cURL
│   ├── pesquisa-crud.md          # Fundamentos das operações de CRUD
│   ├── pesquisa-pdo.md           # Estudo comparativo PDO vs MySQLi
│   ├── pesquisa-scrum.md         # Framework Ágil Scrum e seus rituais
│   └── pesquisa-xampp.md         # Configuração do ambiente local
│
├── includes/                     # Middlewares e funções de segurança
│   └── auth.php                  # Funções de proteção de rota e autenticação
│
├── JavaScript/                   # Scripts e comportamentos dinâmicos
│   └── sensores.js               # Validação de formulários e simulação de leitura em tempo real
│
├── Telas/                        # Interfaces de usuário e scripts de processamento
│   ├── cabecalho.php             # Cabeçalho responsivo com exibição do perfil e logout
│   ├── conexao.php               # Estabelecimento de conexão MySQLi
│   ├── painel-admin.php          # Tela de teste e verificação de acesso exclusivo de Admin
│   ├── processa-exclusao-rota.php# Script de remoção de rotas
│   ├── processa-exclusao-trem.php# Script de remoção de trens (com validação de dependências)
│   ├── processa-exclusao-user.php# Script de remoção de usuários
│   ├── processa-salvar-rota.php  # Processamento de cadastro e edição de rotas
│   ├── processa-salvar-trem.php  # Processamento de cadastro e edição de trens
│   ├── rodape.php                # Rodapé padrão do sistema
│   ├── style.css                 # Folha de estilos globais
│   ├── tela-cadastro-rota.php    # Formulário para inclusão e alteração de rotas
│   ├── tela-cadastro-sensor.php  # Formulário para inclusão de sensores
│   ├── tela-cadastro-trem.php    # Formulário para inclusão e alteração de trens
│   ├── tela-cadastro-user.php    # Formulário para inclusão de usuários
│   ├── tela-editar-user.php      # Edição de dados do usuário
│   ├── tela-home.php             # Dashboard principal
│   ├── tela-lista-rotas.php      # Tabela com listagem das rotas cadastradas
│   ├── tela-lista-sensores.php   # Tabela e monitor de sensores
│   ├── tela-lista-trens.php      # Tabela com listagem dos trens cadastrados
│   ├── tela-lista-usuarios.php   # Tabela de gestão de usuários
│   ├── tela-login.php            # Formulário de autenticação do sistema
│   ├── Tela-trilho.php           # Painel de controle do circuito
│   └── verifica-login.php        # Processamento e validação de login BCRYPT
│
├── Banco.sql                     # Script de criação do banco e tabelas (Usuários, Trens, Rotas)
├── atualizar_senhas.php          # Script utilitário para migração de senhas em texto puro para BCRYPT
├── index.php                     # Ponto de entrada do sistema
├── logout.php                    # Destruição de sessão e redirecionamento para o login
├── LICENSE                       # Licença de uso do software
└── README.md                     # Documentação principal do repositório
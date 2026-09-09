# Projeto Ferrorama - Sistema de Gestao e Monitoramento Ferroviario

## 1. Sumario
- 1. Sobre o Projeto
- 2. Funcionalidades e Requisitos
- 3. Arquitetura e Tecnologias
- 4. Estrutura do Repositorio
- 5. Pre-requisitos e Instalacao
- 6. Configuracao do Banco de Dados
- 7. Teste e Validacao da Conexao
- 8. Pesquisa Teorica: PDO vs MySQLi
- 9. Metodologia Agil e Kanban
- 10. Padrao de Commits e Rastreabilidade
- 11. Equipe e Contribuidores

## 1. Sobre o Projeto

O Ferrorama e um sistema web desenvolvido no contexto da Situacao de Aprendizagem do curso tecnico. A aplicacao visa realizar o controle, gerenciamento e monitoramento em tempo real de maquetes e circuitos ferroviarios automatizados, permitindo o cadastro de sensores de pista, gerenciamento de usuarios do sistema, simulacao de carrinho de compras de itens ferroviarios e controle de pecas.

Na Etapa 1, o projeto foi estruturado com prototipacao estatica em HTML5, CSS3, JavaScript e documentacao em Markdown baseada na metodologia Scrum.

Na Etapa 2, o sistema passou por uma refatoracao tecnica, convertendo as paginas estaticas para arquivos .php, estruturando o modelo de inclusao de modulos reutilizaveis (header.php e footer.php), criando a camada de conexao com o banco de dados MySQL via extensao MySQLi e documentando um estudo teorico sobre PDO.

## 2. Funcionalidades e Requisitos

### Requisitos Funcionais (RF)
- [RF01] Vitrine e Tela Principal (index.php): Apresentacao visual dos produtos, categorias de locomotivas e trilhos, com cabecalho responsivo e rodape dinamico.
- [RF02] Gestao de Usuarios (tela-lista-usuarios.php): Exibicao da tabela de usuarios cadastrados no sistema com niveis de acesso (Administrador e Comprador).
- [RF03] Gerenciamento de Sensores (tela-cadastro-sensores.php): Formulario de cadastro e listagem dinamica dos sensores de presenca, velocidade e parada instalados nos trilhos.
- [RF04] Carrinho de Compras / Offcanvas: Painel lateral dinamico acionado pelo menu para selecao de itens e calculo do valor total.
- [RF05] Pesquisa teorica e Documentacao Scrum: Registro dos papeis, rituais e artefatos do Scrum em docs/scrum.md, acompanhado do estudo comparativo sobre conexoes PHP em pesquisas/pdo.md.

### Requisitos Nao Funcionais (RNF)
- [RNF01] Modularidade: Arquitetura desacoplada utilizando inclusao de cabecalhos e rodapes reutilizaveis.
- [RNF02] Conectividade: Uso da extensao MySQLi para comunicacao segura com a base de dados.
- [RNF03] Responsividade: Interface adaptavel para celulares, tablets e desktops via Bootstrap 5.
- [RNF04] Rastreabilidade: Mapeamento bidirecional completo entre Requisito -> Kanban -> Codigo -> Commit.

## 3. Arquitetura e Tecnologias

A aplicacao segue uma arquitetura cliente-servidor monolitica baseada no padrao modular PHP.

### Tecnologias Utilizadas:
- Backend: PHP 8.2 (Procedural e Modular)
- Banco de Dados: MySQL 8.0
- Frontend: HTML5, CSS3, JavaScript (ES6+), Bootstrap 5.3, FontAwesome 6.4
- Controle de Versao: Git e GitHub
- Gestao do Projeto: GitHub Projects (Kanban)
- Servidor Local: XAMPP / WAMP / Laragon (Apache)

## 4. Estrutura do Repositorio

Organizacao detalhada das pastas e arquivos do sistema:

```text
ferrorama/
│
├── assets/                  # Arquivos estaticos do sistema
│   ├── js/                  # Scripts JavaScript
│   │   └── sensores.js      # Manipulacao dinamica da tabela de sensores
│   └── style/               # Estilos CSS customizados
│       └── style.css        # Regras de estilo globais do Ferrorama
│
├── config/                  # Arquivos de configuracao do servidor
│   └── conexao.php          # Script de conexao MySQLi com tratamento de erro
│
├── docs/                    # Documentacao do projeto
│   └── scrum.md             # Pesquisa sobre a metodologia agil Scrum
│
├── includes/                # Componentes reutilizaveis PHP
│   ├── footer.php           # Rodape padrao e inclusao de scripts
│   └── header.php           # Cabecalho, navegacao e inclusao de CSS
│
├── pesquisas/               # Estudos tecnicos do curso
│   └── pdo.md               # Pesquisa aprofundada sobre a extensao PDO
│
├── index.php                # Pagina inicial do sistema (Home/Vitrine)
├── tela-cadastro-sensores.php # Pagina de cadastro e gestao de sensores
├── tela-lista-usuarios.php    # Pagina de visualizacao de usuarios
├── teste-conexao.php        # Pagina de validacao do status do banco
├── README.md                # Documentacao tecnica principal do repositorio
└── .gitignore               # Arquivos ignorados pelo controle de versao
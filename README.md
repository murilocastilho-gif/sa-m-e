Projeto Ferrorama - Sistema de Gestão e Monitoramento Ferroviário
Sumário

1- Sobre o Projeto

2- Funcionalidades e Requisitos

3- Arquitetura e Tecnologias

4- Estrutura do Repositório

5- Pré-requisitos e Instalação

6- Configuração e Modelagem do Banco de Dados

7- Controle de Acesso e Autenticação

8- Pesquisas Técnicas e Acadêmicas

9- Metodologia Ágil e Kanban

10- Equipe e Contribuidores

Sobre o Projeto
O Ferrorama é um sistema web desenvolvido no contexto da Situação de Aprendizagem do curso técnico. A aplicação realiza o controle, gerenciamento e monitoramento em tempo real de maquetes e circuitos ferroviários automatizados, integrando autenticação segura de usuários, gerenciamento de sensores de pista, cadastro completo de trens e rotas, e simulação de telemetria.

Funcionalidades e Requisitos
Requisitos Funcionais:

RF01 Autenticação e Login: Autenticação segura de usuários com validação de senha por hash BCRYPT e encerramento de sessão em logout.php.

RF02 Controle de Permissões no Backend: Proteção de rotas sensíveis via verifica-sessao.php. Usuários do perfil Padrão são impedidos de acessar áreas restritas do Administrador.

RF03 Gestão de Usuários: Cadastro, edição, listagem e remoção de usuários do sistema.

RF04 Gestão de Trens: Cadastro e manutenção de locomotivas, velocidade máxima, modelo, status operacional e vinculação ao usuário responsável.

RF05 Gestão de Rotas: Mapeamento de trajetos com estação de origem, destino, distância em quilômetros, tempo estimado e vinculação a um trem.

RF06 Gerenciamento e Telemetria de Sensores: Cadastro e simulação em tempo real de leitura de sensores via JavaScript.

RF07 Painéis de Controle: Dashboard para visualização geral do circuito em tela-home.php e painel administrativo restrito em tela-admin.php.

Requisitos Não Funcionais:

RNF01 Criptografia e Segurança: Armazenamento de senhas utilizando o algoritmo BCRYPT via password_hash e password_verify.

RNF02 Prevenção contra SQL Injection: Uso de Prepared Statements em todas as operações de consulta e escrita no MySQL.

RNF03 Integridade Referencial: Relacionamentos no banco de dados protegidos por Foreign Keys entre as tabelas.

RNF04 Modularidade: Componentes reutilizáveis em PHP como cabecalho.php, rodape.php, conexao.php e verifica-sessao.php.

RNF05 Separação de Acessos: Divisão clara entre tela de consulta operacional e tela de gestão administrativa.

Arquitetura e Tecnologias
A aplicação utiliza uma arquitetura cliente-servidor monolítica baseada no padrão modular PHP.

Backend: PHP 8.2 procedural e modular com sessões e Prepared Statements.

Banco de Dados: MySQL 8.0 / MariaDB com MySQLi e Foreign Keys.

Frontend: HTML5, CSS3, Bootstrap 5 e JavaScript ES6.

Servidor Local: XAMPP com Apache e MySQL.

Controle de Versão: Git e GitHub.

Estrutura do Repositório
ferrorama/
├── documentação/
│   ├── pesquisa-apis.md
│   ├── pesquisa-crud.md
│   ├── pesquisa-pdo.md
│   ├── pesquisa-scrum.md
│   └── pesquisa-xampp.md
├── includes/
│   └── auth.php
├── JavaScript/
│   └── sensores.js
├── Telas/
│   ├── cabecalho.php
│   ├── conexao.php
│   ├── rodape.php
│   ├── tela-admin.php
│   ├── tela-cadastro-rota.php
│   ├── tela-cadastro-trem.php
│   ├── tela-cadastro-user.php
│   ├── tela-home.php
│   ├── tela-lista-rotas.php
│   ├── tela-lista-sensores.php
│   ├── tela-lista-trens.php
│   ├── tela-lista-usuarios.php
│   ├── tela-login.php
│   ├── verifica-login.php
│   └── verifica-sessao.php
├── Banco.sql
├── index.php
├── logout.php
└── README.md

Pré-requisitos e Instalação
Pré-requisitos:

XAMPP com Apache e MySQL ativos.

Navegador web.

Instalação:

Clone o repositório no diretório htdocs do XAMPP:
git clone https://github.com/murilocastilho-gif/sa-m-e.git

Inicie os serviços Apache e MySQL no XAMPP Control Panel.

Acesse a aplicação no navegador pelo endereço:
http://localhost/sa-m-e/Telas/tela-login.php

Configuração e Modelagem do Banco de Dados
Script SQL de criação do banco e tabelas:

CREATE DATABASE IF NOT EXISTS ferrorama;
USE ferrorama;

CREATE TABLE IF NOT EXISTS usuarios (
id_usuario INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL UNIQUE,
senha VARCHAR(255) NOT NULL,
perfil ENUM('Administrador', 'Usuario') NOT NULL DEFAULT 'Usuario',
criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS trens (
id_trem INT AUTO_INCREMENT PRIMARY KEY,
nome_trem VARCHAR(100) NOT NULL,
modelo VARCHAR(50),
velocidade_max DECIMAL(5,2),
status ENUM('Operacional', 'Manutencao', 'Inativo') DEFAULT 'Operacional',
id_usuario INT,
FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS rotas (
id_rota INT AUTO_INCREMENT PRIMARY KEY,
nome_rota VARCHAR(100) NOT NULL,
origem VARCHAR(100) NOT NULL,
destino VARCHAR(100) NOT NULL,
distancia_km DECIMAL(6,2) NOT NULL,
tempo_estimado_min INT NOT NULL,
id_trem INT,
FOREIGN KEY (id_trem) REFERENCES trens(id_trem) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS sensores (
id_sensor INT AUTO_INCREMENT PRIMARY KEY,
nome_sensor VARCHAR(100) NOT NULL,
tipo VARCHAR(50) NOT NULL,
localizacao VARCHAR(100),
status ENUM('Ativo', 'Inativo') DEFAULT 'Ativo',
id_rota INT,
FOREIGN KEY (id_rota) REFERENCES rotas(id_rota) ON DELETE CASCADE
);

Controle de Acesso e Autenticação
O sistema possui dois perfis de acesso validados por sessão no servidor:

Administrador: Acesso completo ao sistema e ao painel administrativo tela-admin.php.

Operador: Acesso restrito de consulta ao painel tela-home.php.

A verificação de permissão é feita pela função exigirAdmin no arquivo verifica-sessao.php, que redireciona usuários sem privilégio e encerra a execução do script para evitar acessos diretos por URL.

Pesquisas Técnicas e Acadêmicas
A pasta documentação contém cinco relatórios de pesquisa acadêmica:

pesquisa-apis.md: Estudo sobre arquitetura REST, JSON, verbos HTTP e cURL.

pesquisa-crud.md: Conceitos e implementação das operações de Create, Read, Update e Delete.

pesquisa-pdo.md: Análise comparativa entre as extensões PDO e MySQLi.

pesquisa-scrum.md: Fundamentos do framework Scrum, papéis, eventos e artefatos.

pesquisa-xampp.md: Guia de instalação e configuração do ambiente local XAMPP.

Metodologia Ágil e Kanban
O projeto foi gerenciado com a metodologia Kanban no GitHub Projects. O fluxo de trabalho dividiu as tarefas em quatro etapas: Backlog, Em Progresso, Em Revisão e Concluído, garantindo o acompanhamento de cada requisito técnico do sistema.

Equipe e Contribuidores
Projeto desenvolvido para a avaliação da Situação de Aprendizagem do curso técnico.
Repositório oficial: https://github.com/murilocastilho-gif/sa-m-e
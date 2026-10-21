# Pesquisa Acadêmica: Application Programming Interfaces (APIs)

1. O que é uma API?
Uma API (Application Programming Interface, ou Interface de Programação de Aplicações) é um conjunto de rotinas, protocolos e padrões de programação que permite a comunicação entre diferentes sistemas de software. Ela funciona como uma ponte ou intermediária, permitindo que uma aplicação utilize dados, rotinas ou serviços de outra de forma padronizada e segura, sem expor a complexidade interna do seu código ou banco de dados.

# 2. Objetivo e Comunicação entre Sistemas
O objetivo principal de uma API é integrar sistemas e automatizar a troca de dados entre aplicações distintas. A comunicação ocorre por meio do modelo Cliente e Servidor:
Cliente (Requisição): O sistema frontend, aplicativo mobile ou serviço externo envia um pedido de informação via protocolo HTTP.
Servidor (Processamento e Resposta): A API recebe a requisição, valida as permissões de acesso, processa a regra de negócio no banco de dados e retorna os dados formatados para o cliente acompanhados de um código de status.

# 3. APIs REST e seus Princípios
O REST (Representational State Transfer) é um estilo arquitetural de desenvolvimento para serviços web que utiliza os padrões nativos do protocolo HTTP. APIs que seguem rigorosamente esses padrões são chamadas de RESTful.

Principais princípios do REST:
Separação Cliente e Servidor: A interface de usuário (frontend) é totalmente independente da regra de negócio e armazenamento de dados (backend).
Sem Estado (Stateless): O servidor não armazena o histórico da sessão do cliente. Cada requisição enviada pelo cliente deve conter todas as informações necessárias para ser processada.
Interface Uniforme: Acesso padronizado aos recursos por meio de URLs organizadas e métodos HTTP bem definidos.

# 4. Métodos HTTP
Os métodos HTTP informam ao servidor qual ação deve ser realizada sobre um recurso específico:
GET: Utilizado exclusivamente para consultar e ler informações do banco de dados.
POST: Utilizado para criar e cadastrar um novo registro na aplicação.
PUT: Utilizado para atualizar todos os dados de um registro existente.
PATCH: Utilizado para atualizar apenas campos específicos de um registro.
DELETE: Utilizado para remover um registro do banco de dados.

# 5. Requisições, Respostas e Endpoints
Endpoints: São os endereços (URLs) específicos disponibilizados pela API para acessar cada recurso. Exemplo no Ferrorama: /api/trens ou /api/rotas.
Requisição (Request): Composta pelo Endpoint, pelo Método HTTP escolhido, pelos Cabeçalhos (Headers) com metadados de autenticação e pelo Corpo (Body) contendo os dados a serem salvos.
Resposta (Response): Contém os dados solicitados e o Status Code HTTP para indicar o resultado da operação:
200 OK: Operação realizada com sucesso.
201 Created: Registro criado com sucesso.
400 Bad Request: Dados enviados incorretos ou inválidos.
401 Unauthorized: Usuário não autenticado no sistema.
403 Forbidden: Usuário sem permissão para acessar a funcionalidade.
404 Not Found: Recurso ou endpoint não encontrado.
500 Internal Server Error: Falha interna no código do servidor.

# 6. Formato JSON
O JSON (JavaScript Object Notation) é o formato mais utilizado para transferência de dados em APIs RESTful por ser leve, estruturado e legível para humanos e máquinas.

# Exemplo de dados no formato JSON:
```json
{
  "sucesso": true,
  "trem": {
    "id_trem": 1,
    "nome_trem": "Locomotiva Carga Expressa",
    "modelo": "GE Dash 9",
    "velocidade_maxima": 110,
    "status": "Operacional"
  }
}

API REST vs. Sistema Web Tradicional
Sistema Web Tradicional: O servidor backend em PHP consulta o banco de dados e renderiza o código HTML e CSS completo que é enviado diretamente para o navegador do usuário.
Arquitetura com API REST: O backend em PHP apenas processa as regras de negócio e retorna dados puros em JSON. O cliente (React, aplicativo mobile ou dashboard) fica encarregado de construir a interface gráfica e exibir as informações.

Integração Prática em PHP

Consumindo uma API externa no PHP (cURL):

<?php
$url = "[https://api.exemplo.com/v1/trens/1](https://api.exemplo.com/v1/trens/1)";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

$resposta = curl_exec($ch);
curl_close($ch);

$dados = json_decode($resposta, true);
echo "Nome do Trem: " . $dados['trem']['nome_trem'];
?>

Disponibilizando dados em JSON via PHP:

<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../conexao.php';

$sql = "SELECT id_trem, nome_trem, status FROM trens";
$resultado = $conexao->query($sql);

$trens = [];
while ($linha =$resultado->fetch_assoc()) {
    $trens[] =$linha;
}

http_response_code(200);
echo json_encode(["sucesso" => true, "trens" => $trens]);
?>

Segurança e Autenticação em APIs
A proteção de dados em APIs exige mecanismos rigorosos de controle de acesso:
HTTPS: Criptografia das requisições para evitar a interceptação de dados na rede.
API Keys: Chaves identificadoras enviadas nos cabeçalhos da requisição.
Tokens JWT (JSON Web Tokens): Credencial gerada após o login que valida a identidade e os privilégios do usuário em cada nova chamada à API.

Benefícios e Aplicações no Setor Ferroviário
Sensores IoT: Envio automático de telemetria (velocidade, temperatura do motor) dos trens em tempo real para a central.
Integração Logística: Comunicação direta entre o sistema da ferrovia e os portos de carga.
Serviços de Clima: Consulta automática de APIs de tempo para prevenção de acidentes em trilhos sob tempestades.
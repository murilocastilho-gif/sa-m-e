# Relatório de Utilização de Inteligência Artificial — Projeto Ferrorama

## 1. Ferramenta Utilizada
- Agente/Ferramenta: ChatGPT / Gemini AI
- Versão/Modelo: Modelo de Linguagem de Larga Escala (LLM)
- Data de Aplicação: Etapas 10 e 11

## 2. Objetivo do Uso
A Inteligência Artificial foi utilizada como ferramenta de auxílio ao desenvolvimento para:
1. Estruturação do consumo das APIs assíncronas em JavaScript (`Fetch API` para Open-Meteo e ViaCEP).
2. Auxílio na elaboração da documentação técnica e relatórios acadêmicos.
3. Refinamento de layout Bootstrap 5 para garantir responsividade e padronização visual.

## 3. Prompts e Instruções Fornecidos

### Prompt 1 (Integração de APIs)
"Crie um script em JavaScript nativo utilizando Fetch API para consultar a API de clima gratuita Open-Meteo para a latitude/longitude de Joinville. Trate erros de conexão e retorne o código formatado em HTML para injetar em um widget."

### Prompt 2 (Design System & CSS)
Forneça uma estrutura de tabela Bootstrap 5 com suporte a badges e ícones do FontAwesome 6 mantendo um contraste adequado no padrão WCAG."*


## 4. Funcionalidades e Código Gerados com Auxílio da IA
- Arquivo `JavaScript/clima.js` (Lógica de requisição HTTP e parsing de JSON).
- Arquivo `JavaScript/cep.js` (Função de autocomplete de endereço).
- Estrutura base da Landing Page (`Telas/apresentação.php`).
- Documento de Identidade Visual (`pesquisas/identidade-visual.md`).


## 5. Alterações e Validações Efetuadas pela Equipe
Nenhum código gerado pela IA foi inserido no sistema sem revisão prévia. As seguintes modificações foram realizadas pelos integrantes:
- Sanitização de CEP: Inclusão de regra Regex `.replace(/\D/g, '')` para evitar falhas com traços e pontos.
- Tratamento de Exceções: Criação de mensagens amigáveis em português quando o serviço de clima ou CEP está indisponível.
- Ajuste de Idioma: Adaptação de nomenclaturas geradas originalmente em tom neutro/PT-PT para a norma brasileira (PT-BR).

## 6. Testes Realizados
1. Teste de CEP Inexistente: Inserção do CEP `00000-000` para validar o retorno do erro `dados.erro = true`.
2. Teste de CEP Formato Inválido: Digitação de menos de 8 caracteres para verificar o bloqueio de requisições desnecessárias.
3. Teste de Clima Offline: Simulação de queda de conexão para garantir que a interface exibe o alerta sem quebrar o layout.

## 7. Reflexão e Limitações
A utilização da IA acelerou o processo de prototipagem e a estruturação dos scripts assíncronos. Contudo, observou-se que a IA necessitou de ajustes manuais no alinhamento das classes do Bootstrap e no tratamento específico de caminhos de arquivos PHP (`__DIR__`). A equipe validou 100% dos fluxos em ambiente local (XAMPP).
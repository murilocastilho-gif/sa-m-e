Markdown
# Documento de Identidade Visual e Teoria das Cores — Ferrorama

## 1. Referências Visuais Pesquisadas
Foram analisadas interfaces de painéis de controle industriais, dashboards de monitoramento ferroviário (como Siemens Mobility e GE Transportation) e sistemas modernos de logística. A equipe absorveu a necessidade de alta legibilidade, contraste marcado e distinção imediata por cores para estados operacionais.

## 2. Conceitos de Teoria das Cores Utilizados
Foi aplicada a psicologia das cores voltada para a sinalização ferroviária:
- Azul Escuro Industrial: Transmite estabilidade, tecnologia e corporativismo.
- Verde Sinalizador: Indica via livre, rotas ativas e operações normais.
- Amarelo Âmbar: Indica atenção, sensores de telemetria e avisos.
- Vermelho Alerta: Reservado para paradas, exclusões e status de manutenção crítica.

## 3. Paleta de Cores Escolhida

| Função | Nome da Cor | Código HEX | Aplicação no Sistema |
| :--- | :--- | :--- | :--- |
| Primária / Header | Azul Marinho Industrial | `#0F2C59` | Navbar, cabeçalhos principais e cards de destaque |
| Sucesso / Operação | Verde Sinal | `#198754` | Status "Em Operação", botões de salvamento e módulo de Rotas |
| Atenção / Telemetria | Amarelo Âmbar | `#FFC107` | Módulo de Sensores, avisos e botões de ação secundária |
| Erro / Perigo | Vermelho Alerta | `#DC3545` | Botões de exclusão, perfis de Administrador e badges restritos |
| Fundo da Aplicação | Cinza Neutro Claro | `#F8F9FA` | Fundo geral da página para destacar os cartões brancos |
| Superfície / Cards | Branco Puro | `#FFFFFF` | Cartões de formulário, tabelas e contêineres de conteúdo |
| Texto Principal | Grafite Escuro | `#212529` | Títulos, rótulos de campos e dados das tabelas |

## 4. Tipografia e Elementos Gráficos
- Tipografia: Segoe UI / System UI (Sans-serif). Garantem excelente leitura em telas digitais de resoluções variadas.
- Ícones: FontAwesome 6. Utilizados de forma semântica (Trem `fa-train`, Rota `fa-route`, Sensor `fa-tower-cell`, Usuário `fa-users`).

## 5. Decisões de Layout e Hierarquia Visual
1. Cards com Borda Indicadora (Border-Left Highlight):** Cada módulo possui um destaque na borda esquerda com a cor do seu domínio (Azul para Trens, Verde para Rotas, Amarelo para Sensores).
2. Formulários Limitados: Todos os cards de formulários possuem `max-width: 620px` para evitar o esticamento de campos em monitores ultrawide.
3. Badges Redondos (Pílulas): Uso de `.rounded-pill` para status e trajetos (`Origem → Destino`).

## 6. Problemas de Usabilidade Identificados nas Versões Anteriores
- Cabeçalho escuro na tabela de usuários que desalinhava do padrão das outras telas.
- Botões de ação com textos brutos "Editar" e "Excluir" em caixas grandes na tela de usuários.
- Termos em Português de Portugal na página de login (*Palavra-passe*).
- Falta de indicação visual do clima no painel inicial do operador.

## 7. Mudanças Realizadas e Justificativas
- Padronização da Tabela de Usuários: Troca do `bg-dark` por `.table-light` e substituição dos botões grandes por ícones compactos em círculo.
- Internacionalização/Localização: Ajuste de todos os formulários para o Português do Brasil (PT-BR).
- Fundo Contrastante no Login: Alteração do fundo branco puro para um tom escuro/azulado (`#0F2C59`), aumentando o foco no formulário central.

## 8. Testes de Contraste, Legibilidade e Responsividade
- Contraste (WCAG 2.1 AA): O texto escuro (`#212529`) sobre o fundo branco dos cartões atinge taxa de contraste de 15.8:1 (superior ao mínimo de 4.5:1).
- Responsividade: Testado em resoluções de 375px (Mobile), 768px (Tablet) e 1920px (Desktop Full HD) via Ferramentas do Desenvolvedor do navegador.

## 9. Fontes Consultadas
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.3/)
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Material Design Color System](https://m2.material.io/design/color/)

## 10. Evidências do Processo Autoral

### 3 Decisões Autorais Justificadas:
1. Não utilizar sombras pesadas: Optou-se por `.shadow-sm` para manter um visual limpo e corporativo.
2. Identificação por Ícones e Cores: Nenhuma tabela depende exclusivamente da cor para transmitir um status; o texto descritivo e o ícone acompanham o sinal.
3. Widget Climatológico Integrado: Posicionado no topo do dashboard para simular a tomada de decisão logística baseada nas condições do tempo na pista.

### Dificuldade Visual Resolvida:
- Problema: A tela de cadastro de trens parecia um bloco gigante sem separação de seções em telas de computadores desktop.
- Solução: Aplicação de um contêiner com `max-width` e centralização automática via
# Guia de Identidade Visual, UI/UX e Teoria das Cores — Já Ismaga

Este documento registra o estudo, a pesquisa e as decisões tomadas para a construção da interface autoral do sistema de monitoramento ferroviário **Já Ismaga**.

---

## 1. Conceito e Justificativa do Design

O objetivo da interface é unir a robustez da sinalização ferroviária industrial com a modernidade dos painéis analíticos da **Indústria 4.0**.

- **Identidade Temática:** Inspirada na sinalização de tráfego de trens, onde o laranja vibrante remete ao alerta operacional e o cinza de alta densidade simula o aço e a estrutura dos trilhos.
- **Diferenciação Visual:** Afastamento de templates corporativos genéricos em azul/branco, adotando cores quentes e alto contraste para facilitar a visualização em ambientes operacionais ou de controle de tráfego.

---

## 2. Paleta de Cores e Teoria Cromática

Utilizamos uma **harmonia análoga com acentos quentes de alerta**, priorizando alto contraste (atendendo à regra de acessibilidade WCAG AAA para leitura de textos).

| Categoria | Nome / Função | Código HEX | Aplicação no Sistema |
| :--- | :--- | :--- | :--- |
| **Cor Principal** | Laranja Sinalização (*Brand*) | `#FF6600` | Navbar, botões primários, ícones em destaque e badges |
| **Cor Hover** | Laranja Queimado (*Hover*) | `#E05500` | Estados interativos de botões e links ativos |
| **Fundo Geral** | Cinza Nevoa (*Page Background*) | `#F8FAFC` | Fundo geral da aplicação, reduzindo o cansaço visual |
| **Superfície** | Branco Puro (*Card Background*) | `#FFFFFF` | Fundos de formulários, tabelas e modais |
| **Texto Principal** | Grafite Escuro (*Primary Text*) | `#334155` | Títulos, rótulos de campos e corpo de texto |
| **Status: Ativo / Sucesso** | Verde Operacional | `#198754` | Badges de status *Ativo* / *Linha Ativa* e alertas |
| **Status: Alerta / Manutenção** | Amarelo Sinalização | `#FFC107` | Badges de status *Manutenção* e avisos |
| **Status: Inativo / Erro** | Vermelho Pare | `#DC3545` | Badges de status *Inativo*, mensagens de erro e botões de exclusão |

---

## 3. Tipografia e Hierarquia Visual

- **Fonte Primária:** `Segoe UI`, `system-ui`, `-apple-system`, `sans-serif`.
  - **Justificativa:** Fontes sem serifa com excelente renderização técnica em telas de variadas resoluções, proporcionando leitura rápida em tabelas e painéis.
- **Pesos e Proporções:**
  - `H1 / H3 (Títulos de Seção)`: Bold (700) com cor de contraste escuro (`#334155`).
  - `Form Labels`: Semibold (600) para garantir a identificação imediata dos campos.
  - `Corpo / Tabelas`: Regular (400) com tamanho de 14px a 16px.

---

## 4. Padrão dos Componentes de UI

1. **Barra de Navegação (Navbar):**
   - Fundo laranja corporativo (`#FF6600`) com logo integrada via `mix-blend-mode: multiply` para eliminação do fundo da imagem.
   - Informações dinâmicas de sessão (`Olá, Nome (Perfil)`) alinhadas à direita com botão de saída.
2. **Formulários e Inputs:**
   - Grupos de entrada (`input-group`) utilizando ícones do **Bootstrap Icons** à esquerda para identificação visual imediata do tipo de dado.
   - Borda de destaque laranja nos estados de foco (`:focus`) e mensagens explicativas abaixo de campos com dependências.
3. **Listagens e Tabelas:**
   - Tabelas zebradas com cabeçalhos escuros para legibilidade rápida de rotas e frotas.
   - Utilização de ícones em botões de ação (*Editar*, *Excluir*) acompanhados de badges coloridos para indicar os status.

---

## 5. Decisões Autorais de Design & Resolução de Problemas

- **Decisão 1 — Indicadores Multissensoriais:** Status não utilizam apenas cores; todas as badges contêm um ícone específico (ex: símbolo de verificado para *Ativo*, chave inglesa para *Manutenção*, e X para *Inativo*), garantindo acessibilidade para daltônicos.
- **Decisão 2 — Controle RBAC no Formulário:** No formulário do trem, operadores veem apenas os campos operacionais, enquanto o admin visualiza também o campo de atribuição do responsável.
- **Decisão 3 — Eliminação de Erro de Tablespace/MySQL:** Correção das Foreign Keys com `ON DELETE SET NULL` no banco de dados, permitindo a exclusão de trens sem causar falhas nas tabelas de rotas e sensores.

---

## 6. Ferramentas e Fontes Consultadas

- **Acessibilidade de Cores:** WebAIM Contrast Checker.
- **Ícones e Grid:** Bootstrap 5.3 & Bootstrap Icons.
- **Ferramenta de IA:** Google Gemini (apoio na refatoração de componentes PHP/CSS e validações em JS).
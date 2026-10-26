# Já Ismaga — Ferrorama IoT e Indústria 4.0

<p align="center">
  <img src="https://img.shields.io/static/v1?label=STATUS&message=EM%20DESENVOLVIMENTO&color=orange&style=for-the-badge" alt="Status: Em Desenvolvimento"/>
  <img src="https://img.shields.io/static/v1?label=CONTEXTO&message=IND%C3%9ASTRIA%204.0&color=blue&style=for-the-badge" alt="Contexto: Indústria 4.0"/>
</p>

<p align="center">
  <img width="300" height="300" alt="Logo Já Ismaga" src="assets/imagem_1.png" />
</p>

---

## Índice
- [Descrição do Projeto](#descrição-do-projeto)
- [Novidades e Atualizações do Sistema](#novidades-e-atualizações-do-sistema)
- [Funcionalidades e Requisitos Funcionais (RFs)](#funcionalidades-e-requisitos-funcionais-rfs)
- [Integração com APIs Externas](#integração-com-apis-externas)
- [Identidade Visual e Teoria das Cores](#identidade-visual-e-teoria-das-cores)
- [Mapeamento de Interfaces (CRUD UI)](#mapeamento-de-interfaces-crud-ui)
- [Firmware e Hardware (IoT)](#firmware-e-hardware-iot)
- [Utilização de Inteligência Artificial](#utilização-de-inteligência-artificial)
- [Pesquisas Técnicas e Documentação](#pesquisas-técnicas-e-documentação)
- [Metodologia de Desenvolvimento e Kanban](#metodologia-de-desenvolvimento-e-kanban)
- [Padrões de Código (Style Guide)](#padrões-de-código-style-guide)
- [Tecnologias e Ferramentas](#tecnologias-e-ferramentas)
- [Instruções de Execução do Sistema](#instruções-de-execução-do-sistema)
- [Estrutura do Projeto](#estrutura-do-projeto)

---

## Descrição do Projeto

O projeto de **Ferrorama IoT da Já Ismaga** une a nostalgia do clássico brinquedo à vanguarda da **Indústria 4.0**, transformando linhas férreas e trilhos tradicionais num ecossistema conectado, automatizado e inteligente.

A solução foca em tecnologia, automação e monitorização ferroviária através do conceito de IoT (*Internet of Things*). O objetivo principal é criar uma plataforma inteligente para o acompanhamento e controlo de informações da ferrovia em tempo real, integrando sensores, atuadores, conectividade sem fio e uma interface moderna para a visualização analítica dos dados. 

O sistema eleva o nível de controlo e segurança operacional através da recolha e transmissão contínua de telemetria, mitigando falhas e otimizando o gerenciamento logístico.

<p align="center">
  <img width="100%" alt="Maquete / Protótipo Ferroviário" src="assets/wmremove-transformed.png" />
</p>

---

## Novidades e Atualizações do Sistema

O sistema passou por uma consolidação funcional e refatoração completa para a apresentação integrada de funcionamento:

- **Design Autoral e Teoria das Cores:** Implementação da paleta de cores baseada em sinalização ferroviária industrial (`#FF6600` Laranja Sinalização e `#334155` Grafite Escuro) com alto contraste (WCAG AAA) e suporte multissensorial com ícones temáticos para daltônicos.
- **Integração com APIs Externas (Clima & CEP):** Implementação de consulta meteorológica em tempo real (**Open-Meteo**) no painel principal e auto-preenchimento de endereços via CEP (**ViaCEP**) com tratamento completo de erros e exceções de rede.
- **Controlo de Permissões Flexível (RBAC no Backend):** Liberação do acesso aos CRUDs operacionais (**Trens**, **Rotas** e **Sensores**) para usuários do tipo `operador` e `admin`, mantendo a gestão de **Usuários** restrita exclusivamente a administradores (`admin`).
- **Autenticação Segura com Bcrypt Hash:** Criptografia das senhas no banco de dados MySQL via `password_hash()` e verificação segura no login (`login-processar.php`), eliminando o armazenamento em texto puro.
- **Estrutura de Banco e Chaves Estrangeiras:** Inclusão dos campos de CEP/endereço na tabela `usuarios` e ajuste das chaves estrangeiras com `ON DELETE SET NULL` no banco de dados (`database/ja_ismaga.sql`), permitindo a exclusão de registros sem travamentos de integridade referencial.
- **Firmware ESP32 Integrado:** Presença do código-fonte para o microcontrolador ESP32 (`firmware/esp32-sa.ino`) responsável pela leitura e transmissão dos dados dos sensores na ferrovia.
- **Relatório de Utilização de IA:** Inclusão da documentação transparente dos prompts, revisões e registros de coautoria em `doc/relatorio-uso-ia.md`.

---

## Funcionalidades e Requisitos Funcionais (RFs)

As funcionalidades do ecossistema foram categorizadas em três pilares, associadas aos Requisitos Funcionais (RFs) do projeto:

### 1. Controlo de Acesso e Segurança (Autenticação)
- **[RF01] Login de Utilizadores:** Interface para autenticação de operadores e administradores.
- **[RF02] Validação de Credenciais:** Integração e verificação de acessos via PDO MySQL com hash Bcrypt criptográfico.
- **[RF03] Sessão Segura e Controle de Perfil:** Controle de permissões por perfil (`admin`, `operador`, `usuario comum`) para restrição de ações operacionais e administrativas diretamente no servidor.

### 2. Monitorização e Telemetria em Tempo Real
- **[RF04] API de Telemetria IoT:** Endpoint dedicado (`api-telemetria.php`) para recepção e processamento das medições dos sensores do microcontrolador ESP32.
- **[RF05] Classificação Automática de Status:** Algoritmo que categoriza instantaneamente o estado operacional do trem (*Ativo*, *Em Manutenção*, *Inativo*).
- **[RF06] Atualização Dinâmica (Live Data):** Interface Web que atualiza os dados automaticamente sem recarregamento da página via scripts JavaScript dedicados em `scripts/`.
- **[RF07] Widget de Clima em Tempo Real:** Exibição dinâmica das condições meteorológicas da estação na Home Page.

### 3. Gestão de Dispositivos (IoT) e Relatórios Preditivos
- **[RF08] CRUD de Entidades (Utilizadores, Trens, Rotas, Sensores):** Módulos completos para cadastro, listagem, edição e eliminação com interface responsiva e validações no frontend e backend.
- **[RF09] Validação e Preenchimento por CEP:** Auto-preenchimento e validação assíncrona de endereços brasileiros via API.
- **[RF10] Manutenção Preditiva & Automação de Desvios:** Leitura de sensores para antecipar falhas operacionais e controle logístico.

---

## Integração com APIs Externas

O sistema consome duas APIs públicas REST em tempo real:

1. **API de Clima — [Open-Meteo API](https://open-meteo.com/):**
   - **Objetivo:** Exibir na Home Page as condições meteorológicas da estação ferroviária (temperatura atual, código de condição climática e data/hora da atualização).
   - **Endpoint Utilizado:** `https://api.open-meteo.com/v1/forecast?latitude=-26.3045&longitude=-48.8487&current_weather=true`
   - **Tratamento de Erros:** Em caso de falha de conexão ou timeout, a interface exibe uma mensagem preventiva sem interromper as demais funções da página.

2. **API de CEP — [ViaCEP API](https://viacep.com.br/):**
   - **Objetivo:** Consultar e preencher automaticamente os dados de endereço (logradouro, bairro, cidade, UF) nos formulários do sistema.
   - **Endpoint Utilizado:** `https://viacep.com.br/ws/{CEP}/json/`
   - **Tratamento de Erros:** Validação de formato (8 dígitos), tratamento para CEPs inexistentes na base nacional e tratamento para exceções de rede.

---

## Identidade Visual e Teoria das Cores

A interface do sistema foi desenvolvida com base num estudo de **UI/UX e Teoria das Cores**, visando afastar-se de templates genéricos e refletir o contexto ferroviário industrial:

- **Paleta de Cores:**
  - `Laranja Sinalização (#FF6600)`: Cor primária da marca (Navbar, botões primários e destaques).
  - `Laranja Queimado (#E05500)`: Estado de *hover* e interação.
  - `Grafite Escuro (#334155)`: Leitura de títulos e textos com alto contraste.
  - `Cinza Névoa (#F8FAFC)`: Fundo das telas, reduzindo a fadiga visual do operador.
- **Acessibilidade:** Todas as badges de status utilizam cores combinadas a ícones e textos claros (*Ativo*, *Em Manutenção*, *Inativo*), garantindo acessibilidade para daltônicos.
- **Documentação do Estudo:** O relatório detalhado de design está disponível em [`pesquisas/identidade-visual.md`](pesquisas/identidade-visual.md).

---

## Mapeamento de Interfaces (CRUD UI)

Abaixo estão listadas as interfaces desenvolvidas para cada entidade do sistema:

| Entidade | Tela de Listagem | Tela de Form | Processadores Backend | Script JS Dedicado |
| :--- | :--- | :--- | :--- | :--- |
| **Utilizadores** | `public/usuarios.php` | `public/usuario-form.php` | `usuario-salvar.php`, `usuario-deletar.php` | `scripts/usuarios.js`, `usuario-form.js`, `usuario-salvar.js`, `usuario-deletar.js` |
| **Trens** | `public/trens.php` | `public/trem-form.php` | `trem-salvar.php`, `trem-deletar.php` | `scripts/trens.js`, `trem-form.js`, `trem-deletar.js` |
| **Rotas** | `public/rotas.php` | `public/rota-form.php` | `rota-salvar.php`, `rota-deletar.php` | `scripts/rotas.js`, `rota-form.js`, `rota-salvar.js`, `rota-deletar.js` |
| **Sensores** | `public/Sensores.php` | `public/sensor-form.php` | `sensor-salvar.php`, `sensor-deletar.php` | `scripts/Sensores.js`, `sensor-form.js`, `sensor-salvar.js`, `sensor-deletar.js` |

---

## Firmware e Hardware (IoT)

O projeto integra hardware embarcado para coleta e controle em tempo real:
- **Microcontrolador:** ESP32
- **Arquivo de Firmware:** `firmware/esp32-sa.ino`
- **Comunicação:** Conexão Wi-Fi enviando requisições HTTP POST para o endpoint `public/api-telemetria.php`.

---

## Utilização de Inteligência Artificial

O desenvolvimento contou com o auxílio transparente e documentado de agentes de Inteligência Artificial (Google Gemini / GitHub Copilot):
- **Aplicações:** Estruturação de scripts PHP de validação RBAC, refatoração de regras do MySQL, construção dos scripts assíncronos de consumo das APIs e padronização visual com Bootstrap 5.
- **Relatório Completo & Coautoria:** O detalhamento dos prompts, testes executados pela equipe, correções aplicadas e registro de coautoria em commits estão disponíveis no arquivo **`doc/relatorio-uso-ia.md`**.

---

## Pesquisas Técnicas e Documentação

O diretório `doc/` e `pesquisas/` armazena a documentação e pesquisas técnicas do projeto:
- **`pesquisas/identidade-visual.md`:** Manual de Identidade Visual, Teoria das Cores e decisões de UI/UX.
- **`pesquisas/pesquisa-crud.md`:** Fundamentos e arquitetura das operações de persistência de dados.
- **`pesquisas/pesquisa-scrum.md`:** Estudo das metodologias ágeis aplicadas ao desenvolvimento.
- **`pesquisas/XAMPP.md`:** Guia de configuração do ambiente local de desenvolvimento.
- **`doc/relatorio-uso-ia.md`:** Documentação oficial do uso responsável de IA na entrega.

---

## Metodologia de Desenvolvimento e Kanban

A condução do projeto utiliza a metodologia **Scrumban** (Scrum + Kanban).
- **Kanban:** Gestão visual de tarefas no **GitHub Projects** (*A Fazer*, *Em Desenvolvimento*, *Em Teste*, *Concluído*).
- **Scrum:** Alinhamento de prazos e validação das entregas dos Requisitos Funcionais.

Link do GitHub Projects: [https://github.com/jaime168-arch/SA_1/projects](https://github.com/jaime168-arch/SA_1/projects)

---

## Padrões de Código (Style Guide)

- **Arquivos e Pastas:** Padrão `kebab-case` para scripts e arquivos (ex: `trem-form.php`, `api-telemetria.php`).
- **Variáveis e Funções:** Padrão `camelCase` em PHP e JavaScript (ex: `limparStatusCampo()`, `usuarioId`).
- **Banco de Dados:** Tabelas e colunas em minúsculas com separação por underline (`usuario_id`, `trem_id`).

---

## Tecnologias e Ferramentas

<p align="left">
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=html,css,js,php,mysql,bootstrap,cpp,git,github" />
  </a>
</p>

- **Frontend:** HTML5, CSS3, JavaScript (ES6+ com AJAX/Fetch), Bootstrap 5 e Bootstrap Icons.
- **Backend:** PHP 8+ (Controle de sessões, autenticação, APIs REST e PDO MySQL).
- **IoT & Embarcados:** C++ / Arduino (ESP32).
- **Banco de Dados:** MySQL (`database/ja_ismaga.sql`).
- **Ambiente Local:** XAMPP (Apache + MySQL).

---

## Instruções de Execução do Sistema

1. **Configuração do Ambiente Local (XAMPP):**
   - Baixe e instale o XAMPP com suporte a Apache e MySQL.
   - Mova a pasta do projeto para o diretório `C:\xampp\htdocs\ja_ismaga`.

2. **Importação do Banco de Dados:**
   - Abra o phpMyAdmin (`http://localhost/phpmyadmin`).
   - Importe ou execute o script SQL atualizado contido em `database/ja_ismaga.sql`.

3. **Conexão com o Banco:**
   - Verifique se as credenciais no arquivo `config/conexao.php` correspondem ao seu ambiente local.

4. **Acesso à Aplicação:**
   - Inicie os módulos Apache e MySQL no XAMPP Control Panel.
   - Acesse no navegador: `http://localhost/ja_ismaga/public/login.php` ou `http://localhost/ja_ismaga/index.php`.
   - **Credenciais de Teste:**
     - **Admin:** `admin@ismaga.com` | Senha: `123456`
     - **Operador:** `icaro@gmail.com` | Senha: `123456`

---

## Estrutura do Projeto

Estrutura completa de diretórios e arquivos do repositório:

```text
/
├── assets/                 # Recursos visuais e gráficos
│   ├── crud.png
│   ├── flecha.webp
│   ├── imagem_1.png
│   ├── img_2.png
│   ├── scrum.png
│   ├── wmremove-transformed.png
│   └── xampp.png
├── config/                 # Arquivos de configuração e conexão
│   ├── auth.php
│   └── conexao.php
├── database/               # Script do banco de dados MySQL
│   └── ja_ismaga.sql
├── doc/                    # Documentações e pesquisas do projeto
│   ├── pesquisas/          # Pesquisas técnicas adicionais
│   ├── indentidade.visual.md
│   ├── pesquisa-crud.md
│   ├── pesquisa-scrum.md
│   ├── relatorio-uso-ia.md
│   └── XAMPP.md
├── firmware/               # Código-fonte para hardware IoT (ESP32)
│   └── esp32-sa.ino
├── public/                 # Interfaces web e scripts PHP do backend
│   ├── api-telemetria.php
│   ├── atualizar_senhas.php
│   ├── autenticar.php
│   ├── gerar_senha.php
│   ├── home.php
│   ├── login-processar.php
│   ├── login.php
│   ├── logout.php
│   ├── reset.php
│   ├── rota-deletar.php
│   ├── rota-form.php
│   ├── rota-salvar.php
│   ├── rotas.php
│   ├── sensor-deletar.php
│   ├── sensor-form.php
│   ├── sensor-salvar.php
│   ├── Sensores.php
│   ├── trem-deletar.php
│   ├── trem-form.php
│   ├── trem-salvar.php
│   ├── trens.php
│   ├── usuario-deletar.php
│   ├── usuario-form.php
│   ├── usuario-salvar.php
│   └── usuarios.php
├── scripts/                # Lógicas e validadores em JavaScript
│   ├── autenticar.js
│   ├── home.js
│   ├── login.js
│   ├── rota-deletar.js
│   ├── rota-form.js
│   ├── rota-salvar.js
│   ├── rotas.js
│   ├── sensor-deletar.js
│   ├── sensor-form.js
│   ├── sensor-salvar.js
│   ├── Sensores.js
│   ├── trem-deletar.js
│   ├── trem-form.js
│   ├── trens.js
│   ├── usuario-deletar.js
│   ├── usuario-form.js
│   ├── usuario-salvar.js
│   └── usuarios.js
├── styles/                 # Estilos CSS
│   └── style.css
├── index.php               # Página inicial pública da aplicação
├── LICENSE                 # Licença do projeto
└── README.md               # Documentação oficial
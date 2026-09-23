# 🚂 Já Ismaga — Ferrorama IoT e Indústria 4.0

<p align="center">
  <img src="https://img.shields.io/static/v1?label=STATUS&message=EM%20DESENVOLVIMENTO&color=orange&style=for-the-badge" alt="Status: Em Desenvolvimento"/>
  <img src="https://img.shields.io/static/v1?label=CONTEXTO&message=IND%C3%9ASTRIA%204.0&color=blue&style=for-the-badge" alt="Contexto: Indústria 4.0"/>
</p>

<p align="center">
  <img width="300" height="300" alt="Logo Já Ismaga" src="assets/imagem_1.webp.png" />
</p>

---

## 📌 Índice
- [Descrição do Projeto](#descrição-do-projeto)
- [Funcionalidades e Requisitos Funcionais (RFs)](#funcionalidades-e-requisitos-funcionais-rfs)
- [Mapeamento de Interfaces (CRUD UI)](#mapeamento-de-interfaces-crud-ui)
- [Metodologia de Desenvolvimento e Kanban](#metodologia-de-desenvolvimento-e-kanban)
- [Padrões de Código (Style Guide)](#padrões-de-código-style-guide)
- [Tecnologias e Ferramentas](#tecnologias-e-ferramentas)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Como Executar o Projeto](#como-executar-o-projeto)
- [Desenvolvedores](#desenvolvedores)

---

## 📖 Descrição do Projeto

O projeto de **Ferrorama IoT da Já Ismaga** une a nostalgia do clássico brinquedo à vanguarda da **Indústria 4.0**, transformando linhas férreas e trilhos tradicionais num ecossistema conectado, automatizado e inteligente.

A solução foca em tecnologia, automação e monitorização ferroviária através do conceito de IoT (*Internet of Things*). O objetivo principal é criar uma plataforma inteligente para o acompanhamento e controlo de informações da ferrovia em tempo real, integrando sensores, atuadores, conectividade sem fio e uma interface moderna para a visualização analítica dos dados. 

O sistema eleva o nível de controlo e segurança operacional através da recolha e transmissão contínua de telemetria, mitigando falhas e otimizando o gerenciamento logístico.

<p align="center">
  <img width="100%" alt="Maquete / Protótipo Ferroviário" src="assets/wmremove-transformed.png" />
</p>

---

## ⚙️ Funcionalidades e Requisitos Funcionais (RFs)

As funcionalidades do ecossistema foram categorizadas em três pilares, associadas aos Requisitos Funcionais (RFs) do projeto:

### 1. Controlo de Acesso e Segurança (Autenticação)
* **[RF01] Login de Utilizadores:** Interface segura para autenticação de operadores.
* **[RF02] Validação de Credenciais:** Integração e verificação de acessos via banco de dados MySQL (PDO / API REST).
* **[RF03] Sessão Segura:** Função de logout e controlo de permissões para encerramento de atividades na mesa de controlo.

### 2. Monitorização e Telemetria em Tempo Real
* **[RF04] Localização no Mapa Interativo:** Exibição em tempo real do posicionamento exato da locomotiva ao longo dos trilhos.
* **[RF05] Classificação Automática de Status:** Algoritmo que categoriza instantaneamente o estado operacional do trem (*Normal*, *Alerta*, *Falha*).
* **[RF06] Atualização Dinâmica (Live Data):** Interface Web que atualiza os dados automaticamente sem recarregamento da página (via AJAX/Fetch API em JS).
* **[RF07] Controlo Remoto de Variáveis:** Monitorização e ajuste remoto de velocidade, sentido de direção e iluminação.

### 3. Gestão de Dispositivos (IoT) e Relatórios Preditivos
* **[RF08] CRUD de Entidades (Utilizadores, Trens, Rotas, Sensores):** Telas e formulários para cadastro, listagem, edição e eliminação.
* **[RF09] Manutenção Preditiva:** Análise do estado dos componentes e leitura de sensores para antecipar falhas operacionais.
* **[RF10] Automação de Desvios:** Controlo inteligente de desvios de trilhos e paradas logísticas programadas.
* **[RF11] Módulo Analítico e Relatórios:** Geração e histórico de relatórios de desempenho e métricas operacionais para auditoria.

---

## 🖥️ Mapeamento de Interfaces (CRUD UI)

Abaixo estão listadas as interfaces desenvolvidas e padronizadas para cada entidade do sistema:

| Entidade | Tela de Listagem / Exibição | Tela de Form (Cadastro / Edição) | Lógica JS Front / Backend |
| :--- | :--- | :--- | :--- |
| **Utilizadores** | `public/usuarios.php` | `public/usuario-form.php` | `scripts/usuarios.js`, `usuario-form.js`, `usuario-salvar.js`, `usuario-deletar.js` |
| **Trens** | `public/trens.php` | `public/trem-form.php` | `scripts/trens.js`, `trem-form.js`, `trem-deletar.js` |
| **Rotas** | `public/rotas.php` | `public/rota-form.php` | `scripts/rotas.js`, `rota-form.js`, `rota-salvar.js`, `rota-deletar.js` |
| **Sensores** | `public/sensores.php` | `public/sensor-form.php` | `scripts/sensores.js`, `sensor-form.js`, `sensor-salvar.js`, `sensor-deletar.js` |

---

## 📊 Metodologia de Desenvolvimento e Kanban

Para a condução do projeto, a equipa adotou a metodologia **Scrumban** (combinação entre **Scrum** e **Kanban**).

### Justificativa da Escolha:
A combinação do Scrum com o Kanban garante à equipa a agilidade e a previsibilidade necessárias para entregas académicas em etapas, mantendo total flexibilidade visual sobre o fluxo de trabalho.
* O **Kanban** fornece transparência imediata sobre o status de cada tarefa (*A Fazer*, *Em Desenvolvimento*, *Em Teste*, *Concluído*), evitando sobrecarga nos desenvolvedores.
* Os ritos do **Scrum** mantêm a equipa em sincronia quanto aos prazos e prioridades dos Requisitos Funcionais.

### Gestão e Acompanhamento das Tarefas:
O acompanhamento do desenvolvimento é realizado via **GitHub Projects**. Cada card no board contém obrigatoriamente:
- **Título claro da ação** (com tag `[RF]` ou `[Frontend]`)
- **Descrição das atividades**
- **Membro responsável (Assignee)**
- **Status de execução**

📌 **Link do GitHub Projects (Kanban):** [https://github.com/jaime168-arch/SA_1/projects](https://github.com/jaime168-arch/SA_1/projects)

---

## 🎨 Padrões de Código (Style Guide)

Para garantir a consistência e organização do repositório, a equipa estabeleceu as seguintes regras de desenvolvimento:

### 1. Nomenclatura de Arquivos e Pastas
* **Arquivos Web, PHP, JS e CSS:** Padrão `kebab-case` em minúsculas (ex: `sensor-form.php`, `sensor-salvar.js`, `style.css`).
* **Arquivos de Pesquisa e Documentação:** Padrão `kebab-case` minúsculo dentro da pasta `pesquisas/` ou `doc/` (ex: `pesquisas/pdo.md`).
* **Variáveis e Funções (JS/PHP):** Padrão `camelCase` (ex: `validarUsuario()`, `statusSensor`).
* **Constantes:** Padrão `UPPER_SNAKE_CASE` (ex: `LIMITE_VELOCIDADE`).

### 2. Boas Práticas de Código
* **Indentação:** Espaçamento padrão de 2 a 4 espaços em arquivos HTML, PHP, CSS e JS.
* **Comentários:** Utilizados para explicar regras de negócio complexas, rotas de API ou blocos de script SQL.
* **Idioma:** Nomenclatura em português alinhada ao domínio do projeto Ferroramas.

---

## 🛠️ Tecnologias e Ferramentas

O ecossistema utiliza as seguintes tecnologias:

<p align="left">
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=html,css,js,php,mysql,bootstrap,git,github" />
  </a>
</p>

* **Frontend:** HTML5, CSS3, JavaScript (ES6+ com Fetch API / AJAX), Bootstrap 5.
* **Backend:** PHP / Node.js (Comunicação via APIs REST e integração MySQL via PDO/MySQLi).
* **Banco de Dados:** MySQL (Gerenciado via XAMPP / MySQL Workbench).
* **Documentação & Pesquisa:** Markdown (Pesquisa técnica sobre **PDO** disponível em `pesquisas/pdo.md`).
* **Gestão & Versionamento:** Git, GitHub e GitHub Projects (Kanban).

---

## 📂 Estrutura do Projeto

A estrutura de diretórios do repositório está organizada da seguinte forma:

```text
/
├── assets/                 # Imagens, logos e recursos visuais
├── database/               # Scripts SQL (WorkBench.SQL) e arquivos de conexão PHP
├── doc/                    # Documentações do projeto
├── pesquisas/              # Pesquisas acadêmicas e técnicas (pdo.md)
├── public/                 # Telas e formulários PHP/HTML do sistema
│   ├── home.php
│   ├── usuarios.php
│   ├── usuario-form.php
│   ├── trens.php
│   ├── trem-form.php
│   ├── rotas.php
│   ├── rota-form.php
│   ├── sensores.php
│   └── sensor-form.php
├── scripts/                # Lógicas e chamadas assíncronas em JavaScript
│   ├── autenticar.js
│   ├── cadastro.js
│   ├── home.js
│   ├── login.js
│   ├── usuarios.js
│   ├── usuario-form.js
│   ├── usuario-salvar.js
│   ├── usuario-deletar.js
│   ├── trens.js
│   ├── trem-form.js
│   ├── trem-deletar.js
│   ├── rotas.js
│   ├── rota-form.js
│   ├── rota-salvar.js
│   ├── rota-deletar.js
│   ├── sensores.js
│   ├── sensor-form.js
│   ├── sensor-salvar.js
│   └── sensor-deletar.js
├── styles/                 # Folhas de estilo CSS (style.css)
├── index.php               # Arquivo principal / Inicial da aplicação
├── LICENSE
└── README.md               # Documentação oficial do projeto
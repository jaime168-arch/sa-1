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
- [Mapeamento de Interfaces (CRUD UI)](#mapeamento-de-interfaces-crud-ui)
- [Firmware e Hardware (IoT)](#firmware-e-hardware-iot)
- [Pesquisas Técnicas e Documentação](#pesquisas-técnicas-e-documentação)
- [Metodologia de Desenvolvimento e Kanban](#metodologia-de-desenvolvimento-e-kanban)
- [Padrões de Código (Style Guide)](#padrões-de-código-style-guide)
- [Tecnologias e Ferramentas](#tecnologias-e-ferramentas)
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

- **Controlo de Permissões Flexível (RBAC no Backend):** Liberação do acesso aos CRUDs operacionais (**Trens**, **Rotas** e **Sensores**) para usuários do tipo `operador` e `admin`, mantendo a gestão de **Usuários** restrita exclusivamente a administradores (`admin`).
- **Autenticação, Utilitários de Senha e API de Telemetria:** Inclusão de scripts de apoio para utilitários de autenticação e redefinição de senhas (`autenticar.php`, `atualizar_senhas.php`, `gerar_senha.php`, `login-processar.php`, `reset.php`), além da API dedicada para recepção de dados (`api-telemetria.php`).
- **Firmware ESP32 Integrado:** Presença do código-fonte para o microcontrolador ESP32 (`firmware/esp32-sa.ino`) responsável pela leitura e transmissão dos dados dos sensores na ferrovia.
- **Ajustes na Integridade Referencial (MySQL):** Chaves estrangeiras configuradas com `ON DELETE SET NULL` no banco de dados (`database/ja_ismaga.sql`), permitindo a exclusão de trens sem causar conflitos com rotas vinculadas.
- **Documentação de Projeto Expandida:** Inclusão de guias e pesquisas técnicas na pasta `doc/` cobrindo Identidade Visual, Pesquisa CRUD, Pesquisa Scrum e XAMPP.

---

## Funcionalidades e Requisitos Funcionais (RFs)

As funcionalidades do ecossistema foram categorizadas em três pilares, associadas aos Requisitos Funcionais (RFs) do projeto:

### 1. Controlo de Acesso e Segurança (Autenticação)
- **[RF01] Login de Utilizadores:** Interface para autenticação de operadores e administradores.
- **[RF02] Validação de Credenciais:** Integração e verificação de acessos via PDO MySQL com utilitários de redefinição de hash.
- **[RF03] Sessão Segura e Controle de Perfil:** Controle de permissões por perfil (`admin`, `operador`, `usuario comum`) para restrição de ações operacionais e administrativas diretamente no servidor.

### 2. Monitorização e Telemetria em Tempo Real
- **[RF04] API de Telemetria IoT:** Endpoint dedicado (`api-telemetria.php`) para recepção e processamento das medições dos sensores do microcontrolador ESP32.
- **[RF05] Classificação Automática de Status:** Algoritmo que categoriza instantaneamente o estado operacional do trem (*Ativo*, *Em Manutenção*, *Inativo*).
- **[RF06] Atualização Dinâmica (Live Data):** Interface Web que atualiza os dados automaticamente sem recarregamento da página via scripts JavaScript dedicados em `scripts/`.
- **[RF07] Controlo Remoto de Variáveis:** Monitorização e ajuste remoto de velocidade, sentido de direção e iluminação.

### 3. Gestão de Dispositivos (IoT) e Relatórios Preditivos
- **[RF08] CRUD de Entidades (Utilizadores, Trens, Rotas, Sensores):** Módulos completos para cadastro, listagem, edição e eliminação com interface responsiva e validações no frontend e backend.
- **[RF09] Manutenção Preditiva:** Análise do estado dos componentes e leitura de sensores para antecipar falhas operacionais.
- **[RF10] Automação de Desvios:** Controlo inteligente de desvios de trilhos e paradas logísticas programadas.

---

## Mapeamento de Interfaces (CRUD UI)

Abaixo estão listadas as interfaces desenvolvidas para cada entidade do sistema[cite: 4, 5]:

| Entidade | Tela de Listagem | Tela de Form | Processadores Backend | Script JS Dedicado |
| :--- | :--- | :--- | :--- | :--- |
| **Utilizadores** | `public/usuarios.php` | `public/usuario-form.php` | `usuario-salvar.php`, `usuario-deletar.php` | `scripts/usuarios.js`, `usuario-form.js`, `usuario-salvar.js`, `usuario-deletar.js` |
| **Trens** | `public/trens.php` | `public/trem-form.php` | `trem-salvar.php`, `trem-deletar.php` | `scripts/trens.js`, `trem-form.js`, `trem-deletar.js` |
| **Rotas** | `public/rotas.php` | `public/rota-form.php` | `rota-salvar.php`, `rota-deletar.php` | `scripts/rotas.js`, `rota-form.js`, `rota-salvar.js`, `rota-deletar.js` |
| **Sensores** | `public/Sensores.php` | `public/sensor-form.php` | `sensor-salvar.php`, `sensor-deletar.php` | `scripts/Sensores.js`, `sensor-form.js`, `sensor-salvar.js`, `sensor-deletar.js` |

---

## Firmware e Hardware (IoT)

O projeto integra hardware embarcado para coleta e controle em tempo real[cite: 4]:
- **Microcontrolador:** ESP32
- **Arquivo de Firmware:** `firmware/esp32-sa.ino`[cite: 4]
- **Comunicação:** Conexão Wi-Fi enviando requisições HTTP POST para a rota `public/api-telemetria.php`[cite: 4].

---

## Pesquisas Técnicas e Documentação

O diretório `doc/` armazena a documentação e pesquisas técnicas do projeto[cite: 4]:
- **`indentidade.visual.md`:** Manual de identidade visual, cores e padrões da marca[cite: 4].
- **`pesquisa-crud.md`:** Fundamentos e arquitetura das operações de persistência de dados[cite: 4].
- **`pesquisa-scrum.md`:** Estudo das metodologias ágeis aplicadas ao desenvolvimento[cite: 4].
- **`XAMPP.md`:** Guia de configuração do ambiente local de desenvolvimento[cite: 4].

---

## Metodologia de Desenvolvimento e Kanban

A condução do projeto utiliza a metodologia **Scrumban** (Scrum + Kanban)[cite: 4].
- **Kanban:** Gestão visual de tarefas no **GitHub Projects** (*A Fazer*, *Em Desenvolvimento*, *Em Teste*, *Concluído*).
- **Scrum:** Alinhamento de prazos e validação das entregas dos Requisitos Funcionais.

Link do GitHub Projects: [https://github.com/jaime168-arch/SA_1/projects](https://github.com/jaime168-arch/SA_1/projects)

---

## Padrões de Código (Style Guide)

- **Arquivos e Pastas:** Padrão `kebab-case` para scripts e arquivos (ex: `trem-form.php`, `api-telemetria.php`)[cite: 4].
- **Variáveis e Funções:** Padrão `camelCase` em PHP e JavaScript (ex: `limparStatusCampo()`, `usuarioId`).
- **Banco de Dados:** Tabelas e colunas em minúsculas com separação por underline (`usuario_id`, `trem_id`)[cite: 4].

---

## Tecnologias e Ferramentas

<p align="left">
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=html,css,js,php,mysql,bootstrap,cpp,git,github" />
  </a>
</p>

- **Frontend:** HTML5, CSS3, JavaScript (ES6+ com AJAX/Fetch), Bootstrap 5 e Bootstrap Icons[cite: 4, 5].
- **Backend:** PHP 8+ (Controle de sessões, autenticação, APIs REST e PDO MySQL)[cite: 4].
- **IoT & Embarcados:** C++ / Arduino (ESP32)[cite: 4].
- **Banco de Dados:** MySQL (`database/ja_ismaga.sql`)[cite: 4].
- **Ambiente Local:** XAMPP (Apache + MySQL)[cite: 4].

---

## Estrutura do Projeto

Estrutura completa de diretórios e arquivos do repositório[cite: 4, 5]:

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
├── doc/                    # Documentações do projeto
│   ├── pesquisas/          # Pesquisas técnicas adicionais
│   ├── indentidade.visual.md
│   ├── pesquisa-crud.md
│   ├── pesquisa-scrum.md
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
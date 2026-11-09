# Relatório de Utilização de Inteligência Artificial

**Projeto:** Já Ismaga — Ferrorama IoT e Indústria 4.0  
**Contexto:** Situação de Aprendizagem (SA-1) / SENAI  
**Data da Entrega:** 16 de Novembro de 2026  
**Documento:** `doc/relatorio-uso-ia.md`  

---

## 1. Visão Geral e Transparência
Durante o desenvolvimento do projeto **Já Ismaga**, a equipe utilizou assistentes de IA (Google Gemini e GitHub Copilot) como ferramentas de apoio e produtividade. O uso da IA foi conduzido de forma transparente, ética e responsável, servindo como suporte para refatoração de código, identificação de erros de execução e documentação técnica, sem substituir o controle e a validação do grupo.

Toda a lógica de negócios, regras de controle de acesso (RBAC), estrutura do banco de dados MySQL e validação de interfaces foram revisadas, testadas e integradas manualmente pela equipe.

---

## 2. Ferramentas e Agentes de IA Utilizados

| Ferramenta / Agente | Função Principal no Projeto |
| :--- | :--- |
| **Google Gemini (AI Collaborator)** | Auxílio na migração do driver PDO para MySQLi nativo, estruturação de componentes Bootstrap 5, integração de APIs externas (Open-Meteo e ViaCEP) e padronização do README.md. |
| **GitHub Copilot** | Autocompletar trechos repetitivos de código PHP/JS, sugestão de validações de formulário e apoio em comandos Git. |

---

## 3. Objetivos do Uso da IA

1. **Migração Tecnológica:** Refatoração do driver do banco de dados de `PDO` para `MySQLi` nativo (`$conn`), garantindo padronização e segurança com *prepared statements* (`bind_param`).
2. **Integração de APIs REST:** Implementação de chamadas assíncronas em JavaScript (`Fetch API`) para consumo da **Open-Meteo API** (clima da estação em Joinville/SC) e **ViaCEP API** (preenchimento automático de endereços).
3. **Resolução de Erros de Execução:** Diagnóstico de exceções e erros fatais de PHP (como `Call to undefined method` e falhas de bind em prepared statements).
4. **Documentação Técnica:** Auxílio na estruturação de documentações em Markdown e no alinhamento às exigências dos Requisitos Funcionais (RFs).

---

## 4. Histórico de Prompts e Atividades Realizadas

### Atividade 1: Migração de PDO para MySQLi
- **Prompt Utilizado:** *"Altere as instruções de banco de dados do arquivo rota-deletar.php de PDO ($pdo) para MySQLi ($conn), usando$stmt->bind_param() e mantendo todas as validações de sessão e permissão intactas."*
- **Arquivo Impactado:** `public/rota-deletar.php`, `public/rota-salvar.php`, `public/sensor-deletar.php`, `public/sensor-salvar.php`, `public/sensor-form.php`, `public/sensores.php`.
- **Alterações da Equipe:** Teste manual das rotas via navegador e validação no phpMyAdmin para confirmar a exclusão e atualização correta de registros.

### Atividade 2: Correção de Erros de Conexão
- **Prompt Utilizado:** *"Fatal error: Call to undefined method mysqli_result::fetchAll(). Como ajustar para a sintaxe nativa do MySQLi?"*
- **Solução Gerada:** Substituição de `fetchAll(PDO::FETCH_ASSOC)` por `$resultado->fetch_all(MYSQLI_ASSOC)` e `fetch(PDO::FETCH_ASSOC)` por `$resultado->fetch_assoc()`.
- **Validação:** Verificação das listagens para garantir que nenhum array nulo gerasse avisos de PHP (*warnings*).

### Atividade 3: Widget de Clima em Joinville (Open-Meteo API)
- **Prompt Utilizado:** *"Monte um widget em Bootstrap com paleta bege/creme para exibir na home.php a temperatura, direção do vento e condições de Joinville/SC consumindo a API da Open-Meteo."*
- **Arquivo Impactado:** `public/home.php`.
- **Validação:** Execução de testes de rede (simulando falhas de conexão) para validar o fallback e a exibição de mensagem preventiva.

---

## 5. Testes e Qualidade do Código

Após cada sugestão fornecida pela IA, a equipe realizou a seguinte rotina de testes:

1. **Testes de Integração Backend:** Execução do PHP no Apache local (XAMPP) com `error_reporting(E_ALL)` para garantir zero avisos (*notices* ou *warnings*).
2. **Testes de Integridade Referencial:** Testes de exclusão de rotas e sensores vinculados a trens para verificar o comportamento das chaves estrangeiras (`foreign keys`).
3. **Testes de Interface (UI/UX):** Verificação da responsividade em dispositivos móveis e testes de contraste de cores (paleta `#FF6600` e `#334155`).

---

## 6. Registro de Coautoria nos Commits

Para os trechos de código estruturados com auxílio do agente de IA, a equipe aplicou o padrão oficial do Git para registro de coautoria:

```text
feat(home): integra widget de clima em bege com a API Open-Meteo

- Consome a API da Open-Meteo para a cidade de Joinville/SC
- Exibe temperatura, velocidade e direção do vento
- Adiciona tratamento de erro para falhas de rede

Co-authored-by: Gemini AI <assistant@gemini.google.com>
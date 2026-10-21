# Relatório de Utilização de Inteligência Artificial — Já Ismaga

## 1. Ferramentas Utilizadas
- **Agente de IA / LLM:** Gemini (Google) / GitHub Copilot.

## 2. Objetivos da Utilização
- Auxílio na criação das lógicas de validação de formulários em JavaScript (`trem-form.js`, `cep.js`).
- Refatoração dos scripts PHP de permissões RBAC (`trem-salvar.php`, `trem-form.php`).
- Estruturação do layout responsivo com Bootstrap 5 e ícones integrados.
- Padronização da documentação no `README.md` e resolução de conflitos de Foreign Keys no MySQL.

## 3. Principais Prompts / Instruções Fornecidas
- *"Ajuste o arquivo trem-form.php para permitir que o tipo operador consiga cadastrar e editar trens, mas sem visualizar/editar dados de usuários."*
- *"Crie uma função assíncrona em JavaScript para consultar a API do ViaCEP e preencher os campos de endereço automaticamente com tratamento de erro."*

## 4. Arquivos e Funcionalidades Desenvolvidos com Auxílio da IA
- `public/trem-form.php` e `public/trem-salvar.php` (Ajuste de perfil RBAC e atalhos de gravação PDO).
- `scripts/trem-form.js` (Validação de campos obrigatórios no frontend).
- `scripts/clima.js` (Consumo da API Open-Meteo para a Home Page).
- `doc/relatorio-uso-ia.md` (Documentação do relatório de coautoria).

## 5. Validações, Testes e Alterações da Equipe
- **Revisão de Código:** Todos os trechos gerados foram revisados linha a linha pelos integrantes da equipe.
- **Ajustes Manuais:** Mapeamento de variáveis do banco de dados (troca de `codigo` por `nome` nos trechos gerados), ajuste no CSS corporativo da navbar (`mix-blend-mode: multiply`).
- **Testes Executados:** Testes de submissão de formulários, tentativa de exclusão de registros vinculados no MySQL e validação de login com perfis `admin` e `operador`.

## 6. Reflexão sobre o Uso da IA
A utilização da IA acelerou o processo de identificação de erros de validação e sintaxe, permitindo que a equipe focasse na regra de negócio e no design corporativo da aplicação. A validação manual continuou sendo essencial para garantir a integridade referencial do banco de dados e as permissões de acesso.
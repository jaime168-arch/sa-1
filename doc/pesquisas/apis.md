# Pesquisa Técnica: APIs e Integração entre Sistemas

## 1. O que é uma API e qual é sua finalidade
API (*Application Programming Interface* ou Interface de Programação de Aplicações) é um conjunto de rotinas, protocolos e padrões estabelecidos por um software para que outras aplicações possam utilizar suas funcionalidades ou dados sem ter acesso ao seu código-fonte interno.

A finalidade principal de uma API é servir como ponte de comunicação entre sistemas heterogêneos, promovendo a reutilização de software, a modularidade e a interoperabilidade entre diferentes tecnologias (por exemplo, um frontend em React comunicando-se com um backend PHP, ou um aplicativo mobile consumindo dados de telemetria IoT).

---

## 2. Como funciona a comunicação entre sistemas por meio de APIs
A comunicação ocorre através do modelo **Cliente-Servidor**:
1. **Cliente (Consumer):** Envia uma requisição (*Request*) via protocolo HTTP/HTTPS direcionada a uma URL específica.
2. **Servidor (Provider):** Processa a requisição, executa as regras de negócio e consultas ao banco de dados e retorna uma resposta (*Response*), acompanhada de um código de status e dados formatados.

---

## 3. O que são APIs REST
APIs **REST** (*Representational State Transfer*) seguem um conjunto de princípios arquiteturais que utilizam o protocolo HTTP de forma padronizada.

### Princípios Fundamentais do REST:
- **Stateless (Sem Estado):** Cada requisição do cliente para o servidor deve conter todas as informações necessárias para ser compreendida e processada. O servidor não armazena contexto do cliente entre requisições.
- **Cliente-Servidor:** Separação clara de responsabilidades entre a interface do usuário e o processamento de dados.
- **Interface Uniforme:** Uso padronizado de recursos, URLs, métodos HTTP e formatos de representação (como JSON e XML).
- **Recursos (Resources):** Entidades expostas através de URLs estruturadas e previsíveis.

---

## 4. O papel dos Métodos HTTP
Os métodos HTTP (verbos) indicam a intenção da ação a ser realizada no recurso:

| Método | Descrição e Finalidade | Idempotente |
| :--- | :--- | :--- |
| **GET** | Recupera ou consulta dados de um recurso. | Sim |
| **POST** | Cria um novo registro ou recurso no servidor. | Não |
| **PUT** | Atualiza ou substitui completamente um recurso existente. | Sim |
| **PATCH** | Aplica alterações parciais a um recurso existente. | Não |
| **DELETE** | Remove ou inativa um recurso específico. | Sim |

---

## 5. Requisições e Respostas HTTP

### Estrutura da Requisição HTTP:
- **Linha de Requisição:** Método (GET, POST, etc.) + Endpoint + Versão do Protocolo.
- **Cabeçalhos (Headers):** Metadados como `Content-Type: application/json` e tokens de autenticação `Authorization: Bearer <token>`.
- **Corpo (Body):** Conteúdo enviado na requisição (usado principalmente em POST, PUT e PATCH).

### Estrutura da Resposta HTTP:
- **Linha de Status:** Código HTTP de resposta.
- **Cabeçalhos (Headers):** Metadados sobre a resposta (ex: `Content-Type: application/json`).
- **Corpo (Body):** Dados retornados pelo servidor (geralmente em formato JSON).

### Principais Códigos de Status HTTP:
- **200 OK:** Requisição processada com sucesso.
- **201 Created:** Novo recurso criado com sucesso.
- **400 Bad Request:** Erro na requisição enviada pelo cliente (dados inválidos).
- **401 Unauthorized:** Cliente não autenticado.
- **403 Forbidden:** Cliente autenticado, mas sem permissão de acesso.
- **404 Not Found:** Recurso ou endpoint não encontrado.
- **500 Internal Server Error:** Erro interno no processamento do servidor.

---

## 6. O que são Endpoints
Um **Endpoint** é a URL específica através da qual uma API expõe um determinado recurso para interação.

### Exemplos de Endpoints do Sistema Ferroramas:
- `GET /api/v1/trens` — Lista todos os trens cadastrados.
- `GET /api/v1/trens/5` — Retorna os detalhes do trem com ID 5.
- `POST /api/v1/sensores` — Cadastra um novo sensor de telemetria.
- `DELETE /api/v1/rotas/12` — Remove a rota com ID 12.

---

## 7. Troca de Dados no Formato JSON
O **JSON** (*JavaScript Object Notation*) é um formato leve e de fácil leitura para humanos e computadores, tornando-se o padrão para troca de dados em APIs REST.

### Exemplo de Objeto JSON (Telemetria do Sensor Ferroramas):
```json
{
  "sensor_id": "SNR-8821",
  "tipo": "Sensor de Velocidade e Temperatura",
  "localizacao": "Vagão TR-101",
  "status_leitura": "Ativo",
  "leitura": {
    "velocidade_kmh": 42.5,
    "temperatura_c": 36.8,
    "bateria_porcentagem": 94
  },
  "trem_vinculado": {
    "id": 3,
    "nome": "Expressa Ferrorama",
    "modelo": "EF-2000"
  },
  "timestamp": "2026-10-19T09:43:00Z"
}
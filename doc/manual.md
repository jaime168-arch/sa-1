# Guia de Operação e Uso — Sistema Já Ismaga Ferrorama IoT

O **Já Ismaga** é uma plataforma desenvolvida para a gestão e o acompanhamento operacional da malha ferroviária, integrando o controle de frota, o mapeamento de rotas e o monitoramento remotos via sensores IoT.

Este documento fornece as orientações necessárias para navegação e teste na Estação de Demonstração.

---

## 1. Perfis e Credenciais de Acesso

Para operar o sistema durante os testes, utilize uma das contas pré-configuradas abaixo:

| Perfil de Acesso | E-mail de Demonstração | Senha | Nível de Permissão |
| :--- | :--- | :--- | :--- |
| **Administrador** | `admin@ismaga.com` | `123456` | Acesso total: Gestão de usuários, trens, rotas e sensores. |
| **Operador** | `icaro@gmail.com` | `123456` | Acesso operacional: Consulta e cadastro de trens, rotas e sensores. |

> **Nota de Segurança:** As senhas armazenadas no banco de dados utilizam criptografia nativa via hash `bcrypt`.

---

## 2. Instruções de Navegação

### 2.1 Autenticação no Sistema
1. Acesse o endereço da aplicação no navegador da estação de testes.
2. Informe o e-mail e a senha correspondentes ao perfil desejado.
3. Clique no botão **Entrar** para validar as credenciais.

### 2.2 Painel Principal (Home)
- **Informações Meteorológicas:** Apresenta dados da temperatura, velocidade do vento e condições climáticas da Estação de Joinville/SC em tempo real (dados obtidos via integração com a Open-Meteo API).
- **Indicadores Operacionais:** Exibe o quantitativo consolidado de trens em operação, rotas mapeadas, dispositivos IoT ativos e usuários cadastrados.

### 2.3 Encerramento da Sessão
- Para sair da aplicação de forma segura, utilize a opção **Sair** localizada no canto superior direito do menu de navegação.

---

## 3. Estrutura dos Módulos Operacionais

### 3.1 Gestão de Usuários (`usuarios.php`)
- **Restrição:** Módulo exclusivo para o perfil Administrador.
- **Funcionalidade:** Permite listar, cadastrar, editar permissões (`admin` ou `operador`) e alterar o status de acesso dos integrantes da equipe.

### 3.2 Controle de Frota (`trens.php`)
- **Funcionalidade:** Exibe a listagem de locomotivas e vagões, com acompanhamento de status operacional (*Ativo*, *Em Manutenção* ou *Inativo*), capacidade de carga e associação de responsáveis.

### 3.3 Mapeamento de Rotas (`rotas.php`)
- **Funcionalidade:** Gerencia os trajetos da malha ferroviária, registrando origem, destino, extensão em quilômetros (KM) e estimativa de tempo de percurso.

### 3.4 Telemetria de Sensores (`sensores.php`)
- **Funcionalidade:** Monitora os dispositivos IoT instalados nos trens. O módulo recebe atualizações contínuas de temperatura, velocidade e presença enviadas pelos microcontroladores remotos.

---

## 4. Diagnóstico e Resolução de Erros

* **Falha ao carregar as páginas do sistema:**
  Verifique no painel de controle do XAMPP se os serviços **Apache** e **MySQL** estão ativos e em execução.

* **Menu de Usuários indisponível no painel:**
  Confirme se a autenticação foi realizada com a conta de **Administrador**. O perfil de Operador possui restrição de acesso a este módulo.

* **Indisponibilidade dos dados de clima:**
  O sistema realiza tratamento preventivo de falhas de conexão. Caso ocorra oscilação na rede externa, o painel exibirá o status de conexão indisponível sem comprometer o funcionamento dos demais módulos.
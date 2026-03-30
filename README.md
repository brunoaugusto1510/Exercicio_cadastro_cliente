# 📚 Projeto de Estudo: Sistema de Cadastro em PHP

⚠️ **Aviso:** Este projeto foi desenvolvido estritamente para **fins de estudo e aprendizagem**. O objetivo principal é praticar e consolidar conceitos de desenvolvimento web utilizando PHP, manipulação de base de dados MySQL via PDO e estruturação de operações CRUD (Create, Read, Update, Delete).

## 🎯 Sobre o Projeto

Este repositório contém uma série de exercícios práticos que demonstram a evolução de um sistema de gestão do zero. A arquitetura avança desde a simples captura de dados num formulário HTML até à construção de um sistema relacional completo envolvendo clientes, categorias, produtos e pedidos.

O código foi construído utilizando consultas SQL nativas, com foco no entendimento prático das instruções diretas à base de dados e na gestão de transações.

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP (8.x)
* **Base de Dados:** MySQL
* **Comunicação com a BD:** PDO (PHP Data Objects) utilizando *Prepared Statements* para maior segurança.
* **Frontend:** HTML5, CSS3 (para estilização das tabelas e formulários) e JavaScript (para interações dinâmicas no DOM).

## 🚀 Funcionalidades e Evolução dos Exemplos

O projeto está dividido em diretórios que representam a progressão da aprendizagem:

* **Primeiro Exemplo:** Introdução à captura de dados de um formulário HTML e exibição no ecrã usando PHP puro.
* **Segundo e Terceiro Exemplos:** Implementação de um CRUD completo para a entidade **Clientes** (Inclusão, Listagem, Edição e Exclusão).
* **Quarto e Quinto Exemplos:** Criação do CRUD de **Produtos**, introduzindo o relacionamento com a tabela de **Categorias** (Chave Estrangeira).
* **Sexto Exemplo:** Implementação de um sistema de pesquisa avançada com múltiplos filtros dinâmicos (por descrição, intervalo de stock, intervalo de preço e categoria).
* **Sétimo Exemplo:** O módulo mais avançado, referente ao **Lançamento de Pedidos**. Demonstra:
    * Integração entre Clientes e Produtos.
    * Adição dinâmica de múltiplos itens no pedido via JavaScript.
    * Uso de **Transações na base de dados** (`beginTransaction`, `commit` e `rollBack`) para garantir que o pedido só seja salvo se houver sucesso na gravação dos itens e na baixa do stock.

## ⚙️ Como Executar o Projeto

1. **Pré-requisitos:** Vais precisar de um servidor web local com suporte a PHP e MySQL (como XAMPP, WAMP, Laragon, ou o teu ambiente de desenvolvimento integrado).
2. **Base de Dados:**
    * Cria uma base de dados chamada `banco_exemplo`.
    * Executa os scripts de criação de tabelas encontrados no ficheiro `scripts_banco/script_banco_exemplo_crud_php.doc`.
3. **Configuração da Conexão:**
    * Acede ao ficheiro `config/conexao.php`.
    * Verifica se as variáveis `$servidor`, `$usuario` e `$senha` correspondem às credenciais do teu ambiente local.
4. **Executar a Aplicação:**
    * Inicia o teu servidor local e acede às pastas dos exemplos (ex: `http://localhost/exercicio_cadastro_cliente/terceiro_exemplo/incluir_clientes_3.php`) para testar as funcionalidades.

# 📊 FrequenCy — Sistema de Monitoramento de Frequência Escolar

O **FrequenCy** é uma solução digital desenvolvida para otimizar, centralizar e organizar o controle de frequência escolar. O sistema substitui os métodos manuais e as planilhas fragmentadas por uma plataforma segura, ágil e estruturada, voltada para o uso de secretarias e coordenações escolares.

Este projeto foi concebido e desenvolvido por alunos do 3º Ano do Ensino Médio Técnico em Informática da **Escola Estadual de Ensino Profissional Manoel Mano**, em Crateús/CE, na disciplina de *Laboratório de Software*.

---

## 📌 O Problema

Atualmente, muitas instituições de ensino realizam o controle de presença de forma manual, dependendo de planilhas desorganizadas e registros descentralizados mantidos individualmente por professores e secretarias. 

Esse cenário gera diversos gargalos:
* **Falta de Padronização:** Informações sobre faltas, atrasos, atestados e justificativas médicas ficam dispersas e armazenadas separadamente.
* **Erro Humano:** A dependência de inserções estritamente manuais eleva o risco de inconsistências e duplicidade de dados.
* **Lentidão Administrativa:** Dificuldade e lentidão para consultar o histórico de um estudante ou consolidar indicadores importantes de infrequência.
* **Impacto em Benefícios:** Dificuldade no monitoramento ágil de alunos que correm o risco de perder benefícios governamentais atrelados à assiduidade escolar, como o programa **Pé-de-Meia**.

---

## 💡 A Solução

O **FrequenCy** centraliza todas as informações de frequência escolar em uma única plataforma web. O software elimina o retrabalho e o uso de papéis ao automatizar o cálculo de assiduidade, organizar dados de forma segmentada por turmas e fornecer relatórios visuais rápidos para a tomada de decisões administrativas.

---

## 🛠️ Funcionalidades Detalhadas

De acordo com o mapeamento de requisitos do projeto, o sistema divide-se nas seguintes capacidades técnicas:

### 🔐 Autenticação e Controle de Acesso
* **Acesso Restrito (RF01 / RNF03):** Login seguro por e-mail e senha para usuários autorizados. O acesso é exclusivo para a coordenação, secretaria e coletores da frequência, não permitindo o acesso direto de alunos.
* **Níveis de Permissão:** Separação lógica entre as funções de Administrador/Secretaria (gerenciamento total) e Professor/Coletor (lançamento de presença).

### 🏫 Administração de Alunos e Turmas
* **Cadastro de Turmas (RF02):** Permite registrar e catalogar as salas/turmas existentes na instituição.
* **Gestão de Estudantes (RF03 / RF11):** Permite cadastrar e atualizar informações essenciais dos alunos (Nome, Matrícula, Número de Chamada e Turma).
* **Busca e Segmentação (RF04 / RF12):** Listagem e organização automática dos dados dos alunos filtrados diretamente pela respectiva turma.

### 📝 Controle de Frequência e Ocorrências
* **Registro de Presença (RF05):** Interface fluida para marcar presença, falta ou atraso do estudante na data selecionada.
* **Gerenciamento de Justificativas (RF06 / RF07):** Registro centralizado de atestados médicos, dispensas e saídas antecipadas anexadas ao histórico do aluno.

### 📊 Indicadores e Relatórios
* **Cálculo Automatizado de Presença (RF08):** O sistema processa e exibe a porcentagem exata de assiduidade do aluno de forma mensal.
* **Monitoramento do Programa Pé-de-Meia (RF09):** Módulo dedicado para calcular a porcentagem de alunos participantes do programa governamental, sinalizando o risco de perda do benefício por baixa frequência.
* **Geração de Relatórios (RF10):** Exportação de dados organizados sobre o fluxo de faltas geral, por turmas ou individual para a tomada de medidas preventivas.

---

## 🚫 Limitações do Escopo

Para garantir a viabilidade e o foco no problema principal, o sistema **NÃO** realiza:
1. Pagamentos ou qualquer tipo de controle financeiro.
2. Envio automático de mensagens ou notificações externas (WhatsApp/E-mail).
3. Integração nativa com sistemas governamentais ou escolares externos nesta versão.

---

## 📐 Especificações Técnicas e Requisitos Não Funcionais

O sistema foi modelado sob critérios rígidos de usabilidade e performance:
* **Interface Responsiva (RNF01):** Adaptável a computadores e dispositivos móveis, garantindo acesso a qualquer funcionalidade em até 3 cliques.
* **Desempenho (RNF02):** Tempo de resposta do servidor para as operações em até 2 segundos.
* **Segurança e Integridade (RNF04 / RNF07):** Proteção de dados contra acessos não autorizados e validação estrutural no banco de dados para evitar duplicidades.

### 🚀 Stack Tecnológica
* **Front-end:** HTML5, CSS3, JavaScript (com bibliotecas visuais como *Chart.js* para exibição de gráficos).
* **Back-end:** PHP (com arquitetura lógica estruturada).
* **Banco de Dados:** MySQL (Relacional, utilizando chaves estrangeiras vinculadas pela matrícula do aluno).
* **Ferramentas de Desenvolvimento:** VS Code, Git/GitHub, Google Planilhas (para mapeamento de testes).

---

## 📸 Demonstração do Sistema

Para visualizar o fluxo visual e a interface responsiva do **FrequenCy**, confira as telas principais do sistema abaixo:

### 1. Painel Geral de Controle (Dashboard)
Visão analítica contendo o total de alunos presentes, quantidade de faltas gerais e segmentadas por ano, além de alertas para o programa Pé-de-Meia.

![Painel Geral de Controle](image_71939f.png)

### 2. Lançamento de Frequência por Turma
Interface simplificada onde o coletor seleciona a turma e realiza a chamada de forma rápida.

![Chamada por Turma](image_719304.png)

### 3. Painel Individual do Aluno
Histórico detalhado do estudante, exibindo a porcentagem de presença no mês e o status de assiduidade.

![Painel do Aluno](image_719341.png)

---

## 📁 Estrutura do Projeto

```text
FrequenCy/
│
├── assets/                  # Arquivos estáticos e dependências visuais
│   ├── css/                 # Estilos do sistema (incluindo style.css)
│   ├── js/                  # Scripts e interações dinâmicas
│   ├── img/                 # Imagens, logotipos e favicons
│   └── fonts/               # Fontes customizadas utilizadas
│
├── config/                  # Configurações de sistema e banco de dados
│   ├── conexao.php          # Credenciais de acesso ao MySQL
│   └── helper.php           # Funções auxiliares globais
│
├── includes/                # Componentes globais de interface
│   ├── navbar.php           # Menu de navegação do sistema
│   ├── footer.php           # Rodapé padrão
│   └── modal_frequencia_aulas.php
│
├── auth/                    # Controle de acesso e segurança
│   ├── login.php / tela_login.php
│   ├── logout.php
│   └── verifica_login.php
│
├── pages/                   # Telas e interfaces com o usuário (Views)
│   ├── pg_inicial.php       # Dashboard principal (Métricas gerais)
│   ├── painel_aluno.php     # Visão individual do histórico do estudante
│   ├── tela_cadastro_*.php  # Telas de formulário (aluno, atestado, atraso, etc.)
│   ├── tela_edita_*.php     # Telas de modificação e atualização de dados
│   ├── lista_*.php          # Exibição tabular de alunos, registros e ocorrências
│   └── visualizar_*.php     # Visualização de atestados e dispensas
│
├── actions/                 # Processamento lógico e CRUD em PHP (Backend)
│   ├── cadastro_*.php       # Scripts de inserção no banco (INSERT)
│   ├── edita_*.php          # Scripts de atualização (UPDATE)
│   ├── exclui_*.php         # Scripts de remoção lógica/física (DELETE)
│   ├── salvar_*.php         # Processamento de frequências realizadas
│   └── buscar_*.php         # Consultas dinâmicas ao banco (SELECT)
│
├── reports/                 # Módulo de relatórios e estatísticas
│   ├── fpdf/                # Biblioteca PHP para geração de documentos
│   ├── gerar_relatorio_*.php # Emissão de relatórios em PDF (Geral e Individual)
│   └── graficos_de_*.php    # Processamento de dados para os gráficos do Dashboard
│
├── node_modules/            # Dependências locais de pacotes NPM
├── composer.json            # Gerenciador de dependências PHP
├── package.json             # Gerenciador de dependências e scripts do Node
└── README.md                # Documentação oficial do projeto

```

## 🚀 Passo a Passo para Instalação e Execução

Siga as instruções abaixo para configurar o ambiente de desenvolvimento local e executar o projeto.

### 📋 Pré-requisitos
Para rodar este projeto baseado em PHP, você precisará de um ambiente de servidor local configurado. Recomendamos o uso do **XAMPP** (ou WampServer), que já traz o PHP e o banco de dados MySQL integrados.

* [XAMPP instalado](https://www.apachefriends.org/)
* [Git instalado](https://git-scm.com/)

---

### 💻 Como Executar Localmente

### Passo 1: Clonar o Repositório
Abra o seu terminal (ou Git Bash) dentro da pasta de servidores do XAMPP (geralmente `C:\xampp\htdocs\`) e clone este repositório:
cd C:\xampp\htdocs
git clone [https://github.com/guiguichuvaa/ProjetoMonitoramentoDeFrequencia.git]

---

### Passo 2: Configurar o Banco de Dados
Abra o XAMPP Control Panel e inicie os módulos Apache e MySQL.
Acesse no seu navegador: http://localhost/phpmyadmin/.
Crie um novo banco de dados chamado sistema_frequencia.
Importe o arquivo SQL do projeto (normalmente localizado na pasta /database ou na raiz com o nome database.sql ou similar) para dentro do banco criado.

---

### Passo 3: Configurar as Credenciais
Verifique se os arquivos de conexão com o banco de dados (config.php ou conexao.php) estão apontando corretamente para o seu servidor local:
PHP
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sistema_frequencia";

---

### Passo 4: Acessar a Aplicação
Abra o navegador e digite o endereço:
http://localhost/Frequency/pg_inicial.php


---

### Equipe
O projeto foi dividido utilizando papéis metodológicos claros para o desenvolvimento de software:

* Janniny Vieira Menezes: Líder / Project Owner (PO)

* Guilherme Gomes Oliveira: Desenvolvedor Full-Stack / Designer Gráfico

* Othon Almeida Bindá Soares Mourão: Desenvolvedor Full-Stack

* Murilo Rodrigues Araújo: Desenvolvedor Backend

* Antonia Letícia Silva Martins: Analista de Testes / QA


### Licenças
Este software foi gerado dentro do ecossistema educacional técnico da EEEP Manoel Mano. Como melhorias futuras,
projeta-se a expansão de APIs para comunicação nativa com outras plataformas de gestão acadêmica.

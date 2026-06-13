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
* **Ferramentas de Desenvolvimento:** VS Code, Git/GitHub, Composer, NPM.

---

## 📸 Demonstração do Sistema

Para visualizar o fluxo visual e a interface responsiva do **FrequenCy**, confira as telas principais do sistema abaixo:

### 1. Painel Geral de Controle (Dashboard)
Visão analítica contendo o total de alunos presentes, quantidade de faltas gerais e segmentadas por ano, além de alertas para o programa Pé-de-Meia.

![Painel Geral de Controle](image_719304.png)

### 2. Lançamento de Frequência por Turma
Interface simplificada onde o coletor seleciona a turma e realiza a chamada de forma rápida.

![Chamada por Turma](image_71939f.png)

### 3. Painel Individual do Aluno
Histórico detalhado do estudante, exibindo a porcentagem de presença no mês e o status de assiduidade.

![Painel do Aluno](image_719341.png)

---

## 📁 Estrutura do Projeto

O projeto está organizado com diretórios dedicados a recursos estáticos e dependências, enquanto os arquivos funcionais (PHP) encontram-se na raiz, divididos por responsabilidade lógica. Abaixo está o mapeamento detalhado do sistema:

```text
FrequenCy/
│
├── Diretórios Principais
│   ├── css/                     # Estilos visuais do sistema (ex: style.css)
│   ├── database/                # Arquivos e scripts do banco de dados MySQL
│   ├── fonts/ / font/           # Fontes tipográficas customizadas
│   ├── img/ / favicon_io/       # Imagens, logotipos, ícones e assets visuais
│   ├── js/                      # Scripts de interação e comportamento (JavaScript)
│   └── node_modules/            # Dependências locais instaladas via NPM
│
├── Configuração e Autenticação
│   ├── conexao.php              # Credenciais de conexão com o banco de dados
│   ├── helper.php               # Funções e utilitários auxiliares globais
│   ├── login.php / tela_login.php # Interface e lógica de autenticação
│   ├── logout.php               # Script para encerramento seguro de sessão
│   └── verifica_login.php       # Proteção de rotas e validação de sessão ativa
│
├── Painéis Principais (Views)
│   ├── pg_inicial.php           # Dashboard principal do sistema (Admin/Secretaria)
│   ├── painel_aluno.php         # Visão individual e histórico do estudante
│   ├── perfil_usuario.php       # Perfil do administrador
│   ├── perfil_usuario_coletor.php # Perfil focado na visão do professor/coletor
│   └── sobre.php / equipe.php   # Páginas institucionais e informações do projeto
│
├── Componentes de Interface
│   ├── navbar.php               # Menu de navegação superior (Administrador)
│   ├── navbar_coletor.php       # Menu de navegação específico para coletores
│   ├── footer.php               # Rodapé padrão das páginas
│   └── modal_*.php              # Componentes de janelas sobrepostas (Modais)
│
├── Gestão de Cadastros e Edições (Telas - Frontend)
│   ├── tela_cadastro_*.php      # Formulários para criar alunos, atestados, atrasos, etc.
│   └── tela_edita_*.php         # Interfaces para edição de dados já existentes
│
├── Processamento Lógico (Ações - Backend)
│   ├── cadastro_*.php           # Scripts que realizam INSERT no banco de dados
│   ├── edita_*.php              # Scripts que realizam UPDATE no banco de dados
│   ├── exclui_*.php             # Scripts que realizam DELETE no banco de dados
│   ├── salvar_frequencia*.php   # Processamento das chamadas e assiduidade
│   └── buscar_*.php / dados.php # Buscas assíncronas e requisições de dados específicos
│
├── Listagens e Visualizações (Tabelas)
│   ├── lista_*.php              # Telas contendo as tabelas (alunos, usuários, faltas)
│   ├── lista_frequencia_coletor.php # Lista de chamada adaptada para o coletor
│   ├── listar_*.php             # Processamento do carregamento das listas
│   └── visualizar_*.php         # Visualização de detalhes em texto de atestados e afins
│
├── Relatórios e Gráficos
│   ├── fpdf.php                 # Biblioteca nativa para geração de documentos PDF
│   ├── gerar_relatorio_*.php    # Emissão de documentos formais (geral e por aluno)
│   └── graficos_de_*.php        # Renderização visual dos dados analíticos no Dashboard
│
└── Gerenciamento de Dependências
    ├── composer.json            # Gestor de pacotes PHP
    ├── package.json             # Gestor de pacotes NPM
    └── README.md                # Documentação oficial do projeto

```

---

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

```bash
cd C:\xampp\htdocs
git clone [https://github.com/seu-usuario/FrequenCy.git](https://github.com/seu-usuario/FrequenCy.git)

```

### Passo 2: Configurar o Banco de Dados

1. Abra o XAMPP Control Panel e inicie os módulos **Apache** e **MySQL**.
2. Acesse no seu navegador: `http://localhost/phpmyadmin/`.
3. Crie um novo banco de dados chamado `frequency`.
4. Importe o arquivo SQL do projeto (normalmente localizado na pasta `/database` ou na raiz) para dentro do banco criado.

### Passo 3: Configurar as Credenciais

Verifique se o arquivo de conexão com o banco de dados (`conexao.php`) está apontando corretamente para o seu servidor local:

```php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "frequency";

```

### Passo 4: Instalar Dependências (Opcional, caso necessário)

Se o projeto utilizar bibliotecas gerenciadas por Composer ou pacotes Node extras:

```bash
composer install
npm install

```

### Passo 5: Acessar a Aplicação

Abra o navegador e digite o endereço:

```text
http://localhost/Frequency/pg_inicial.php

```

---

## 👥 Equipe

O projeto foi dividido utilizando papéis metodológicos claros para o desenvolvimento de software:

* **Janniny Vieira Menezes:** Líder / Project Owner (PO)
* **Guilherme Gomes Oliveira:** Desenvolvedor Full-Stack / Designer Gráfico
* **Othon Almeida Bindá Soares Mourão:** Desenvolvedor Full-Stack
* **Murilo Rodrigues Araújo:** Desenvolvedor Backend
* **Antonia Letícia Silva Martins:** Analista de Testes / QA

---

## 📜 Licenças e Continuidade

Este software foi gerado dentro do ecossistema educacional técnico da EEEP Manoel Mano. Como melhorias futuras, projeta-se a expansão de APIs para comunicação nativa com outras plataformas de gestão acadêmica.

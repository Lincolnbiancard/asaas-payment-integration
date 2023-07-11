# 🚀 Projeto de integração com meios de pagamento usando Laravel & React

Este é um projeto desenvolvido utilizando Laravel e React, rodando dentro de containers Docker.

## 🧰 Pré-requisitos

Para rodar este projeto, você precisa ter instalado na sua máquina:

- [Docker](https://www.docker.com/get-started)
- [Composer](https://getcomposer.org/download/)
- [npm](https://www.npmjs.com/get-npm)
- [make](https://www.gnu.org/software/make/)
- [git](https://git-scm.com/downloads)

## 🛠️ Tecnologias Utilizadas

Este projeto foi desenvolvido com as seguintes tecnologias:

- [Laravel](https://laravel.com/)
- [PHP](https://www.php.net/)
- [React](https://reactjs.org/)

## 💻 Executando o projeto


### 1️⃣ Clone o repositório
```
ssh: git clone git@github.com:Lincolnbiancard/asaas-payment-integration.git
```
Ou
```
Http: git clone https://github.com/Lincolnbiancard/asaas-payment-integration.git
```
```
cd asaas-payment-integration
```

### 2️⃣ Copie o arquivo .env
```bash
cp .env.example .env && composer install
```

### 3️⃣ Construa e inicialize o ambiente Docker
```
make up
```

### 4️⃣ Instale as dependências do backend
```
make composer-install
```

### 5️⃣ Execute as migrações do Laravel
```
make migrate
```

### 6️⃣ Instale as dependências do frontend e inicie o servidor de desenvolvimento
```bash
cd front
```
```bash
npm install
```
```bash
npm start
```

###  Inicie a aplicação
Agora, o frontend React deve estar rodando em http://localhost:3000.

### Você deve ver uma tela parecida com está:
![Tela do front](./tela-front.png)

🎉 Parabéns! Agora você deve ter seu projeto Laravel & React rodando em seu ambiente local!

#
## 🧪 Testes

Este projeto usa a ferramenta PHPUnit para testes de unidade. Para rodar os testes, execute:
```
make test
```

#

## 💡 Cobertura de Testes

A cobertura de testes é uma medida importante para garantir a qualidade do código. Nosso objetivo é sempre manter a cobertura de testes tão alta quanto possível. 

Para gerar um relatório de cobertura de testes, você pode usar o seguinte comando:
```bash
make coverage
```
Os relatórios gerados vão estar disponíveis na pasta `coverage` na raiz do projeto.

#
# ⚙️Padrões de projeto e estrutura
Este projeto adota uma série de padrões de projeto consagrados na indústria para garantir um código de alta qualidade, manutenibilidade e escalabilidade. Aqui estão alguns dos padrões e práticas que foram utilizados:

## Clean Architecture

A [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html), ou "Arquitetura Limpa", foi utilizada para estruturar as pastas do sistema. Este é um padrão de projeto que é agnóstico em relação a frameworks, bancos de dados ou quaisquer outras tecnologias. Ele enfatiza a separação de preocupações, tornando o sistema fácil de manter, entender e desenvolver.

## Domain-Driven Design (DDD)

O [Domain-Driven Design](https://dddcommunity.org/learning-ddd/what_is_ddd/) é uma abordagem à arquitetura de software que busca manter o design do software alinhado com o núcleo do negócio. Ele promove uma estreita colaboração entre desenvolvedores e especialistas de domínio, resultando em um software que é flexível e alinhado com as necessidades reais do negócio.

## Strategy

O padrão [Strategy](https://refactoring.guru/design-patterns/strategy) permite que um algoritmo seja selecionado em tempo de execução. Isso proporciona uma grande flexibilidade ao sistema, pois diferentes algoritmos podem ser trocados facilmente.

## Factory

O padrão [Factory](https://refactoring.guru/design-patterns/factory-method) foi utilizado para abstrair a criação de objetos, permitindo que o código seja mais flexível e menos acoplado.

## Form Request e Rules

Form Request e Rules são recursos do Laravel utilizados para lidar com a validação de dados no lado do servidor de uma maneira elegante e organizada.

## Elegants Objects

O projeto também segue os princípios dos [Elegants Objects](https://www.elegantobjects.org/), que é uma abordagem orientada a objetos que preza por objetos imutáveis, interfaces pequenas, composição sobre herança e muitos outros conceitos interessantes que resultam em um código mais limpo e elegante.

Esses padrões de projeto e práticas são adotados para assegurar que o código seja fácil de entender, manter e escalar. Eles são parte integrante do compromisso do projeto em aderir às melhores práticas de desenvolvimento de software.



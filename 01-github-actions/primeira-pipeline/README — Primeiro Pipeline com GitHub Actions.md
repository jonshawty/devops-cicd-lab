# 🚀 Primeiro Pipeline com GitHub Actions

## 📚 Objetivo

Este exercício faz parte do laboratório de estudos de **CI/CD**, criado para aprender os conceitos desde o zero e evoluir gradualmente para pipelines mais completos.

Neste primeiro exercício, o objetivo é entender:

- O que é um pipeline;
- O que é um workflow;
- Como o GitHub Actions funciona;
- Como um `git push` pode disparar automaticamente uma pipeline;
- O conceito de Runner;
- O funcionamento de Jobs e Steps;
- A estrutura básica de um arquivo YAML.

---

## 🧠 Conceitos estudados

### CI — Continuous Integration

Integração Contínua é a prática de integrar alterações de código frequentemente e executar validações automatizadas.

Exemplo:

```text
Desenvolvedor
     ↓
git commit
     ↓
git push
     ↓
GitHub
     ↓
GitHub Actions
     ↓
Build / Testes / Validações
```

### Pipeline

É o fluxo completo de execução das etapas automatizadas.

Exemplo:

```text
Pipeline
   ↓
Build
   ↓
Test
   ↓
Deploy
```

### Workflow

No GitHub Actions, o workflow é definido através de um arquivo YAML localizado em:

```text
.github/workflows/
```

### Job

É uma tarefa ou conjunto de tarefas executadas dentro do workflow.

Exemplo:

```text
Job
 ├── Checkout
 ├── Instalação
 └── Testes
```

### Step

É uma ação individual executada dentro de um Job.

Exemplo:

```yaml
steps:
  - name: Baixar código
    uses: actions/checkout@v4

  - name: Executar comando
    run: echo "Olá CI/CD"
```

### Runner

É o ambiente responsável por executar os Jobs.

Neste exercício será utilizado:

```yaml
runs-on: ubuntu-latest
```

Isso significa que o Job será executado em um ambiente Ubuntu disponibilizado pelo GitHub Actions.

---

# 🏗️ Estrutura do exercício

O laboratório possui a seguinte estrutura:

```text
cicd-lab/
│
├── 01-github-actions/
│   └── primeiro-pipeline/
│       └── README.md
│
└── .github/
    └── workflows/
        └── primeiro-pipeline.yml
```

O `README.md` contém a documentação do exercício.

O arquivo:

```text
.github/workflows/primeiro-pipeline.yml
```

contém o workflow que será executado pelo GitHub Actions.

---

# ⚙️ Primeiro Pipeline

O objetivo do primeiro pipeline é criar um workflow simples que seja executado automaticamente quando houver um `push` na branch `main`.

Fluxo esperado:

```text
git push
   ↓
GitHub
   ↓
GitHub Actions
   ↓
Workflow
   ↓
Job
   ↓
Runner Ubuntu
   ↓
Steps
   ↓
Pipeline concluído
```

---

# 📄 Estrutura básica do Workflow

O workflow será composto por:

```yaml
name:
on:
jobs:
```

### `name`

Define o nome do workflow.

### `on`

Define o evento que irá disparar o workflow.

Exemplo:

```yaml
on:
  push:
    branches:
      - main
```

Nesse caso, o workflow será executado quando ocorrer um `push` na branch `main`.

### `jobs`

Define os Jobs que serão executados.

Exemplo:

```yaml
jobs:
  test:
```

### `runs-on`

Define o ambiente onde o Job será executado.

```yaml
runs-on: ubuntu-latest
```

### `steps`

Define as etapas executadas pelo Job.

---

# 🎯 Resultado esperado

Após realizar:

```bash
git add .
git commit -m "Adiciona primeiro pipeline CI"
git push
```

o GitHub Actions deverá identificar o `push` e iniciar automaticamente o workflow.

No GitHub:

```text
Repository
   ↓
Actions
   ↓
Primeiro Pipeline
   ↓
Job
   ↓
Steps
   ↓
✅ Success
```

---

# 📝 O que aprendi

- [ ] Entendi o conceito de CI;
- [ ] Entendi o conceito de Pipeline;
- [ ] Entendi o que é um Workflow;
- [ ] Entendi o que é um Job;
- [ ] Entendi o que é um Step;
- [ ] Entendi o conceito de Runner;
- [ ] Entendi como um `git push` pode disparar uma pipeline;
- [ ] Entendi a estrutura básica de um workflow YAML;
- [ ] Executei meu primeiro pipeline utilizando GitHub Actions.

---

# 🚀 Próximo passo

Depois deste exercício, o próximo objetivo será transformar o pipeline em uma **CI real**.

Em vez de apenas executar comandos simples, o pipeline deverá:

```text
git push
   ↓
GitHub Actions
   ↓
Runner Ubuntu
   ↓
Instalar dependências
   ↓
Executar testes
   ↓
Validar resultado
   ↓
✅ Pipeline aprovado
```

O próximo exercício será trabalhar com **Build + Testes automatizados**.
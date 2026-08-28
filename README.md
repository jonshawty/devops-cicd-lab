# 🚀 Minha jornada de estudos: CI/CD na prática

> Documento de acompanhamento do meu laboratório pessoal de estudos de **CI/CD**, construído do zero, evoluindo um passo de cada vez — commit por commit, erro por erro, log por log.

## 📌 Sobre o projeto

Criei um repositório exclusivo pra estudar CI/CD na prática: **[devops-cicd-lab](https://github.com/jonshawty/devops-cicd-lab)**.

A proposta é simples: começar do absoluto zero (o que é uma pipeline, o que é um runner) e ir evoluindo gradualmente até tocar em conceitos reais de DevOps — build, cache, lint, containers, artifacts, secrets, environments e, por fim, CD de verdade com deploy na AWS.

**Stack usada no laboratório:** GitHub Actions · PHP 8.2 · Composer · PHPUnit 10 · PHP_CodeSniffer (PSR-12) · Docker · Terraform · AWS (ECR, ECS Fargate, IAM/OIDC)

### 🎯 Escopo (o que este lab é e o que ele não é)

Esse laboratório é sobre **CI/CD e automação de entrega** — do commit até o deploy em produção, passando por tudo que valida e empacota o código no caminho. Terraform entra porque, quando usado dentro de uma pipeline, é a mesma lógica de CI/CD aplicada à infraestrutura (`plan` valida antes de aplicar, `apply` é literalmente um step de CD) — não é um desvio de rota, é a pipeline provisionando o que ela mesma precisa, em vez de eu clicar no console da AWS.

Fora do escopo **de propósito**: Kubernetes, scripting solto em Python, observabilidade avançada (SLI/SLO), certificações. São tópicos valiosos, mas pertencem a outros estudos — aqui o fio condutor é sempre "commit → pipeline → produção".

---

## 🧠 Conceitos fundamentais

Antes de escrever qualquer YAML, entendi a diferença entre os blocos que formam uma pipeline:

| Conceito | O que é |
|---|---|
| **Repository** | Onde o código e os arquivos do projeto vivem |
| **Pipeline** | O fluxo automatizado completo (push → build → test → deploy) — nem toda pipeline faz deploy |
| **Stage** | Uma etapa da pipeline (ex: BUILD, TEST, DEPLOY) |
| **Job** | Uma tarefa específica dentro da pipeline |
| **Runner** | A máquina que executa o job (no meu caso, `ubuntu-latest`) |

---

## 🗺️ Trilha de aprendizado (roadmap completo)

```
Fundamentos (Repo, Pipeline, Stage, Job, Runner)
        ↓
GitHub Actions + primeira pipeline
        ↓
CI real: Composer + PHPUnit
        ↓
phpunit.xml + Cache de dependências
        ↓
Lint (PHP_CodeSniffer + PSR-12)
        ↓
Containerização (Dockerfile)          ← 🔜 próximo passo
        ↓
Build / Artifacts (imagem Docker)
        ↓
Secrets via OIDC (sem chaves fixas)
        ↓
Infraestrutura como código (Terraform)
        ↓
Registry (Amazon ECR)
        ↓
Environments (staging / production)
        ↓
CD → Deploy (Amazon ECS Fargate, blue-green)
        ↓
Observabilidade (CloudWatch + rollback)
```

---

## ✅ O que já foi feito

- [x] **Fundamentos teóricos** — Repository, Pipeline, Stage, Job, Runner, e a diferença entre CI e CD
- [x] **Primeira pipeline no GitHub Actions** — um workflow simples (`echo`) só pra entender a estrutura de um `.yml`: `name`, `on`, `jobs`, `runs-on`, `steps`
- [x] **Primeiro problema real de Git** — `push` rejeitado (`fetch first`), resolvido com `git pull --rebase origin main`
- [x] **`.gitignore` bem definido** — evitando versionar `/vendor/`, `.env`, `.phpunit.cache/`, etc.
- [x] **CI validando código PHP de verdade** — Composer instalando dependências + PHPUnit rodando testes automatizados
- [x] **Debug de erros reais de pipeline**:
  - `Composer could not find a composer.json file` → resolvido entendendo o conceito de **`working-directory`**
  - `phpunit [options] <directory|file>` → resolvido apontando explicitamente a pasta `tests`
- [x] **`phpunit.xml`** — configuração declarativa do PHPUnit (bootstrap, testsuite, source), eliminando argumentos soltos na CLI
- [x] **Cache de dependências do Composer** — usando `actions/cache`, incluindo debug de um cache que nunca salvava por um path fixo incorreto, resolvido com `composer config cache-files-dir` (path dinâmico, funciona em qualquer runner)
- [x] **Lint com PHP_CodeSniffer (PSR-12)** — quality gate *antes* dos testes (conceito de **fail fast**), incluindo correção de erros reais: fim de linha CRLF vs LF, ausência de namespace, `.gitattributes` pra padronizar quebras de linha no repositório inteiro
- [x] **Pipeline completa e verde**: Baixar código → Configurar PHP → Cache → Instalar dependências → Lint → PHPUnit

---

## 🔜 Próximos passos

- [ ] **Containerização** — escrever um `Dockerfile` pro projeto PHP, empacotando a aplicação de forma que rode igual em qualquer lugar
- [ ] **Build / Artifacts** — a pipeline passa a *construir e versionar a imagem Docker*, em vez de só validar código
- [ ] **Secrets via OIDC** — eliminar credenciais fixas: configurar a AWS pra confiar no GitHub como emissor de identidade, usando `aws-actions/configure-aws-credentials` + uma IAM Role com permissões mínimas
- [ ] **Infraestrutura como código (Terraform)** — descrever ECR, ECS Fargate e as IAM Roles em `.tf` versionado, com `terraform plan` rodando como *check* de CI (valida a mudança antes de aplicar) e `terraform apply` como step de CD — reaproveitando a mesma autenticação OIDC do item anterior
- [ ] **Registry (Amazon ECR)** — enviar a imagem construída pro registro de containers da AWS (já provisionado via Terraform)
- [ ] **Environments** — `staging` e `production` no GitHub Actions, cada um com sua própria IAM Role e regras de aprovação manual
- [ ] **CD → Deploy (Amazon ECS Fargate)** — deploy de verdade, usando estratégia **blue-green** (sobe a versão nova em paralelo, testa, e só então vira o tráfego — com rollback instantâneo se algo falhar)
- [ ] **Observabilidade** — ligar CloudWatch pra métricas/logs da aplicação e definir critério de rollback automático em caso de erro

---

## ☁️ Como isso se conecta com a AWS no mundo real

Uma dúvida que resolvi antes de seguir: **esse laboratório serve pra AWS mesmo, ou é só teoria de GitHub?** Resposta: o GitHub Actions não sabe nem se importa pra onde ele está mandando o resultado — ele só executa comandos. Se um desses comandos fala com a API da AWS, ele fala. É literalmente a arquitetura mais comum do mercado hoje (inclusive porque a própria AWS descontinuou o CodeCommit — seu serviço de Git — pra novos clientes em 2024, reforçando GitHub como a origem do código e o Actions como o motor do CI/CD).

| Conceito do mundo real | O que resolve |
|---|---|
| **OIDC (OpenID Connect)** | A pipeline autentica na AWS com um token temporário, válido só durante aquela execução — nada de chave de acesso fixa guardada em lugar nenhum |
| **Infraestrutura como código (IaC)** | Em vez de clicar no console da AWS, a infraestrutura é descrita em código versionado (Terraform) — revisável em Pull Request e aplicada pela própria pipeline |
| **Build once, deploy many** | A imagem Docker é construída **uma única vez** por mudança de código e promovida entre ambientes — o que passou em staging é *byte a byte* o que vai pra produção |
| **Blue-green deployment** | A versão nova sobe em paralelo à antiga; o tráfego só é virado depois de validar — com rollback instantâneo se necessário |
| **Least privilege** | Cada IAM Role (papel de acesso) tem só a permissão estritamente necessária pra aquela etapa da pipeline |

---

## 🐛 Principais aprendizados de troubleshooting

Não teve estudo de CI/CD sem log de erro — e foi exatamente aí que mais aprendi:

1. **Ler o log é mais importante que decorar YAML.** Todo erro real (Composer, PHPUnit, cache, lint) foi resolvido lendo a saída da pipeline com atenção, não adivinhando.
2. **`working-directory` importa.** Todo comando roda em um diretório específico do runner — não assumir que "a raiz do repo" é sempre o contexto certo.
3. **Caminhos fixos são frágeis entre sistemas operacionais.** O cache do Composer não é o mesmo path no Windows e no Linux — a solução robusta é perguntar pra própria ferramenta (`composer config cache-files-dir`), não fixar um valor.
4. **Editar YAML aos pedaços é arriscado.** Colar um trecho novo sem revisar o arquivo inteiro pode apagar sem querer o que já existia — às vezes reescrever o arquivo completo é mais seguro que remendar.
5. **Fail fast economiza tempo.** Colocar o lint antes dos testes garante que a pipeline não gasta recursos testando um código que nem está bem formatado.

---

## 🗂️ Estrutura atual do repositório

```
devops-cicd-lab/
│
├── 01-github-actions/
│   └── primeira-pipeline/
│       └── README.md
│
├── 02-phpunit-ci/
│   ├── composer.json
│   ├── phpunit.xml
│   ├── phpcs.xml
│   ├── src/
│   │   └── Calculadora.php
│   └── tests/
│       └── CalculadoraTest.php
│
├── .github/
│   └── workflows/
│       ├── primeiro-pipeline.yml
│       └── phpunit-ci.yml
│
├── .gitattributes
├── .gitignore
└── README.md
```

---

*Documento vivo — atualizo conforme avanço na trilha. Se você também está estudando CI/CD, bora trocar figurinha! 🚀*
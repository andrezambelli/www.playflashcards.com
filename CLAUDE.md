# Play Flashcards

## 1. Projeto

Plataforma de criação e estudo de flashcards com suporte a repetição espaçada (SRS). Permite criar baralhos (decks) e cartões privados ou públicos, estudar em sessões e acompanhar o progresso. Suporta quatro idiomas: inglês, português, espanhol e francês.

## 2. Stack

- PHP (sem framework)
- MySQL
- CSS próprio (sem framework adicional)
- jQuery 3.6.1
- JavaScript

## 3. Estrutura

| Pasta / Arquivo | Conteúdo |
|---|---|
| `admin/` | Painel administrativo |
| `common/` | Páginas comuns: sobre, contato, cookies, termos, privacidade, doação |
| `content/` | Imagens e recursos de conteúdo |
| `dash/` | Área logada: gerenciamento de decks, cartões e sessões de estudo |
| `docs/` | Documentação local: scripts MySQL, configs Apache, templates de servidor |
| `docs/server/` | Templates de `car-server.php` para Mac e produção |
| `external-lib/` | Bibliotecas externas (MailerSend) |
| `general/` | Funções utilitárias (`functions.inc`), handler de sessão |
| `home/` | Página inicial pública |
| `include/` | Blocos reutilizáveis: header, footer, mensagens |
| `lang/` | Arquivos de tradução por idioma |
| `login/` | Autenticação: login, PIN, Google, logoff |
| `profile/` | Perfil do usuário e configuração de SRS |
| `public/` | Baralhos e estudos públicos acessíveis sem login |
| `test/` | Scripts de teste |
| `car-server.php` | Configuração de ambiente: credenciais de banco e caminhos absolutos (gitignored) |
| `general/config.inc` | Conexão com banco e inicialização de sessão (gitignored) |
| `config.inc` | Configuração global: versão, constantes de negócio, idioma e rotas |
| `routes.inc` | Mapeamento de rotas URL para arquivos PHP |

## 4. Ambiente

**Local**
- URL: `http://playflashcards.localhost/`
- Admin: `http://playflashcards.localhost/admin/`
- `car-server.php` define caminhos absolutos e credenciais do banco local
- `general/config.inc` cria a conexão mysqli e inicializa a sessão

**Produção**
- URL: `https://www.playflashcards.com/`
- Deploy: `one deploy playflashcards`

**Templates de ambiente**
- `docs/server/car-server-mac.php` — referência para o `car-server.php` local
- `docs/server/car-server-prod.php` — referência para o `car-server.php` de produção

## 5. Como o projeto funciona

### Roteamento

Todas as requisições chegam em `index.php` via `.htaccess`. O roteamento acontece em dois níveis:

1. **Rotas estáticas**: `routes.inc` define um array `$routes` mapeando URLs para arquivos PHP
2. **Rotas dinâmicas**: URLs com segmentos como `/deck/abc123/nome` e `/study/abc123` são interpretadas diretamente em `index.php`

### Idiomas

O idioma é armazenado em sessão (`$_SESSION['lang']`). Rotas incluem o prefixo de idioma (ex.: `en/login/login`, `pt-br/login/login`). O arquivo de tradução é carregado automaticamente em `config.inc`.

### SRS (Repetição Espaçada)

Configurado por usuário em `profile/srs.php`. Constantes globais em `config.inc`:

| Constante | Descrição |
|---|---|
| `CAR_USER_SRS_LIMIT` | Máximo de cartões por sessão SRS |
| `CAL_USER_SRS_SEQUENCE` | Sequência de repetição |
| `CAL_USER_SRS_RATE` | Taxa de acerto alvo (%) |
| `CAL_USER_SRS_DAYS` | Intervalo de dias entre sessões |

### Limites por usuário

| Constante | Descrição |
|---|---|
| `CAL_USER_MAX_DECK` | Máximo de baralhos por usuário |
| `CAL_USER_MAX_STUDY` | Máximo de sessões de estudo |
| `CAL_USER_MAX_CARD` | Máximo de cartões por baralho |

## 6. Restrições (nunca)

- Nunca usar travessão em nenhum texto criado
- Nunca criar arquivos desnecessários. Sempre preferir editar o que já existe
- Nunca sugerir deploy, commit ou push ao final de mensagens. O usuário sabe quando executar essas ações e solicita quando necessário

## 7. Regras (ao fazer)

- Ao criar ou editar texto, usar pt-BR correto, com acentos, cedilhas e pontuação
- Ao modificar qualquer arquivo `.js` ou `.css`, incrementar o valor de `CAL_VERSION` em `config.inc`
- Ao identificar durante o trabalho uma regra, padrão ou exceção recorrente que ainda não está documentada, propor a adição neste CLAUDE.md antes de encerrar a conversa

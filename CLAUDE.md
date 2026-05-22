# Play Flashcards

## 1. Projeto

Plataforma de criação e estudo de flashcards com suporte a repetição espaçada (SRS). Permite criar baralhos (decks) e cartões privados ou públicos, estudar em sessões e acompanhar o progresso. Suporta quatro idiomas: inglês, português, espanhol e francês.

## 2. Stack

- PHP (sem framework)
- MySQL
- Bootstrap 5.3.8 (CSS + JS bundle, arquivos locais em `assets/`)
- Bootstrap Icons 1.13.1 (arquivo local em `assets/css/`)
- CSS próprio mínimo em `assets/css/styles.css` (apenas overrides e tokens que o Bootstrap não cobre)
- JavaScript vanilla (sem jQuery, sem framework)

## 3. Estrutura

| Pasta / Arquivo | Conteúdo |
|---|---|
| `admin/` | Painel administrativo |
| `common/` | Páginas comuns: sobre, contato, cookies, termos, privacidade, doação |
| `containers/` | Blocos reutilizáveis incluídos nas páginas: header, footer, message, share, boxes |
| `content/` | Imagens e recursos de conteúdo |
| `dash/` | Área logada: gerenciamento de decks, cartões e sessões de estudo |
| `docs/` | Documentação local (gitignored): scripts MySQL, templates de servidor |
| `external-lib/` | Bibliotecas externas (MailerSend) |
| `general/` | Funções utilitárias (`functions.inc`), handler de sessão |
| `home/` | Página inicial pública |
| `lang/` | Arquivos de tradução por idioma |
| `login/` | Autenticação: login, PIN, Google, logoff |
| `profile/` | Perfil do usuário e configuração de SRS |
| `public/` | Baralhos e estudos públicos acessíveis sem login |
| `services/` | Scripts de serviço sem página: troca de idioma, cookie, último acesso |
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

**Templates de ambiente** (em `docs/`, gitignored — apenas local)
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
| `CAR_USER_SRS_SEQUENCE` | Sequência de repetição |
| `CAR_USER_SRS_RATE` | Taxa de acerto alvo (%) |
| `CAR_USER_SRS_DAYS` | Intervalo de dias entre sessões |

### Limites por usuário

| Constante | Descrição |
|---|---|
| `CAR_USER_MAX_DECK` | Máximo de baralhos por usuário |
| `CAR_USER_MAX_STUDY` | Máximo de sessões de estudo |
| `CAR_USER_MAX_CARD` | Máximo de cartões por baralho |

## 6. Convenções de código

### Prefixos
- Todas as funções utilitárias usam prefixo `car_` (ex.: `car_t()`, `car_redirect()`, `car_check_login()`)
- Todas as constantes de ambiente usam prefixo `CAR_` (ex.: `CAR_PATH_WEB`, `CAR_ROOT_WEB`, `CAR_VERSION`)

### Padrão de arquivos
- `*.php` sem sufixo = páginas que renderizam HTML
- `*-act.php` = actions que processam dados e fazem redirect (nunca renderizam HTML)
- `*.inc` = blocos incluídos por outras páginas (não acessíveis diretamente via URL)
- Primeira linha de todo arquivo PHP: `<?php /** @var array $t */ ?>` (suprime falso positivo do Intelephense para a variável `$t`)

### i18n
- Variável `$t` = array associativo de traduções carregado via `lang/lang.inc`
- Uso: `car_t($t, 'chave')` para texto traduzido, `car_t($t, 'chave')` aceita chave simples ou string direta
- Chaves compostas usam notação com ponto: `'dash.deck.delete'`, `'login.login.privacy'`
- Ao adicionar texto visível ao usuário, sempre adicionar a chave nos quatro arquivos de idioma: `lang-en.inc`, `lang-pt-br.inc`, `lang-es.inc`, `lang-fr.inc`
- O painel admin (`admin/`) usa strings em português fixo no código — isso é intencional, pois é uma área interna sem necessidade de i18n

### Autenticação
- `car_check_login($t)` no topo de toda página da área logada (`dash/`, `profile/`)
- Páginas públicas (`public/`, `common/`) não requerem login

### Banco de dados
- Conexão mysqli disponível via `$mysqli` (inicializada em `general/config.inc`)
- Autocommit desligado: usar `$mysqli->commit()` após operações de escrita
- Escapar inputs com `$mysqli->real_escape_string()` nas queries interpoladas

## 7. Restrições (nunca)

- Nunca usar travessão em nenhum texto criado
- Nunca criar arquivos desnecessários. Sempre preferir editar o que já existe
- Nunca sugerir deploy, commit ou push ao final de mensagens. O usuário sabe quando executar essas ações e solicita quando necessário
- Nunca usar jQuery. O projeto foi migrado para JavaScript vanilla + Bootstrap 5. jQuery foi removido completamente
- Nunca adicionar CSS próprio para algo que o Bootstrap já resolve nativamente. Verificar se existe classe Bootstrap antes de criar estilo customizado

## 8. Regras (ao fazer)

- Ao criar ou editar texto, usar pt-BR correto, com acentos, cedilhas e pontuação
- Ao modificar qualquer arquivo `.js` ou `.css`, incrementar o valor de `CAR_VERSION` em `config.inc`
- Ao adicionar ou alterar qualquer constante em `car-server.php` (local ou produção), atualizar também os templates em `docs/server/car-server-mac.php` e `docs/server/car-server-prod.php`
- Ao identificar durante o trabalho uma regra, padrão ou exceção recorrente que ainda não está documentada, propor a adição neste CLAUDE.md antes de encerrar a conversa
- Ao escrever JavaScript, usar vanilla JS com `fetch()` para requisições assíncronas e `document.addEventListener('DOMContentLoaded', ...)` para inicializações. Seguir o padrão do `assets/js/main.js`
- Ao referenciar o design visual do redesign, consultar `docs/redesign/claude_design/` apenas como referência de aparência (cores, layout, tipografia), nunca como fonte de código a copiar

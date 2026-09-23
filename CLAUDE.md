# Play Flashcards

## 1. Projeto

Plataforma de criação e estudo de flashcards com suporte a repetição espaçada (SRS). Permite criar baralhos (decks) e cartões privados ou públicos, estudar em sessões e acompanhar o progresso. Suporta múltiplos idiomas (en, pt-br, es, fr, de, it, ja, zh, nl, pl, ru, hi).

## 2. Ambiente

- Stack além da padrão: MySQL. Bootstrap e Bootstrap Icons servidos de arquivos locais em `assets/`; CSS próprio mínimo em `assets/css/styles.css` (apenas overrides e tokens que o Bootstrap não cobre)
- Local: `http://playflashcards.localhost/`
- Produção: `https://www.playflashcards.com/`, deploy `one deploy play www`
- Staging: `one deploy play staging`
- Versão de assets: `CAR_VERSION` em `config.inc`
- `car-server.php` (gitignored) define caminhos absolutos e credenciais do banco; `general/db.inc` cria a conexão mysqli e inicializa a sessão
- O painel administrativo é o repositório próprio `admin.playflashcards.com` (`one deploy play admin`), com strings em português fixo, sem i18n

## 3. Estrutura

| Pasta / Arquivo | Conteúdo |
|---|---|
| `common/` | Páginas comuns: sobre, contato, cookies, termos, privacidade, doação |
| `containers/` | Blocos reutilizáveis incluídos nas páginas: header, footer, message, share, boxes |
| `dash/` | Área logada: gerenciamento de decks, cartões e sessões de estudo |
| `docs/` | Documentação local (gitignored): scripts MySQL, credenciais Google, referências do redesign e a revisão de segurança do login por PIN (`docs/agents/pincode-security.md`, relatório, não agente) |
| `general/` | Funções utilitárias (`functions.inc`), conexão e handler de sessão (`db.inc`), GA |
| `home/` | Página inicial pública |
| `lang/` | Arquivos de tradução por idioma |
| `login/` | Autenticação: login, PIN, Google, logoff |
| `profile/` | Perfil do usuário e configuração de SRS |
| `public/` | Baralhos e estudos públicos acessíveis sem login |
| `services/` | Scripts de serviço sem página: troca de idioma, cookie, último acesso, sitemap |
| `car-server.php` | Configuração de ambiente: credenciais de banco e caminhos absolutos (gitignored) |
| `config.inc` | Configuração global: versão, constantes de negócio, idioma e rotas |
| `routes.inc` | Mapeamento de rotas URL para arquivos PHP |

## 4. Arquitetura

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

### Convenções de código

#### Prefixos
- Todas as funções utilitárias usam prefixo `car_` (ex.: `car_t()`, `car_redirect()`, `car_check_login()`)
- Todas as constantes de ambiente usam prefixo `CAR_` (ex.: `CAR_PATH_WEB`, `CAR_ROOT_WEB`, `CAR_VERSION`)
- Todas as classes CSS customizadas usam prefixo `car-` (ex.: `car-brand-mark`, `car-flashcard`, `car-message-error`). Isso diferencia visualmente as classes próprias das classes nativas do Bootstrap

#### Padrão de arquivos
- `*.php` sem sufixo = páginas que renderizam HTML
- `*-act.php` = actions que processam dados e fazem redirect (nunca renderizam HTML)
- `*.inc` = blocos incluídos por outras páginas (não acessíveis diretamente via URL)
- Primeira linha de todo arquivo PHP: `<?php /** @var array $t */ ?>` (suprime falso positivo do Intelephense para a variável `$t`)
- Avisos do Intelephense sobre funções e constantes indefinidas em `*-act.php` são falsos positivos: o Intelephense não consegue resolver includes com `$_SERVER['DOCUMENT_ROOT']`. Ignorar.
- Comentários no código devem ser escritos em pt-BR e, preferencialmente, em letra minúscula

#### Includes especiais
- `login/user-insert-act.inc`: espera que `$user_email` seja definido pelo arquivo que o inclui. Todo arquivo que inclui este `.inc` deve também incluir `lang/lang.inc` antes, pois ele acessa `$t['lang']` ao inserir novos usuários.

#### i18n
- Variável `$t` = array associativo de traduções carregado via `lang/lang.inc`
- Uso: `car_t($t, 'chave')` para texto traduzido, `car_t($t, 'chave')` aceita chave simples ou string direta
- Chaves compostas usam notação com ponto: `'dash.deck.delete'`, `'login.login.privacy'`
- Ao adicionar texto visível ao usuário, sempre adicionar a chave em todos os arquivos de idioma ativos (pelo menos `lang-en.inc`, `lang-pt-br.inc`, `lang-es.inc`, `lang-fr.inc`)

#### Capitalização nos arquivos de idioma
- Usar **sentence case** em todos os idiomas: apenas a primeira letra da frase é maiúscula, mais nomes próprios (`SRS`, `Play Flashcards`, `Google`, `CSV`)
- Isso vale para botões, títulos, rótulos de campos, textos curtos e referências a labels dentro de textos explicativos
- Exemplos corretos: `'Save deck'`, `'Delete flashcard'`, `'Accuracy rate'`, `'Study frequency'`
- Exemplos errados: `'Save Deck'`, `'Delete Flashcard'`, `'Accuracy Rate'`, `'Study Frequency'`
- Essa regra se aplica aos quatro idiomas: title case é gramaticalmente incorreto em pt-BR, es e fr, e foge do padrão moderno de UI mesmo em en

#### Autenticação
- `car_check_login($t)` no topo de toda página da área logada (`dash/`, `profile/`)
- Páginas públicas (`public/`, `common/`) não requerem login

#### Banco de dados
- Conexão mysqli disponível via `$mysqli` (inicializada em `general/db.inc`)
- Autocommit desligado: usar `$mysqli->commit()` após operações de escrita
- Escapar inputs com `$mysqli->real_escape_string()` nas queries interpoladas

## 5. Restrições (nunca)

- Nunca alterar o estilo de um botão isolado fora do hero. Mudanças de espaçamento, padding, fonte ou raio de botões devem ser aplicadas ao padrão global de botões

## 6. Regras (ao fazer)

- Ao escrever JavaScript, seguir o padrão do `assets/js/main.js`
- Ao referenciar o design visual do redesign, consultar `docs/redesign/claude_design/` apenas como referência de aparência (cores, layout, tipografia), nunca como fonte de código a copiar
- Ao adicionar um novo idioma `{code}`, atualizar obrigatoriamente todos os 11 pontos abaixo, sem exceção:
  1. Criar `lang/lang-{code}.inc` com todas as chaves de `lang/lang-en.inc` traduzidas (incluindo `'lang' => '{code}'`)
  2. `lang/lang.inc`: adicionar `{code}` ao array `$valid`, ao `$_lang_map` e criar o bloco `elseif` de include
  3. `containers/header.inc`: adicionar a `$lang_labels` (ex: `'de' => 'DE'`)
  4. `lang/lang-list.inc`: adicionar `{code}` ao array `$car_langs` com o nome nativo (ex: `'de' => 'Deutsch'`): atualiza automaticamente os selects em `profile/home.php`, `dash/deck-new.php`, `dash/deck-edit.php` e o dropdown em `containers/header.inc`
  5. `services/change-language-act.php`: adicionar ao array `$valid_langs` e às duas verificações de sufixo de URL (`elseif` de detecção de prefixo na URL)
  6. `routes.inc`: adicionar rotas para `{code}`, `{code}/login/login`, `{code}/contact-us`, `{code}/cookie-settings`, `{code}/terms-and-conditions` e `{code}/privacy-policy`
  7. `services/create-sitemap.php`: adicionar `{code}` ao array `$langs`
  8. `main.php`: adicionar `{code}` ao array `in_array` da validação anti-loop (linha com `$_uri_first`): omitir causa `ERR_TOO_MANY_REDIRECTS` na homepage do idioma
  9. `general/functions.inc`: adicionar bloco `elseif` para `/{code}/` na função `car_check_language()`
  10. `home/card-preview.inc`: adicionar entrada no array `$home_card_preview_examples` com 5 flashcards de exemplo traduzidos para `{code}`
  11. `profile/home.php` (select): o atributo `selected` dos `<option>` usa `$t['lang']` (sessão ativa), não `$user_lang` (banco): isso já está correto; ao criar novos selects de idioma em outras páginas, seguir o mesmo padrão

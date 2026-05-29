<?php /** @var array $t */ ?>
<?php
// bloco visual da sessão de estudo, compartilhado entre área pública e logada.
//
// variáveis obrigatórias fornecidas pelo controlador antes do include:
//   $has_study     bool   — se o estudo existe no banco
//   $has_card      bool   — se ainda há cartões a responder
//   $stud_key      string — chave única do estudo
//   $stse_order    int    — posição do cartão atual na sessão
//   $card_front    string — texto da frente do cartão
//   $card_back     string — texto do verso do cartão
//   $deck_key      string — chave do baralho
//   $deck_name     string — nome do baralho
//   $deck_desc     string — descrição do baralho (pode ser vazia)
//   $stud_begin    string — data/hora de início do estudo
//   $stud_end      string — data/hora de término do estudo
//   $stud_total    int    — total de cartões no estudo
//   $stud_true     int    — total de respostas corretas
//   $_progress_pct int    — percentual de progresso (0–100)
//   $_deck_url     string — url de retorno ao baralho
//   $_form_action  string — url de destino do formulário de resposta
//   $_is_public    bool   — true = área pública; false = área logada
?>
<div class="car-play-stage">

    <div class="car-play-header">
        <?php if (!empty($deck_key)) { ?>
        <a href="<?= car_htmlspecialchars($_deck_url) ?>"
           class="btn btn-sm btn-link text-secondary text-decoration-none d-inline-flex align-items-center gap-1 px-0">
            <span class="car-kbd">ESC</span>
            <?= car_t($t, 'dash.study.exit') ?>
        </a>
        <?php } ?>
        <?php if ($has_study && $has_card) { ?>
        <div class="flex-grow-1 d-flex align-items-center gap-3" style="max-width: 360px">
            <div class="progress flex-grow-1" style="height: 4px" role="progressbar"
                 aria-valuenow="<?= $_progress_pct ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: <?= $_progress_pct ?>%"></div>
            </div>
            <span class="car-text-mono small text-secondary">
                <?= str_pad($stse_order, 2, '0', STR_PAD_LEFT) ?> / <?= str_pad($stud_total, 2, '0', STR_PAD_LEFT) ?>
            </span>
        </div>
        <?php } ?>
        <?php if (!empty($deck_name)) { ?>
        <div class="ms-auto">
            <div class="car-label-uc"><?= car_htmlspecialchars($deck_name) ?></div>
        </div>
        <?php } ?>
    </div>

    <div class="car-play-canvas">

        <?php if ($has_study && $has_card) { ?>

        <form id="study_form" method="post" action="<?= $_form_action ?>">
            <input type="hidden" name="k" value="<?= car_htmlspecialchars($stud_key) ?>">
            <input type="hidden" name="stse_order" value="<?= $stse_order ?>">
            <input type="hidden" id="stse_answer" name="stse_answer" value="">
        </form>

        <div id="car_flashcard" class="car-flashcard" role="button" tabindex="0">
            <div id="card_side" class="car-flashcard-side">
                <?= car_t($t, 'Front') ?> &middot; <?= $stse_order ?>/<?= $stud_total ?>
            </div>
            <div id="card_text" class="car-flashcard-text"><?= car_htmlspecialchars($card_front) ?></div>
            <div class="car-flashcard-hint"><?= car_t($t, 'dash.study.flip-hint') ?></div>
        </div>

        <div id="play_actions" class="d-flex gap-3 w-100" style="max-width: 640px">
            <button type="button" id="btn_false" class="car-play-btn dont">
                <span><?= car_t($t, 'False Btn') ?></span>
                <span class="car-play-btn-kbd">←</span>
            </button>
            <button type="button" id="btn_true" class="car-play-btn know">
                <span><?= car_t($t, 'True Btn') ?></span>
                <span class="car-play-btn-kbd">→</span>
            </button>
        </div>

        <div class="d-none d-md-flex gap-4 text-secondary" style="font-size: 0.75rem">
            <div class="d-flex align-items-center gap-2">
                <span class="car-kbd"><?= car_t($t, 'dash.study.key-space') ?></span>
                <?= car_t($t, 'Front') ?> / <?= car_t($t, 'Back') ?>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="car-kbd">← →</span>
                <?= car_t($t, 'dash.study.respond') ?>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="car-kbd">ESC</span>
                <?= car_t($t, 'dash.study.exit') ?>
            </div>
        </div>

        <?php } elseif ($has_study && !$has_card) { ?>

        <div style="max-width: 480px; width: 100%">

            <div class="text-center mb-4">
                <div class="car-label-uc mb-2"><?= car_t($t, 'public.study.result-for') ?></div>
                <div class="fw-semibold fs-5 mb-1"><?= car_htmlspecialchars($deck_name) ?></div>
                <?php if (!empty($deck_desc)) { ?>
                <div class="text-secondary small"><?= car_htmlspecialchars($deck_desc) ?></div>
                <?php } ?>
            </div>

            <div class="text-center mb-4">
                <?php
                    $_acc       = car_percent($stud_true, $stud_total);
                    $_acc_color = $_acc < 50 ? 'text-danger' : ($_acc < 75 ? 'text-warning' : 'text-success');
                ?>
                <div class="display-4 fw-semibold car-text-mono mb-1 <?= $_acc_color ?>"><?= $_acc ?>%</div>
                <div class="text-secondary small"><?= $stud_true ?> / <?= $stud_total ?> <?= car_t($t, 'Correctly Answered') ?></div>
            </div>

            <div class="card mb-3">
                <div class="card-body d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary small"><?= car_t($t, 'Study ID') ?></span>
                        <span class="small car-text-mono"><?= car_htmlspecialchars(car_format_study_key($stud_key)) ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary small"><?= car_t($t, 'Start Date') ?></span>
                        <span class="small car-text-mono"><?= car_htmlspecialchars($stud_begin) ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary small"><?= car_t($t, 'Study Time') ?></span>
                        <span class="small car-text-mono"><?= car_diff_dates($stud_begin, $stud_end) ?></span>
                    </div>
                </div>
            </div>

            <?php if (!$_is_public) { ?>
            <div class="car-label-uc text-center mb-3"><?= car_t($t, 'dash.study.study-again') ?></div>
            <?php } ?>

            <div class="d-flex flex-column gap-2 mb-4">
                <?php if ($_is_public) { ?>
                <!-- área pública: apenas baralho completo (sem SRS, pois SRS exige conta) -->
                <form action="<?= CAR_PATH_WEB ?>/deck/study-new-act" method="post">
                    <input type="hidden" name="k" value="<?= car_htmlspecialchars($deck_key) ?>">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-clockwise" aria-hidden="true"></i>
                        <?= car_t($t, 'dash.study.study-again') ?>
                    </button>
                </form>
                <?php } else { ?>
                <!-- área logada: srs (recomendado) + baralho completo -->
                <a href="<?= CAR_PATH_WEB ?>/dash/study-srs-new-act?k=<?= car_htmlspecialchars($deck_key) ?>"
                   class="btn btn-primary">
                    <i class="bi bi-stars" aria-hidden="true"></i>
                    <?= car_t($t, 'dash.deck.study-smart') ?>
                </a>
                <a href="<?= CAR_PATH_WEB ?>/dash/study-new-act?k=<?= car_htmlspecialchars($deck_key) ?>"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-layers" aria-hidden="true"></i>
                    <?= car_t($t, 'dash.deck.study-full') ?>
                </a>
                <?php } ?>
            </div>

            <div class="text-center">
                <a href="<?= car_htmlspecialchars($_deck_url) ?>"
                   class="btn btn-link text-secondary text-decoration-none small d-inline-flex align-items-center gap-1">
                    <span class="car-kbd">ESC</span>
                    <?= car_t($t, 'dash.study.exit') ?>
                </a>
            </div>

        </div>

        <?php } ?>

    </div>

</div>

<?php if ($has_study && !$has_card) { ?>
<script>
// tela de resultados: esc retorna ao baralho
// capture phase garante disparo antes de qualquer elemento focado
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { e.preventDefault(); location.href = <?= json_encode($_deck_url) ?>; }
}, true);
</script>
<?php } ?>
<?php if ($has_study && $has_card) { ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var card            = document.getElementById('car_flashcard');
    var actions         = document.getElementById('play_actions');
    var cardSide        = document.getElementById('card_side');
    var cardText        = document.getElementById('card_text');
    var btnFalseText    = document.querySelector('#btn_false span:first-child');
    var btnTrueText     = document.querySelector('#btn_true span:first-child');
    var flipped         = false;
    var frontText       = <?= json_encode($card_front) ?>;
    var backText        = <?= json_encode($card_back) ?>;
    var labelFront      = <?= json_encode(car_t($t, 'Front')) ?>;
    var labelBack       = <?= json_encode(car_t($t, 'Back')) ?>;
    var labelFalse      = <?= json_encode(car_t($t, 'False Btn')) ?>;
    var labelTrue       = <?= json_encode(car_t($t, 'True Btn')) ?>;
    var labelFalseFlip  = <?= json_encode(car_t($t, 'dash.study.false-flipped')) ?>;
    var labelTrueFlip   = <?= json_encode(car_t($t, 'dash.study.true-flipped')) ?>;
    var cardStep        = <?= json_encode($stse_order . '/' . $stud_total) ?>;
    var exitUrl         = <?= json_encode($_deck_url) ?>;

    function fitCardText() {
        var style = getComputedStyle(card);
        var padV  = parseFloat(style.paddingTop) + parseFloat(style.paddingBottom);
        var avail = card.clientHeight - padV;
        var size  = 44;
        cardText.style.fontSize = size + 'px';
        while (cardText.scrollHeight > avail && size > 12) {
            size--;
            cardText.style.fontSize = size + 'px';
        }
    }

    function flip() {
        if (card.classList.contains('flip-out') || card.classList.contains('flip-start')) return;
        card.classList.add('flip-out');
        setTimeout(function () {
            flipped = !flipped;
            card.classList.toggle('flipped', flipped);
            cardSide.textContent     = (flipped ? labelBack : labelFront) + ' · ' + cardStep;
            cardText.textContent     = flipped ? backText       : frontText;
            btnFalseText.textContent = flipped ? labelFalseFlip : labelFalse;
            btnTrueText.textContent  = flipped ? labelTrueFlip  : labelTrue;
            card.classList.add('flip-start');
            card.classList.remove('flip-out');
            void card.offsetWidth; // força reflow para o jump sem transição
            card.classList.remove('flip-start');
            fitCardText();
        }, 280);
    }

    function answer(value) {
        document.getElementById('stse_answer').value = value;
        document.getElementById('study_form').submit();
    }

    card.addEventListener('click', flip);
    // esc no card: evita que o foco no elemento consuma a tecla antes do listener do documento
    card.addEventListener('keydown', function (e) {
        if      (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); flip(); }
        else if (e.key === 'Escape')                 { e.preventDefault(); location.href = exitUrl; }
    });

    document.getElementById('btn_true').addEventListener('click', function () { answer('true'); });
    document.getElementById('btn_false').addEventListener('click', function () { answer('false'); });

    fitCardText();

    var resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(fitCardText, 100);
    });

    // capture phase: intercepta esc antes de qualquer elemento filho receber o evento
    document.addEventListener('keydown', function (e) {
        if      (e.key === ' ')          { e.preventDefault(); flip(); }
        else if (e.key === 'ArrowRight') { e.preventDefault(); answer('true'); }
        else if (e.key === 'ArrowLeft')  { e.preventDefault(); answer('false'); }
        else if (e.key === 'Escape')     { e.preventDefault(); location.href = exitUrl; }
    }, true);
});
</script>
<?php } ?>

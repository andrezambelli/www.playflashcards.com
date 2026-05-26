<?php /** @var array $t */ ?>
<?php
    $home_card_preview_examples = [
        'en' => [
            ['front' => 'Capital of Iceland',                  'back' => 'Reykjavik'],
            ['front' => 'What is photosynthesis?',             'back' => 'Plants turn light into energy'],
            ['front' => 'Browser search shortcut',             'back' => 'Ctrl + F or Command + F'],
            ['front' => 'Smallest prime number',               'back' => '2'],
            ['front' => 'Meaning of "serendipity"',            'back' => 'A happy unexpected discovery'],
        ],
        'es' => [
            ['front' => 'Capital de Islandia',                 'back' => 'Reikiavik'],
            ['front' => '¿Qué es la fotosíntesis?',            'back' => 'Las plantas convierten luz en energía'],
            ['front' => 'Atajo para buscar en el navegador',   'back' => 'Ctrl + F o Command + F'],
            ['front' => 'Número primo más pequeño',            'back' => '2'],
            ['front' => 'Significado de "serendipia"',         'back' => 'Un hallazgo feliz e inesperado'],
        ],
        'fr' => [
            ['front' => 'Capitale de l\'Islande',              'back' => 'Reykjavik'],
            ['front' => 'Qu\'est-ce que la photosynthèse ?',   'back' => 'Les plantes transforment la lumière en énergie'],
            ['front' => 'Raccourci pour chercher',             'back' => 'Ctrl + F ou Command + F'],
            ['front' => 'Plus petit nombre premier',           'back' => '2'],
            ['front' => 'Sens de "sérendipité"',               'back' => 'Une découverte heureuse et inattendue'],
        ],
        'pt-br' => [
            ['front' => 'Capital da Islândia',                 'back' => 'Reykjavik'],
            ['front' => 'O que é fotossíntese?',               'back' => 'Plantas transformam luz em energia'],
            ['front' => 'Atalho para buscar no navegador',     'back' => 'Ctrl + F ou Command + F'],
            ['front' => 'Menor número primo',                  'back' => '2'],
            ['front' => 'Significado de "serendipidade"',      'back' => 'Uma descoberta feliz e inesperada'],
        ],
    ];
    $home_card_preview_lang     = $home_card_preview_examples[$t['lang']] ?? $home_card_preview_examples['en'];
    $home_card_preview_selected = $home_card_preview_lang[array_rand($home_card_preview_lang)];
?>
<section class="car-card-preview-section overflow-hidden">
    <div class="container">
        <div class="car-card-stack">
            <div class="car-card-ghost car-card-ghost--left">
                <div class="car-label-uc"><?= car_t($t, 'Back') ?> &middot; 02/20</div>
            </div>
            <div class="car-card-ghost car-card-ghost--right"></div>
            <div id="home_card_preview"
                 class="car-card-preview"
                 role="button"
                 tabindex="0"
                 data-front-label="<?= car_htmlspecialchars(car_t($t, 'Front')) ?>"
                 data-back-label="<?= car_htmlspecialchars(car_t($t, 'Back')) ?>"
                 data-front-text="<?= car_htmlspecialchars($home_card_preview_selected['front']) ?>"
                 data-back-text="<?= car_htmlspecialchars($home_card_preview_selected['back']) ?>">
                <div class="car-card-preview-header">
                    <span id="home_card_preview_side" class="car-label-uc">
                        <?= car_t($t, 'Front') ?> &middot; 7/20
                    </span>
                </div>
                <div class="car-card-preview-body">
                    <p id="home_card_preview_text" class="car-card-preview-text mb-0"><?= car_htmlspecialchars($home_card_preview_selected['front']) ?></p>
                </div>
                <div class="car-card-preview-footer">
                    <span class="car-card-preview-hint"><?= car_t($t, 'home.hero.card-hint') ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var card = document.getElementById('home_card_preview');
    if (!card) return;

    var side       = document.getElementById('home_card_preview_side');
    var text       = document.getElementById('home_card_preview_text');
    var flipped    = false;
    var frontLabel = card.dataset.frontLabel;
    var backLabel  = card.dataset.backLabel;
    var frontText  = card.dataset.frontText;
    var backText   = card.dataset.backText;

    function flipHomeCard() {
        if (card.classList.contains('flip-out') || card.classList.contains('flip-start')) return;

        card.classList.add('flip-out');
        setTimeout(function () {
            flipped = !flipped;
            card.classList.toggle('flipped', flipped);
            side.textContent = (flipped ? backLabel : frontLabel) + ' · ' + (flipped ? '02/20' : '7/20');
            text.textContent = flipped ? backText : frontText;
            card.classList.add('flip-start');
            card.classList.remove('flip-out');
            void card.offsetWidth;
            card.classList.remove('flip-start');
        }, 280);
    }

    function isTypingTarget(target) {
        return target.closest('input, textarea, select, button, [contenteditable="true"]');
    }

    card.addEventListener('click', flipHomeCard);
    card.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            flipHomeCard();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === ' ' && !isTypingTarget(e.target)) {
            e.preventDefault();
            flipHomeCard();
        }
    }, true);
});
</script>

<?php /** @var array $t */ ?>
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
                 data-front-text="Posh part of the city"
                 data-back-text="Affluent or fashionable area">
                <div class="car-card-preview-header">
                    <span id="home_card_preview_side" class="car-label-uc">
                        <?= car_t($t, 'Front') ?> &middot; 7/20
                    </span>
                </div>
                <div class="car-card-preview-body">
                    <p id="home_card_preview_text" class="car-card-preview-text mb-0">Posh part of the city</p>
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

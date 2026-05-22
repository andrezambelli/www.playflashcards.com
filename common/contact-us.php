<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    $header_title        = car_t($t, 'common.contact-us.title') . ' - Play Flashcards';
    $header_description  = car_t($t, 'common.contact-us.desc');
    $header_index_follow = 'index,follow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<div class="container py-5">
    <div class="mx-auto" style="max-width:600px">

        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>

        <!-- hero -->
        <div class="car-label-uc mb-2"><?= car_t($t, 'Contact') ?></div>
        <h1 class="mb-3" style="font-size:clamp(1.8rem,4vw,2.5rem);font-weight:600;letter-spacing:-0.02em;line-height:1.1">
            <?= car_t($t, 'common.contact-us.heading') ?><br>
            <span class="fw-normal text-secondary"><?= car_t($t, 'common.contact-us.heading-accent') ?></span>
        </h1>
        <p class="text-secondary mb-5"><?= car_t($t, 'common.contact-us.subtitle') ?></p>

        <!-- formulário -->
        <form id="contact-form">
            <input type="hidden" name="url"  value="www.playflashcards.com">
            <input type="hidden" name="lang" value="<?= car_htmlspecialchars($t['lang']) ?>">

            <!-- nome -->
            <div class="mb-3">
                <label class="form-label" for="contact-name">
                    <?= car_t($t, 'Name') ?>
                    <span class="form-text">(<?= car_t($t, 'common.contact-us.name-optional') ?>)</span>
                </label>
                <input type="text"
                       class="form-control"
                       id="contact-name"
                       name="name"
                       maxlength="100"
                       autocomplete="name">
            </div>

            <!-- email -->
            <div class="mb-3">
                <label class="form-label" for="contact-email"><?= car_t($t, 'Email') ?></label>
                <input type="email"
                       class="form-control"
                       id="contact-email"
                       name="email"
                       maxlength="255"
                       required
                       autocomplete="email">
            </div>

            <!-- assunto -->
            <div class="mb-3">
                <label class="form-label d-block"><?= car_t($t, 'common.contact-us.topic-label') ?></label>
                <div class="d-flex flex-wrap gap-2">
                    <input type="radio" class="btn-check" name="topic" id="topic-feedback" value="Feedback" checked>
                    <label class="btn btn-sm btn-outline-secondary" for="topic-feedback">
                        <i class="bi bi-chat-dots" aria-hidden="true"></i>
                        <?= car_t($t, 'common.contact-us.topic.feedback') ?>
                    </label>

                    <input type="radio" class="btn-check" name="topic" id="topic-bug" value="Bug report">
                    <label class="btn btn-sm btn-outline-secondary" for="topic-bug">
                        <i class="bi bi-bug" aria-hidden="true"></i>
                        <?= car_t($t, 'common.contact-us.topic.bug') ?>
                    </label>

                    <input type="radio" class="btn-check" name="topic" id="topic-feature" value="Feature request">
                    <label class="btn btn-sm btn-outline-secondary" for="topic-feature">
                        <i class="bi bi-lightbulb" aria-hidden="true"></i>
                        <?= car_t($t, 'common.contact-us.topic.feature') ?>
                    </label>

                    <input type="radio" class="btn-check" name="topic" id="topic-partnership" value="Partnership">
                    <label class="btn btn-sm btn-outline-secondary" for="topic-partnership">
                        <i class="bi bi-handshake" aria-hidden="true"></i>
                        <?= car_t($t, 'common.contact-us.topic.partnership') ?>
                    </label>

                    <input type="radio" class="btn-check" name="topic" id="topic-other" value="Other">
                    <label class="btn btn-sm btn-outline-secondary" for="topic-other">
                        <i class="bi bi-three-dots" aria-hidden="true"></i>
                        <?= car_t($t, 'common.contact-us.topic.other') ?>
                    </label>
                </div>
            </div>

            <!-- mensagem -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-end mb-1">
                    <label class="form-label mb-0" for="contact-message">
                        <?= car_t($t, 'common.contact-us.message-label') ?>
                    </label>
                    <span class="form-text car-text-mono" id="contact-count">0 / 1000</span>
                </div>
                <textarea class="form-control"
                          id="contact-message"
                          name="message"
                          rows="6"
                          maxlength="1000"
                          required
                          placeholder="<?= car_t($t, 'common.contact-us.message-placeholder') ?>"
                          oninput="document.getElementById('contact-count').textContent = this.value.length + ' / 1000'"></textarea>
            </div>

            <div id="form-status" class="mb-3"></div>

            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <?= car_t($t, 'Send') ?>
            </button>
        </form>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form       = document.getElementById('contact-form');
            var statusDiv  = document.getElementById('form-status');
            var msgSending = <?= json_encode(car_t($t, 'common.contact-us.sending')) ?>;
            var msgSuccess = <?= json_encode(car_t($t, 'common.contact-us.status.success')) ?>;
            var msgError   = <?= json_encode(car_t($t, 'common.contact-us.status.error')) ?>;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                var btn = form.querySelector('[type=submit]');
                btn.disabled = true;
                statusDiv.innerHTML = '<p class="text-secondary small mb-0">' + msgSending + '</p>';

                fetch('https://services.onepropage.com.br/contact/action-1.0.3.php', {
                    method: 'POST',
                    body: new FormData(form)
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data && data.success === true) {
                        statusDiv.innerHTML = '<div class="alert alert-success mb-0">' + msgSuccess + '</div>';
                        form.reset();
                    } else {
                        statusDiv.innerHTML = '<div class="alert alert-danger mb-0">' + msgError + '</div>';
                        btn.disabled = false;
                    }
                })
                .catch(function () {
                    statusDiv.innerHTML = '<div class="alert alert-danger mb-0">' + msgError + '</div>';
                    btn.disabled = false;
                });
            });
        });
        </script>

    </div>
</div>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>

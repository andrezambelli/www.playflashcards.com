<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    $pincode_s  = car_get_session_attribute('pincode', '');
    $email      = car_get_session_attribute('email', '');
    $sent_at    = (int) car_get_session_attribute('code_sent_at', 0);
    $remaining  = $sent_at > 0 ? max(0, 60 - (time() - $sent_at)) : 0;

    if (empty($pincode_s)) {
        car_redirect(CAR_PATH_WEB . '/'. $t['lang'] . '/login/login');
    }

    if ($sent_at > 0 && (time() - $sent_at) > 600) {
        car_set_session_attribute('pincode', '');
        car_set_session_attribute('code_sent_at', 0);
        car_set_session_error_message('login.login-pincode-act.expired');
        car_redirect(CAR_PATH_WEB . '/'. $t['lang'] . '/login/login');
    }

    $header_title       = car_t($t, 'login.login-pincode.title') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<div class="car-auth-wrap">
    <div class="car-auth-panel">

        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>

        <div class="car-label-uc mb-2"><?= car_t($t, 'login.login-pincode.label') ?></div>
        <h1 class="mb-0" style="font-size:2rem"><?= car_t($t, 'login.login-pincode.title') ?></h1>
        <p class="text-secondary mt-2 mb-1">
            <?= car_t($t, 'login.login-pincode.sent-to') ?>
            <strong><?= car_htmlspecialchars($email) ?></strong>.
        </p>

        <form action="<?= CAR_PATH_WEB . '/login/login-pincode-act'; ?>" method="post">
            <div class="mb-3">
                <label class="visually-hidden" for="pincode"><?= car_t($t, 'Code') ?></label>
                <input type="text"
                       id="pincode"
                       name="pincode"
                       class="form-control form-control-lg car-pincode-field"
                       maxlength="6"
                       inputmode="numeric"
                       autocomplete="one-time-code"
                       pattern="[0-9]{6}"
                       autofocus />
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100">
                <?= car_t($t, 'Check the Code') ?>
            </button>
        </form>

        <form id="form-resend" action="<?= CAR_PATH_WEB . '/login/login-act' ?>" method="post" style="display:none">
            <input type="hidden" name="email" value="<?= car_htmlspecialchars($email) ?>">
            <input type="hidden" name="redirect_url" value="">
        </form>

        <div class="d-flex justify-content-center gap-4 mt-4">
            <a id="link-resend" href="#"
               class="small text-secondary text-decoration-none">
                <?= car_t($t, 'login.login-pincode.resend-code') ?>
                <span class="car-auth-countdown car-text-mono"></span>
            </a>
            <a id="link-change-email" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/login/login' ?>"
               class="small text-secondary text-decoration-none">
                <?= car_t($t, 'login.login-pincode.change-email') ?>
                <span class="car-auth-countdown car-text-mono"></span>
            </a>
        </div>
        <p class="car-auth-note small text-secondary text-center mt-4 mb-0"><?= car_t($t, 'login.login-pincode.message2') ?></p>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var linkResend = document.getElementById('link-resend');
            var linkChange = document.getElementById('link-change-email');
            var els        = [linkResend, linkChange];
            var countdowns = document.querySelectorAll('.car-auth-countdown');
            var seconds    = <?= (int) $remaining ?>;
            var pincodeInput = document.getElementById('pincode');
            var submitBtn    = document.querySelector('button[type="submit"]');
            var pincodeForm  = submitBtn.closest('form');

            function processPin(val) {
                val = val.replace(/\D/g, '').slice(0, 6);
                pincodeInput.value = val;
                if (val.length === 6) {
                    submitBtn.disabled = true;
                    pincodeForm.submit();
                }
            }

            pincodeInput.addEventListener('input', function () {
                processPin(pincodeInput.value);
            });

            pincodeInput.addEventListener('paste', function (e) {
                e.preventDefault();
                var text = (e.clipboardData || window.clipboardData).getData('text');
                processPin(text);
            });

            pincodeForm.addEventListener('submit', function () {
                submitBtn.disabled = true;
            });

            linkResend.addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('form-resend').submit();
            });

            function lock() {
                els.forEach(function (el) {
                    el.style.pointerEvents = 'none';
                    el.style.opacity = '0.45';
                });
            }
            function unlock() {
                els.forEach(function (el) {
                    el.style.pointerEvents = '';
                    el.style.opacity = '';
                });
                countdowns.forEach(function (el) { el.textContent = ''; });
            }

            if (seconds > 0) {
                lock();
                countdowns.forEach(function (el) { el.textContent = '(' + seconds + ')'; });

                var interval = setInterval(function () {
                    seconds--;
                    countdowns.forEach(function (el) { el.textContent = '(' + seconds + ')'; });
                    if (seconds <= 0) {
                        clearInterval(interval);
                        unlock();
                    }
                }, 1000);
            }
        });
        </script>

    </div>
</div>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>

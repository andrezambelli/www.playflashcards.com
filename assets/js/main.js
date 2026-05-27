/**
 * Aceite de cookies GDPR — esconde o banner e registra no servidor
 */
function setCookieGDPR(url) {
    const banner = document.getElementById('cookie-banner');
    if (banner) banner.remove();

    if (!url) return;

    fetch(url, { method: 'POST' }).catch(() => {});
}

/* Fecha o menu mobile ao clicar fora */
document.addEventListener('click', function (event) {
    const collapse = document.querySelector('.navbar-collapse');
    const toggler  = document.querySelector('.navbar-toggler');
    if (!collapse || !toggler) return;
    if (collapse.classList.contains('show') &&
        !collapse.contains(event.target) &&
        !toggler.contains(event.target)) {
        bootstrap.Collapse.getOrCreateInstance(collapse).hide();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    /* Fecha o menu mobile ao clicar em item do menu */
    const collapse = document.querySelector('.navbar-collapse');
    if (collapse) {
        collapse.querySelectorAll('.nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (collapse.classList.contains('show')) {
                    bootstrap.Collapse.getOrCreateInstance(collapse).hide();
                }
            });
        });
    }

    /* Auto-foco no primeiro input de texto de formulários */
    const firstInput = document.querySelector('form input[type="text"]:first-of-type');
    if (firstInput) firstInput.focus();
});

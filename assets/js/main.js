/* Navbar: oculta ao rolar para baixo e revela ao rolar para cima */
(function () {
    var navbar = document.querySelector('.navbar.fixed-top');
    if (!navbar) return;
    var collapse = navbar.querySelector('.navbar-collapse');
    var lastScrollY = window.scrollY;

    function update() {
        var currentScrollY = window.scrollY;
        var menuOpen = !!(collapse && collapse.classList.contains('show'));

        if (!menuOpen) {
            if (currentScrollY <= 60) {
                navbar.classList.remove('one-navbar-hidden');
            } else if (currentScrollY > lastScrollY) {
                navbar.classList.add('one-navbar-hidden');
            } else {
                navbar.classList.remove('one-navbar-hidden');
            }
        }

        lastScrollY = currentScrollY;
    }

    window.addEventListener('scroll', update, { passive: true });
    navbar.addEventListener('show.bs.collapse', function () {
        navbar.classList.remove('one-navbar-hidden');
    });
    update();
})();

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

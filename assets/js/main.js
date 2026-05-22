/**
 * Recebe um número e adiciona 0 se for menor que 10
 */
function padZero(value) {
    return value < 10 ? '0' + value : value;
}

/**
 * Retorna o timezone do navegador no formato +HH:MM / -HH:MM
 */
function getTimezoneFormated() {
    const offset = new Date().getTimezoneOffset();
    const hours = Math.floor(Math.abs(offset) / 60);
    const minutes = Math.abs(offset) % 60;
    const sign = offset < 0 ? '+' : '-';
    return sign + padZero(hours) + ':' + padZero(minutes);
}

/**
 * Aceite de cookies GDPR — esconde o banner e registra no servidor
 */
function setCookieGDPR(url) {
    const banner = document.getElementById('cookie-banner');
    if (banner) banner.remove();

    if (!url) return;

    fetch(url, { method: 'POST' }).catch(() => {});
}

/* Auto-foco no primeiro input de texto de formulários */
document.addEventListener('DOMContentLoaded', () => {
    const firstInput = document.querySelector('form input[type="text"]:first-of-type');
    if (firstInput) firstInput.focus();
});

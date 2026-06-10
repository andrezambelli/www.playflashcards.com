document.addEventListener('DOMContentLoaded', function () {
    const firstInput = document.querySelector('form input:not([type=hidden])');
    if (firstInput) firstInput.focus();
});

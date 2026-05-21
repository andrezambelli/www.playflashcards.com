<?php
    $tempo_expiracao = time() + (30 * 24 * 60 * 60); // 30 dias

    setcookie('key', 'abc', $tempo_expiracao, '/');


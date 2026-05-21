<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    $header_title = car_t($t, 'common.cookie-settings.title') . ' - Play Flashcards';
    $header_description = car_t($t, 'common.cookie-settings.desc');
    $header_index_follow = 'index,follow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <?php if ($t['lang'] == 'pt-br') { ?>
            <h1>Configurações de Cookies</h1>
            O Play Flashcards utiliza cookies para garantir o funcionamento correto do site e melhorar sua experiência de navegação.<br/>
            <br/>
            <strong>O que são cookies?</strong><br/>
            Cookies são pequenos arquivos de texto armazenados no seu navegador quando você visita um site. Eles permitem que o site lembre suas preferências e mantenha você conectado entre as visitas.<br/>
            <br/>
            <strong>Cookies que utilizamos</strong><br/>
            <br/>
            <strong>Cookie de sessão</strong>: Utilizado para manter você autenticado no Play Flashcards. Sem ele, você precisaria fazer login a cada página acessada. Este cookie é excluído automaticamente ao fechar o navegador.<br/>
            <br/>
            <strong>Cookie de idioma</strong>: Armazena o idioma escolhido para que você não precise selecioná-lo novamente em cada visita.<br/>
            <br/>
            <strong>Cookie de fuso horário</strong>: Armazena o fuso horário do seu dispositivo para exibir datas e horários corretamente.<br/>
            <br/>
            <strong>Cookies de terceiros</strong>: Não utilizamos cookies de rastreamento ou publicidade de terceiros.<br/>
            <br/>
            <strong>Como gerenciar os cookies</strong><br/>
            Você pode configurar seu navegador para bloquear ou excluir cookies. Porém, bloquear o cookie de sessão impedirá que você faça login no site.<br/>
            <br/>
            Atualizado em: 2024/01/01<br/>
        <?php } else { ?>
            <h1>Cookie Settings</h1>
            Play Flashcards uses cookies to ensure the website works correctly and to improve your browsing experience.<br/>
            <br/>
            <strong>What are cookies?</strong><br/>
            Cookies are small text files stored in your browser when you visit a website. They allow the site to remember your preferences and keep you logged in between visits.<br/>
            <br/>
            <strong>Cookies we use</strong><br/>
            <br/>
            <strong>Session cookie</strong>: Used to keep you authenticated on Play Flashcards. Without it, you would need to log in on every page you visit. This cookie is automatically deleted when you close your browser.<br/>
            <br/>
            <strong>Language cookie</strong>: Stores your chosen language so you do not need to select it again on each visit.<br/>
            <br/>
            <strong>Timezone cookie</strong>: Stores your device timezone to display dates and times correctly.<br/>
            <br/>
            <strong>Third-party cookies</strong>: We do not use any tracking or advertising cookies from third parties.<br/>
            <br/>
            <strong>How to manage cookies</strong><br/>
            You can configure your browser to block or delete cookies. However, blocking the session cookie will prevent you from logging in to the site.<br/>
            <br/>
            Updated: 2024/01/01<br/>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>

<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_language($t['lang']); ?>
<?php
    $header_title = cal_t($t, 'common.privacy.title') . ' - Play Flashcards';
    $header_description = cal_t($t, 'common.privacy.desc');
    $header_index_follow = 'index,follow';
    include_once CAL_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <?php if ($t['lang'] == 'pt-br') { ?>
            <h1>Política de Privacidade</h1>
            O Play Flashcards está comprometido em proteger sua privacidade. Esta Política de Privacidade descreve como coletamos, usamos e protegemos suas informações pessoais.<br/>
            <br/>
            <strong>Informações Coletadas</strong>: Ao utilizar o site e criar uma conta, o Play Flashcards coleta e armazena somente o seu endereço e o idioma do seu navegador para fornecer os serviços do site.<br/>
            <br/>
            <strong>Uso das Informações</strong>: Utilizamos suas informações para personalizar sua experiência no site, enviar notificações relevantes e melhorar nossos serviços.<br/>
            <br/>
            <strong>Compartilhamento de Informações</strong>: Não compartilhamos suas informações pessoais com terceiros, exceto quando necessário para fornecer os serviços solicitados ou conforme exigido por lei.<br/>
            <br/>
            <strong>Segurança</strong>: Implementamos medidas de segurança para proteger suas informações contra acesso não autorizado ou uso indevido.<br/>
            <br/>
            <strong>Cookies</strong>: Utilizamos cookies para melhorar a funcionalidade do site e aprimorar sua experiência de uso. Basicamente utilizamos cookie para armazenar sua sessão e manter seu usuário logado no Play Flashcards.<br/>
            <br/>
            <strong>Alterações na Política de Privacidade</strong>: Podemos atualizar esta Política de Privacidade conforme necessário. Quaisquer alterações serão publicadas nesta página.<br/>
            <br/>
            Atualizado em: 2023/08/02<br/>
        <?php } else { ?>
            <h1>Privacy Policy</h1>
            Play Flashcards is committed to protecting your privacy. This Privacy Policy describes how we collect, use and protect your personal information.<br/>
            <br/>
            <strong>Information Collected</strong>: When using the site and creating an account, Play Flashcards collects and stores only your address and the language of your browser to provide the services of the site.<br/>
            <br/>
            <strong>Use of Information</strong>: We use your information to customize your website experience, send you relevant notifications, and improve our services.<br/>
            <br/>
            <strong>Information Sharing</strong>: We do not share your personal information with third parties, except as necessary to provide you with requested services or as required by law.<br/>
            <br/>
            <strong>Security</strong>: We implement security measures to protect your information from unauthorized access or misuse.<br/>
            <br/>
            <strong>Cookies</strong>: We use cookies to improve the functionality of the website and enhance your user experience. Basically, we use a cookie to store your session and keep your user logged into Play Flashcards.<br/>
            <br/>
            <strong>Privacy Policy Changes</strong>: We may update this Privacy Policy as needed. Any changes will be posted on this page.<br/>
            <br/>
            Updated: 2023/08/02<br/>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>˙
<?php include_once CAL_ROOT_WEB . '/containers/footer.inc';?>

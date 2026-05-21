<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_language($t['lang']); ?>
<?php
    $header_title = cal_t($t, 'common.terms.title') . ' - Play Flashcards';
    $header_description = cal_t($t, 'common.terms.desc');
    $header_index_follow = 'index,follow';
    include_once CAL_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <?php if ($t['lang'] == 'pt-br') { ?>
            <h1>Termos e Condições de Uso</h1>
            Ao acessar e utilizar o Play Flashcards, você concorda em cumprir estes Termos e Condições de Uso.<br/>
            <br/>
            <strong>Uso do Site</strong>: O Play Flashcards oferece um serviço de criação de cartões de estudo. Ao criar uma conta e utilizar o site, você concorda em usar o serviço apenas para fins pessoais, educacionais e legais.<br/>
            <br/>
            <strong>Responsabilidade do Usuário</strong>: Você é responsável por manter suas informações de conta atualizadas e garantir que o conteúdo criado esteja em conformidade com as leis aplicáveis. O Play Flashcards não se responsabiliza por qualquer conteúdo criado pelos usuários.<br/>
            <br/>
            <strong>Privacidade</strong>: Respeitamos a sua privacidade. Consulte nossa Política de Privacidade para entender como coletamos, usamos e protegemos suas informações pessoais.<br/>
            <br/>
            <strong>Propriedade Intelectual</strong>: O conteúdo e recursos disponíveis no Play Flashcards são protegidos por direitos autorais e outras leis de propriedade intelectual. Não é permitido copiar, modificar, distribuir ou explorar comercialmente qualquer conteúdo sem permissão expressa.<br/>
            <br/>
            <strong>Grupos de Estudo Públicos</strong>: Ao criar um grupo de estudo público no Play Flashcards, você concorda que o conteúdo desse grupo, incluindo o nome do grupo, a descrição e os cartões de estudo associados, poderá ser compartilhado publicamente na internet. Isso significa que qualquer pessoa poderá visualizar, acessar e estudar o conteúdo do grupo de estudo público.<br/>
            <br/>
            <strong>Rescisão</strong>: Reservamo-nos o direito de suspender ou encerrar sua conta e acesso ao site, caso haja violação destes Termos e Condições.<br/>
            <br/>
            <strong>Alterações nos Termos</strong>: Podemos atualizar estes Termos e Condições de Uso periodicamente. Recomendamos que você verifique esta página regularmente para ficar atualizado sobre quaisquer alterações.<br/>
            <br/>
            Atualizado em: 2023/08/02<br/>
        <?php } else { ?>
            <h1>Terms and Conditions of Use</h1>
            By accessing and using Play Flashcards, you agree to abide by these Terms and Conditions of Use.<br/>
            <br/>
            <strong>Site Usage</strong>: Play Flashcards offers a flashcard creation service. By creating an account and using the site, you agree to use the service for personal, educational and legal purposes only.<br/>
            <br/>
            <strong>User Responsibility</strong>: You are responsible for keeping your account information up to date and ensuring that content you create complies with applicable laws. Play Flashcards is not responsible for any content created by users.<br/>
            <br/>
            <strong>Privacy</strong>: We respect your privacy. Please see our Privacy Policy to understand how we collect, use and protect your personal information.<br/>
            <br/>
            <strong>Intellectual Property</strong>: The content and features available on Play Flashcards are protected by copyright and other intellectual property laws. It is not allowed to copy, modify, distribute or commercially exploit any content without express permission.<br/>
            <br/>
            <strong>Public Study Groups</strong>: By creating a public study group on Play Flashcards, you agree that the group's content, including the group name, description, and associated study cards, may be shared publicly on the internet. This means that anyone will be able to view, access and study the content of the public study group.<br/>
            <br/>
            <strong>Termination</strong>: We reserve the right to suspend or terminate your account and access to the website if you violate these Terms and Conditions.<br/>
            <br/>
            <strong>Changes to Terms</strong>: We may update these Terms and Conditions of Use from time to time. We recommend that you check this page regularly to stay up to date on any changes.<br/>
            <br/>
            Updated: 2023/08/02<br/>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>˙
<?php include_once CAL_ROOT_WEB . '/containers/footer.inc';?>

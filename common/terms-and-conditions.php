<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php

$page_h1              = '';
$page_subtitle        = '';
$sidebar_on_this_page = '';
$sidebar_questions    = '';
$sidebar_questions_desc = '';
$sections             = [];

switch ($t['lang']) {

    case 'pt-br':
        $page_h1       = 'Termos e Condições de Uso';
        $page_subtitle = 'Ao acessar e utilizar o Play Flashcards, você concorda em cumprir estes Termos e Condições de Uso.';
        $sidebar_on_this_page   = 'Nesta página';
        $sidebar_questions      = 'Dúvidas?';
        $sidebar_questions_desc = 'Entre em contato com nossa equipe.';
        $sections = [
            ['id' => 'usage',                'title' => 'Uso do Site',
             'content' => '<p>O Play Flashcards oferece um serviço de criação e estudo de flashcards. Ao criar uma conta e utilizar o site, você concorda em usar o serviço apenas para fins pessoais, educacionais e legais.</p>'],
            ['id' => 'responsibility',       'title' => 'Responsabilidade do Usuário',
             'content' => '<p>Você é responsável por manter suas informações de conta atualizadas e garantir que o conteúdo criado esteja em conformidade com as leis aplicáveis. O Play Flashcards não se responsabiliza por qualquer conteúdo criado pelos usuários.</p>'],
            ['id' => 'privacy',              'title' => 'Privacidade',
             'content' => '<p>Respeitamos a sua privacidade. Consulte nossa <a href="' . CAR_PATH_WEB . '/' . 'pt-br/privacy-policy">Política de Privacidade</a> para entender como coletamos, usamos e protegemos suas informações pessoais.</p>'],
            ['id' => 'intellectual-property','title' => 'Propriedade Intelectual',
             'content' => '<p>O conteúdo e os recursos disponíveis no Play Flashcards são protegidos por direitos autorais e outras leis de propriedade intelectual. Não é permitido copiar, modificar, distribuir ou explorar comercialmente qualquer conteúdo sem permissão expressa.</p>'],
            ['id' => 'public-decks',         'title' => 'Baralhos Públicos',
             'content' => '<p>Ao criar um baralho público no Play Flashcards, você concorda que o conteúdo desse baralho, incluindo o nome, a descrição e os cartões associados, poderá ser compartilhado publicamente na internet. Qualquer pessoa poderá visualizar, acessar e estudar o conteúdo do baralho público.</p>'],
            ['id' => 'termination',          'title' => 'Rescisão',
             'content' => '<p>Reservamo-nos o direito de suspender ou encerrar sua conta e acesso ao site, caso haja violação destes Termos e Condições.</p>'],
            ['id' => 'changes',              'title' => 'Alterações nos Termos',
             'content' => '<p>Podemos atualizar estes Termos e Condições de Uso periodicamente. Recomendamos verificar esta página regularmente para se manter atualizado sobre quaisquer alterações.</p>'],
        ];
        break;

    case 'es':
        $page_h1       = 'Términos y Condiciones de Uso';
        $page_subtitle = 'Al acceder y utilizar Play Flashcards, aceptas cumplir con estos Términos y Condiciones de Uso.';
        $sidebar_on_this_page   = 'En esta página';
        $sidebar_questions      = 'Preguntas?';
        $sidebar_questions_desc = 'Contacta a nuestro equipo.';
        $sections = [
            ['id' => 'usage',                'title' => 'Uso del sitio',
             'content' => '<p>Play Flashcards ofrece un servicio de creación y estudio de tarjetas de memoria. Al crear una cuenta y utilizar el sitio, aceptas usar el servicio únicamente para fines personales, educativos y legales.</p>'],
            ['id' => 'responsibility',       'title' => 'Responsabilidad del usuario',
             'content' => '<p>Eres responsable de mantener actualizada la información de tu cuenta y de asegurarte de que el contenido que crees cumpla con las leyes aplicables. Play Flashcards no se responsabiliza por ningún contenido creado por los usuarios.</p>'],
            ['id' => 'privacy',              'title' => 'Privacidad',
             'content' => '<p>Respetamos tu privacidad. Consulta nuestra <a href="' . CAR_PATH_WEB . '/' . 'es/privacy-policy">Política de Privacidad</a> para entender cómo recopilamos, usamos y protegemos tu información personal.</p>'],
            ['id' => 'intellectual-property','title' => 'Propiedad intelectual',
             'content' => '<p>El contenido y las funciones disponibles en Play Flashcards están protegidos por derechos de autor y otras leyes de propiedad intelectual. No está permitido copiar, modificar, distribuir ni explotar comercialmente ningún contenido sin permiso expreso.</p>'],
            ['id' => 'public-decks',         'title' => 'Mazos públicos',
             'content' => '<p>Al crear un mazo público en Play Flashcards, aceptas que el contenido de ese mazo, incluyendo el nombre, la descripción y las tarjetas asociadas, puede compartirse públicamente en internet. Cualquier persona podrá ver, acceder y estudiar el contenido del mazo público.</p>'],
            ['id' => 'termination',          'title' => 'Terminación',
             'content' => '<p>Nos reservamos el derecho de suspender o cancelar tu cuenta y acceso al sitio si incumples estos Términos y Condiciones.</p>'],
            ['id' => 'changes',              'title' => 'Cambios en los términos',
             'content' => '<p>Podemos actualizar estos Términos y Condiciones de Uso periódicamente. Recomendamos consultar esta página con regularidad para mantenerte al día con cualquier cambio.</p>'],
        ];
        break;

    case 'fr':
        $page_h1       = "Conditions Générales d'Utilisation";
        $page_subtitle = "En accédant et en utilisant Play Flashcards, vous acceptez de respecter ces Conditions Générales d'Utilisation.";
        $sidebar_on_this_page   = 'Sur cette page';
        $sidebar_questions      = 'Des questions?';
        $sidebar_questions_desc = 'Contactez notre équipe.';
        $sections = [
            ['id' => 'usage',                'title' => 'Utilisation du site',
             'content' => "<p>Play Flashcards propose un service de création et d'étude de cartes mémoire. En créant un compte et en utilisant le site, vous acceptez d'utiliser le service uniquement à des fins personnelles, éducatives et légales.</p>"],
            ['id' => 'responsibility',       'title' => "Responsabilité de l'utilisateur",
             'content' => "<p>Vous êtes responsable de maintenir vos informations de compte à jour et de vous assurer que le contenu que vous créez est conforme aux lois applicables. Play Flashcards n'est pas responsable du contenu créé par les utilisateurs.</p>"],
            ['id' => 'privacy',              'title' => 'Vie privée',
             'content' => '<p>Nous respectons votre vie privée. Veuillez consulter notre <a href="' . CAR_PATH_WEB . '/' . 'fr/privacy-policy">Politique de confidentialité</a> pour comprendre comment nous collectons, utilisons et protégeons vos informations personnelles.</p>'],
            ['id' => 'intellectual-property','title' => 'Propriété intellectuelle',
             'content' => "<p>Le contenu et les fonctionnalités disponibles sur Play Flashcards sont protégés par le droit d'auteur et d'autres lois sur la propriété intellectuelle. Il n'est pas permis de copier, modifier, distribuer ou exploiter commercialement tout contenu sans autorisation expresse.</p>"],
            ['id' => 'public-decks',         'title' => 'Paquets publics',
             'content' => "<p>En créant un paquet public sur Play Flashcards, vous acceptez que le contenu de ce paquet, y compris le nom, la description et les cartes associées, puisse être partagé publiquement sur internet. N'importe qui pourra consulter, accéder et étudier le contenu du paquet public.</p>"],
            ['id' => 'termination',          'title' => 'Résiliation',
             'content' => '<p>Nous nous réservons le droit de suspendre ou de résilier votre compte et votre accès au site en cas de violation de ces Conditions.</p>'],
            ['id' => 'changes',              'title' => 'Modifications des conditions',
             'content' => '<p>Nous pouvons mettre à jour ces Conditions Générales à tout moment. Nous vous recommandons de consulter cette page régulièrement pour rester informé de tout changement.</p>'],
        ];
        break;

    default: // en
        $page_h1       = 'Terms and Conditions of Use';
        $page_subtitle = 'By accessing and using Play Flashcards, you agree to abide by these Terms and Conditions of Use.';
        $sidebar_on_this_page   = 'On this page';
        $sidebar_questions      = 'Questions?';
        $sidebar_questions_desc = 'Reach our support team.';
        $sections = [
            ['id' => 'usage',                'title' => 'Site usage',
             'content' => '<p>Play Flashcards offers a flashcard creation and study service. By creating an account and using the site, you agree to use the service for personal, educational and legal purposes only.</p>'],
            ['id' => 'responsibility',       'title' => 'User responsibility',
             'content' => '<p>You are responsible for keeping your account information up to date and ensuring that content you create complies with applicable laws. Play Flashcards is not responsible for any content created by users.</p>'],
            ['id' => 'privacy',              'title' => 'Privacy',
             'content' => '<p>We respect your privacy. Please see our <a href="' . CAR_PATH_WEB . '/en/privacy-policy">Privacy Policy</a> to understand how we collect, use and protect your personal information.</p>'],
            ['id' => 'intellectual-property','title' => 'Intellectual property',
             'content' => '<p>The content and features available on Play Flashcards are protected by copyright and other intellectual property laws. It is not permitted to copy, modify, distribute or commercially exploit any content without express permission.</p>'],
            ['id' => 'public-decks',         'title' => 'Public decks',
             'content' => '<p>By creating a public deck on Play Flashcards, you agree that the content of that deck, including the deck name, description and associated flashcards, may be shared publicly on the internet. Anyone will be able to view, access and study the content of that public deck.</p>'],
            ['id' => 'termination',          'title' => 'Termination',
             'content' => '<p>We reserve the right to suspend or terminate your account and access to the site if you violate these Terms and Conditions.</p>'],
            ['id' => 'changes',              'title' => 'Changes to terms',
             'content' => '<p>We may update these Terms and Conditions of Use from time to time. We recommend checking this page regularly to stay up to date on any changes.</p>'],
        ];
}

$header_title        = $page_h1 . ' - Play Flashcards';
$header_description  = car_t($t, 'common.terms.desc');
$header_index_follow = 'index,follow';
$header_hreflang_slug = 'terms-and-conditions';
include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<main class="container py-5">

    <!-- título -->
    <h1 class="mb-3" style="font-size:clamp(2rem,5vw,3rem);letter-spacing:-0.025em;line-height:1.1">
        <?= car_htmlspecialchars($page_h1) ?>
    </h1>
    <p class="text-secondary mb-5" style="font-size:1rem;max-width:600px;line-height:1.65">
        <?= car_htmlspecialchars($page_subtitle) ?>
    </p>

    <div class="row g-5">

        <!-- sidebar TOC -->
        <div class="col-lg-3">
            <div class="car-doc-sidebar">
                <p class="car-label-uc mb-3"><?= car_htmlspecialchars($sidebar_on_this_page) ?></p>
                <nav class="car-doc-toc mb-4" aria-label="<?= car_htmlspecialchars($sidebar_on_this_page) ?>">
                    <?php foreach ($sections as $i => $section) { ?>
                    <a href="#<?= car_htmlspecialchars($section['id']) ?>">
                        <span class="car-doc-toc-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                        <?= car_htmlspecialchars($section['title']) ?>
                    </a>
                    <?php } ?>
                </nav>

                <!-- card de dúvidas: visível apenas no desktop (mobile fica no fim da página) -->
                <div class="card p-3 d-none d-lg-block">
                    <p class="fw-semibold small mb-1"><?= car_htmlspecialchars($sidebar_questions) ?></p>
                    <p class="small text-secondary mb-3"><?= car_htmlspecialchars($sidebar_questions_desc) ?></p>
                    <a class="btn btn-sm btn-outline-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/contact-us' ?>">
                        <i class="bi bi-envelope" aria-hidden="true"></i>
                        <?= car_t($t, 'Contact us') ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- seções -->
        <div class="col-lg-9">

            <?php foreach ($sections as $i => $section) { ?>
            <section id="<?= car_htmlspecialchars($section['id']) ?>" class="car-doc-section">
                <span class="car-label-uc text-primary d-block mb-2"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                <h2 class="mb-3" style="font-size:1.375rem;letter-spacing:-0.015em">
                    <?= car_htmlspecialchars($section['title']) ?>
                </h2>
                <div class="text-secondary" style="line-height:1.75">
                    <?= $section['content'] ?>
                </div>
            </section>
            <?php } ?>

            <!-- card de dúvidas: visível apenas no mobile (desktop fica na sidebar) -->
            <div class="card p-3 mt-4 d-lg-none">
                <p class="fw-semibold small mb-1"><?= car_htmlspecialchars($sidebar_questions) ?></p>
                <p class="small text-secondary mb-3"><?= car_htmlspecialchars($sidebar_questions_desc) ?></p>
                <a class="btn btn-sm btn-outline-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/contact-us' ?>">
                    <i class="bi bi-envelope" aria-hidden="true"></i>
                    <?= car_t($t, 'Contact us') ?>
                </a>
            </div>
        </div>

    </div>
</main>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>

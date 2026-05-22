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
        $page_h1       = 'Política de Privacidade';
        $page_subtitle = 'O Play Flashcards se compromete a proteger sua privacidade. Esta política descreve o que coletamos, como usamos e os controles que você tem.';
        $sidebar_on_this_page   = 'Nesta página';
        $sidebar_questions      = 'Dúvidas?';
        $sidebar_questions_desc = 'Entre em contato com nossa equipe.';
        $sections = [
            ['id' => 'information', 'title' => 'Informações Coletadas',
             'content' => '<p>Ao usar o site e criar uma conta, o Play Flashcards coleta e armazena apenas o seu endereço de e-mail e a preferência de idioma do seu navegador, para fornecer os serviços do site.</p><p>Podemos também coletar dados de uso não identificáveis, como quais baralhos você estuda e quais recursos utiliza, para melhorar o produto. Esses dados não estão vinculados à sua conta.</p>'],
            ['id' => 'use',         'title' => 'Uso das Informações',
             'content' => '<p>Utilizamos suas informações para personalizar sua experiência no site, enviar notificações relevantes (somente as que você optou por receber) e melhorar nossos serviços.</p>'],
            ['id' => 'sharing',     'title' => 'Compartilhamento de Informações',
             'content' => '<p>Não compartilhamos suas informações pessoais com terceiros, exceto quando necessário para fornecer os serviços solicitados ou conforme exigido por lei.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lock-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">Não vendemos seus dados. Nunca.</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Sem redes de publicidade, sem perfis comportamentais, sem corretores de dados.</p></div></div>'],
            ['id' => 'security',    'title' => 'Segurança',
             'content' => '<p>Implementamos medidas de segurança para proteger suas informações contra acesso não autorizado ou uso indevido, incluindo criptografia em trânsito (TLS 1.3), criptografia em repouso e auditorias regulares de segurança. Senhas de conta nunca são armazenadas. Utilizamos apenas códigos de acesso enviados por e-mail.</p>'],
            ['id' => 'cookies',     'title' => 'Cookies',
             'content' => '<p>Utilizamos cookies para melhorar a funcionalidade do site e aprimorar sua experiência de uso.</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Cookie</th><th>Finalidade</th><th>Duração</th></tr></thead><tbody><tr><td class="font-monospace small">pf_session</td><td>Mantém você conectado.</td><td>30 dias</td></tr><tr><td class="font-monospace small">pf_lang</td><td>Lembra seu idioma.</td><td>1 ano</td></tr><tr><td class="font-monospace small">pf_theme</td><td>Lembra a preferência de tema claro/escuro.</td><td>1 ano</td></tr></tbody></table></div>'],
            ['id' => 'changes',     'title' => 'Alterações na Política',
             'content' => '<p>Podemos atualizar esta Política de Privacidade conforme necessário. Quaisquer alterações serão publicadas nesta página. Recomendamos verificar esta página periodicamente para se manter informado.</p>'],
        ];
        break;

    case 'es':
        $page_h1       = 'Política de Privacidad';
        $page_subtitle = 'Play Flashcards se compromete a proteger tu privacidad. Esta política describe qué recopilamos, cómo lo usamos y los controles que tienes.';
        $sidebar_on_this_page   = 'En esta página';
        $sidebar_questions      = 'Preguntas?';
        $sidebar_questions_desc = 'Contacta a nuestro equipo.';
        $sections = [
            ['id' => 'information', 'title' => 'Información recopilada',
             'content' => '<p>Al usar el sitio y crear una cuenta, Play Flashcards recopila y almacena únicamente tu dirección de correo electrónico y la preferencia de idioma de tu navegador, para proporcionar los servicios del sitio.</p><p>También podemos recopilar datos de uso no identificables, como qué mazos estudias y qué funciones utilizas, para mejorar el producto. Estos datos no están vinculados a tu cuenta.</p>'],
            ['id' => 'use',         'title' => 'Uso de la información',
             'content' => '<p>Utilizamos tu información para personalizar tu experiencia en el sitio, enviarte notificaciones relevantes (solo las que hayas activado) y mejorar nuestros servicios.</p>'],
            ['id' => 'sharing',     'title' => 'Compartir información',
             'content' => '<p>No compartimos tu información personal con terceros, excepto cuando sea necesario para proporcionarte los servicios solicitados o según lo exija la ley.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lock-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">No vendemos tus datos. Nunca.</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Sin redes publicitarias, sin perfiles de comportamiento, sin intermediarios de datos.</p></div></div>'],
            ['id' => 'security',    'title' => 'Seguridad',
             'content' => '<p>Implementamos medidas de seguridad para proteger tu información contra el acceso no autorizado o el uso indebido, incluyendo cifrado en tránsito (TLS 1.3), cifrado en reposo y auditorías de seguridad periódicas. Las contraseñas de las cuentas nunca se almacenan. Usamos únicamente códigos de acceso enviados por correo electrónico.</p>'],
            ['id' => 'cookies',     'title' => 'Cookies',
             'content' => '<p>Utilizamos cookies para mejorar la funcionalidad del sitio web y tu experiencia de usuario.</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Cookie</th><th>Finalidad</th><th>Duración</th></tr></thead><tbody><tr><td class="font-monospace small">pf_session</td><td>Te mantiene conectado.</td><td>30 días</td></tr><tr><td class="font-monospace small">pf_lang</td><td>Recuerda tu idioma.</td><td>1 año</td></tr><tr><td class="font-monospace small">pf_theme</td><td>Recuerda la preferencia de tema claro/oscuro.</td><td>1 año</td></tr></tbody></table></div>'],
            ['id' => 'changes',     'title' => 'Cambios en la política',
             'content' => '<p>Podemos actualizar esta Política de Privacidad según sea necesario. Cualquier cambio se publicará en esta página. Recomendamos consultar esta página ocasionalmente para mantenerte informado.</p>'],
        ];
        break;

    case 'fr':
        $page_h1       = 'Politique de confidentialité';
        $page_subtitle = "Play Flashcards s'engage à protéger votre vie privée. Cette politique décrit ce que nous collectons, comment nous l'utilisons et les contrôles dont vous disposez.";
        $sidebar_on_this_page   = 'Sur cette page';
        $sidebar_questions      = 'Des questions?';
        $sidebar_questions_desc = 'Contactez notre équipe.';
        $sections = [
            ['id' => 'information', 'title' => 'Informations collectées',
             'content' => "<p>En utilisant le site et en créant un compte, Play Flashcards collecte et stocke uniquement votre adresse e-mail et la préférence de langue de votre navigateur, afin de fournir les services du site.</p><p>Nous pouvons également collecter des données d'utilisation non identifiables, telles que les paquets que vous étudiez et les fonctionnalités que vous utilisez, afin d'améliorer le produit. Ces données ne sont pas liées à votre compte.</p>"],
            ['id' => 'use',         'title' => 'Utilisation des informations',
             'content' => '<p>Nous utilisons vos informations pour personnaliser votre expérience sur le site, vous envoyer des notifications pertinentes (uniquement celles auxquelles vous avez choisi de vous abonner) et améliorer nos services.</p>'],
            ['id' => 'sharing',     'title' => 'Partage des informations',
             'content' => '<p>Nous ne partageons pas vos informations personnelles avec des tiers, sauf si nécessaire pour vous fournir les services demandés ou si requis par la loi.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lock-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">Nous ne vendons pas vos données. Jamais.</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Pas de réseaux publicitaires, pas de profilage comportemental, pas de courtiers en données.</p></div></div>'],
            ['id' => 'security',    'title' => 'Sécurité',
             'content' => '<p>Nous mettons en oeuvre des mesures de sécurité pour protéger vos informations contre tout accès non autorisé ou toute utilisation abusive, notamment le chiffrement en transit (TLS 1.3), le chiffrement au repos et des audits de sécurité réguliers. Les mots de passe des comptes ne sont jamais stockés. Nous utilisons uniquement des codes d\'accès envoyés par e-mail.</p>'],
            ['id' => 'cookies',     'title' => 'Cookies',
             'content' => '<p>Nous utilisons des cookies pour améliorer les fonctionnalités du site web et votre expérience utilisateur.</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Cookie</th><th>Finalité</th><th>Durée</th></tr></thead><tbody><tr><td class="font-monospace small">pf_session</td><td>Vous maintient connecté.</td><td>30 jours</td></tr><tr><td class="font-monospace small">pf_lang</td><td>Mémorise votre langue.</td><td>1 an</td></tr><tr><td class="font-monospace small">pf_theme</td><td>Mémorise la préférence de thème clair/sombre.</td><td>1 an</td></tr></tbody></table></div>'],
            ['id' => 'changes',     'title' => 'Modifications de la politique',
             'content' => '<p>Nous pouvons mettre à jour cette Politique de confidentialité si nécessaire. Toute modification sera publiée sur cette page. Nous vous recommandons de consulter cette page occasionnellement pour rester informé.</p>'],
        ];
        break;

    default: // en
        $page_h1       = 'Privacy Policy';
        $page_subtitle = 'Play Flashcards is committed to protecting your privacy. This policy describes what we collect, how we use it, and the controls you have.';
        $sidebar_on_this_page   = 'On this page';
        $sidebar_questions      = 'Questions?';
        $sidebar_questions_desc = 'Reach our privacy team.';
        $sections = [
            ['id' => 'information', 'title' => 'Information collected',
             'content' => '<p>When using the site and creating an account, Play Flashcards collects and stores only your email address and the language preference of your browser, to provide the services of the site.</p><p>We may also collect non-identifiable usage data, such as which decks you study and which features you use, to improve the product. This data is not linked to your account.</p>'],
            ['id' => 'use',         'title' => 'Use of information',
             'content' => '<p>We use your information to customize your website experience, send you relevant notifications (only the ones you have opted into), and improve our services.</p>'],
            ['id' => 'sharing',     'title' => 'Information sharing',
             'content' => '<p>We do not share your personal information with third parties, except as necessary to provide you with requested services or as required by law.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lock-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">We don\'t sell your data. Ever.</p><p class="small mb-0" style="color:var(--bs-secondary-color)">No advertising networks, no behavioral profiling, no data brokers.</p></div></div>'],
            ['id' => 'security',    'title' => 'Security',
             'content' => '<p>We implement security measures to protect your information from unauthorized access or misuse, including encryption in transit (TLS 1.3), encryption at rest, and regular security audits. Account passwords are never stored. We use one-time email codes only.</p>'],
            ['id' => 'cookies',     'title' => 'Cookies',
             'content' => '<p>We use cookies to improve the functionality of the website and enhance your user experience.</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Cookie</th><th>Purpose</th><th>Duration</th></tr></thead><tbody><tr><td class="font-monospace small">pf_session</td><td>Keeps you signed in.</td><td>30 days</td></tr><tr><td class="font-monospace small">pf_lang</td><td>Remembers your language.</td><td>1 year</td></tr><tr><td class="font-monospace small">pf_theme</td><td>Remembers light/dark preference.</td><td>1 year</td></tr></tbody></table></div>'],
            ['id' => 'changes',     'title' => 'Policy changes',
             'content' => '<p>We may update this Privacy Policy as needed. Any changes will be posted on this page. We recommend checking this page occasionally to stay informed.</p>'],
        ];
}

$header_title        = $page_h1 . ' - Play Flashcards';
$header_description  = car_t($t, 'common.privacy.desc');
$header_index_follow = 'index,follow';
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

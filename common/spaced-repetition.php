<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php

$page_h1              = '';
$page_subtitle        = '';
$sidebar_on_this_page = '';
$sidebar_cta_title    = '';
$sidebar_cta_desc     = '';
$sidebar_cta_btn      = '';
$header_description   = '';
$header_canonical     = '';
$sections             = [];

switch ($t['lang']) {

    case 'en':
        $page_h1              = 'Spaced Repetition (SRS)';
        $page_subtitle        = 'Studying more isn\'t studying better. Spaced repetition is the scientific technique that helps you remember more with less review time.';
        $sidebar_on_this_page = 'On this page';
        $sidebar_cta_title    = 'Try it now';
        $sidebar_cta_desc     = 'Create a free account and start studying with SRS.';
        $sidebar_cta_btn      = 'Create account';
        $header_description   = 'Learn how spaced repetition works in Play Flashcards: the review criteria, configurable parameters, and the science behind the technique.';
        $header_canonical     = 'https://www.playflashcards.com/en/spaced-repetition/';
        $sections = [
            ['id' => 'what-it-is', 'title' => 'What is spaced repetition',
             'content' => '<p>Spaced repetition (SRS) is a memorization technique based on how the human brain learns and forgets. Instead of reviewing all content uniformly, you focus on the cards you haven\'t mastered yet and set aside those already fixed in memory.</p><p>The scientific basis comes from the <strong>forgetting curve</strong>, described by psychologist Hermann Ebbinghaus in the 19th century: without review, we forget most new information within hours or days. Spaced repetition interrupts this process by reviewing content at the right moment, before forgetting sets in.</p><p>The practical result: you learn faster, retain longer, and spend less time reviewing what you already know.</p>'],
            ['id' => 'how-it-works', 'title' => 'How Play Flashcards applies SRS',
             'content' => '<p>In Play Flashcards, each card accumulates three metrics across your study sessions:</p><ul><li><strong>Accuracy rate:</strong> the percentage of times you answered correctly over time.</li><li><strong>Consecutive correct answers:</strong> how many times in a row you answered correctly without any mistake.</li><li><strong>Last study date:</strong> when the card was last studied.</li></ul><p>These three metrics form a picture of your mastery of each card. When any one of them signals that the card needs attention, it becomes <strong>pending</strong>.</p>'],
            ['id' => 'when-pending', 'title' => 'When a card becomes pending',
             'content' => '<p>A card is <strong>pending</strong> when the SRS identifies that it needs to be reviewed. This happens if <strong>any</strong> of the following conditions is true:</p><ul><li>The accuracy rate is below the configured minimum.</li><li>The consecutive correct answers count is below the configured minimum.</li><li>The card has not been studied for more days than the configured interval.</li></ul><p>This criterion is intentional: a card you answer correctly often but haven\'t seen in weeks is still <strong>pending</strong>. Likewise, a card with a good historical rate that you missed in recent sessions becomes <strong>pending</strong> again immediately.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">A mistake resets the sequence</p><p class="small mb-0" style="color:var(--bs-secondary-color)">A single mistake resets the consecutive correct answers to zero. This ensures you only truly master a card when you answer consistently, not by luck.</p></div></div>'],
            ['id' => 'settings', 'title' => 'The parameters you control',
             'content' => '<p>Play Flashcards SRS has four configurable parameters in your profile, all with default values designed for most use cases:</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Parameter</th><th>Default</th><th>What it controls</th></tr></thead><tbody><tr><td class="fw-semibold small">Accuracy rate</td><td class="font-monospace small">75%</td><td>Below this percentage, the card remains <strong>pending</strong>.</td></tr><tr><td class="fw-semibold small">Consecutive correct answers</td><td class="font-monospace small">5</td><td>Minimum consecutive correct answers with no mistakes.</td></tr><tr><td class="fw-semibold small">Study frequency</td><td class="font-monospace small">7 days</td><td>Cards not studied within this period become <strong>pending</strong> again, even if already mastered.</td></tr><tr><td class="fw-semibold small">Cards per session</td><td class="font-monospace small">20 cards</td><td>Maximum number of cards per SRS study session.</td></tr></tbody></table></div><p class="mt-3">You can adjust these values to match your learning pace. Those who study daily can reduce the study frequency interval; those with a large deck can increase the cards per session limit.</p>'],
            ['id' => 'study-session', 'title' => 'What an SRS study session looks like',
             'content' => '<p>When you start an SRS session on a deck, Play Flashcards automatically selects the <strong>pending</strong> cards, shuffles them, and presents them one by one. For each card you see the front, decide your answer mentally, and reveal the back to check.</p><p>You then indicate whether you got it right or wrong. That answer is recorded immediately and updates the card\'s three metrics. At the end of the session, the system shows your result: how many cards you got right and how many you missed.</p><p>If there are no <strong>pending</strong> cards in the deck, the system lets you know that everything is up to date and there is nothing to review at the moment.</p>'],
        ];
        break;

    case 'es':
        $page_h1              = 'Repetición espaciada (SRS)';
        $page_subtitle        = 'Estudiar más no es estudiar mejor. La repetición espaciada es la técnica científica que te ayuda a recordar más con menos tiempo de repaso.';
        $sidebar_on_this_page = 'En esta página';
        $sidebar_cta_title    = 'Pruébalo ahora';
        $sidebar_cta_desc     = 'Crea una cuenta gratuita y empieza a estudiar con SRS.';
        $sidebar_cta_btn      = 'Crear cuenta';
        $header_description   = 'Aprende cómo funciona la repetición espaciada en Play Flashcards: los criterios de revisión, los parámetros configurables y la ciencia detrás de la técnica.';
        $header_canonical     = 'https://www.playflashcards.com/es/spaced-repetition/';
        $sections = [
            ['id' => 'que-es', 'title' => 'Qué es la repetición espaciada',
             'content' => '<p>La repetición espaciada (SRS) es una técnica de memorización basada en cómo el cerebro humano aprende y olvida. En lugar de repasar todo el contenido de forma uniforme, te enfocas en las tarjetas que aún no dominas y dejas de lado las que ya están fijas en la memoria.</p><p>La base científica proviene de la <strong>curva del olvido</strong>, descrita por el psicólogo Hermann Ebbinghaus en el siglo XIX: sin repaso, olvidamos la mayor parte de una información nueva en pocas horas o días. La repetición espaciada interrumpe ese proceso repasando el contenido en el momento justo, antes de que el olvido se consolide.</p><p>El resultado práctico: aprendes más rápido, retienes por más tiempo y gastas menos tiempo repasando lo que ya sabes.</p>'],
            ['id' => 'como-funciona', 'title' => 'Cómo Play Flashcards aplica el SRS',
             'content' => '<p>En Play Flashcards, cada tarjeta acumula tres métricas a lo largo de tus sesiones de estudio:</p><ul><li><strong>Tasa de precisión:</strong> el porcentaje de veces que respondiste correctamente a lo largo del tiempo.</li><li><strong>Aciertos consecutivos:</strong> cuántas veces seguidas acertaste sin ningún error entre medio.</li><li><strong>Fecha del último estudio:</strong> cuándo se estudió la tarjeta por última vez.</li></ul><p>Estas tres métricas forman el retrato de tu dominio sobre cada tarjeta. Cuando cualquiera de ellas indica que la tarjeta necesita atención, se vuelve <strong>pendiente</strong>.</p>'],
            ['id' => 'cuando-pendiente', 'title' => 'Cuándo una tarjeta queda pendiente',
             'content' => '<p>Una tarjeta es <strong>pendiente</strong> cuando el SRS identifica que necesita ser repasada. Esto ocurre si <strong>cualquiera</strong> de las siguientes condiciones es verdadera:</p><ul><li>La tasa de precisión está por debajo del mínimo configurado.</li><li>Los aciertos consecutivos están por debajo del mínimo configurado.</li><li>La tarjeta no ha sido estudiada durante más días que el intervalo configurado.</li></ul><p>Este criterio es intencional: una tarjeta que aciertas con frecuencia pero no ves desde hace semanas sigue siendo <strong>pendiente</strong>. Del mismo modo, una tarjeta con buena tasa histórica que erraste en las últimas sesiones vuelve a ser <strong>pendiente</strong> inmediatamente.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">El error reinicia la secuencia</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Un solo error hace que la secuencia de aciertos vuelva a cero. Esto garantiza que solo dominas una tarjeta cuando aciertas de forma consistente, no por suerte.</p></div></div>'],
            ['id' => 'configuracion', 'title' => 'Los parámetros que controlas',
             'content' => '<p>El SRS de Play Flashcards tiene cuatro parámetros configurables en tu perfil, todos con valores por defecto pensados para la mayoría de los casos:</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Parámetro</th><th>Por defecto</th><th>Qué controla</th></tr></thead><tbody><tr><td class="fw-semibold small">Tasa de precisión</td><td class="font-monospace small">75%</td><td>Por debajo de este porcentaje, la tarjeta permanece <strong>pendiente</strong>.</td></tr><tr><td class="fw-semibold small">Aciertos consecutivos</td><td class="font-monospace small">5</td><td>Mínimo de aciertos consecutivos sin ningún error.</td></tr><tr><td class="fw-semibold small">Frecuencia de estudio</td><td class="font-monospace small">7 días</td><td>Tarjetas no estudiadas en ese período vuelven a ser <strong>pendientes</strong>, aunque ya estuvieran dominadas.</td></tr><tr><td class="fw-semibold small">Tarjetas por sesión</td><td class="font-monospace small">20 tarjetas</td><td>Máximo de tarjetas por sesión de estudio SRS.</td></tr></tbody></table></div><p class="mt-3">Puedes ajustar estos valores según tu ritmo de aprendizaje. Quienes estudian a diario pueden reducir la frecuencia; quienes tienen un mazo muy grande pueden aumentar el límite por sesión.</p>'],
            ['id' => 'sesion-estudio', 'title' => 'Cómo es una sesión de estudio SRS',
             'content' => '<p>Al iniciar una sesión SRS en un mazo, Play Flashcards selecciona automáticamente las tarjetas <strong>pendientes</strong>, las mezcla y las presenta una por una. Para cada tarjeta ves el frente, decides tu respuesta mentalmente y revelas el reverso para comprobar.</p><p>Luego indicas si acertaste o erraste. Esa respuesta se registra inmediatamente y actualiza las tres métricas de la tarjeta. Al final de la sesión, el sistema muestra el resultado: cuántas tarjetas acertaste y cuántas erraste.</p><p>Si no hay ninguna tarjeta <strong>pendiente</strong> en el mazo, el sistema informa que todo está al día y no hay nada que repasar en este momento.</p>'],
        ];
        break;

    case 'fr':
        $page_h1              = 'Répétition espacée (SRS)';
        $page_subtitle        = 'Étudier plus n\'est pas étudier mieux. La répétition espacée est la technique scientifique qui vous aide à mémoriser plus avec moins de temps de révision.';
        $sidebar_on_this_page = 'Sur cette page';
        $sidebar_cta_title    = 'Essayez maintenant';
        $sidebar_cta_desc     = 'Créez un compte gratuit et commencez à étudier avec le SRS.';
        $sidebar_cta_btn      = 'Créer un compte';
        $header_description   = 'Découvrez comment fonctionne la répétition espacée dans Play Flashcards : les critères de révision, les paramètres configurables et la science derrière la technique.';
        $header_canonical     = 'https://www.playflashcards.com/fr/spaced-repetition/';
        $sections = [
            ['id' => 'quest-ce-que', 'title' => 'Qu\'est-ce que la répétition espacée',
             'content' => '<p>La répétition espacée (SRS) est une technique de mémorisation basée sur la façon dont le cerveau humain apprend et oublie. Au lieu de réviser tout le contenu de manière uniforme, vous vous concentrez sur les fiches que vous ne maîtrisez pas encore et mettez de côté celles déjà fixées en mémoire.</p><p>La base scientifique vient de la <strong>courbe de l\'oubli</strong>, décrite par le psychologue Hermann Ebbinghaus au XIXe siècle : sans révision, nous oublions la plupart des nouvelles informations en quelques heures ou jours. La répétition espacée interrompt ce processus en révisant le contenu au bon moment, avant que l\'oubli ne s\'installe.</p><p>Le résultat pratique : vous apprenez plus vite, retenez plus longtemps et passez moins de temps à réviser ce que vous savez déjà.</p>'],
            ['id' => 'comment-ca-marche', 'title' => 'Comment Play Flashcards applique le SRS',
             'content' => '<p>Dans Play Flashcards, chaque fiche accumule trois indicateurs au fil de vos sessions d\'étude :</p><ul><li><strong>Taux de précision :</strong> le pourcentage de fois où vous avez répondu correctement au fil du temps.</li><li><strong>Bonnes réponses consécutives :</strong> combien de fois de suite vous avez répondu correctement sans aucune erreur.</li><li><strong>Date de dernière étude :</strong> quand la fiche a été étudiée pour la dernière fois.</li></ul><p>Ces trois indicateurs forment un portrait de votre maîtrise de chaque fiche. Lorsque l\'un d\'eux indique que la fiche nécessite de l\'attention, elle devient <strong>en attente</strong>.</p>'],
            ['id' => 'quand-en-attente', 'title' => 'Quand une fiche est en attente',
             'content' => '<p>Une fiche est <strong>en attente</strong> lorsque le SRS identifie qu\'elle doit être révisée. Cela se produit si <strong>l\'une</strong> des conditions suivantes est vraie :</p><ul><li>Le taux de précision est inférieur au minimum configuré.</li><li>Les bonnes réponses consécutives sont inférieures au minimum configuré.</li><li>La fiche n\'a pas été étudiée depuis plus de jours que l\'intervalle configuré.</li></ul><p>Ce critère est intentionnel : une fiche que vous répondez souvent correctement mais que vous n\'avez pas vue depuis des semaines reste <strong>en attente</strong>. De même, une fiche avec un bon historique que vous avez raté lors des dernières sessions redevient <strong>en attente</strong> immédiatement.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">Une erreur remet la séquence à zéro</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Une seule erreur fait revenir la séquence de bonnes réponses à zéro. Cela garantit que vous ne maîtrisez une fiche que lorsque vous répondez correctement de manière constante, pas par chance.</p></div></div>'],
            ['id' => 'parametres', 'title' => 'Les paramètres que vous contrôlez',
             'content' => '<p>Le SRS de Play Flashcards propose quatre paramètres configurables dans votre profil, tous avec des valeurs par défaut pour la plupart des cas :</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Paramètre</th><th>Par défaut</th><th>Ce qu\'il contrôle</th></tr></thead><tbody><tr><td class="fw-semibold small">Taux de précision</td><td class="font-monospace small">75 %</td><td>En dessous de ce pourcentage, la fiche reste <strong>en attente</strong>.</td></tr><tr><td class="fw-semibold small">Bonnes réponses consécutives</td><td class="font-monospace small">5</td><td>Minimum de bonnes réponses consécutives sans erreur.</td></tr><tr><td class="fw-semibold small">Fréquence d\'étude</td><td class="font-monospace small">7 jours</td><td>Les fiches non étudiées dans ce délai redeviennent <strong>en attente</strong>, même si déjà maîtrisées.</td></tr><tr><td class="fw-semibold small">Fiches par session</td><td class="font-monospace small">20 fiches</td><td>Nombre maximum de fiches par session d\'étude SRS.</td></tr></tbody></table></div><p class="mt-3">Vous pouvez ajuster ces valeurs selon votre rythme d\'apprentissage. Ceux qui étudient chaque jour peuvent réduire l\'intervalle ; ceux qui ont un grand paquet peuvent augmenter la limite par session.</p>'],
            ['id' => 'session-etude', 'title' => 'Comment se déroule une session d\'étude SRS',
             'content' => '<p>Lorsque vous démarrez une session SRS sur un paquet, Play Flashcards sélectionne automatiquement les fiches <strong>en attente</strong>, les mélange et les présente une par une. Pour chaque fiche vous voyez le recto, décidez votre réponse mentalement et révélez le verso pour vérifier.</p><p>Vous indiquez ensuite si vous avez répondu correctement ou non. Cette réponse est enregistrée immédiatement et met à jour les trois indicateurs de la fiche. À la fin de la session, le système affiche votre résultat : combien de fiches vous avez réussies et combien vous avez ratées.</p><p>S\'il n\'y a aucune fiche <strong>en attente</strong> dans le paquet, le système vous indique que tout est à jour et qu\'il n\'y a rien à réviser pour le moment.</p>'],
        ];
        break;

    case 'de':
        $page_h1              = 'Spaced Repetition (SRS)';
        $page_subtitle        = 'Mehr zu lernen bedeutet nicht, besser zu lernen. Spaced Repetition ist die wissenschaftliche Technik, die Ihnen hilft, mit weniger Wiederholungsaufwand mehr zu behalten.';
        $sidebar_on_this_page = 'Auf dieser Seite';
        $sidebar_cta_title    = 'Jetzt ausprobieren';
        $sidebar_cta_desc     = 'Erstelle ein kostenloses Konto und fange an, mit SRS zu lernen.';
        $sidebar_cta_btn      = 'Konto erstellen';
        $header_description   = 'Erfahren Sie, wie Spaced Repetition in Play Flashcards funktioniert: die Wiederholungskriterien, konfigurierbaren Parameter und die Wissenschaft hinter der Technik.';
        $header_canonical     = 'https://www.playflashcards.com/de/spaced-repetition/';
        $sections = [
            ['id' => 'was-ist', 'title' => 'Was ist Spaced Repetition',
             'content' => '<p>Spaced Repetition (SRS) ist eine Memorierungstechnik, die darauf basiert, wie das menschliche Gehirn lernt und vergisst. Anstatt alle Inhalte gleichmäßig zu wiederholen, konzentrierst du dich auf die Karten, die du noch nicht beherrschst, und legst die bereits gelernten zur Seite.</p><p>Die wissenschaftliche Grundlage kommt von der <strong>Vergessenskurve</strong>, die der Psychologe Hermann Ebbinghaus im 19. Jahrhundert beschrieb: ohne Wiederholung vergessen wir die meisten neuen Informationen innerhalb von Stunden oder Tagen. Spaced Repetition unterbricht diesen Prozess, indem der Inhalt zum richtigen Zeitpunkt wiederholt wird, bevor das Vergessen einsetzt.</p><p>Das praktische Ergebnis: Du lernst schneller, behältst länger und verbringst weniger Zeit mit dem Wiederholen von bereits Gelerntem.</p>'],
            ['id' => 'wie-funktioniert', 'title' => 'Wie Play Flashcards SRS anwendet',
             'content' => '<p>In Play Flashcards sammelt jede Karte im Laufe deiner Lernsitzungen drei Metriken:</p><ul><li><strong>Genauigkeitsrate:</strong> der prozentuale Anteil der richtigen Antworten über die Zeit.</li><li><strong>Aufeinanderfolgende richtige Antworten:</strong> wie viele Male in Folge du richtig geantwortet hast, ohne einen Fehler dazwischen.</li><li><strong>Datum des letzten Lernens:</strong> wann die Karte zuletzt gelernt wurde.</li></ul><p>Diese drei Metriken bilden ein Bild deines Beherrschungsgrades jeder Karte. Wenn eine davon anzeigt, dass die Karte Aufmerksamkeit benötigt, wird sie <strong>ausstehend</strong>.</p>'],
            ['id' => 'wann-ausstehend', 'title' => 'Wann eine Karte ausstehend wird',
             'content' => '<p>Eine Karte ist <strong>ausstehend</strong>, wenn das SRS erkennt, dass sie wiederholt werden muss. Dies geschieht, wenn <strong>eine</strong> der folgenden Bedingungen zutrifft:</p><ul><li>Die Genauigkeitsrate liegt unter dem konfigurierten Minimum.</li><li>Die aufeinanderfolgenden richtigen Antworten liegen unter dem konfigurierten Minimum.</li><li>Die Karte wurde länger nicht gelernt als das konfigurierte Intervall.</li></ul><p>Dieses Kriterium ist beabsichtigt: eine Karte, die du oft richtig beantwortest, aber seit Wochen nicht gesehen hast, ist dennoch <strong>ausstehend</strong>. Ebenso wird eine Karte mit guter historischer Rate, die du in letzten Sitzungen falsch beantwortet hast, sofort wieder <strong>ausstehend</strong>.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">Ein Fehler setzt die Sequenz zurück</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Ein einziger Fehler setzt die Sequenz richtiger Antworten auf null zurück. So stellst du sicher, dass du eine Karte nur dann beherrschst, wenn du konsequent richtig antwortest, nicht durch Zufall.</p></div></div>'],
            ['id' => 'einstellungen', 'title' => 'Die Parameter, die du kontrollierst',
             'content' => '<p>Das SRS von Play Flashcards hat vier konfigurierbare Parameter in deinem Profil, alle mit Standardwerten für die meisten Anwendungsfälle:</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Parameter</th><th>Standard</th><th>Was er steuert</th></tr></thead><tbody><tr><td class="fw-semibold small">Genauigkeitsrate</td><td class="font-monospace small">75 %</td><td>Unterhalb dieses Prozentsatzes bleibt die Karte <strong>ausstehend</strong>.</td></tr><tr><td class="fw-semibold small">Aufeinanderfolgende richtige Antworten</td><td class="font-monospace small">5</td><td>Mindestanzahl aufeinanderfolgender richtiger Antworten ohne Fehler.</td></tr><tr><td class="fw-semibold small">Lernhäufigkeit</td><td class="font-monospace small">7 Tage</td><td>Karten, die in diesem Zeitraum nicht gelernt wurden, werden wieder <strong>ausstehend</strong>, auch wenn sie bereits beherrscht wurden.</td></tr><tr><td class="fw-semibold small">Karten pro Sitzung</td><td class="font-monospace small">20 Karten</td><td>Maximale Anzahl von Karten pro SRS-Lernsitzung.</td></tr></tbody></table></div><p class="mt-3">Du kannst diese Werte an dein Lerntempo anpassen. Wer täglich lernt, kann das Intervall verringern; wer ein sehr großes Deck hat, kann das Limit pro Sitzung erhöhen.</p>'],
            ['id' => 'lernsitzung', 'title' => 'Wie eine SRS-Lernsitzung aussieht',
             'content' => '<p>Wenn du eine SRS-Sitzung für ein Deck startest, wählt Play Flashcards automatisch die <strong>ausstehenden</strong> Karten aus, mischt sie und präsentiert sie einzeln. Für jede Karte siehst du die Vorderseite, entscheidest innerlich deine Antwort und deckst die Rückseite auf.</p><p>Du gibst dann an, ob du richtig oder falsch geantwortet hast. Diese Antwort wird sofort gespeichert und aktualisiert die drei Metriken der Karte. Am Ende der Sitzung zeigt das System dein Ergebnis: wie viele Karten du richtig und wie viele du falsch beantwortet hast.</p><p>Gibt es keine <strong>ausstehenden</strong> Karten im Deck, informiert dich das System darüber, dass alles aktuell ist und im Moment nichts zu wiederholen ist.</p>'],
        ];
        break;

    case 'it':
        $page_h1              = 'Ripetizione spaziata (SRS)';
        $page_subtitle        = 'Studiare di più non significa studiare meglio. La ripetizione spaziata è la tecnica scientifica che ti aiuta a ricordare di più con meno tempo di ripasso.';
        $sidebar_on_this_page = 'In questa pagina';
        $sidebar_cta_title    = 'Provalo ora';
        $sidebar_cta_desc     = 'Crea un account gratuito e inizia a studiare con il SRS.';
        $sidebar_cta_btn      = 'Crea account';
        $header_description   = 'Scopri come funziona la ripetizione spaziata in Play Flashcards: i criteri di revisione, i parametri configurabili e la scienza dietro la tecnica.';
        $header_canonical     = 'https://www.playflashcards.com/it/spaced-repetition/';
        $sections = [
            ['id' => 'cosa-e', 'title' => 'Cos\'è la ripetizione spaziata',
             'content' => '<p>La ripetizione spaziata (SRS) è una tecnica di memorizzazione basata su come il cervello umano apprende e dimentica. Invece di ripassare tutti i contenuti in modo uniforme, ti concentri sulle flashcard che non padroneggi ancora e metti da parte quelle già fisse nella memoria.</p><p>La base scientifica viene dalla <strong>curva dell\'oblio</strong>, descritta dallo psicologo Hermann Ebbinghaus nel XIX secolo: senza ripasso, dimentichiamo la maggior parte di una nuova informazione in poche ore o giorni. La ripetizione spaziata interrompe questo processo ripassando il contenuto al momento giusto, prima che l\'oblio si consolidi.</p><p>Il risultato pratico: impari più velocemente, conservi più a lungo e spendi meno tempo a ripassare ciò che già sai.</p>'],
            ['id' => 'come-funziona', 'title' => 'Come Play Flashcards applica il SRS',
             'content' => '<p>In Play Flashcards, ogni flashcard accumula tre metriche nel corso delle tue sessioni di studio:</p><ul><li><strong>Tasso di precisione:</strong> la percentuale di volte in cui hai risposto correttamente nel tempo.</li><li><strong>Risposte corrette consecutive:</strong> quante volte di fila hai risposto correttamente senza errori nel mezzo.</li><li><strong>Data dell\'ultimo studio:</strong> quando la flashcard è stata studiata l\'ultima volta.</li></ul><p>Queste tre metriche formano un quadro della tua padronanza di ogni flashcard. Quando una di esse segnala che la flashcard necessita di attenzione, diventa <strong>in sospeso</strong>.</p>'],
            ['id' => 'quando-in-sospeso', 'title' => 'Quando una flashcard diventa in sospeso',
             'content' => '<p>Una flashcard è <strong>in sospeso</strong> quando il SRS identifica che deve essere ripetuta. Questo avviene se <strong>una</strong> delle seguenti condizioni è vera:</p><ul><li>Il tasso di precisione è inferiore al minimo configurato.</li><li>Le risposte corrette consecutive sono inferiori al minimo configurato.</li><li>La flashcard non è stata studiata per più giorni rispetto all\'intervallo configurato.</li></ul><p>Questo criterio è intenzionale: una flashcard che rispondi spesso correttamente ma non vedi da settimane è ancora <strong>in sospeso</strong>. Allo stesso modo, una flashcard con un buon storico che hai sbagliato nelle ultime sessioni torna <strong>in sospeso</strong> immediatamente.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">L\'errore azzera la sequenza</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Un singolo errore riporta la sequenza di risposte corrette a zero. Questo garantisce che padroneggi una flashcard solo quando rispondi in modo costante, non per fortuna.</p></div></div>'],
            ['id' => 'configurazione', 'title' => 'I parametri che controlli',
             'content' => '<p>Il SRS di Play Flashcards ha quattro parametri configurabili nel tuo profilo, tutti con valori predefiniti per la maggior parte dei casi:</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Parametro</th><th>Predefinito</th><th>Cosa controlla</th></tr></thead><tbody><tr><td class="fw-semibold small">Tasso di precisione</td><td class="font-monospace small">75%</td><td>Al di sotto di questa percentuale, la flashcard rimane <strong>in sospeso</strong>.</td></tr><tr><td class="fw-semibold small">Risposte corrette consecutive</td><td class="font-monospace small">5</td><td>Minimo di risposte corrette consecutive senza errori.</td></tr><tr><td class="fw-semibold small">Frequenza di studio</td><td class="font-monospace small">7 giorni</td><td>Flashcard non studiate in questo periodo tornano <strong>in sospeso</strong>, anche se già padroneggiate.</td></tr><tr><td class="fw-semibold small">Carte per sessione</td><td class="font-monospace small">20 carte</td><td>Numero massimo di flashcard per sessione di studio SRS.</td></tr></tbody></table></div><p class="mt-3">Puoi regolare questi valori in base al tuo ritmo di apprendimento. Chi studia ogni giorno può ridurre l\'intervallo; chi ha un mazzo molto grande può aumentare il limite per sessione.</p>'],
            ['id' => 'sessione-studio', 'title' => 'Come si svolge una sessione di studio SRS',
             'content' => '<p>Quando avvii una sessione SRS su un mazzo, Play Flashcards seleziona automaticamente le flashcard <strong>in sospeso</strong>, le mescola e le presenta una alla volta. Per ogni flashcard vedi il fronte, decidi mentalmente la tua risposta e riveli il retro per verificare.</p><p>Poi indichi se hai risposto correttamente o meno. Quella risposta viene registrata immediatamente e aggiorna le tre metriche della flashcard. Alla fine della sessione, il sistema mostra il risultato: quante flashcard hai risposto correttamente e quante hai sbagliato.</p><p>Se non ci sono flashcard <strong>in sospeso</strong> nel mazzo, il sistema ti informa che tutto è aggiornato e non c\'è nulla da ripassare al momento.</p>'],
        ];
        break;

    case 'ja':
        $page_h1              = '間隔反復（SRS）';
        $page_subtitle        = '多く学ぶことが、より良く学ぶことではありません。間隔反復は、より少ない復習時間でより多くを記憶できる科学的な手法です。';
        $sidebar_on_this_page = 'このページの内容';
        $sidebar_cta_title    = '今すぐ試す';
        $sidebar_cta_desc     = '無料アカウントを作成して、SRSで学習を始めましょう。';
        $sidebar_cta_btn      = 'アカウントを作成';
        $header_description   = 'Play Flashcardsの間隔反復の仕組みを学ぶ：復習の基準、設定可能なパラメータ、そしてその科学的根拠。';
        $header_canonical     = 'https://www.playflashcards.com/ja/spaced-repetition/';
        $sections = [
            ['id' => 'what-is', 'title' => '間隔反復とは',
             'content' => '<p>間隔反復（SRS）は、人間の脳の学習と忘却のメカニズムに基づいた暗記技法です。すべてのコンテンツを均一に復習するのではなく、まだ習得していないカードに集中し、すでに記憶に定着したカードは脇に置きます。</p><p>科学的根拠は、19世紀に心理学者ヘルマン・エビングハウスが提唱した<strong>忘却曲線</strong>にあります。復習なしでは、新しい情報のほとんどを数時間から数日で忘れてしまいます。間隔反復は、忘却が定着する前に適切なタイミングでコンテンツを復習することで、このプロセスを中断します。</p><p>実際の効果：より早く学習し、より長く記憶し、すでに知っていることの復習に費やす時間を減らせます。</p>'],
            ['id' => 'how-it-works', 'title' => 'Play Flashcardsが間隔反復を適用する方法',
             'content' => '<p>Play Flashcardsでは、各カードが学習セッションを通じて3つの指標を蓄積します：</p><ul><li><strong>正解率：</strong>これまでに正しく回答した割合。</li><li><strong>連続正解数：</strong>エラーなしで連続して正解した回数。</li><li><strong>最終学習日：</strong>カードが最後に学習された日時。</li></ul><p>これら3つの指標が、各カードの習熟度を示します。いずれかの指標がカードに注意が必要であることを示すと、そのカードは<strong>保留中</strong>になります。</p>'],
            ['id' => 'when-pending', 'title' => 'カードが保留中になるタイミング',
             'content' => '<p>カードは、SRSが復習が必要と判断したときに<strong>保留中</strong>になります。以下の条件のいずれかが当てはまる場合に発生します：</p><ul><li>正解率が設定された最小値を下回っている。</li><li>連続正解数が設定された最小値を下回っている。</li><li>カードが設定された間隔より長く学習されていない。</li></ul><p>このOR条件は意図的です：頻繁に正解できるカードでも、数週間見ていない場合はまだ<strong>保留中</strong>です。同様に、過去の正解率が良くても最近のセッションでミスしたカードは直ちに<strong>保留中</strong>に戻ります。</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">ミスは連続記録をリセットする</p><p class="small mb-0" style="color:var(--bs-secondary-color)">1回のミスで連続正解数がゼロに戻ります。これにより、偶然ではなく一貫して正解したときにのみカードを習得したとみなされます。</p></div></div>'],
            ['id' => 'settings', 'title' => '設定できるパラメータ',
             'content' => '<p>Play FlashcardsのSRSには、プロフィールで設定できる4つのパラメータがあります：</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>パラメータ</th><th>デフォルト</th><th>制御すること</th></tr></thead><tbody><tr><td class="fw-semibold small">正解率</td><td class="font-monospace small">75%</td><td>この割合を下回ると、カードは<strong>保留中</strong>のままです。</td></tr><tr><td class="fw-semibold small">連続正解数</td><td class="font-monospace small">5回</td><td>エラーなしで必要な最低連続正解数。</td></tr><tr><td class="fw-semibold small">学習頻度</td><td class="font-monospace small">7日</td><td>この期間学習されなかったカードは、習得済みでも<strong>保留中</strong>に戻ります。</td></tr><tr><td class="fw-semibold small">セッションあたりのカード数</td><td class="font-monospace small">20枚</td><td>SRS学習セッションあたりの最大カード数。</td></tr></tbody></table></div><p class="mt-3">これらの値は学習ペースに合わせて調整できます。毎日学習する方は間隔を短くでき、大きなデッキを持つ方はセッションあたりの制限を増やせます。</p>'],
            ['id' => 'study-session', 'title' => 'SRS学習セッションの流れ',
             'content' => '<p>デッキでSRSセッションを開始すると、Play Flashcardsは<strong>保留中</strong>のカードを自動的に選択し、シャッフルして1枚ずつ表示します。各カードで表側を見て、頭の中で答えを考え、裏側を確認します。</p><p>次に、正解か不正解かを示します。その回答はすぐに記録され、カードの3つの指標が更新されます。セッション終了時に、正解したカードと不正解のカードの数が表示されます。</p><p>デッキに<strong>保留中</strong>のカードがない場合、すべて最新の状態であり、現時点で復習するものはないとシステムが通知します。</p>'],
        ];
        break;

    case 'zh':
        $page_h1              = '间隔重复（SRS）';
        $page_subtitle        = '学得多不代表学得好。间隔重复是一种科学技术，帮助你用更少的复习时间记住更多内容。';
        $sidebar_on_this_page = '本页内容';
        $sidebar_cta_title    = '立即尝试';
        $sidebar_cta_desc     = '创建免费账户，开始使用 SRS 学习。';
        $sidebar_cta_btn      = '创建账户';
        $header_description   = '了解 Play Flashcards 中间隔重复的工作原理：复习标准、可配置参数以及背后的科学依据。';
        $header_canonical     = 'https://www.playflashcards.com/zh/spaced-repetition/';
        $sections = [
            ['id' => 'what-is', 'title' => '什么是间隔重复',
             'content' => '<p>间隔重复（SRS）是一种基于人类大脑学习和遗忘机制的记忆技术。你不必均匀复习所有内容，而是专注于尚未掌握的卡片，将已经记住的卡片放在一边。</p><p>科学依据来自19世纪心理学家赫尔曼·艾宾浩斯描述的<strong>遗忘曲线</strong>：不加复习，我们会在数小时或数天内忘记大部分新知识。间隔重复通过在遗忘发生前的恰当时机进行复习，来打断这一过程。</p><p>实际效果：学得更快，记得更久，花更少的时间重复你已经掌握的内容。</p>'],
            ['id' => 'how-it-works', 'title' => 'Play Flashcards 如何应用 SRS',
             'content' => '<p>在 Play Flashcards 中，每张卡片会在学习过程中积累三项指标：</p><ul><li><strong>准确率：</strong>你历史上回答正确的百分比。</li><li><strong>连续正确回答：</strong>你连续答对的次数，中间不能有错误。</li><li><strong>最后学习日期：</strong>该卡片最后一次被学习的时间。</li></ul><p>这三项指标构成你对每张卡片掌握程度的全貌。当其中任何一项表明卡片需要关注时，该卡片变为<strong>待复习</strong>。</p>'],
            ['id' => 'when-pending', 'title' => '卡片何时变为待复习',
             'content' => '<p>当 SRS 判断卡片需要复习时，它会变为<strong>待复习</strong>。以下任意一个条件成立时就会发生：</p><ul><li>准确率低于配置的最低值。</li><li>连续正确回答次数低于配置的最低值。</li><li>卡片未被学习的天数超过配置的间隔。</li></ul><p>这种"或"条件是有意为之：你经常答对但几周未见的卡片仍然是<strong>待复习</strong>。同样，历史准确率良好但最近几次答错的卡片也会立即变回<strong>待复习</strong>。</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">错误会重置连续记录</p><p class="small mb-0" style="color:var(--bs-secondary-color)">一次错误就会将连续正确回答数归零。这确保只有在你持续答对时才算真正掌握了一张卡片，而不是凭运气。</p></div></div>'],
            ['id' => 'settings', 'title' => '你可以控制的参数',
             'content' => '<p>Play Flashcards 的 SRS 在你的个人资料中有四个可配置参数：</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>参数</th><th>默认值</th><th>控制内容</th></tr></thead><tbody><tr><td class="fw-semibold small">准确率</td><td class="font-monospace small">75%</td><td>低于此百分比，卡片保持<strong>待复习</strong>状态。</td></tr><tr><td class="fw-semibold small">连续正确回答</td><td class="font-monospace small">5次</td><td>无错误的最低连续正确回答次数。</td></tr><tr><td class="fw-semibold small">学习频率</td><td class="font-monospace small">7天</td><td>在此期间未学习的卡片将再次变为<strong>待复习</strong>，即使已经掌握。</td></tr><tr><td class="fw-semibold small">每次学习的卡片数</td><td class="font-monospace small">20张</td><td>每次 SRS 学习的最大卡片数。</td></tr></tbody></table></div><p class="mt-3">你可以根据自己的学习节奏调整这些值。每天学习的人可以缩短间隔；卡片很多的人可以增加每次的限制。</p>'],
            ['id' => 'study-session', 'title' => 'SRS 学习过程是什么样的',
             'content' => '<p>在牌组中开始 SRS 学习时，Play Flashcards 会自动选择<strong>待复习</strong>的卡片，将其打乱并逐一呈现。对于每张卡片，你看到正面，在脑海中思考答案，然后翻开背面确认。</p><p>然后你标记是否答对。该答案立即被记录，并更新卡片的三项指标。学习结束时，系统显示结果：答对了多少张，答错了多少张。</p><p>如果牌组中没有<strong>待复习</strong>的卡片，系统会通知你一切都是最新状态，目前没有需要复习的内容。</p>'],
        ];
        break;

    case 'nl':
        $page_h1              = 'Gespreide herhaling (SRS)';
        $page_subtitle        = 'Meer studeren is niet beter studeren. Gespreide herhaling is de wetenschappelijke techniek die je helpt meer te onthouden met minder herhalingstijd.';
        $sidebar_on_this_page = 'Op deze pagina';
        $sidebar_cta_title    = 'Probeer het nu';
        $sidebar_cta_desc     = 'Maak een gratis account aan en begin met leren via SRS.';
        $sidebar_cta_btn      = 'Account aanmaken';
        $header_description   = 'Ontdek hoe gespreide herhaling werkt in Play Flashcards: de herhalingscriteria, configureerbare parameters en de wetenschap achter de techniek.';
        $header_canonical     = 'https://www.playflashcards.com/nl/spaced-repetition/';
        $sections = [
            ['id' => 'wat-is', 'title' => 'Wat is gespreide herhaling',
             'content' => '<p>Gespreide herhaling (SRS) is een memorisatietechniek gebaseerd op hoe het menselijk brein leert en vergeet. In plaats van alle inhoud uniform te herhalen, focus je op de kaarten die je nog niet beheerst en zet je de kaarten die al zijn vastgelegd opzij.</p><p>De wetenschappelijke basis komt van de <strong>vergeetcurve</strong>, beschreven door de psycholoog Hermann Ebbinghaus in de 19e eeuw: zonder herhaling vergeten we de meeste nieuwe informatie binnen uren of dagen. Gespreide herhaling onderbreekt dit proces door de inhoud op het juiste moment te herhalen, voordat het vergeten zich vestigt.</p><p>Het praktische resultaat: je leert sneller, onthoudt langer en besteedt minder tijd aan het herhalen van wat je al weet.</p>'],
            ['id' => 'hoe-werkt', 'title' => 'Hoe Play Flashcards SRS toepast',
             'content' => '<p>In Play Flashcards accumuleert elke kaart drie statistieken gedurende je studiesessies:</p><ul><li><strong>Nauwkeurigheidspercentage:</strong> het percentage keren dat je in de loop der tijd correct hebt geantwoord.</li><li><strong>Opeenvolgende juiste antwoorden:</strong> hoeveel keer je achter elkaar correct hebt geantwoord zonder fouten.</li><li><strong>Datum van laatste studie:</strong> wanneer de kaart voor het laatst is bestudeerd.</li></ul><p>Deze drie statistieken vormen een beeld van je beheersing van elke kaart. Wanneer een van hen aangeeft dat de kaart aandacht nodig heeft, wordt deze <strong>in behandeling</strong>.</p>'],
            ['id' => 'wanneer-in-behandeling', 'title' => 'Wanneer een kaart in behandeling is',
             'content' => '<p>Een kaart is <strong>in behandeling</strong> wanneer het SRS vaststelt dat deze herhaald moet worden. Dit gebeurt als <strong>een</strong> van de volgende voorwaarden waar is:</p><ul><li>Het nauwkeurigheidspercentage ligt onder het geconfigureerde minimum.</li><li>De opeenvolgende juiste antwoorden liggen onder het geconfigureerde minimum.</li><li>De kaart is langer niet bestudeerd dan het geconfigureerde interval.</li></ul><p>Dit criterium is opzettelijk: een kaart die je vaak goed beantwoordt maar weken niet hebt gezien, is nog steeds <strong>in behandeling</strong>. Evenzo wordt een kaart met een goed historisch percentage die je in recente sessies fout hebt, onmiddellijk weer <strong>in behandeling</strong>.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">Een fout reset de reeks</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Één fout brengt de reeks juiste antwoorden terug naar nul. Zo zorg je ervoor dat je een kaart alleen echt beheerst wanneer je consistent antwoordt, niet bij toeval.</p></div></div>'],
            ['id' => 'instellingen', 'title' => 'De parameters die jij beheert',
             'content' => '<p>Het SRS van Play Flashcards heeft vier configureerbare parameters in je profiel, allemaal met standaardwaarden voor de meeste gevallen:</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Parameter</th><th>Standaard</th><th>Wat het regelt</th></tr></thead><tbody><tr><td class="fw-semibold small">Nauwkeurigheidspercentage</td><td class="font-monospace small">75%</td><td>Onder dit percentage blijft de kaart <strong>in behandeling</strong>.</td></tr><tr><td class="fw-semibold small">Opeenvolgende juiste antwoorden</td><td class="font-monospace small">5</td><td>Minimaal aantal opeenvolgende juiste antwoorden zonder fouten.</td></tr><tr><td class="fw-semibold small">Studiefrequentie</td><td class="font-monospace small">7 dagen</td><td>Kaarten die in deze periode niet zijn bestudeerd, worden weer <strong>in behandeling</strong>, zelfs als ze al beheerst worden.</td></tr><tr><td class="fw-semibold small">Kaarten per sessie</td><td class="font-monospace small">20 kaarten</td><td>Maximum aantal kaarten per SRS-studiesessie.</td></tr></tbody></table></div><p class="mt-3">Je kunt deze waarden aanpassen aan je leertempo. Wie dagelijks studeert, kan het interval verkorten; wie een groot deck heeft, kan het limiet per sessie verhogen.</p>'],
            ['id' => 'studiesessie', 'title' => 'Hoe een SRS-studiesessie eruitziet',
             'content' => '<p>Wanneer je een SRS-sessie start op een deck, selecteert Play Flashcards automatisch de <strong>in behandeling</strong> zijnde kaarten, schudt deze door en presenteert ze één voor één. Voor elke kaart zie je de voorkant, beslis je mentaal je antwoord en onthul je de achterkant ter controle.</p><p>Je geeft dan aan of je goed of fout hebt geantwoord. Dat antwoord wordt direct geregistreerd en werkt de drie statistieken van de kaart bij. Aan het einde van de sessie toont het systeem je resultaat: hoeveel kaarten je goed en hoeveel je fout hebt.</p><p>Als er geen <strong>in behandeling</strong> zijnde kaarten in het deck zijn, laat het systeem je weten dat alles up-to-date is en er op dit moment niets te herhalen is.</p>'],
        ];
        break;

    case 'pl':
        $page_h1              = 'Powtarzanie z przerwami (SRS)';
        $page_subtitle        = 'Więcej nauki to nie lepsza nauka. Powtarzanie z przerwami to naukowa technika, która pomaga zapamiętać więcej przy mniejszym czasie powtórek.';
        $sidebar_on_this_page = 'Na tej stronie';
        $sidebar_cta_title    = 'Wypróbuj teraz';
        $sidebar_cta_desc     = 'Utwórz darmowe konto i zacznij uczyć się z SRS.';
        $sidebar_cta_btn      = 'Utwórz konto';
        $header_description   = 'Dowiedz się, jak działa powtarzanie z przerwami w Play Flashcards: kryteria powtórek, konfigurowalne parametry i nauka stojąca za techniką.';
        $header_canonical     = 'https://www.playflashcards.com/pl/spaced-repetition/';
        $sections = [
            ['id' => 'czym-jest', 'title' => 'Czym jest powtarzanie z przerwami',
             'content' => '<p>Powtarzanie z przerwami (SRS) to technika zapamiętywania oparta na tym, jak ludzki mózg uczy się i zapomina. Zamiast powtarzać wszystkie treści równomiernie, skupiasz się na fiszkach, których jeszcze nie opanowałeś, i odkładasz na bok te już utrwalone w pamięci.</p><p>Podstawa naukowa pochodzi z <strong>krzywej zapominania</strong>, opisanej przez psychologa Hermanna Ebbinghausa w XIX wieku: bez powtórek zapominamy większość nowych informacji w ciągu kilku godzin lub dni. Powtarzanie z przerwami przerywa ten proces, powtarzając treść we właściwym momencie, zanim zapominanie się utrwali.</p><p>Praktyczny efekt: uczysz się szybciej, zachowujesz wiedzę dłużej i spędzasz mniej czasu na powtarzaniu tego, co już wiesz.</p>'],
            ['id' => 'jak-dziala', 'title' => 'Jak Play Flashcards stosuje SRS',
             'content' => '<p>W Play Flashcards każda fiszka gromadzi trzy wskaźniki w trakcie sesji nauki:</p><ul><li><strong>Wskaźnik dokładności:</strong> procent poprawnych odpowiedzi na przestrzeni czasu.</li><li><strong>Kolejne poprawne odpowiedzi:</strong> ile razy z rzędu odpowiedziałeś poprawnie bez żadnego błędu.</li><li><strong>Data ostatniej nauki:</strong> kiedy fiszka była ostatnio uczona.</li></ul><p>Te trzy wskaźniki tworzą obraz twojego opanowania każdej fiszki. Gdy którykolwiek z nich wskazuje, że fiszka wymaga uwagi, staje się <strong>oczekująca</strong>.</p>'],
            ['id' => 'kiedy-oczekujaca', 'title' => 'Kiedy fiszka jest oczekująca',
             'content' => '<p>Fiszka jest <strong>oczekująca</strong>, gdy SRS identyfikuje, że musi być powtórzona. Dzieje się tak, jeśli spełniony jest <strong>którykolwiek</strong> z poniższych warunków:</p><ul><li>Wskaźnik dokładności jest poniżej skonfigurowanego minimum.</li><li>Kolejne poprawne odpowiedzi są poniżej skonfigurowanego minimum.</li><li>Fiszka nie była uczona przez więcej dni niż skonfigurowany interwał.</li></ul><p>To kryterium jest celowe: fiszka, którą często odpowiadasz poprawnie, ale której nie widziałeś od tygodni, nadal jest <strong>oczekująca</strong>. Podobnie, fiszka z dobrym wskaźnikiem historycznym, którą ostatnio popełniłeś błąd, natychmiast staje się <strong>oczekująca</strong> z powrotem.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">Błąd zeruje sekwencję</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Jeden błąd przywraca sekwencję poprawnych odpowiedzi do zera. Gwarantuje to, że opanowujesz fiszkę tylko wtedy, gdy odpowiadasz konsekwentnie, a nie przez przypadek.</p></div></div>'],
            ['id' => 'parametry', 'title' => 'Parametry, które kontrolujesz',
             'content' => '<p>SRS w Play Flashcards ma cztery konfigurowalne parametry w twoim profilu, wszystkie z wartościami domyślnymi dla większości przypadków:</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Parametr</th><th>Domyślnie</th><th>Co kontroluje</th></tr></thead><tbody><tr><td class="fw-semibold small">Wskaźnik dokładności</td><td class="font-monospace small">75%</td><td>Poniżej tego procentu fiszka pozostaje <strong>oczekująca</strong>.</td></tr><tr><td class="fw-semibold small">Kolejne poprawne odpowiedzi</td><td class="font-monospace small">5</td><td>Minimalna liczba kolejnych poprawnych odpowiedzi bez błędów.</td></tr><tr><td class="fw-semibold small">Częstotliwość nauki</td><td class="font-monospace small">7 dni</td><td>Fiszki, których nie uczono w tym czasie, znów stają się <strong>oczekujące</strong>, nawet jeśli już były opanowane.</td></tr><tr><td class="fw-semibold small">Fiszki na sesję</td><td class="font-monospace small">20 fiszek</td><td>Maksymalna liczba fiszek na sesję SRS.</td></tr></tbody></table></div><p class="mt-3">Możesz dostosować te wartości do swojego tempa nauki. Ci, którzy uczą się codziennie, mogą skrócić interwał; ci z bardzo dużą talią mogą zwiększyć limit na sesję.</p>'],
            ['id' => 'sesja-nauki', 'title' => 'Jak wygląda sesja nauki SRS',
             'content' => '<p>Po uruchomieniu sesji SRS w talii, Play Flashcards automatycznie wybiera <strong>oczekujące</strong> fiszki, tasuje je i prezentuje po jednej. Dla każdej fiszki widzisz przód, decydujesz odpowiedź w myślach i odkrywasz tył, żeby sprawdzić.</p><p>Następnie wskazujesz, czy odpowiedziałeś poprawnie, czy nie. Ta odpowiedź jest natychmiast zapisywana i aktualizuje trzy wskaźniki fiszki. Na koniec sesji system pokazuje wynik: ile fiszek odpowiedziałeś poprawnie i ile błędnie.</p><p>Jeśli w talii nie ma <strong>oczekujących</strong> fiszek, system informuje, że wszystko jest aktualne i nie ma nic do powtórzenia w tej chwili.</p>'],
        ];
        break;

    case 'ru':
        $page_h1              = 'Интервальное повторение (SRS)';
        $page_subtitle        = 'Учиться больше не значит учиться лучше. Интервальное повторение — научная техника, которая помогает запомнить больше при меньших затратах времени на повторение.';
        $sidebar_on_this_page = 'На этой странице';
        $sidebar_cta_title    = 'Попробуйте сейчас';
        $sidebar_cta_desc     = 'Создайте бесплатный аккаунт и начните учиться с SRS.';
        $sidebar_cta_btn      = 'Создать аккаунт';
        $header_description   = 'Узнайте, как работает интервальное повторение в Play Flashcards: критерии повторения, настраиваемые параметры и научная основа техники.';
        $header_canonical     = 'https://www.playflashcards.com/ru/spaced-repetition/';
        $sections = [
            ['id' => 'chto-takoe', 'title' => 'Что такое интервальное повторение',
             'content' => '<p>Интервальное повторение (SRS) — техника запоминания, основанная на том, как мозг человека учится и забывает. Вместо того чтобы повторять весь контент равномерно, вы сосредотачиваетесь на карточках, которые ещё не освоили, и откладываете те, что уже закреплены в памяти.</p><p>Научная основа — <strong>кривая забывания</strong>, описанная психологом Германом Эббингаузом в XIX веке: без повторения мы забываем большую часть новой информации в течение нескольких часов или дней. Интервальное повторение прерывает этот процесс, повторяя материал в нужный момент, до того как забывание закрепится.</p><p>Практический результат: вы учитесь быстрее, запоминаете дольше и тратите меньше времени на повторение того, что уже знаете.</p>'],
            ['id' => 'kak-rabotaet', 'title' => 'Как Play Flashcards применяет SRS',
             'content' => '<p>В Play Flashcards каждая карточка накапливает три показателя в ходе учебных сессий:</p><ul><li><strong>Процент точности:</strong> доля правильных ответов за всё время.</li><li><strong>Последовательные правильные ответы:</strong> сколько раз подряд вы ответили правильно без ошибок.</li><li><strong>Дата последнего изучения:</strong> когда карточка изучалась в последний раз.</li></ul><p>Эти три показателя формируют картину вашего владения каждой карточкой. Когда любой из них сигнализирует, что карточка требует внимания, она считается <strong>ожидающей</strong>.</p>'],
            ['id' => 'kogda-zhdet', 'title' => 'Когда карточка считается ожидающей',
             'content' => '<p>Карточка считается <strong>ожидающей</strong>, когда SRS определяет, что её нужно повторить. Это происходит, если выполняется <strong>хотя бы одно</strong> из следующих условий:</p><ul><li>Процент точности ниже установленного минимума.</li><li>Количество последовательных правильных ответов ниже установленного минимума.</li><li>Карточка не изучалась дольше, чем заданный интервал.</li></ul><p>Это условие задумано намеренно: карточка, на которую вы часто отвечаете правильно, но не видели несколько недель, всё равно считается <strong>ожидающей</strong>. Аналогично, карточка с хорошей исторической точностью, на которую вы ошиблись в последних сессиях, немедленно становится <strong>ожидающей</strong> снова.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">Ошибка обнуляет серию</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Одна ошибка обнуляет количество последовательных правильных ответов. Это гарантирует, что вы считаете карточку освоенной только тогда, когда отвечаете правильно постоянно, а не случайно.</p></div></div>'],
            ['id' => 'parametry', 'title' => 'Параметры, которые вы контролируете',
             'content' => '<p>SRS в Play Flashcards имеет четыре настраиваемых параметра в вашем профиле, все со значениями по умолчанию для большинства случаев:</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Параметр</th><th>По умолчанию</th><th>Что контролирует</th></tr></thead><tbody><tr><td class="fw-semibold small">Процент точности</td><td class="font-monospace small">75%</td><td>Ниже этого значения карточка остаётся <strong>ожидающей</strong>.</td></tr><tr><td class="fw-semibold small">Последовательные правильные ответы</td><td class="font-monospace small">5</td><td>Минимальное количество правильных ответов подряд без ошибок.</td></tr><tr><td class="fw-semibold small">Частота обучения</td><td class="font-monospace small">7 дней</td><td>Карточки, не изучавшиеся в течение этого периода, снова становятся <strong>ожидающими</strong>, даже если уже были освоены.</td></tr><tr><td class="fw-semibold small">Карточек за сессию</td><td class="font-monospace small">20 карточек</td><td>Максимальное количество карточек за SRS-сессию.</td></tr></tbody></table></div><p class="mt-3">Вы можете настроить эти значения под свой темп обучения. Кто занимается ежедневно — может сократить интервал; у кого большая колода — может увеличить лимит за сессию.</p>'],
            ['id' => 'uchebnaya-sessiya', 'title' => 'Как проходит учебная SRS-сессия',
             'content' => '<p>При запуске SRS-сессии в колоде Play Flashcards автоматически выбирает <strong>ожидающие</strong> карточки, перемешивает их и показывает по одной. Для каждой карточки вы видите лицевую сторону, мысленно решаете ответ и открываете оборотную сторону для проверки.</p><p>Затем вы указываете, ответили ли вы правильно или нет. Этот ответ немедленно фиксируется и обновляет три показателя карточки. По окончании сессии система показывает результат: сколько карточек вы ответили правильно и сколько ошиблись.</p><p>Если в колоде нет <strong>ожидающих</strong> карточек, система сообщает, что всё актуально и в данный момент нечего повторять.</p>'],
        ];
        break;

    case 'hi':
        $page_h1              = 'अंतराल पुनरावृत्ति (SRS)';
        $page_subtitle        = 'ज़्यादा पढ़ना बेहतर पढ़ना नहीं है। अंतराल पुनरावृत्ति एक वैज्ञानिक तकनीक है जो कम समय में अधिक याद रखने में मदद करती है।';
        $sidebar_on_this_page = 'इस पृष्ठ पर';
        $sidebar_cta_title    = 'अभी आज़माएं';
        $sidebar_cta_desc     = 'एक मुफ़्त खाता बनाएं और SRS के साथ अध्ययन शुरू करें।';
        $sidebar_cta_btn      = 'खाता बनाएं';
        $header_description   = 'Play Flashcards में अंतराल पुनरावृत्ति कैसे काम करती है, यह जानें: समीक्षा मानदंड, कॉन्फ़िगर करने योग्य पैरामीटर और तकनीक के पीछे का विज्ञान।';
        $header_canonical     = 'https://www.playflashcards.com/hi/spaced-repetition/';
        $sections = [
            ['id' => 'kya-hai', 'title' => 'अंतराल पुनरावृत्ति क्या है',
             'content' => '<p>अंतराल पुनरावृत्ति (SRS) एक स्मृति तकनीक है जो इस बात पर आधारित है कि मानव मस्तिष्क कैसे सीखता और भूलता है। सभी सामग्री को एक समान रूप से दोहराने के बजाय, आप उन कार्डों पर ध्यान केंद्रित करते हैं जिन्हें आपने अभी तक नहीं सीखा है और पहले से याद किए हुए कार्डों को अलग रखते हैं।</p><p>वैज्ञानिक आधार 19वीं सदी में मनोवैज्ञानिक हर्मान एबिंगहॉस द्वारा वर्णित <strong>विस्मरण वक्र</strong> से आता है: बिना दोहराव के, हम कुछ घंटों या दिनों में अधिकांश नई जानकारी भूल जाते हैं। अंतराल पुनरावृत्ति सही समय पर सामग्री को दोहराकर इस प्रक्रिया को बाधित करती है, इससे पहले कि विस्मरण स्थायी हो जाए।</p><p>व्यावहारिक परिणाम: आप तेज़ सीखते हैं, अधिक समय तक याद रखते हैं और जो पहले से जानते हैं उसे दोहराने में कम समय लगाते हैं।</p>'],
            ['id' => 'kaise-kaam', 'title' => 'Play Flashcards SRS कैसे लागू करता है',
             'content' => '<p>Play Flashcards में, प्रत्येक कार्ड आपके अध्ययन सत्रों में तीन मेट्रिक्स जमा करता है:</p><ul><li><strong>सटीकता दर:</strong> समय के साथ आपने कितने प्रतिशत बार सही उत्तर दिया।</li><li><strong>लगातार सही उत्तर:</strong> बीच में कोई गलती किए बिना आपने कितनी बार लगातार सही उत्तर दिया।</li><li><strong>अंतिम अध्ययन तिथि:</strong> कार्ड को आखिरी बार कब पढ़ा गया था।</li></ul><p>ये तीन मेट्रिक्स प्रत्येक कार्ड पर आपकी महारत की तस्वीर बनाते हैं। जब इनमें से कोई भी संकेत देता है कि कार्ड पर ध्यान देने की ज़रूरत है, तो वह <strong>लंबित</strong> हो जाता है।</p>'],
            ['id' => 'kab-lambít', 'title' => 'कार्ड कब लंबित होता है',
             'content' => '<p>एक कार्ड <strong>लंबित</strong> होता है जब SRS पहचानता है कि उसे दोहराने की ज़रूरत है। यह तब होता है जब निम्नलिखित में से <strong>कोई एक</strong> शर्त सच हो:</p><ul><li>सटीकता दर कॉन्फ़िगर किए गए न्यूनतम से नीचे है।</li><li>लगातार सही उत्तर कॉन्फ़िगर किए गए न्यूनतम से नीचे हैं।</li><li>कार्ड को कॉन्फ़िगर किए गए अंतराल से अधिक दिनों तक नहीं पढ़ा गया है।</li></ul><p>यह "या" मानदंड जानबूझकर है: एक कार्ड जिसे आप अक्सर सही उत्तर देते हैं लेकिन हफ्तों से नहीं देखा है, अभी भी <strong>लंबित</strong> है। इसी तरह, अच्छी ऐतिहासिक दर वाला कार्ड जिसे आपने हाल के सत्रों में गलत किया, तुरंत फिर से <strong>लंबित</strong> हो जाता है।</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">गलती अनुक्रम को रीसेट कर देती है</p><p class="small mb-0" style="color:var(--bs-secondary-color)">एक गलती लगातार सही उत्तरों की संख्या को शून्य कर देती है। यह सुनिश्चित करता है कि आप किसी कार्ड को तभी माहिर मानते हैं जब आप लगातार सही उत्तर देते हैं, संयोग से नहीं।</p></div></div>'],
            ['id' => 'parameters', 'title' => 'वे पैरामीटर जो आप नियंत्रित करते हैं',
             'content' => '<p>Play Flashcards का SRS आपकी प्रोफ़ाइल में चार कॉन्फ़िगर करने योग्य पैरामीटर रखता है, सभी अधिकांश मामलों के लिए डिफ़ॉल्ट मानों के साथ:</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>पैरामीटर</th><th>डिफ़ॉल्ट</th><th>क्या नियंत्रित करता है</th></tr></thead><tbody><tr><td class="fw-semibold small">सटीकता दर</td><td class="font-monospace small">75%</td><td>इस प्रतिशत से नीचे, कार्ड <strong>लंबित</strong> रहता है।</td></tr><tr><td class="fw-semibold small">लगातार सही उत्तर</td><td class="font-monospace small">5</td><td>बिना किसी गलती के न्यूनतम लगातार सही उत्तर।</td></tr><tr><td class="fw-semibold small">अध्ययन आवृत्ति</td><td class="font-monospace small">7 दिन</td><td>इस अवधि में न पढ़े गए कार्ड फिर से <strong>लंबित</strong> हो जाते हैं, भले ही वे पहले से माहिर हों।</td></tr><tr><td class="fw-semibold small">प्रति सत्र कार्ड</td><td class="font-monospace small">20 कार्ड</td><td>प्रति SRS अध्ययन सत्र कार्डों की अधिकतम संख्या।</td></tr></tbody></table></div><p class="mt-3">आप इन मानों को अपनी सीखने की गति के अनुसार समायोजित कर सकते हैं। जो लोग प्रतिदिन पढ़ते हैं वे अंतराल कम कर सकते हैं; जिनके पास बहुत बड़ा डेक है वे सत्र सीमा बढ़ा सकते हैं।</p>'],
            ['id' => 'adhyayan-satra', 'title' => 'SRS अध्ययन सत्र कैसा दिखता है',
             'content' => '<p>डेक में SRS सत्र शुरू करने पर, Play Flashcards स्वचालित रूप से <strong>लंबित</strong> कार्ड चुनता है, उन्हें फेरबदल करता है और एक-एक करके प्रस्तुत करता है। प्रत्येक कार्ड के लिए आप सामने वाला भाग देखते हैं, मन में उत्तर सोचते हैं और जाँच के लिए पीछे वाला भाग पलटते हैं।</p><p>फिर आप बताते हैं कि आपने सही उत्तर दिया या गलत। वह उत्तर तुरंत दर्ज हो जाता है और कार्ड के तीन मेट्रिक्स अपडेट हो जाते हैं। सत्र के अंत में, सिस्टम परिणाम दिखाता है: कितने कार्डों के सही उत्तर दिए और कितने गलत।</p><p>यदि डेक में कोई <strong>लंबित</strong> कार्ड नहीं है, तो सिस्टम बताता है कि सब कुछ अप-टू-डेट है और अभी कुछ भी दोहराने की ज़रूरत नहीं है।</p>'],
        ];
        break;

    case 'pt-br':
    default:
        $page_h1              = 'Repetição Espaçada (SRS)';
        $page_subtitle        = 'Estudar mais não é estudar melhor. A repetição espaçada é a técnica científica que faz você lembrar mais com menos tempo de revisão.';
        $sidebar_on_this_page = 'Nesta página';
        $sidebar_cta_title    = 'Experimente agora';
        $sidebar_cta_desc     = 'Crie uma conta gratuita e comece a estudar com SRS.';
        $sidebar_cta_btn      = 'Criar conta';
        $header_description   = 'Entenda como a repetição espaçada funciona no Play Flashcards: os critérios de revisão, os parâmetros configuráveis e a ciência por trás da técnica.';
        $header_canonical     = 'https://www.playflashcards.com/pt-br/spaced-repetition/';
        $sections = [
            ['id' => 'o-que-e', 'title' => 'O que é repetição espaçada',
             'content' => '<p>Repetição espaçada (em inglês, <em>Spaced Repetition System</em> ou SRS) é uma técnica de memorização baseada em como o cérebro humano aprende e esquece. Em vez de revisar todo o conteúdo de forma uniforme, você foca nos cartões que ainda não domina e deixa de lado os que já estão fixados.</p><p>A base científica vem da <strong>curva do esquecimento</strong>, descrita pelo psicólogo Hermann Ebbinghaus no século XIX: sem revisão, esquecemos a maior parte de uma informação nova em poucas horas ou dias. A repetição espaçada interrompe esse processo revisando o conteúdo no momento certo, antes que o esquecimento se consolide.</p><p>O resultado prático: você aprende mais rápido, retém por mais tempo e gasta menos tempo revisando o que já sabe.</p>'],
            ['id' => 'como-funciona', 'title' => 'Como o Play Flashcards aplica o SRS',
             'content' => '<p>No Play Flashcards, cada cartão acumula três métricas ao longo das suas sessões de estudo:</p><ul><li><strong>Taxa de acerto:</strong> percentual de vezes que você respondeu corretamente ao longo do tempo.</li><li><strong>Sequência de acertos:</strong> quantas vezes consecutivas você acertou o cartão sem nenhum erro entre elas.</li><li><strong>Data do último estudo:</strong> quando o cartão foi estudado pela última vez.</li></ul><p>Essas três métricas formam o retrato do seu domínio sobre cada cartão. Quando qualquer uma delas indica que o cartão precisa de atenção, ele se torna <strong>pendente</strong>.</p>'],
            ['id' => 'quando-revisar', 'title' => 'Quando um cartão fica pendente',
             'content' => '<p>Um cartão é <strong>pendente</strong> quando o SRS identifica que ele precisa ser revisado. Isso acontece se <strong>qualquer uma</strong> das condições abaixo for verdadeira:</p><ul><li>A taxa de acerto está abaixo do mínimo configurado.</li><li>A sequência de acertos consecutivos está abaixo do mínimo configurado.</li><li>O cartão não foi estudado há mais dias do que o intervalo configurado.</li></ul><p>Esse critério é intencional: um cartão que você acerta com frequência mas não vê há semanas ainda fica <strong>pendente</strong>. Da mesma forma, um cartão com boa taxa histórica mas que você errou nas últimas sessões volta a ser <strong>pendente</strong> imediatamente.</p><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lightbulb-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">O erro zera a sequência</p><p class="small mb-0" style="color:var(--bs-secondary-color)">Um único erro faz a sequência de acertos voltar para zero. Isso garante que você só domina um cartão quando acerta consistentemente, não por sorte.</p></div></div>'],
            ['id' => 'configuracao', 'title' => 'Os parâmetros que você controla',
             'content' => '<p>O SRS do Play Flashcards tem quatro parâmetros configuráveis no seu perfil, todos com valores padrão pensados para a maioria dos casos:</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Parâmetro</th><th>Padrão</th><th>O que controla</th></tr></thead><tbody><tr><td class="fw-semibold small">Taxa de acerto mínima</td><td class="font-monospace small">75%</td><td>Abaixo desse percentual, o cartão permanece <strong>pendente</strong>.</td></tr><tr><td class="fw-semibold small">Sequência de acertos</td><td class="font-monospace small">5</td><td>Mínimo de acertos consecutivos sem nenhum erro.</td></tr><tr><td class="fw-semibold small">Intervalo de revitalização</td><td class="font-monospace small">7 dias</td><td>Cartões não estudados nesse período voltam a ser <strong>pendentes</strong>, mesmo que já dominados.</td></tr><tr><td class="fw-semibold small">Limite por sessão</td><td class="font-monospace small">20 cartões</td><td>Máximo de cartões por sessão de estudo SRS.</td></tr></tbody></table></div><p class="mt-3">Você pode ajustar esses valores conforme o seu ritmo de aprendizado. Quem estuda diariamente pode reduzir o intervalo de revitalização; quem tem um baralho muito grande pode aumentar o limite por sessão.</p>'],
            ['id' => 'sessao-de-estudo', 'title' => 'Como é uma sessão de estudo SRS',
             'content' => '<p>Ao iniciar uma sessão SRS em um baralho, o Play Flashcards seleciona automaticamente os cartões <strong>pendentes</strong>, embaralha-os e apresenta um por vez. Para cada cartão você vê a frente, decide sua resposta mentalmente e revela o verso para conferir.</p><p>Você então indica se acertou ou errou. Essa resposta é registrada imediatamente e atualiza as três métricas do cartão. Ao final da sessão, o sistema mostra o resultado: quantos cartões você acertou e quantos errou.</p><p>Se não houver nenhum cartão <strong>pendente</strong> no baralho, o sistema informa que tudo está em dia e não há nada para revisar no momento.</p>'],
        ];
}

$header_title        = $page_h1 . ' - Play Flashcards';
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

                <!-- CTA: visível apenas no desktop (mobile fica no fim da página) -->
                <div class="card p-3 d-none d-lg-block">
                    <p class="fw-semibold small mb-1"><?= car_htmlspecialchars($sidebar_cta_title) ?></p>
                    <p class="small text-secondary mb-3"><?= car_htmlspecialchars($sidebar_cta_desc) ?></p>
                    <a class="btn btn-sm btn-primary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/login/login' ?>">
                        <?= car_htmlspecialchars($sidebar_cta_btn) ?>
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

            <!-- CTA: visível apenas no mobile (desktop fica na sidebar) -->
            <div class="card p-3 mt-4 d-lg-none">
                <p class="fw-semibold small mb-1"><?= car_htmlspecialchars($sidebar_cta_title) ?></p>
                <p class="small text-secondary mb-3"><?= car_htmlspecialchars($sidebar_cta_desc) ?></p>
                <a class="btn btn-sm btn-primary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/login/login' ?>">
                    <?= car_htmlspecialchars($sidebar_cta_btn) ?>
                </a>
            </div>
        </div>

    </div>
</main>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>

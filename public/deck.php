<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
    // Parâmetros
    $user_id = cal_get_session_attribute('user_id', CAL_USER_ID_MASTER);

    // Variáveis
    $_page = $routes[$t['lang']];

    $user_id_deck = 0;
    $deck_key = '';
    $deck_id = 0;
    $deck_name = '';
    $deck_desc = '';
    $deck_url = '';
    $deck_follow = 0;

    $total_cards = 0;

    $has_deck = false;
    $page_deck_url = '';
    $page_redirect = false;

    if(isset($_GET['page'])) {
        $pages = $_GET['page'];

        //remove a / se houver no final a string
        if ($pages[strlen($pages) - 1] == '/') {
            $pages = substr($pages, 0, -1);
            $page_redirect = true;
        }

        $pages = explode('/', $pages);

        // $pages[0] = group
        // $pages[1] = deck_key
        // $pages[2] = deck_url
        $deck_key = $pages[1];

        // Procurando informações do deck publico
        $sql = sprintf("select user_id, deck_id, deck_name, deck_desc, deck_url, deck_follow from car_deck where deck_key = '%s' and deck_public = 1",
                        $mysqli->real_escape_string(cal_never_null($deck_key)));

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $user_id_deck = $row['user_id'];
            $deck_id = $row['deck_id'];
            $deck_name = $row['deck_name'];
            $deck_desc = $row['deck_desc'];
            $deck_url = $row['deck_url'];
            $deck_follow = $row['deck_follow'];

            $has_deck = true;
        }

        // Procurando o total de cartões deste grupo
        $sql = sprintf('select count(1) as count from car_card where deck_id = %d', $deck_id);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $total_cards = $row['count'];
        }
    }

    // Definindo title e meta description
    $_title = cal_t($t, 'Deck');
    if (!empty($deck_name)) $_title .= ': '. $deck_name;

    // Se a deck_url do banco de dados for diferente da deck_url do pages, então redirecionar
    if (isset($pages[2]) === true) {
        $page_deck_url = $pages[2];
    }

    if ($deck_url != $page_deck_url || $page_redirect) {
        cal_redirect(CAL_PATH_WEB . '/deck/'. $deck_key . '/'. $deck_url);
    }
?>
<?php
    $header_title = cal_htmlspecialchars($_title) . ' - Play Flashcards';
    $header_description = cal_htmlspecialchars($deck_desc);
    if ($deck_follow) {
        $header_index_follow = 'index,follow';
    } else {
        $header_index_follow = 'noindex,nofollow';
    }
    include_once CAL_ROOT_WEB . '/include/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAL_ROOT_WEB . '/include/message.inc' ?>
        <?php if ($has_deck) { ?>
            <div class="title">
                <?= cal_t($t, 'Deck'); ?>
            </div>
            <div class="stats-title">
                <?= cal_htmlspecialchars($deck_name); ?>
            </div>
            <div class="stats-value">
                <?= cal_htmlspecialchars($deck_desc); ?>
            </div>
            <?php if($total_cards > 0) { ?>
                <div>
                    <?php if ($user_id == $user_id_deck) { // usuario logado é o dono do deck ?>
                        <a href="<?= CAL_PATH_WEB; ?>/dash/study-srs-new-act?k=<?= $deck_key; ?>" class="buttonx">
                            <?= cal_t($t, 'Play SRS'); ?>
                        </a>
                        <a href="<?= CAL_PATH_WEB; ?>/dash/study-new-act?k=<?= $deck_key; ?>" class="buttonx">
                            <?= cal_t($t, 'Play'); ?>
                        </a>
                    <?php } else { ?>
                        <form action="<?= CAL_PATH_WEB; ?>/deck/study-new-act" method="post">
                            <input type="hidden" name="k" value="<?= cal_htmlspecialchars($deck_key); ?>">
                            <input type="submit" value="<?= cal_t($t, 'Play'); ?>" class="buttonx" />
                        </form>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <?= cal_t($t, 'This deck has no flashcards.'); ?>
                <?php } ?>
        <?php } else { ?>
            <?= cal_t($t, 'Deck not found.'); ?>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAL_ROOT_WEB . '/include/box-signin.inc'; ?>
    <?php include_once CAL_ROOT_WEB . '/include/box-follow-decks.inc'; ?>
</div>
<?php include_once CAL_ROOT_WEB . '/include/footer.inc'; ?>


<?php
    $sql = sprintf('select deck_key, deck_name
                             from car_deck 
                            where deck_follow = 1
                              and deck_public = 1
                            order by deck_name asc');

	$result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
?>
<?php if ($result->num_rows > 0) { ?>
    <div class="div-box">
        <div class="title">
            <?= cal_t($t, 'Samples'); ?>
        </div>
        <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
            <div class="line">
                <a href="<?= CAL_PATH_WEB . '/deck/' . $row['deck_key']; ?>">
                    <?= cal_htmlspecialchars($row['deck_name']); ?>
                </a>
            </div>
        <?php } ?>
    </div>
<?php } ?>
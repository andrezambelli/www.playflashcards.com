<?php // $deck_key precisa estar definida no arquivo pai ?>
<div class="stats-title"><?= cal_t($t, 'New Study'); ?>:</div>
<div class="stats-value">
    <table class="tip-table">
        <tr>
            <td class="td1">
                <a href="<?= CAL_PATH_WEB; ?>/dash/study-srs-new-act?k=<?= $deck_key; ?>" class="buttonx w75">
                    <?= cal_t($t, 'Play SRS'); ?>
                </a>
            </td>
            <td class="td2">
                <div class="tip">
                    <?= cal_t($t, 'dash.new-study.play-srs-info'); ?> <a href="<?= CAL_PATH_WEB . '/profile/srs'; ?>">SRS</a>.
                </div>
            </td>
        </tr>
        <tr>
            <td class="td1">
                <a href="<?= CAL_PATH_WEB; ?>/dash/study-new-act?k=<?= $deck_key; ?>" class="buttonx w75">
                    <?= cal_t($t, 'Play'); ?>
                </a>
            </td>
            <td class="td2">
                <div class="tip">
                    <?= cal_t($t, 'dash.new-study.play-info'); ?>
                </div>
            </td>
        </tr>
    </table>
</div>

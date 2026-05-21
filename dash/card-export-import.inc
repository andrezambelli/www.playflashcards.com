<?php // $deck_key precisa estar definida no arquivo pai ?>
<div class="stats-title"><?= cal_t($t, 'Export and Import'); ?>:</div>
<div class="stats-value">
    <table class="tip-table">
        <tr>
            <td class="td1">
                <a href="<?= CAL_PATH_WEB; ?>/dash/card-download-act?k=<?= $deck_key; ?>" class="buttonx w75">
                    <?= cal_t($t, 'Export'); ?>
                </a>
            </td>
            <td class="td2">
                <div class="tip">
                    <?= cal_t($t, 'dash.card-list.export'); ?><br/>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td1">
                <form id="upload_form" action="<?= CAL_PATH_WEB; ?>/dash/card-upload-act" method="post" enctype="multipart/form-data">
                    <input type="file" id="input_file" name="input_file" style="display: none;">
                    <input type="hidden" name="k" value="<?= $deck_key; ?>">
                    <label for="input_file" class="buttonx w75"><?= cal_t($t, 'Import'); ?></label>
                </form>
            </td>
            <td class="td2">
                <div class="tip">
                    <?= cal_t($t, 'dash.card-list.import'); ?><br/>
                </div>
            </td>
        </tr>
    </table>
</div>

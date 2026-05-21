<?php // $deck_key precisa estar definida no arquivo pai ?>
<div class="stats-title"><?= car_t($t, 'Export and Import'); ?>:</div>
<div class="stats-value">
    <table class="tip-table">
        <tr>
            <td class="td1">
                <a href="<?= CAR_PATH_WEB; ?>/dash/card-download-act?k=<?= $deck_key; ?>" class="buttonx w75">
                    <?= car_t($t, 'Export'); ?>
                </a>
            </td>
            <td class="td2">
                <div class="tip">
                    <?= car_t($t, 'dash.card-list.export'); ?><br/>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td1">
                <form id="upload_form" action="<?= CAR_PATH_WEB; ?>/dash/card-upload-act" method="post" enctype="multipart/form-data">
                    <input type="file" id="input_file" name="input_file" style="display: none;">
                    <input type="hidden" name="k" value="<?= $deck_key; ?>">
                    <label for="input_file" class="buttonx w75"><?= car_t($t, 'Import'); ?></label>
                </form>
            </td>
            <td class="td2">
                <div class="tip">
                    <?= car_t($t, 'dash.card-list.import'); ?><br/>
                </div>
            </td>
        </tr>
    </table>
</div>

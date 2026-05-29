<?php
$car_langs = [
    'de'    => 'Deutsch',
    'en'    => 'English',
    'es'    => 'Español',
    'fr'    => 'Français',
    'hi'    => 'हिंदी',
    'it'    => 'Italiano',
    'ja'    => '日本語',
    'nl'    => 'Nederlands',
    'pl'    => 'Polski',
    'pt-br' => 'Português (Brasil)',
    'ru'    => 'Русский',
    'zh'    => '中文',
];

function car_lang_options(string $selected): string {
    global $car_langs;
    $html = '';
    foreach ($car_langs as $code => $name) {
        $sel  = $selected === $code ? ' selected' : '';
        $html .= '<option value="' . $code . '"' . $sel . '>' . $name . '</option>' . "\n";
    }
    return $html;
}

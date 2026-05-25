<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php
    // Parâmetros
    $user_id = car_get_session_attribute('user_id', CAR_USER_ID_MASTER);

    $new_lang = car_get_parameter('lang', CAR_SYSTEM_LANG_DEFAULT); // novo idioma do parâmetro

    // Variáveis
    $original_lang = $_SESSION['lang']; // idioma da sessão
    $redirect_url = car_safe_redirect_url($_SERVER['HTTP_REFERER'] ?? '', '');

    // Carrega o conteúdo do idioma do navegador na sessão
    $_SESSION['lang'] = $new_lang;

    // Atualiza o idioma no usuário
    if ($user_id != CAR_USER_ID_MASTER) {
        $sql = sprintf("update car_user set user_lang = '%s', user_update = now() where user_id = %d",
            $mysqli->real_escape_string($new_lang),
            $user_id);

        $result = $mysqli->query($sql);

        $mysqli->commit();
    }

    if (empty($redirect_url)) {
        // Se não tem URL para redirecionar, volta para a home do idioma
        $redirect = CAR_PATH_WEB . '/' . $new_lang . '/';
    } elseif (substr($redirect_url, -3) === '/en' || substr($redirect_url, -4) === '/en/' ||
        substr($redirect_url, -5) === '/pt-br' || substr($redirect_url, -6) === '/pt-br/' ||
        substr($redirect_url, -3) === '/es' || substr($redirect_url, -4) === '/es/' ||
        substr($redirect_url, -3) === '/fr' || substr($redirect_url, -4) === '/fr/') {

        // Se a URL termina idoma, volta para a mesma página com o novo idioma
        $redirect_url = CAR_PATH_WEB . '/' . $new_lang . '/';
    } elseif (substr($redirect_url, -strlen('/en')) === '/en' ||
        substr($redirect_url, -strlen('/pt-br')) === '/pt-br' ||
        substr($redirect_url, -strlen('/es')) === '/es' ||
        substr($redirect_url, -strlen('/fr')) === '/fr') {

        // Se a URL possui idoma, volta para a mesma página com o novo idioma
        $redirect_url = $redirect_url . '/';
    } elseif (substr($redirect_url, -strlen('.com')) === '.com') {
        $redirect_url = $redirect_url . '/' . $original_lang . '/';
    } elseif (substr($redirect_url, -strlen('.com/')) === '.com/') {
        $redirect_url = $redirect_url . $original_lang . '/';
    } elseif (substr($redirect_url, -strlen('/index.php')) === '/index.php') {
        $redirect_url = CAR_PATH_WEB . '/'. $original_lang . '/';
    }

    $redirect = str_replace('/' . $original_lang . '/', '/' . $new_lang . '/', $redirect_url);

    // Se o idioma não estava na URL (ex: /), redireciona para a home do novo idioma
    if ($redirect === $redirect_url) {
        $redirect = CAR_PATH_WEB . '/' . $new_lang . '/';
    }

    // parâmetro explícito tem prioridade (usado em páginas sem prefixo de idioma na URL)
    $param_redirect = car_get_parameter('redirect_url', '');
    if (!empty($param_redirect)) {
        $redirect = car_safe_redirect_url($param_redirect, $redirect);

        $parsed = parse_url($redirect);
        $path = $parsed['path'] ?? '';
        $parts = explode('/', ltrim($path, '/'));
        $valid_langs = ['en', 'pt-br', 'es', 'fr'];

        if (!empty($parts[0]) && in_array($parts[0], $valid_langs)) {
            $parts[0] = $new_lang;
            $new_path = '/' . implode('/', $parts);
            $redirect = '';

            if (!empty($parsed['scheme']) && !empty($parsed['host'])) {
                $redirect = $parsed['scheme'] . '://' . $parsed['host'];
                if (!empty($parsed['port'])) {
                    $redirect .= ':' . $parsed['port'];
                }
            }

            $redirect .= $new_path;

            if (!empty($parsed['query'])) {
                $redirect .= '?' . $parsed['query'];
            }
        }
    }

    car_redirect($redirect);

<?php
    $GLOBALS['NORMALIZE_CHARS'] = array(
        'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
        'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
        'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
        'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'s', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
        'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
        'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
        'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f', '&'=>' e ',
        '?'=>'',  '('=>'',  ')'=>'',  '<'=>'',  '>'=>'',  '='=>'',  '/'=>'', '\\'=>'', '|'=>'',
        '+'=>''
    );

    function car_check_admin_login() {
        $_login = car_get_session_attribute('session_admin_login', '');

        // se não estiver logado, redireciona para a página de login
        if ($_login == 'off' and strrpos($_SERVER['REQUEST_URI'], '/login/login.php') === false) {
            car_redirect('../login/login.php?redirect_url=' . urlencode(car_current_url()));
        }
    }

    /*
     * Calcula a porcentagem de um número sobre outro. by chatGPT
     */
	function car_percent($_value, $_total) {
		if ($_total !== 0) {
			return round(($_value / $_total) * 100);
		} else {
			return 0;
		}
	}
	
	/*
	 * Subtração de datas. by chatGPT
	 * Retorna o tempo em 36h 34min 36s
	 */
	function car_diff_dates($_begin, $_end) {
		$_b = new DateTime($_begin);
		$_e = new DateTime($_end);
		
		$_diff = $_b->diff($_e);
		
		$_h = $_diff->h + ($_diff->days * 24);
		$_m = $_diff->i;
		$_s = $_diff->s;
		
		$_resul = '';
		
		if ($_h > 0) {
			$_resul = $_h . 'h';
		}
		
		if ($_m > 0) {
			$_resul = $_resul . ' ' . $_m . 'min';
		}
		
		$_resul = $_resul . ' ' . $_s . 's';
		
		return trim($_resul);
	}
	
	/*
	 * Recuperando o idioma do navegador. by chatGPT
	 */
	function car_get_browser_language() {
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$preferredLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
			$languages = explode(',', $preferredLanguages);
			
			$preferredLanguage = strtolower(trim($languages[0]));

			return $preferredLanguage;
		} else {
            return 'en'; // Defina um idioma padrão aqui
        }
	}

    /*
     * Transforma texto em URL
     * Por exemplo: Andre Luis para andre-luis
     */
    function car_text_to_url($_text) {
        $_text = strtr($_text, $GLOBALS['NORMALIZE_CHARS']); // remove acentuação
        $_text = trim($_text);
        $_text = strtr($_text, ' ', '-'); // substitui espaço por hífen
        $_text = strtolower($_text); // caixa baixa
        $_text = trim($_text);

        return $_text;
    }
    /*
     * Lê um atributo da sessão
     */
	function car_get_session_attribute($_key, $_default) {
		$_result = '';

		if (isset($_SESSION) and isset($_SESSION[$_key])) {
			$_result = $_SESSION[$_key];
		} else {
			$_result = $_default;
		}
		
		return $_result;
	}

    /*
     * Grava um atributo na sessão
     */
	function car_set_session_attribute($_key, $_value) {
		if (!empty($_key)) {
			$_SESSION[$_key] = $_value;
		}		
	}

    /*
     * Lê um parâmtro da requisição GET ou POST
     */
	function car_get_parameter($_name, $_default) {
		$_value = $_default;
		
		if (isset($_GET[$_name])) $_value = trim($_GET[$_name]);
		else if (isset($_POST[$_name])) $_value = trim($_POST[$_name]);
		
		if (empty($_value)) $_value = $_default;
		
		return $_value;
	}

	/*
	 * Recupera o último id inserido no banco de dados
	 */
	function car_last_insert_id($_mysqli) {
		$_id = 0;
		$_sql = 'select last_insert_id() as last_insert_id';
		$_result = $_mysqli->query($_sql, MYSQLI_USE_RESULT);
	
		while (list($_last_insert_id) = $_result->fetch_row()) {
			$_id = $_last_insert_id;
		}
		
		return $_id;		
	}

    /*
     * Verifica se o usuário está logado
     * Se não estiver logado, redireciona para a página de login
     * Se estiver logado e acessar a página de login, então direciona para a lista de grupos
     */
	function car_check_login($_t) {
		$_login = car_get_session_attribute('session_login', '');
	
		// se não estiver logado, redireciona para a página de login 
		if ($_login == 'off' and strrpos($_SERVER['REQUEST_URI'], '/login/login') === false) {
			car_redirect(CAR_PATH_WEB . '/'. $_t['lang'] . '/login/login?redirect_url=' . urlencode(car_current_url()));
	
		} else if ($_login == 'on' and strrpos($_SERVER['REQUEST_URI'], '/login/login') !== false) { // se estiver logado e acessar o /login/login/ direciona para a /home
			car_redirect(CAR_PATH_WEB . '/dash/deck-list');
		}
	}

    /*
     * Retorna o valor da chave $_key do array $_t
     */
    function car_t($_t, $_key) {
        if (isset($_t[$_key])) {
            return car_htmlspecialchars($_t[$_key]);
        } else {
            return car_htmlspecialchars('*'. $_key);
        }
    }

    /*
     * Se o idioma da URL for diferente do idioma do parâmetro,
     * Então redireciona para a mesma página do idioma do parâmtro
     */
    function car_check_language($_lang) {
        $_new_lang = 'en';

        if (strrpos($_SERVER['REQUEST_URI'], '/en/') !== false || substr($_SERVER['REQUEST_URI'], -strlen('/en')) === '/en') {
            $_new_lang = 'en';
        } elseif (strrpos($_SERVER['REQUEST_URI'], '/pt-br/') !== false || substr($_SERVER['REQUEST_URI'], -strlen('/pt-br')) === '/pt-br') {
            $_new_lang = 'pt-br';
        } elseif (strrpos($_SERVER['REQUEST_URI'], '/es/') !== false || substr($_SERVER['REQUEST_URI'], -strlen('/es')) === '/es') {
            $_new_lang = 'es';
        } elseif (strrpos($_SERVER['REQUEST_URI'], '/fr/') !== false || substr($_SERVER['REQUEST_URI'], -strlen('/fr')) === '/fr') {
            $_new_lang = 'fr';
        } elseif (strrpos($_SERVER['REQUEST_URI'], '/index.php') !== false || substr($_SERVER['REQUEST_URI'], -strlen('/index.php')) === '/index.php') {
            $_new_lang = $_lang;
        } elseif ($_SERVER['REQUEST_URI'] == '') {
            $_new_lang = $_lang;
        } elseif ($_SERVER['REQUEST_URI'] == '/') {
            $_new_lang = $_lang;
        }

        if ($_new_lang != $_lang) {
           car_redirect(car_get_base_url(CAR_PATH_WEB) . '/services/change-language-act?lang=' . $_new_lang . '&redirect_url=' . urlencode(car_current_url()));
        }
    }

    /*
     * Valida se uma URL de redirect pertence ao mesmo host do servidor.
     * Retorna a URL original se for segura, ou $_fallback caso contrário.
     */
    function car_safe_redirect_url($_url, $_fallback = '') {
        if (empty($_url)) return $_fallback;
        $_parsed = parse_url($_url);
        if (!isset($_parsed['host'])) return $_url; // URL relativa é segura
        if (isset($_SERVER['HTTP_HOST']) && $_parsed['host'] === $_SERVER['HTTP_HOST']) return $_url;
        return $_fallback;
    }

    /*
     * Redireciona a página
     */
	function car_redirect($_url) {
		if (!headers_sent()) {
			header('Location: ' . $_url);
		} else {
			echo '<script>window.location.href = "' . $_url . '";</script>';
		}
		exit;
	}
	
	/*
	 * Retorna a URL do servidor
	 * https://www.playflashcards.com
	 * ou
	 * https://localhost
	 */
	function car_get_base_url($_path) {
		$_protocol = 'http';
		
		if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')) {
			$_protocol = 'https';
		}
		
		$_host = $_SERVER['HTTP_HOST'];
		$_baseUrl = $_protocol . '://' . $_host;
		
		if (substr($_baseUrl, -1) == '/') {
			$_baseUrl = substr($_baseUrl, 0, mb_strlen($_baseUrl, 'UTF-8') - 1);
		}
		
		return $_baseUrl . $_path;
	}

    /*
     * Retorna a URL do navegador
     */
	function car_current_url() {
		$_protocol = 'http';

		if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')) {
			$_protocol = 'https';
		}

		$_host        = $_SERVER['HTTP_HOST'];
		$_request_uri = $_SERVER['REQUEST_URI'];
 
		$_current_url = $_protocol . '://' . $_host . $_request_uri;
 
		return $_current_url;
	}
	
	/*
	 * Gera a chave que será utilizada nos grupos, cartões e estudos
	 */
	function car_generate_key($_size) {
        $random = '';

        $_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        for ($i = 0; $i < $_size; $i++) {
            $random .= $_chars[random_int(0, strlen($_chars) - 1)];
        }

  		return $random;
	}

    /*
     * Remove os caracteres especiais
     */
	function car_htmlspecialchars($_string) {
		return htmlspecialchars(car_never_null($_string));
	}
	
	/*
	 * Se a strint for null, retorna branco ''
	 */
	function car_never_null($_string) {
		$_text = '';
		
		if ($_string != null)  $_text = $_string;
		
		return $_text;
	}
	
    /*
     * Escreve conteúdo na variável de erro da sessão
     */
	function car_set_session_error_message($_message) {
		car_set_session_attribute('error_message', $_message);
	}

    /*
     * Lê a variável de erro da sessão
     */
	function car_get_session_error_message() {
		return car_get_session_attribute('error_message', '');
	}

    /*
     * Retorna verdadeiro se existe variável de erro na sessão
     * Senão retorna false
     */
	function car_has_session_error_message() {
		return (car_get_session_error_message() != '' ? true : false);
	}
	
	/*
	 * Grava conteúdo na variável de alerta da sessão
	 */
	function car_set_session_alert_message($_message) {
		car_set_session_attribute('alert_message', $_message);
	}

    /*
	 * Lê a variável de alerta da sessão
	 */
	function car_get_session_alert_message() {
		return car_get_session_attribute('alert_message', '');
	}

    /*
     * Retorna verdadeiro se existe variável de alerta na sessão
     * Senão retorna false
     */
	function car_has_session_alert_message() {
		return (car_get_session_alert_message() != '' ? true : false);
	}
?>

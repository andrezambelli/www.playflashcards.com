<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once 'config.inc' ?>
<?php
    $_request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $_request_path = strtok($_request_uri, '?');
    if (strpos($_request_path, '//') !== false) {
        $_query = parse_url($_request_uri, PHP_URL_QUERY);
        $_redirect = preg_replace('#/+#', '/', $_request_path);
        if (!empty($_query)) {
            $_redirect .= '?' . $_query;
        }
        car_redirect($_redirect);
    }
    unset($_request_uri, $_request_path, $_query, $_redirect);

	$_page = $routes['en'];

    if(isset($_GET['page'])){
        $pages = $_GET['page'];

		//remove a / se houver no final a string
		if($pages[strlen($pages)-1] == '/') $pages = substr($pages, 0, -1);

		if(array_key_exists($pages, $routes)) {
			$_page = $routes[$pages];
        } else {
            $pages = explode('/', $pages);

            if (sizeof($pages) == 3) {
                if ($pages[0] == 'deck') {
                    $_page = CAR_ROOT_WEB . '/public/deck.php'; // /group/abc123/cores-ingles-portugues
                } else {
                    $_page = $routes["404"];
                }
            } elseif (sizeof($pages) == 2) {
                if ($pages[0] == 'deck') {
                    $_page = CAR_ROOT_WEB . '/public/deck.php'; // /group/abc123
                } elseif ($pages[0] == 'study') {
                    $_page = CAR_ROOT_WEB . '/public/study.php'; // /study/abc123
                } else {
                    $_page = $routes["404"];
                }
            } else {
                $_page = $routes["404"];
            }
        }
    }

    include_once $_page;
	unset($_page);

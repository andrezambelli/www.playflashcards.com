<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_ADMIN . '/config.inc' ?>
<?php
    // Variáveis
    $today = date("Y-m-d");

	// Procurando os grupos que podem ser indexados
    $sql = sprintf('select deck_key, deck_url from car_deck where deck_public = 1 and deck_follow = 1');

	$result_decks = $mysqli->query($sql, MYSQLI_STORE_RESULT);
?>
<?php include_once CAL_ROOT_ADMIN . "/include/header.inc"; ?>
<div class="master">
	<div class="form">
		<strong>Sitemap</strong><br/>
		<br/>
		<?php 
			$xml = '<?xml version="1.0"?><urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">';
			
			// Estáticas Home
			$xml .= '<url><loc>https://www.playflashcards.com/en/</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
			$xml .= '<url><loc>https://www.playflashcards.com/pt-br/</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
			$xml .= '<url><loc>https://www.playflashcards.com/es/</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
			$xml .= '<url><loc>https://www.playflashcards.com/fr/</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';

            $xml .= '<url><loc>https://www.playflashcards.com/en/contact-us</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
            $xml .= '<url><loc>https://www.playflashcards.com/pt-br/contact-us</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
            $xml .= '<url><loc>https://www.playflashcards.com/es/contact-us</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
            $xml .= '<url><loc>https://www.playflashcards.com/fr/contact-us</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';

            echo '[OK] Estáticas Home = 4<br/>';

            // Estatáticas Login
            $xml .= '<url><loc>https://www.playflashcards.com/en/login/login</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
            echo '[OK] Estáticas Login = 1<br/>';

            $xml .= '<url><loc>https://www.playflashcards.com/en/contact-us</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            $xml .= '<url><loc>https://www.playflashcards.com/en/terms-and-conditions</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
            $xml .= '<url><loc>https://www.playflashcards.com/en/privacy-policy</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
            echo '[OK] Estáticas Footer = 3<br/>';

            // Grupos públicos
            $count = 0;

            while ($row = $result_decks->fetch_array(MYSQLI_ASSOC)) {
				$count += 1;

				$x = '<url><loc>';
				
				$x .= 'https://www.playflashcards.com/deck/' . $row['deck_key'] . '/'. $row['deck_url'];
				
				$x .= '</loc><lastmod>'.$today.'</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>';
		
				$xml .= $x;
			}
			
			echo '[OK] Grupos = ' . $count . '<br/>';
			
			$xml .= '</urlset>';
		?>
		<?php 
			$file_path_name = CAL_ROOT_WEB . '/sitemap.xml';
			
			if (file_exists($file_path_name)) {
				unlink($file_path_name);
			}
			
			file_put_contents($file_path_name, $xml);
			
			echo '[OK]<br/>';
		?>
		<br/>
		Sitemap criado com sucesso.<br/>
		<br/>
		Arquivo gerado: <a href="<?= CAL_PATH_WEB . '/sitemap.xml'; ?>"><?= CAL_PATH_WEB . '/sitemap.xml'; ?></a>
	</div>
</div>
<?php include_once CAL_ROOT_ADMIN . "/include/footer.inc"; ?>

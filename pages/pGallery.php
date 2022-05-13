<div id="galleryback"></div>


<article>
<?php

	if ( defined ( 'PICTURE' ) && PICTURE != null ) {
		$filetype = strtolower(pathinfo('gallery/' . ALBUM . '/' . PICTURE , PATHINFO_EXTENSION));
		$pictureList = scandir ('./gallery/' . ALBUM);

		foreach ($pictureList as $number => $name) {
			if ( $name == PICTURE ) {
				$lastPic = $pictureList[$number-1];
				$nextPic = $pictureList[$number+1];

				if ($lastPic == "..") {
					$lastPic = null;
				}
				if ($nextPic == "") {
					$nextPic = null;
				}
			}
		}

		// show single picture
		echo '
				<header class="gallery">
					<h1 class="albumtitle">' . explode("---", ALBUM)[1] . ' - ' . explode("---", ALBUM)[2]  . '</h1>
					<h2>' . PICTURE . '</h2>
					<p><a class="button" href="?page=gallery&album=' . ALBUM . '">&larr; zurück zum Album</a><a class="button" href="?page=login&action=logout">Abmelden</a></p>';

		echo '<p>';

		if ( $lastPic != null ) {
			echo '<a class="button" href="?page=gallery&album=' . ALBUM . '&picture=' . $lastPic . '">&larr; Zurückblättern</a>';
		}

		if ( $nextPic != null ) {
			echo '<a class="button" href="?page=gallery&album=' . ALBUM . '&picture=' . $nextPic . '">Weiterblättern &rarr;</a>';
		}
		echo '</p>';

		echo'	</header>';

		if ( $filetype == "jpg" ) {
			echo '<img class="single" src="gallery/' . ALBUM . '/' . PICTURE . '">';
		} elseif ( $filetype == "mp4" ) {
		echo '
			 <video class="single" controls>
			  <source src="gallery/' . ALBUM . '/' . PICTURE . '" type="video/mp4">
			Your browser does not support the video tag.
			</video> ';

		}

		echo '<footer><a class="button" href="gallery/' . ALBUM . '/' . PICTURE . '">Originaldatei öffnen</a></footer>';

	}
	elseif ( defined ( 'ALBUM' ) && ALBUM != null ) {
		// show specified album
		echo '	<header class="gallery">
					<h1>' . explode("---", ALBUM)[1] . ' - ' . explode("---", ALBUM)[2]  . '</h1>
					<p><a class="button" href="?page=gallery">&larr; zurück zur Galerie</a><a class="button" href="?page=login&action=logout">Abmelden</a></p>
				</header>
		';
		$pictures = scandir('./gallery/' . ALBUM);
		echo '<div class="gallery">';
		foreach ( $pictures as $picture) {
			if ( $picture != "." && $picture != ".." && $picture != "thumb.jpg" && is_file( "gallery/" . ALBUM . "/" . $picture ) ) {
				$picPath = 'gallery/' . ALBUM . '/' . $picture;
				$thumbFilename = pathinfo('gallery/' . ALBUM . '/' . $picture , PATHINFO_FILENAME);
				
				$pictureTitle = explode ($thumbFilename, '---')[1];
				
				$thumbPath = 'thumbs/' . ALBUM . '/' . $thumbFilename . '.jpg';


				if (!file_exists ('thumbs') ) {
					mkdir ('thumbs');
				}
				if (!file_exists ('thumbs/' . ALBUM) ) {
					mkdir ('thumbs/' . ALBUM);
				}
				if ( !file_exists( $thumbPath ) ) { Functions::makeThumb($picPath, $thumbPath, 500); }

				echo '<a class="thumbnail" href="?page=gallery&album=' . ALBUM . '&picture=' . $picture . '"><div class="imgcontainer"><img src="' . $thumbPath . '"></div><p class="imgname">' . $pictureTitle . '</p></a>';
			}
		}
		echo "</div>";

	} else {
		// Show gallery album overview

		echo '
			<header class="gallery">
				<h1>' . PAGETITLE .  '</h1>
				<p>Wenn du fertig bist, kannst du dich hier <a class="button" href="?page=login&action=logout">Abmelden</a></p>
			</header>
		';

		$albums = scandir('./gallery');
		echo '<div class="gallery">';
		foreach ( $albums as $album) {
			if ( $album != "." && $album != ".." && is_dir( "gallery/" . $album ) ) {

				$pictures	= scandir ('./gallery/' . $album);
				$firstPicture	= $pictures[2];

				if ( file_exists('gallery/'  . $album . '/thumb.jpg')) {
					$thumbFilename	= 'thumb';
				} else {
					$thumbFilename	= pathinfo('gallery/' . $album . '/' . $firstPicture , PATHINFO_FILENAME);
				}

				$thumbPath	= 'thumbs/'  . $album . '/' . $thumbFilename . '.jpg';
				$picPath	= 'gallery/' . $album . '/' . $thumbFilename . '.jpg';

				if (!file_exists ('thumbs') ) {
					mkdir ('thumbs');
				}
				if (!file_exists ('thumbs/' . $album) ) {
					mkdir ('thumbs/' . $album);
				}
				if ( !file_exists( $thumbPath ) ) { Functions::makeThumb($picPath, $thumbPath, 500); }

				echo '
					<a class="thumbnail" href="?page=gallery&album=' . $album . '">
						<p class="albumtitle">' . explode("---", $album)[1] . '</p>
						<p class="albumsubtitle">' . explode("---", $album)[2] . '</p>
						<div class="imgcontainer"><img src="' . $thumbPath . '"></div>
					</a>
				';
			}
		}
		echo "</div>";
	}
?>
</article>

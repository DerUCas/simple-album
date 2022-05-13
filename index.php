<?php
	require_once 'classes/cFunctions.php';
	Functions::loadConfig();
	Functions::prepareConstants();
	Functions::sessionHandling();

	echo Functions::getHeader();

    echo "<body>";

	if ( PAGE == "login" ) {
		include("pages/pLogin.php");
	} else {
		include("pages/pGallery.php");
	}

	echo '</body></html>';
?>

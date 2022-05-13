<?php
	$showloginerror = false;
	if ( ( isset ($_SESSION['loginerror'] ) ) && ( $_SESSION['loginerror'] == true ) ) {
		$showloginerror = true;
	} else {
		$redirect = '?page=gallery';
	}
?>

<article class="loginpage">
	<div class="logincontainer">
		<form class="white shadow login box" action="?page=login" method="post">
			<input type="hidden" name="action" value="login">
			<input type="password" class="text" placeholder="Hier das Passwort eingeben…" name="password"></input>
			<button type="submit" name="login" class="button">… und los geht's!</button>
			<?php
				if ( $showloginerror ) {
					echo '<p class="loginerror">Das war leider nicht korrekt.</p>';
				}
			?>
		</form>
	</div>
</article>

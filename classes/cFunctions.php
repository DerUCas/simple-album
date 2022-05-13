<?php
	class Functions {
		public static function loadConfig() {
			require_once 'config.php';
			return true;
		}

		public static function sessionHandling() {
			session_start();

			// if action is login
			if ( ( isset ( $_POST ) ) && ( ACTION == 'login' ) ) {
				$password	= "";

				if ( isset ( $_POST['password'] ) )
					$password = $_POST['password'];

				if ( $password == PASSWORD ) {
					$_SESSION['login'] = true;
					$_SESSION['loginerror'] = false;
					$_SESSION['admin'] = false;
				} else {
					$_SESSION['loginerror'] = true;
				}
			}

			// if action is logout, destroy the session and then redirect to loginpage
			if ( ( isset ( $_GET ) ) && ( ACTION == 'logout' ) ) {
				session_unset(); 
				session_destroy();
				header('Location: ?page=login');
				exit;
			}

			// if there is no usersession and the PAGE is not "login", redirect to login.
			if ( ( !( isset ( $_SESSION['login'] ) ) &&  ( PAGE != "login" ) ) ) {
				header('Location: ?page=login' );
				exit;
			}

			// if there is a usersession and the PAGE is "login", redirect to gallery.
			if ( ( ( isset ( $_SESSION['login'] ) ) && ( $_SESSION['login'] == true ) && ( PAGE == "login" ) ) ) {
				header('Location: ?page=gallery');
				exit;
			}
		}

		public static function getHeader() {
			$header = '<!DOCTYPE html>';
			$header .= "\n" . '<html xmlns="http://www.w3.org/1999/xhtml">';
			$header .= "\n" . '	<head>';
			$header .= "\n" . '		<meta charset="utf-8">';
			$header .= "\n" . '		<title>' . PAGETITLE . '</title>';
			$header .= "\n" . '		<meta name="viewport" content="width=device-width, initial-scale=1.0">';
			$header .= "\n" . '		<link rel="stylesheet" media="all" href="style.css" type="text/css" />';
			$header .= "\n" . '		<link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />';
			$header .= "\n" . '	</head>';
			$header .= "\n";
			return $header;
		}

		public static function prepareConstants() {
			if ( ( isset ( $_GET ) )	&& ( isset ( $_GET["page"] ) ) )		define ( 'PAGE',	$_GET["page"] );		else define ( 'PAGE', null );
			if ( ( isset ( $_GET ) )	&& ( isset ( $_GET["album"] ) ) )		define ( 'ALBUM',	$_GET["album"] );		else define ( 'ALBUM', null );
			if ( ( isset ( $_GET ) )	&& ( isset ( $_GET["picture"] ) ) )		define ( 'PICTURE',	$_GET["picture"] );		else define ( 'PICTURE', null );

			if ( ( isset ( $_GET ) )	&& ( isset ( $_GET["action"] ) ) )		define ( 'ACTION',	$_GET["action"] );
			elseif ( ( isset ( $_POST ) )	&& ( isset ( $_POST["action"] ) ) )
				define ( 'ACTION',	$_POST["action"] );		else define ( 'ACTION', null );

			if (isset ( $_SERVER ['HTTPS'] )) {
				$protocol = "https";
			} else {
				$protocol = "http";
			}

			// Read the used domain and the path where the app is available at.
			// Create $site and set SITEPATH as a constant to use inside the app
			$domain = $_SERVER ['SERVER_NAME'];
			$path = substr ( $_SERVER ['SCRIPT_NAME'], 0, - 9 );
			$request = substr ( $_SERVER ['REQUEST_URI'], strlen ( $path ) );
			$sitepath = "$protocol://$domain$path";

			define ( 'DOMAIN', $domain );
			define ( 'SITEPATH', $sitepath );
			define ( 'REQUEST', $request );

			return true;
		}

		private static function makeVideoThumb ($src, $dest, $desired_width) {
			// todo
		}



		private static function makeJpegThumb ($src, $dest, $desired_width) {
			/* read the source image */
			$source_image = imagecreatefromjpeg($src);

			if(function_exists("exif_read_data")){
				$exif = exif_read_data($src);
				if(!empty($exif['Orientation'])) {
					switch($exif['Orientation']) {
					case 8:
						$source_image = imagerotate($source_image,90,0);
					break;
					case 3:
						$source_image = imagerotate($source_image,180,0);
					break;
					case 6:
						$source_image = imagerotate($source_image,-90,0);
					break;
					}
				}
			}

			$width = imagesx($source_image);
			$height = imagesy($source_image);

			/* find the "desired height" of this thumbnail, relative to the desired width  */
			$desired_height = floor($height * ($desired_width / $width));

			/* create a new, "virtual" image */
			$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

			/* write the physical thumbnail image to its destination */
			imagejpeg($virtual_image, $dest);
		}

		public static function makeThumb($src, $dest, $desired_width) {
			$filetype = strtolower(pathinfo($src, PATHINFO_EXTENSION));

			if ( $filetype == "jpg" ) {
				self::makeJpegThumb($src, $dest, $desired_width);
			} elseif ( $filetype == "mp4" ) {
				self::makeVideoThumb($src, $dest, $desired_width);
			}


		}
	}
?>

# simple-picture-gallery

## How to use
* Clone the repository
* Edit "config.php", add a password and a title for your album. The title is used as the site title and headline in the gallery.
* Create folders for albums in the "gallery" directory
  * Use following naming scheme: "NUMBER---TITLE---SUBTITLE"
  * e.g.: "5---My funny Album---Here is all the fun"
  * or: "2022-03-12---The not so funny album---Here is the serious stuff"
  * The first part is invisible, the other parts are used to label the albums in the gallery.
* Put your pictures into the album directories
  * By default, the first picture in the folder is used as the album thumbnail
  * If you name a picture "thumb.jpg" it will be replace the default thumbnail, this file will not be shown in the album view
* The picture "gallery/wallpaper.jpg" is used for the background

## Prerequisites
* Any webserver with PHP should do, I use Apache with PHP8.0
* php-gd

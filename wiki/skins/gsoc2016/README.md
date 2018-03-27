# BRL-CAD MediaWiki Theme
This is a theme for BRL-CAD MediaWiki website. Made during Google Summer of Code 2016

## Installation
Place 'gsoc2016' folder and 'Gsoc2016.php' into skins folder. Enable theme by putting this in LocalSettings.php :
```php
$wgDefaultSkin = "gsoc2016";
require_once($_SERVER['DOCUMENT_ROOT']."/skins/Gsoc2016.php");
```
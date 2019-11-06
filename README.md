# Flexible Element Bundle
This contao module adds a Content Element that allows you to use a specific layout.

# Requirements
Contao >4 (tested with 4.8)
<br>
this library depends on visualradio (https://github.com/guavestudios/contao-visualradio)

# Install
- Add the following to your `composer.json`: 
```JSON
{
    "respositories": [
        {
            "type": "git",
            "url": "https://github.com/guavestudios/FlexibleElementBundle"
        }
    ],
    "require": {
        "guave/flexibleelement-bundle": "1.0"
    }
}
```
- Execute `composer update`
- Execute `php vendor/php/contao-console install assets`
- Add the following into your `src/Resources/contao/config/config.php`:
```PHP
<?php
$GLOBALS['TL_FLEXIBLEELEMENT']['templates'] = [
    [
        'id'       => 'flexible-2column-text',
        'template' => 'content-elements/ce_2column-text',
    ],
];

$GLOBALS['TL_FLEXIBLEELEMENT']['iconPath'] = 'files/<project>/images/contentelements';
```
- Add the following into your `src/Resource/contao/dca/tl_content.php`:
```PHP
<?php
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['elementTemplate_flexible-2column-text'] = 'flexibleTitle,flexibleText,flexibleTextColumn';
```
 using the ID of your `$GLOBALS['TL_FLEXIBLEELEMENT']['templates']` in the Subpalette's "elementTemplate_<id>" key

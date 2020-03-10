# Flexible Element Bundle
This contao module adds a Content Element that allows you to use a specific layout.

### Requirements
Contao >4 (tested with 4.8)
<br>
this library depends on visualradio (https://github.com/guavestudios/contao-visualradio)

### Install
`composer require guave/flexibleelement-bundle`

### Usage
- To change which fields are shown or add a new one, add a "templates" array into your `src/Resources/contao/config/config.php`:
```PHP
<?php
$GLOBALS['TL_FLEXIBLEELEMENT']['templates'] = [
    [
        'id'       => 'flexible-2column-text',
        'template' => 'content-elements/ce_2column-text',
    ],
];
```
- If you add a new field, add a new subpalette into your `src/Resource/contao/dca/tl_content.php`:
```PHP
<?php
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['elementTemplate_flexible-2column-text'] = 'flexibleTitle,flexibleText,flexibleTextColumn';
```
 using the ID of your `$GLOBALS['TL_FLEXIBLEELEMENT']['templates']` in the Subpalette's "elementTemplate_<id>" key

<?php

$GLOBALS['TL_CTE']['flexibleElement']['flexibleElement'] = Guave\FlexibleElementBundle\Elements\ContentFlexibleElement::class;

$GLOBALS['TL_FLEXIBLEELEMENT']['templates'] = [
    [
        'id'       => 'introtextwhite',
        'template' => 'content-elements/ce_intro_white',
    ],
];

$GLOBALS['TL_FLEXIBLEELEMENT']['iconpath'] = 'files/project/images/contentelements';
$GLOBALS['TL_FLEXIBLEELEMENT']['iconext']  = '.jpg';

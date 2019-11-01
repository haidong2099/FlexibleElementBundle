<?php

array_insert(
    $GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'],
    null,
    [
        'elementTemplate',
    ]
);
$GLOBALS['TL_DCA']['tl_content']['palettes']['flexibleElement'] = '{type_legend},type;{config_legend},elementTemplate;{template_legend:hide},customTpl;';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['elementTemplate_flexible-title-title-text-text'] = 'flexibleTitle,flexibleSubtitle,flexibleText';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['elementTemplate_flexible-right-image-text'] = 'flexibleTitle,flexibleSubtitle,flexibleText,flexibleImage';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['elementTemplate_flexible-left-image-text'] = 'flexibleTitle,flexibleSubtitle,flexibleImage,flexibleText';

$GLOBALS['TL_DCA']['tl_content']['fields']['elementTemplate'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['elementTemplate'],
    'default'   => 'above',
    'options'   => array_column($GLOBALS['TL_FLEXIBLEELEMENT']['templates'], 'id'),
    'inputType' => 'visualradio',
    'eval'      => [
        'mandatory'      => true,
        'submitOnChange' => true,
        'imagepath'      => $GLOBALS['TL_FLEXIBLEELEMENT']['iconpath'],
        'imageext'       => $GLOBALS['TL_FLEXIBLEELEMENT']['iconext'],
        'tl_class'       => 'w100 clr',
    ],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flexibleTitle'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flexibleTitle'],
    'inputType' => 'text',
    'eval'      => ['tl_class' => 'w100 clr'],
    'sql'       => 'varchar(255) NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flexibleSubtitle'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flexibleSubtitle'],
    'inputType' => 'textarea',
    'eval'      => ['rows' => 10, 'cols' => 100, 'tl_class' => 'w100 clr'],
    'sql'       => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flexibleText'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flexibleText'],
    'inputType' => 'textarea',
    'eval'      => ['rows' => 10, 'cols' => 100, 'rte' => 'tinyMCE', 'tl_class' => 'w100 clr'],
    'sql'       => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flexibleImage'] = [
    'label'         => &$GLOBALS['TL_LANG']['tl_content']['flexibleImage'],
    'exclude'       => true,
    'inputType'     => 'fileTree',
    'eval'          => ['files' => true, 'fieldType' => 'checkbox', 'multiple' => true, 'orderField' => 'orderSRC'],
    'sql'           => 'blob NULL',
    'load_callback' => [
        ['tl_content', 'setMultiSrcFlags'],
    ],
];

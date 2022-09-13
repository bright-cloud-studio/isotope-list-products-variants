<?php

 /* Extend the tl_user palettes */
foreach ($GLOBALS['TL_DCA']['tl_iso_product']['palettes'] as $k => $v) {
    $GLOBALS['TL_DCA']['tl_iso_product']['palettes'][$k] = str_replace('stop;', 'stop;{size_convert_legend},size_as_decimal;', $v);
}

/* Add fields to tl_user */
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['size_as_decimal'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_iso_product']['size_as_decimal'],
	'inputType'		=> 'text',
	'default'		=> '',
	'search'		=> true,
	'eval'			=> array('mandatory'=>false, 'tl_class'=>'w50'),
    'save_callback' => array
    (
        array('IsotopeBcs\Backend\Product\SizeConversion', 'convertSize'),
    ),
	'sql'			=> "varchar(255) NOT NULL default ''"
);

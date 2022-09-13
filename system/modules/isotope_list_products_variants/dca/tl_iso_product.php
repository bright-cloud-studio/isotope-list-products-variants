<?php

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
        array('Isotope\Backend\Product\SizeConversion', 'convertSize'),
    ),
	'sql'			=> "varchar(255) NOT NULL default ''"
);

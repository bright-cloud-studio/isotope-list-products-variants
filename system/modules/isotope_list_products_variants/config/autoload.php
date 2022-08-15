<?php

/**
 * Locations - Location Plugin for Contao
 *
 * Copyright (C) 2018 Andrew Stevens
 *
 * @package    asconsulting/locations
 * @link       http://andrewstevens.consulting
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */



ClassLoader::addClasses(array
(
	'ListProductVariants\Backend\ListProductVariantsHelper' 	=> 'system/modules/isotope_list_products_variants/library/Bcs/Backend/ListProductVariantsHelper.php',
	'ListProductVariants\Module\ListProductVariantsList' 		=> 'system/modules/isotope_list_products_variants/library/Bcs/Module/ListProductVariantsList.php',
));

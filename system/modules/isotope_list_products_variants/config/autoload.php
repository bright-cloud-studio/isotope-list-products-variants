<?php

/**
 * Bright Cloud Studio - Isotope List Products Variants
 *
 * Copyright (C) 2022 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/isotope-list-products-variants
 * @link       http://brightcloudstudio.com
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */



ClassLoader::addClasses(array
(
	'Bcs\Backend\ListProductsVariantsHelper' 	=> 'system/modules/isotope_list_products_variants/library/Bcs/Backend/ListProductsVariantsHelper.php',
	'Bcs\Module\ListProductsVariantsList' 		=> 'system/modules/isotope_list_products_variants/library/Bcs/Module/ListProductsVariantsList.php',
	'CustomTags\AddVariantsTags' 			=> 'system/modules/isotope_list_products_variants/library/CustomTags/AddVariantsTags.php'
));

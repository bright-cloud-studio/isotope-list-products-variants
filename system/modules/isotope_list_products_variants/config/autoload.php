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
	//'IsotopeBcs\Backend\Product\SizeConversion' 	=> 'system/modules/isotope_list_products_variants/library/IsotopeBcs/Backend/Product/SizeConversion.php',
	'Bcs\Backend\ListProductsVariantsHelper' 	=> 'system/modules/isotope_list_products_variants/library/Bcs/Backend/ListProductsVariantsHelper.php',
	'Bcs\Module\ListProductsVariantsList' 		=> 'system/modules/isotope_list_products_variants/library/Bcs/Module/ListProductsVariantsList.php',
    'Bcs\Module\ModShowVariants' 		=> 'system/modules/isotope_list_products_variants/library/Bcs/Module/ModShowVariants.php',
	'CustomTags\AddVariantsTags' 			=> 'system/modules/isotope_list_products_variants/library/CustomTags/AddVariantsTags.php'
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'item_variant' 	=> 'system/modules/isotope_list_products_variants/templates/items'
    'mod_show_variants' 	=> 'system/modules/isotope_list_products_variants/templates/modules'
));


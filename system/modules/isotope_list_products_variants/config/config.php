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


/**
 * Frontend modules
 */
$GLOBALS['FE_MOD']['isotope']['iso_list_products_variants'] 	= 'Bcs\Module\ListProductsVariants';


$GLOBALS['FE_MOD']['princeton']['mod_show_variants']              = 'Bcs\Module\ModShowVariants';

/* Hooks */
if (\Config::getInstance()->isComplete()) {
  $GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('CustomTags\AddVariantsTags', 'onReplaceTag');
}

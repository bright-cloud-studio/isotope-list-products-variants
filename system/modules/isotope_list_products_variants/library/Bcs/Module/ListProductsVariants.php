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

  
namespace Bcs\Module;

use Isotope\Module\ProductList;


class ListProductsVariants extends ProductList
{

	/**
     * Find all products we need to list.
     *
     * @param array|null $arrCacheIds
     *
     * @return array
     */
    protected function findProducts($arrCacheIds = null)
    {
	global $objPage;

	$arrProducts = parent::findProducts($arrCacheIds);

        return $arrProducts;
    }

}

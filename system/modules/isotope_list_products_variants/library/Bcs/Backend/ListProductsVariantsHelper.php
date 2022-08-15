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



namespace Bcs\Backend;


use Isotope\Model\Product;


class ListProductsVariantsHelper extends \Isotope\Backend
{


    /**
     * Find all products we need to list.
     *
     * @return array
     */
    function getProducts(\Contao\DataContainer $dc)
    {
		$objProducts = Product::findPublishedByCategories(array((int)$dc->id));

		$arrProducts = array();

		if ($objProducts) {
			while ($objProducts->next()) {
				$arrProducts[$objProducts->id] = $objProducts->name ." " .$objProducts->color_or_design_name ." (SKU: " .$objProducts->sku .")";
			}
		}

        return $arrProducts;
    }

}

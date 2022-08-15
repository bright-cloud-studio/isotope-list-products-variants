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

	/* We are going to customize the compile to add Variants to template */
	protected function compile()
	{
		$arrVariants = array();
		$arrVariants[] = array(
			'variant_1'     => 'ASDF',
			'variant_2'     => 'QUERTY'
		);
		$this->Template->variants = $arrVariants;
	}
	
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

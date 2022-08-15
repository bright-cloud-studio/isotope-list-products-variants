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

namespace CustomTags;
use Contao\Database;
use Contao\DataContainer;
use Contao\ContentElement;

class AddVariantsTags extends \System
{
	public function onReplaceTag (string $insertTag)
	{
		// if this tag doesnt contain :: it doesn't have an id, so we can stop right here
		if (stristr($insertTag, "::") === FALSE) {
			return 'Your tag has no ID. Please add a User ID or remove this tag from the page.';
		}

		// break our tag into an array
		$arrTag = explode("::", $insertTag);

		// lets make decisions based on the beginning of the tag
		switch($arrTag[0]) {
			// if the tag is what we want, {{simple_inventory::id}}, then lets go
			case 'add_variants':
				
				$strType = '';
				$query = \Database::getInstance()
				    ->prepare("SELECT * FROM `tl_iso_product` WHERE `pid` = '". $arrTag[1] ."';")
				    ->execute($strType);
				
				
				return 'Product ID: ' . $strType;
			break;
		}

		// something has gone horribly wrong, let the user know and hope for brighter lights ahead
		return 'something_went_wrong';
	}
}

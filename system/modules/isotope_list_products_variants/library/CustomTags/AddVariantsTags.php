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
use Contao\FrontendTemplate;

use Isotope\Model\Product;

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
			case 'variants':
				$dbObj = \Database::getInstance()->prepare("SELECT * FROM tl_iso_product WHERE pid = '" . $arrTag[1] . "' AND published = 1")->execute();  
				
				$buffer = '';
				
				if ($dbObj->numRows > 0)
				{
				    $arrLocation = array(
						'id'		=> 111,
						'pid'		=> 222
					);
				    while($dbObj->next()) {
				        $prod = Product::findOneBy(['tl_iso_product.id=?'],[$dbObj->id]);
                        $arrLocation['id'] 		= $dbObj->id;
    					$arrLocation['pid']		= $dbObj->pid;
    					$arrLocation['sku']		= $dbObj->sku;
    					$arrLocation['product'] = $prod;
    					$template = new FrontendTemplate('item_variant');
    					$template->variant = $arrLocation;
    					$buffer .= $template->parse();
				    }
					return $buffer;
				}
			break;
            case 'variants_dimentions':
				$dbObj = \Database::getInstance()->prepare("SELECT * FROM tl_iso_product WHERE pid = '" . $arrTag[1] . "' AND published = 1 ORDER BY CAST(size_as_decimal AS SIGNED)")->execute();  
				
				$buffer = '';
				if ($dbObj->numRows > 0)
				{
					$arrLocation = array(
						'id'		=> 111,
						'pid'		=> 222
					);
				    while($dbObj->next()) {
    				    
    					$arrLocation['id'] 		= $dbObj->id;
    					$arrLocation['pid']		= $dbObj->pid;
    					$arrLocation['sku']		= $dbObj->sku;
    					$arrLocation['wp_size']		= $dbObj->wp_size;
    					
    					$arrLocation['baseprice']	= 999;
    					
    					
    					// Lets get our correct prices
    					
    					// First, search tl_iso_product_price using this products ID and that fields PID
    					$step1 = \Database::getInstance()->prepare("SELECT * FROM tl_iso_product_price WHERE pid = '" . $dbObj->id . "'")->execute();  
    					while($step1->next()) {
    					    // Then, search tl_iso_product_pricetier using the PID from the last query to get the 'price'
    					    $step2 = \Database::getInstance()->prepare("SELECT * FROM tl_iso_product_pricetier WHERE pid = '" . $step1->id . "'")->execute();  
					        while($step2->next()) {
					            // Finally, assign that price to our templates array
					            $arrLocation['baseprice'] = $step2->price;
					        }
    					}
    					
    					$template = new FrontendTemplate('item_variant_dimentions');
    					$template->variant = $arrLocation;
    					$buffer .= $template->parse();
				    }
					return $buffer;
				}
			break;
			case 'variants_prices_inches':
				$dbObj = \Database::getInstance()->prepare("SELECT * FROM tl_iso_product WHERE pid = '" . $arrTag[1] . "' AND published = 1 ORDER BY CAST(size_as_decimal AS SIGNED)")->execute();  
				$buffer = '';
				if ($dbObj->numRows > 0)
				{
					$arrLocation = array(
						'id'		=> 0
					);
					$count = 0;
				    while($dbObj->next()) {
				        
				        
				        
				        if($count == 0) {
        					
        					$arrLocation['id']		= 'label';
        					$arrLocation['wp_size']		= 'Size';
        					
        					if($dbObj->length == '' || $dbObj->length == 0)
        					    $arrLocation['length']		= '';
        					else
        					    $arrLocation['length']		= 'Length';
        					
        					
        					if($dbObj->width == '' || $dbObj->width == 0)
        					    $arrLocation['width']		= '';
        					else
        					    $arrLocation['width']		= 'Width';
        					
        					if($dbObj->height == '' || $dbObj->height == 0)
        					    $arrLocation['height']		= '';
        					else
        					    $arrLocation['height']		= 'Diameter';
        					    
        					$template = new FrontendTemplate('item_variant_prices');
        					$template->variant = $arrLocation;
        					$buffer .= $template->parse();
				        }
				        
				        $arrLocation['id']		= $dbObj->id;
    					$arrLocation['wp_size']		= $dbObj->wp_size;
    					
    					if($dbObj->length == '' || $dbObj->length == 0 )
    					    $arrLocation['length']		= '';
    					else
    					    $arrLocation['length']		= round((float)$dbObj->length, 2, PHP_ROUND_HALF_UP);
    					    
    					if($dbObj->width == '' || $dbObj->width == 0)
    					    $arrLocation['width']		= '';
    					else
    					    $arrLocation['width']		= round((float)$dbObj->width, 2, PHP_ROUND_HALF_UP);
    					    
    					if($dbObj->height == '' || $dbObj->height == 0)
    					    $arrLocation['height']		= '';
    					else
    					    $arrLocation['height']		= round((float)$dbObj->height, 2, PHP_ROUND_HALF_UP);
    					    
    					$template = new FrontendTemplate('item_variant_prices');
    					$template->variant = $arrLocation;
    					$buffer .= $template->parse();
    					$count++;
				    }
					return $buffer;
				}
			break;
			case 'variants_prices_millimeters':
				$dbObj = \Database::getInstance()->prepare("SELECT * FROM tl_iso_product WHERE pid = '" . $arrTag[1] . "' AND published = 1 ORDER BY CAST(size_as_decimal AS SIGNED)")->execute();  
				$buffer = '';
				if ($dbObj->numRows > 0)
				{
					$arrLocation = array(
						'id'		=> 0
					);
					$count = 0;
				    while($dbObj->next()) {
				        
				        if($count == 0) {
        					
        					$arrLocation['id']		= 'label';
        					

        					if($dbObj->length == '' || $dbObj->length == 0)
        					    $arrLocation['length']		= '';
        					else
        					    $arrLocation['length']		= 'Length';
        					
        					if($dbObj->width == '' || $dbObj->width == 0)
        					    $arrLocation['width']		= '';
        					else
        					    $arrLocation['width']		= 'Width';
        					
        					if($dbObj->height == '' || $dbObj->height == 0)
        					    $arrLocation['height']		= '';
        					else
        					    $arrLocation['height']		= 'Diameter';
        					    
                            $arrLocation['wp_size']		= 'Size';
        					$template = new FrontendTemplate('item_variant_prices');
        					$template->variant = $arrLocation;
        					$buffer .= $template->parse();
				        }
				        
				        $arrLocation['id']		= $dbObj->id;
    					$arrLocation['wp_size']		= $dbObj->wp_size;
    					
    					
    					if($dbObj->length == '' || $dbObj->length == 0)
    					    $arrLocation['length']		= '';
    					else
    					    $arrLocation['length']      = round(((float)$dbObj->length * 25.4), 2, PHP_ROUND_HALF_UP);

    					if($dbObj->width == '' || $dbObj->width == 0)
    					    $arrLocation['width']		= '';
    					else
    					    $arrLocation['width']		= round(((float)$dbObj->width * 25.4), 2, PHP_ROUND_HALF_UP);

    					if($dbObj->height == '' || $dbObj->height == 0)
    					    $arrLocation['height']		= '';
    					else
    					    $arrLocation['height']		= round(((float)$dbObj->height * 25.4), 2, PHP_ROUND_HALF_UP);

    					$template = new FrontendTemplate('item_variant_prices');
    					$template->variant = $arrLocation;
    					$buffer .= $template->parse();
    					$count++;
				    }
					return $buffer;
				}
			break;
			case 'variants_sizes':
			    
			   // REPLACE('w3resource','ur','r');
			   
				//$dbObj = \Database::getInstance()->prepare("SELECT * FROM tl_iso_product WHERE pid = '" . $arrTag[1] . "' AND published = 1 ORDER BY LENGTH(size_as_decimal), size_as_decimal")->execute(); 
				$dbObj = \Database::getInstance()->prepare("SELECT * FROM tl_iso_product WHERE pid = '" . $arrTag[1] . "' AND published = 1 ORDER BY CAST(size_as_decimal AS SIGNED)")->execute();  
				$buffer = '';
				
				$count = 0;
				if ($dbObj->numRows > 0)
				{
					$arrLocation = array(
						'wp_size'		=> 0,
					);
				    while($dbObj->next()) {
				        
				        if($count != ($dbObj->numRows-1)) {
				            $arrLocation['divider']		= ", ";
				        }
				        else
				            $arrLocation['divider']		= "";
				        
    					$arrLocation['wp_size']		= $dbObj->wp_size;
    					$template = new FrontendTemplate('item_variant_sizes');
    					$template->variant = $arrLocation;
    					$buffer .= $template->parse();
    					
    					$count++;
				    }
					return $buffer;
				}
			break;
		}

		// something has gone horribly wrong, let the user know and hope for brighter lights ahead
		return false;
	}
	
}

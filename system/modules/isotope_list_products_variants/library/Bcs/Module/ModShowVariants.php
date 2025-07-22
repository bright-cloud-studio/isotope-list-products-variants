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

use Contao\Frontend;
use Contao\PageModel;

use Isotope\Model\AttributeOption;
use Isotope\Model\Product;


class ModShowVariants extends \Contao\Module
{

    protected $strTemplate = 'mod_show_variants';
    
    protected function compile()
    {
        $alias = Frontend::getPageIdFromUrl();
        $page = PageModel::findPublishedByIdOrAlias($alias);

        
        $options = [
            'order' => 'name ASC'
        ];
        $variant_data = [];
        $variants = Product::findBy(["tl_iso_product.orderPages LIKE ?", "tl_iso_product.type = ?"],['%' . $page->id . '%', '2'], $options);

        
        if($variants) {
            
            foreach($variants as $id => $variant) {
                
                echo "Count: " . $id . "<br>";
                echo "Name: " . $variant->name . "<br>";
                
                
                $variant_data[$id]['count'] = $id;
                $variant_data[$id]['id'] = $variant->id;
                $variant_data[$id]['name'] = $variant->name;
                
                $variant_data[$id]['image'] = unserialize($variant->images);
                
                
                
                $bristle = AttributeOption::findBy(["tl_iso_attribute_option.id = ?"],[$variant->bristle_type]);
                $variant_data[$id]['bristle'] = $bristle->label;
                
                if($variant->pid == 0)
                    $variant_data[$id]['sizes'] = $variant->wp_size;
                    
                    

                $children = Product::findBy(["tl_iso_product.pid = ?"],[$variant->id]);
                if($children) {
                    
                    $child_data = [];
                    foreach($children as $id => $child) {
                        $child_data[$id]['id'] = $child->id;
                        $child_data[$id]['size'] = $child->wp_size;
                        $child_data[$id]['length'] = round((float)$child->length, 2, PHP_ROUND_HALF_UP);
                        $child_data[$id]['width'] = round((float)$child->width, 2, PHP_ROUND_HALF_UP);
                    }
                    $variant_data[$id]['children'] = $child_data;
                    
                }
                
                
            }

            
        }

        
        $this->Template->variants = $variant_data;
        
    }

}

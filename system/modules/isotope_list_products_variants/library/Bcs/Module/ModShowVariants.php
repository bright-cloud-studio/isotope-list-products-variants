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
        
        $this->Template->page_alias = $alias;
        $this->Template->page_id = $page->id;

        
        $options = [
            'order' => 'name ASC'
        ];
        $variant_data = [];
        $variants = Product::findBy(["tl_iso_product.orderPages LIKE ?", "tl_iso_product.type = ?", "tl_iso_product.published"],['%' . $page->id . '%', '2', '1'], $options);

        
        if($variants) {
            $count = 0;
            foreach($variants as $variant) {

                $variant_data[$count]['count'] = $count;
                $variant_data[$count]['id'] = $variant->id;
                $variant_data[$count]['name'] = $variant->name;
                
                $variant_data[$count]['image'] = unserialize($variant->images);
                
                
                
                $bristle = AttributeOption::findBy(["tl_iso_attribute_option.id = ?"],[$variant->bristle_type]);
                $variant_data[$count]['bristle'] = $bristle->label;
                
                
                $children_options = [
                    'order' => 'width ASC, length ASC'
                ];
                $children = Product::findBy(["tl_iso_product.pid = ?", "tl_iso_product.published = ?"],[$variant->id, '1'], $children_options);
                
                $child_data = [];
                
                if($children) {
                    
                    foreach($children as $id => $child) {
                        $child_data[$id]['id'] = $child->id;
                        $child_data[$id]['size'] = $child->wp_size;
                        $child_data[$id]['length'] = round((float)$child->length, 2, PHP_ROUND_HALF_UP);
                        $child_data[$id]['width'] = round((float)$child->width, 2, PHP_ROUND_HALF_UP);
                        
                        $child_data[$id]['mm_size'] = $child->wp_size;
                        $child_data[$id]['mm_length'] = round(((float)$child->length * 25.4), 2, PHP_ROUND_HALF_UP);
                        $child_data[$id]['mm_width'] = round(((float)$child->width * 25.4), 2, PHP_ROUND_HALF_UP);
                    }
                    $variant_data[$count]['children'] = $child_data;
                    
                }
                
                
                // Build the sizes list from the child variants themselves, so it can
                // never fall out of sync with the products that actually exist
                $sizes = array_column($child_data, 'size');
                $sizes = array_filter($sizes, function($size) { return trim((string)$size) !== ''; });
                $sizes = array_unique($sizes);
                
                if(!empty($sizes))
                    $variant_data[$count]['sizes'] = implode(', ', $sizes);
                else if($variant->pid == 0)
                    $variant_data[$count]['sizes'] = $variant->wp_size;
                
                
                $count++;
            }

            
        }

        
        $this->Template->variants = $variant_data;
        
    }

}

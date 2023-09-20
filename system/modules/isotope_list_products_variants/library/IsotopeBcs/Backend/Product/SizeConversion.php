<?php

/*
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009 - 2019 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @link       https://isotopeecommerce.org
 * @license    https://opensource.org/licenses/lgpl-3.0.html
 */

namespace IsotopeBcs\Backend\Product;


use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;
use Contao\Input;
use Contao\StringUtil;
use Isotope\Model\Product;
use Isotope\DatabaseUpdater;

class SizeConversion extends \Backend
{

    /**
     * Autogenerate a product alias if it has not been set yet
     * @param mixed
     * @param DataContainer
     * @return string
     * @throws \Exception
     */
    public function convertSize(DataContainer $dc)
    {
        
        // starting point
        $newPrice = 0;
        $oldPrice = $dc->activeRecord->wp_size;
        
        // if this has commas dont even try
        if(str_contains($oldPrice, ',')) {
            
            $newPrice = 1;
            
        } else {
            // remove html quote
            $cleaning = str_replace('&#34;','', $oldPrice);
            // remove actual quote
            $cleaning = str_replace('"','', $cleaning);
            
            
            // this is a fraction
            if(str_contains($cleaning, '/')) {
                
                // this is one of the weird */0 fractions
                if(str_contains($cleaning, '/0')) {
                    $cleaning = str_replace('/0', '',$cleaning);
                    $cleaning = $cleaning * -1;
                } else {
                    $cleaning = $this->convertToDecimal($cleaning);
                }
            
            } else {
                $cleaning = $cleaning + 10000;
            }
            
            $newPrice = $cleaning;
        }
        
        \Database::getInstance()->prepare('UPDATE tl_iso_product SET size_as_decimal=? WHERE id=?')->execute($newPrice, $dc->activeRecord->id);
    }

    function convertToDecimal ($fraction)
    {
        $numbers=explode("/",$fraction);
        return round($numbers[0]/$numbers[1],1);
    }
}

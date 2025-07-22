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


class ModShowVariants extends \Contao\Module
{

  protected $strTemplate = 'mod_show_variants';
  
  protected function compile()
  {
    $this->Template->bing = "bong noise!";
  }

}

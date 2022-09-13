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

class SizeConversion extends Backend
{

    /**
     * Autogenerate a product alias if it has not been set yet
     * @param mixed
     * @param DataContainer
     * @return string
     * @throws \Exception
     */
    public function convertSize($varValue, DataContainer $dc)
    {
        \Database::getInstance()->prepare('UPDATE tl_iso_product SET size_as_decimal=? WHERE id=?')->execute("Alias for " ."999", $dc->activeRecord->id);
    }
}

<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Isotope List Products Variants
 * @license    MIT
 * @see        https://github.com/bright-cloud-studio/isotope-list-products-variants
 */

declare(strict_types=1);

namespace Bcs\IsotopeListProductsVariantsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BcsIsotopeListProductsVariantsBundle extends Bundle
{
    /**
     * Return the bundle root rather than src/, so Contao finds the resources
     * in contao/dca/, contao/languages/ and contao/templates/ at the package root
     */
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
